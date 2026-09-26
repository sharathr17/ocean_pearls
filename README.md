# 🌊 Ocean Pearls – Hotel Booking Management System

Ocean Pearls is a web-based **Hotel Booking Management System** developed using **PHP and MySQL**. The application allows users to explore rooms across multiple locations, create accounts, book rooms, make payments, manage their bookings, download invoices, and provide feedback.

The project also includes an **Admin Panel** for managing booking requests and updating booking statuses.

---

## ✨ Features

### 👤 User Features

* User registration and login
* Secure password authentication
* Forgot password functionality
* Browse available rooms
* View rooms based on location
* Select room type and bedding
* Book rooms using check-in and check-out dates
* Automatic total price calculation
* Accept booking terms and conditions
* Payment processing
* View booking history
* Cancel bookings
* Generate booking invoices
* Submit feedback
* User logout

### 🏨 Room Locations

Ocean Pearls currently provides rooms at:

* 🌊 **Maravanthe**
* 🏝️ **Uppinakudru**
* 🏨 **Koteshwara**

Each location provides multiple room categories such as:

* Standard Single
* Standard Double
* Standard King
* Deluxe Single
* Deluxe Double
* Deluxe King
* Suite Single
* Suite Double
* Suite King

---

## 🛠️ Tech Stack

| Technology      | Purpose                               |
| --------------- | ------------------------------------- |
| PHP             | Backend development                   |
| MySQL / MariaDB | Database                              |
| HTML5           | Page structure                        |
| CSS3            | Styling                               |
| JavaScript      | Client-side functionality             |
| PHP Sessions    | Authentication and session management |
| FPDF            | PDF invoice generation                |
| Composer        | PHP dependency management             |
| phpMyAdmin      | Database administration               |

---

## 📦 PHP Dependency

The project uses **FPDF** for generating booking invoices.

```json
"setasign/fpdf": "^1.8"
```

Install dependencies using:

```bash
composer install
```

---

## 🗄️ Database

The application uses a MySQL/MariaDB database named:

```text
ocean_pearls
```

The included `ocean_pearls.sql` file contains the required database structure.

### Main Tables

| Table      | Purpose                                  |
| ---------- | ---------------------------------------- |
| `users`    | Stores registered user information       |
| `admins`   | Stores administrator accounts            |
| `rooms`    | Stores room information and availability |
| `bookings` | Stores room booking details              |
| `feedback` | Stores customer feedback                 |

The booking system tracks information including:

* User
* Room
* Check-in date
* Check-out date
* Total price
* Nationality
* Booking status
* Payment status
* Booking time

Booking statuses include:

```text
Pending
Accepted
User Cancelled
Rejected
```

---

## 📁 Project Structure

```text
ocean_pearls/
│
├── admin/
│   ├── admin_login.php
│   ├── admin_logout.php
│   ├── admin_panel.php
│   └── update_status.php
│
├── assets/
├── includes/
├── script/
├── styles/
├── vendor/
│
├── index.php
├── header.php
├── login.php
├── signup.php
├── logout.php
├── forgot_password.php
│
├── book_room.php
├── process_booking.php
├── cancel_booking.php
├── history.php
├── payment.php
├── generate_invoice.php
│
├── maravanthe_rooms.php
├── uppinakudru_rooms.php
├── koteshwara_rooms.php
│
├── feedback.php
├── terms.php
├── error.php
│
├── db_connect.php
├── insert_admins.php
│
├── ocean_pearls.sql
├── composer.json
└── composer.lock
```

---

## ⚙️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/sharathr17/ocean_pearls.git
```

Move into the project directory:

```bash
cd ocean_pearls
```

---

### 2. Install XAMPP

Install **XAMPP** or another PHP/MySQL development environment.

Start:

```text
Apache
MySQL
```

---

### 3. Move the Project

For XAMPP, place the project inside:

```text
C:\xampp\htdocs\
```

Example:

```text
C:\xampp\htdocs\ocean_pearls
```

---

### 4. Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
ocean_pearls
```

Then import:

```text
ocean_pearls.sql
```

This creates the required tables and initial room data.

---

### 5. Configure Database Connection

The default configuration in `db_connect.php` is:

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ocean_pearls";
```

Change these values if your MySQL configuration is different.

---

### 6. Install Composer Dependencies

Run:

```bash
composer install
```

This installs the FPDF dependency used for PDF invoice generation.

---

### 7. Run the Application

Open:

```text
http://localhost/ocean_pearls/
```

The main page is served through:

```text
index.php
```

---

## 🔄 Booking Workflow

```text
User Registration / Login
          ↓
Select Location
          ↓
Browse Rooms
          ↓
Select Room
          ↓
Choose Check-in & Check-out
          ↓
Submit Booking
          ↓
Booking Created
          ↓
Payment
          ↓
Admin Review
          ↓
Accepted / Rejected
          ↓
Booking History
          ↓
Invoice Generation
```

---

## 🛡️ Admin Panel

The application contains a separate administrator interface.

Admin login:

```text
/admin/admin_login.php
```

Admin dashboard:

```text
/admin/admin_panel.php
```

Administrators can review booking information and update booking statuses.

The status management functionality is handled through:

```text
/admin/update_status.php
```

---

## 🧾 Invoice Generation

Ocean Pearls supports PDF invoice generation using the **FPDF** PHP library.

Invoice functionality is implemented in:

```text
generate_invoice.php
```

Users can generate invoices associated with their bookings.

---

## 📍 Room Management

Room information is stored in the `rooms` database table.

Each room contains:

```text
Location
Room Type
Bedding Type
Availability Status
Price
```

The initial database contains rooms for **Maravanthe, Uppinakudru, and Koteshwara**, with Standard, Deluxe, and Suite options.

---

## 🔐 Authentication

The application provides separate authentication flows for:

```text
Users
Administrators
```

User authentication includes:

* Registration
* Login
* Logout
* Password storage
* Forgot password functionality
* Session management

Administrator authentication is handled separately inside the `admin` directory.

---

## 🚀 Future Improvements

Potential enhancements include:

* Online payment gateway integration
* Email booking confirmations
* OTP-based password recovery
* Real-time room availability
* Search and advanced filtering
* User profile management
* Admin analytics dashboard
* Room image management
* Dynamic room creation and editing
* Booking notifications
* Responsive UI improvements
* REST API
* CSRF protection
* Environment-based database configuration
* Production deployment configuration

---

## 👨‍💻 Author

**Sharath R**

GitHub: `sharathr17`

Repository: `sharathr17/ocean_pearls`

---

## 📄 License

This project currently does not include a dedicated license file.

If the project is intended to be open source, add an appropriate license such as MIT.

---

<p align="center">
  <b>🌊 Ocean Pearls</b><br>
  Hotel Booking Management System
</p>
