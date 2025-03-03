<?php
session_start();
include 'includes/db_connect.php';
include 'header.php';

// Ensure the user is logged in

if (!isset($_SESSION["user_id"])) {
    echo "<div style='
            text-align: center;
            margin: 100px auto;
            font-size: 20px;
            color: #0056b3;
            font-family: Arial, sans-serif;
            padding: 20px;
            border: 2px solid #0056b3;
            border-radius: 8px;
            background-color: #d0e8ff;
            width: 50%;
            max-width: 500px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        '>
            <strong>⚠ Access Denied!</strong><br>
            ❌ Please <a href='login.php' style='
                color: #004085;
                font-weight: bold;
                text-decoration: none;
            '>login</a> to access the booking page.<br><br>

            <a href='login.php' style='
                display: inline-block;
                padding: 10px 15px;
                background-color: #0056b3;
                color: white;
                font-weight: bold;
                text-decoration: none;
                border-radius: 5px;
                transition: 0.3s;
            ' onmouseover='this.style.backgroundColor=\"#004085\"' 
              onmouseout='this.style.backgroundColor=\"#0056b3\"'>
                🔑 Log In
            </a>
        </div>";
    exit;
}



$user_id = intval($_SESSION['user_id']);

// Fetch user details safely
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();

if ($user_result->num_rows == 0) {
    die("User not found.");
}

$user = $user_result->fetch_assoc();

// Check if user already has a pending booking
$booking_query = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? AND status = 'Pending'");
$booking_query->bind_param("i", $user_id);
$booking_query->execute();
$booking_result = $booking_query->get_result();

// Get location from URL (if provided)
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Fetch available rooms based on location
if ($location) {
    $rooms_query = $conn->prepare("SELECT * FROM rooms WHERE status = 'Available' AND location = ?");
    $rooms_query->bind_param("s", $location);
} else {
    $rooms_query = $conn->prepare("SELECT * FROM rooms WHERE status = 'Available'");
}

$rooms_query->execute();
$rooms_result = $rooms_query->get_result();
// Get room details from URL 
$selected_room = isset($_GET['room']) ? $_GET['room'] : '';
$selected_location = isset($_GET['location']) ? $_GET['location'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room <?= $location ? "- " . htmlspecialchars($location) : "" ?></title>
    <link rel="stylesheet" href="styles/book.css">
    <script>
        function calculatePrice() {
            let checkin = new Date(document.getElementById('checkin_date').value);
            let checkout = new Date(document.getElementById('checkout_date').value);
            let roomPrice = parseFloat(document.getElementById('room_price').value) || 0;

            if (isNaN(checkin.getTime()) || isNaN(checkout.getTime())) {
                document.getElementById('total_price').value = "Invalid dates";
                return;
            }

            let timeDiff = checkout - checkin;
            let days = timeDiff / (1000 * 60 * 60 * 24);

            if (days > 0) {
                document.getElementById('total_price').value = (roomPrice * days).toFixed(2);
            } else {
                document.getElementById('total_price').value = "Invalid dates";
                alert("Checkout date must be after Check-in date.");
                document.getElementById('checkout_date').value = ""; // Clear invalid date
            }
        }

        function openPopup(event, url) {
            event.preventDefault(); 
            window.open(url, 'Terms', 'width=600,height=400,scrollbars=yes,resizable=yes');
        }

        function validateForm() {
            let totalPrice = document.getElementById('total_price').value;
            if (totalPrice === "Invalid dates" || totalPrice === "" || totalPrice === "0.00") {
                alert("Please select valid check-in and check-out dates.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<?php if ($booking_result->num_rows > 0): ?>
    <p>You already have a pending booking.</p>
    <form action="cancel_booking.php" method="POST">
        <button type="submit" name="cancel_booking">Cancel Booking</button>
    </form>
<?php elseif ($rooms_result->num_rows > 0): ?>
<div id="book-form">
    <br>
    <form action="process_booking.php" method="POST" onsubmit="return validateForm()">
        <h2>Hotel Booking <?= $location ? "- " . htmlspecialchars($location) : "" ?></h2>
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" readonly><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" readonly><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" readonly><br>

        <label>Nationality:</label>
        <select name="nationality" id="nationality" required>
            <option value="India" <?= ($user['nationality'] == 'India') ? 'selected' : '' ?>>India</option>
            <option value="Other">Other</option>
        </select><br>

        <input type="text" name="other_nationality" id="other_nationality" placeholder="Enter your nationality" style="display: none;">
        
        <script>
            document.getElementById('nationality').addEventListener('change', function() {
                var otherField = document.getElementById('other_nationality');
                if (this.value === 'Other') {
                    otherField.style.display = 'block';
                    otherField.required = true;
                } else {
                    otherField.style.display = 'none';
                    otherField.required = false;
                    otherField.value = ''; 
                }
            });
        </script>

        <label>Check-in Date:</label>
        <input type="date" id="checkin_date" name="checkin_date" required onchange="calculatePrice()"><br>

        <label>Check-out Date:</label>
        <input type="date" id="checkout_date" name="checkout_date" required onchange="calculatePrice()"><br>

        <label>Room Type:</label>
        <select name="room_id" id="room_id" required onchange="document.getElementById('room_price').value = this.options[this.selectedIndex].getAttribute('data-price'); calculatePrice();">
        <option value="">Select a Room</option>
<?php while ($room = $rooms_result->fetch_assoc()) { 
    $isSelected = ($room['room_type'] === $selected_room && $room['location'] === $selected_location) ? 'selected' : ''; 
?>
    <option value="<?= $room['id']; ?>" data-price="<?= $room['price']; ?>" <?= $isSelected; ?>>
        <?= htmlspecialchars($room['room_type'] . " - " . $room['location'] . " (₹" . $room['price'] . " per night)"); ?>
    </option>
            <?php } ?>
        </select><br>

        <input type="hidden" id="room_price" name="room_price">

        <label>Total Price:</label>
        <input type="text" id="total_price" name="total_price" readonly><br>

        <label>
            <input type="checkbox" name="terms" required> 
            I agree to the 
            <a href="terms.php" onclick="openPopup(event, 'terms.php');">terms and conditions</a>
        </label><br>

        <button type="submit" name="submit">Book Now</button>
    </form>
<?php else: ?>
    <p>❌ No available rooms at this time. Please try again later.</p>
<?php endif; ?>
</div>

</body>
</html>

