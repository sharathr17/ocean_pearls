<?php
include "../includes/db_connect.php";
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_name"])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION["admin_name"];

// Fetch statistics
$totalBookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$pendingBookings = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status='Pending' OR status IS NULL")->fetch_assoc()['count'];
$canceledBookings = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status IN ('Rejected', 'User Cancelled')")->fetch_assoc()['count'];
$totalPayments = $conn->query("SELECT SUM(total_price) as total FROM bookings WHERE payment_status='Paid'")->fetch_assoc()['total'] ?? 0;

// Get selected tab
$tab = $_GET['tab'] ?? 'dashboard';

// Fetch bookings based on status
$status_filter = null;
if ($tab == 'pending') {
    $status_filter = "b.status = 'Pending' OR b.status IS NULL";
} elseif ($tab == 'accepted') {
    $status_filter = "b.status = 'Accepted'";
} elseif ($tab == 'rejected') {
    $status_filter = "b.status = 'Rejected'";
} elseif ($tab == 'user_cancelled') {
    $status_filter = "b.status = 'User Cancelled'";
} elseif ($tab == 'payments') {
    $status_filter = "b.payment_status IN ('Paid', 'Not Paid')";
}

$data = [];
if ($status_filter) {
    $sql = "SELECT b.*, u.name, u.email, u.phone, r.location, r.room_type 
            FROM bookings b
            JOIN users u ON b.user_id = u.id
            JOIN rooms r ON b.room_id = r.id
            WHERE $status_filter";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Fetch feedback if the feedback tab is selected
$feedback_result = null;
if ($tab == 'feedback') {
    $feedback_result = $conn->query("SELECT username, email, message, created_at FROM feedback ORDER BY created_at DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel - Ocean Pearls</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Lato", sans-serif;
        }

        body {
            background: #f4f4f9;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: rgb(2, 64, 130);
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .logout-btn {
            display: none;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            left: 0;
            top: 50px;
            height: 100%;
            background: rgb(2, 64, 130);
            padding: 15px;
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .sidebar a:hover, 
        .sidebar a.active {
            background: rgb(76, 120, 168);
            color: white;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            padding-top: 70px;
        }

        .card-container {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
        }

        .card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            text-align: center;
            min-width: 180px;
            flex-shrink: 0;
        }

        .card h3 {
            margin-bottom: 5px;
            font-size: 16px;
        }

        .card p {
            font-size: 18px;
            font-weight: bold;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        @media screen and (max-width: 768px) {
            .header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .nav-links {
                display: none;
            }

            .logout-btn {
                display: block;
                font-size: 14px;
                padding: 5px 10px;
                background: white;
                color: rgb(2, 64, 130);
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: flex;
                flex-wrap: wrap;
                top: 60px;
                padding: 5px;
            }

            .sidebar a {
                flex: 1;
                padding: 8px;
                font-size: 14px;
                text-align: center;
            }

            .content {
                margin-left: 0;
                padding: 10px;
                padding-top: 60px;
            }

            .card-container {
                display: flex;
                overflow-x: auto;
                gap: 10px;
                white-space: nowrap;
            }

            .card {
                min-width: 150px;
                padding: 10px;
            }

            th, td {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Admin Panel - Welcome, <?= htmlspecialchars(strtoupper($admin_name)) ?></h2>
        <div class="nav-links">
            <a href="admin_logout.php">Logout</a>
        </div>
        <button class="logout-btn" onclick="location.href='admin_logout.php'">Logout</button>
    </div>

    <div class="sidebar">
        <a href="?tab=dashboard" class="<?= $tab == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
        <a href="?tab=pending" class="<?= $tab == 'pending' ? 'active' : '' ?>">Pending</a>
        <a href="?tab=accepted" class="<?= $tab == 'accepted' ? 'active' : '' ?>">Accepted</a>
        <a href="?tab=rejected" class="<?= $tab == 'rejected' ? 'active' : '' ?>">Rejected</a>
        <a href="?tab=user_cancelled" class="<?= $tab == 'user_cancelled' ? 'active' : '' ?>">User Canceled</a>
        <a href="?tab=payments" class="<?= $tab == 'payments' ? 'active' : '' ?>">Payments</a>
        <a href="?tab=feedback" class="<?= $tab == 'feedback' ? 'active' : '' ?>">Feedback</a>
    </div>
<br>
    <div class="content">
        <?php if ($tab == 'dashboard'): ?>
            <h2>Dashboard</h2>
            <br>
            <div class="card-container">
                <div class="card"><h3>Total Bookings</h3><p><?= $totalBookings ?></p></div>
                <div class="card"><h3>Pending Bookings</h3><p><?= $pendingBookings ?></p></div>
                <div class="card"><h3>Canceled Bookings</h3><p><?= $canceledBookings ?></p></div>
                <div class="card"><h3>Total Payments</h3><p>₹<?= $totalPayments ?></p></div>
            </div>
        <?php elseif ($tab == 'feedback'): ?>
            <h3>User Feedback</h3>
            <div class="table-container">
                <table>
                    <tr><th>Name</th><th>Email</th><th>Message</th><th>Submitted At</th></tr>
                    <?php if ($feedback_result && $feedback_result->num_rows > 0): ?>
                        <?php while ($row = $feedback_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['message']) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No feedback available.</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        <?php else: ?>
            <h3><?= ucfirst(str_replace('_', ' ', $tab)) ?> Bookings</h3>
            <div class="table-container">
                <table>
                    <tr>
                        <th>User</th><th>Email</th><th>Phone</th><th>Location</th><th>Room Type</th>
                        <th>Check-in</th><th>Check-out</th><th>Time</th><th>Price</th>
                        <?php if ($tab == 'pending' || $tab == 'null'): ?><th>Action</th><?php endif; ?>
                    </tr>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td><?= htmlspecialchars($row['room_type']) ?></td>
                                <td><?= htmlspecialchars($row['checkin_date']) ?></td>
                                <td><?= htmlspecialchars($row['checkout_date']) ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($row['created_at'])) ?></td>
                                <td>₹<?= htmlspecialchars($row['total_price']) ?></td>
                                <?php if ($tab == 'pending' || $tab == 'null'): ?>
                                    <td>
                                        <a href="update_status.php?id=<?= $row['id'] ?>&status=Accepted" class="accept-btn">Accept</a> |
                                        <a href="update_status.php?id=<?= $row['id'] ?>&status=Rejected" class="reject-btn" onclick="return confirm('Reject this booking?')">Reject</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="10">No records found.</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>