<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uppinakudru Rooms - Ocean Pearls</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 1200px; margin: auto; padding: 20px; }
        
        .room-detail { 
            display: flex; 
            flex-wrap: wrap; 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0px 4px 8px rgba(0,0,0,0.2); 
            margin-bottom: 20px; 
        }
        
        .room-images { 
            flex: 1; 
            max-width: 50%; 
            text-align: center; 
        }
        .image-box {
            width: 100%;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 8px;
            background-color: #ddd;
        }
        .room-images img { 
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }

        .thumbnails { 
            display: flex; 
            justify-content: center; 
            margin-top: 10px; 
            gap: 10px;
            flex-wrap: wrap;
        }
        .thumbnails img { 
            width: 80px; 
            height: 60px; 
            cursor: pointer; 
            border-radius: 5px; 
            border: 2px solid transparent; 
            object-fit: cover;
        }
        .thumbnails img:hover, 
        .thumbnails img.active { 
            border: 2px solid #007bff; 
        }

        .room-info { 
            flex: 1; 
            padding: 20px; 
        }
        .room-info h2 { 
            color: #0056b3; 
            margin-bottom: 10px; 
        }
        .room-info p { 
            font-size: 16px; 
            color: #555; 
        }
        .price { 
            font-size: 22px; 
            color: #28a745; 
            font-weight: bold; 
        }
        .book-btn { 
            display: inline-block; 
            padding: 12px 20px; 
            background: #007bff; 
            color: white; 
            text-decoration: none; 
            font-weight: bold; 
            border-radius: 5px; 
            transition: 0.3s; 
        }
        .book-btn:hover { 
            background: #0056b3; 
        }

        .room-list { margin-top: 30px; }
        .room-table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .room-table th, 
        .room-table td { 
            padding: 12px; 
            text-align: center; 
            border: 1px solid #ddd; 
        }
        .room-table th { 
            background: #007bff; 
            color: white; 
        }
        .room-table tr:nth-child(even) { 
            background: #f2f2f2; 
        }

        @media screen and (max-width: 768px) {
            .room-detail { 
                flex-direction: column; 
                text-align: center; 
            }
            .room-images { 
                max-width: 100%; 
            }
            .thumbnails img { 
                width: 60px; 
                height: 45px; 
            }
            .room-info { 
                padding: 15px; 
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1 style="text-align: center; color: #007bff;">Uppinakudru - Room Details</h1>

    <div class="room-detail">
        <div class="room-images">
            <div class="image-box">
                <img src="assets/uppinakudru-room1.jpg" id="mainImage">
            </div>
            <div class="thumbnails">
                <img src="assets/uppinakudru-room1.jpg" onmouseover="changeImage(this)" class="active">
                <img src="assets/uppinakudru-room2.jpg" onmouseover="changeImage(this)">
                <img src="assets/uppinakudru-room3.jpg" onmouseover="changeImage(this)">
                <img src="assets/uppinakudru-room4.jpg" onmouseover="changeImage(this)">
            </div>
        </div>

        <div class="room-info">
            <h2>Luxury Rooms in Uppinakudru</h2>
            <p>Enjoy a peaceful stay at our premium rooms in Uppinakudru, offering scenic views and top-class amenities.</p>
            <p class="price">Starting from ₹1,000/night</p>
            <a href="book_room.php?location=Uppinakudru" class="book-btn">Book Now</a>
        </div>
    </div>
    <div class="room-list">
        <h2>Available Rooms</h2>
        <table class="room-table">
            <tr>
                <th>Room Type</th>
                <th>Bed Type</th>
                <th>Availability</th>
                <th>Price (₹)</th>
                <th>Action</th>
            </tr>
            <tr><td>Suite</td><td>Double</td><td>Available</td><td>2200</td><td><a href="book_room.php?room=Suite%20Double&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
            <tr><td>Suite</td><td>Single</td><td>Available</td><td>2000</td><td><a href="book_room.php?room=Suite%20Single&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
            <tr><td>Deluxe</td><td>King</td><td>Available</td><td>1700</td><td><a href="book_room.php?room=Deluxe%20King&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
            <tr><td>Suite</td><td>King</td><td>Available</td><td>2500</td><td><a href="book_room.php?room=Suite%20King&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
            <tr><td>Deluxe</td><td>Single</td><td>Available</td><td>1300</td><td><a href="book_room.php?room=Deluxe%20Single&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
            <tr><td>Standard</td><td>King</td><td>Available</td><td>1200</td><td><a href="book_room.php?room=Standard%20King&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
            <tr><td>Standard</td><td>Double</td><td>Available</td><td>1000</td><td><a href="book_room.php?room=Standard%20Double&location=Uppinakudru" class="book-btn">Book Now</a></td></tr>
        </table>
    </div>
</div>

<script>
    function changeImage(element) {
        const mainImg = document.getElementById("mainImage");
        mainImg.src = element.src;

        // Remove 'active' class from all thumbnails
        document.querySelectorAll(".thumbnails img").forEach(img => img.classList.remove("active"));

        // Add 'active' to the hovered one
        element.classList.add("active");
    }
</script>


</body>
</html>
