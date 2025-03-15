<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocean Pearls</title>
    
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #f5f5f5;
        }
        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #2c3e50;
            color: white;
            position: relative;
            z-index: 1000;
        }

        .logo-title {
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }

        .logo-title img {
            height: 40px;
            margin-right: 10px;
        }

        /* Navigation */
        nav {
            display: flex;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a, nav ul li span {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        nav ul li a:hover, nav ul li span:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        /* Dropdown */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #34495e;
            width: 150px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 5px 0;
            text-align: left;
        }

        .dropdown.active .dropdown-menu {
            display: block;
        }

        .dropdown-menu li {
            padding: 10px;
        }

        .dropdown-menu li a {
            display: block;
            color: white;
            padding: 10px;
            transition: 0.3s;
            text-decoration: none;
        }

        .dropdown-menu li a:hover {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            cursor: pointer;
        }

        .bar1, .bar2, .bar3 {
            width: 35px;
            height: 5px;
            background-color: white;
            margin: 6px 0;
            transition: 0.4s;
        }

        .change .bar1 {
            transform: translate(0, 11px) rotate(-45deg);
        }

        .change .bar2 {
            opacity: 0;
        }

        .change .bar3 {
            transform: translate(0, -11px) rotate(45deg);
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
                position: absolute;
                right: 20px;
                top: 15px;
            }

            nav {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                right: 0;
                background: #2c3e50;
                width: 100%;
                padding: 10px 0;
                text-align: center;
            }

            nav.active {
                display: flex;
            }

            nav ul {
                flex-direction: column;
                width: 100%;
            }

            nav ul li {
                padding: 10px 0;
            }

            .dropdown-menu {
                position: relative;
                display: none;
                background: #2c3e50;
                width: 100%;
                box-shadow: none;
                padding: 0;
            }

            .dropdown.active .dropdown-menu {
                display: block;
            }
        }
    </style>

    <script>
        function toggleMenu(x) {
            x.classList.toggle("change");
            document.querySelector("nav").classList.toggle("active");
        }

        // Close mobile menu when clicking outside
        document.addEventListener("click", function (event) {
            let menu = document.querySelector("nav");
            let toggle = document.querySelector(".menu-toggle");
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove("active");
                toggle.classList.remove("change");
            }
        });

        // Toggle dropdown on click (for mobile)
        function toggleDropdown(event) {
            event.stopPropagation();
            let dropdown = event.target.closest(".dropdown");
            dropdown.classList.toggle("active");
        }

        // Close dropdown if clicking outside
        document.addEventListener("click", function (event) {
            document.querySelectorAll(".dropdown").forEach(dropdown => {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove("active");
                }
            });
        });
    </script>
</head>
<body>

<header>
    <a href="index.php" class="logo-title">
        <img src="assets/logo.png" alt="Ocean Pearls Logo">
        <span>Ocean Pearls</span>
    </a>

    <div class="menu-toggle" onclick="toggleMenu(this)">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
                <span onclick="toggleDropdown(event)">Location</span>
                <ul class="dropdown-menu">
                    <li><a href="koteshwara_rooms.php">Koteshwara</a></li>
                    <li><a href="maravanthe_rooms.php">Maravanthe</a></li>
                    <li><a href="uppinakudru_rooms.php">Uppinakudru</a></li>
                </ul>
            </li>
            <li><a href="history.php">History</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
</body>
</html>
