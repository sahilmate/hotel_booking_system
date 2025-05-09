# Luxury Hotel Booking System

A complete PHP-based hotel booking system featuring room management, reservations, user accounts, and an admin panel. This application allows users to browse and book rooms, manage their reservations, and provides administrators with tools to manage the entire booking system.

## 📋 Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Admin Panel](#admin-panel)
- [User System](#user-system)
- [Directory Structure](#directory-structure)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

- **User-facing Features**
  - Browse available rooms and view details
  - Search rooms by date and availability
  - Online room booking system
  - User registration and login
  - User dashboard to manage bookings
  - Booking confirmation and details

- **Admin Features**
  - Secure admin login
  - Dashboard with booking statistics
  - Manage rooms and room categories
  - View and manage all bookings
  - User management
  - Room availability tracking

## 🖥️ Demo

### Admin Login
- **Username:** admin
- **Password:** admin123

### User Login
- **Email:** user@example.com
- **Password:** user123

## 🔧 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- XAMPP, WAMP, LAMP, or MAMP stack

## 📥 Installation

1. **Clone the repository or download the ZIP file**:
   ```bash
   git clone https://github.com/yourusername/hotel-booking-system.git
   ```

2. **Move the project to your web server directory** (e.g. `htdocs` for XAMPP):
   - For XAMPP: `C:\xampp\htdocs\hotel-booking-master`
   - For WAMP: `C:\wamp\www\hotel-booking-master`
   - For LAMP: `/var/www/html/hotel-booking-master`

3. **Start your local server** (Apache and MySQL):
   - XAMPP: Start Apache and MySQL from the XAMPP Control Panel
   - WAMP: Start all services from the WAMP tray icon
   - LAMP: `sudo service apache2 start` and `sudo service mysql start`

4. **Access the application**:
   - Open your web browser and navigate to `http://localhost/hotel-booking-master/hotel-booking-master/index.php`

## 💾 Database Setup

1. **Open phpMyAdmin**:
   - XAMPP: `http://localhost/phpmyadmin`
   - WAMP: `http://localhost/phpmyadmin`
   - LAMP: `http://localhost/phpmyadmin`

2. **Create a new database**:
   - Click on "New" in the left sidebar
   - Enter `hotel` as the database name
   - Click "Create"

3. **Import the database structure**:
   - Select the `hotel` database in the left sidebar
   - Click on the "Import" tab at the top
   - Click "Choose File" and select `hotel.sql` from the project's root directory
   - Click "Go" at the bottom to import the structure

4. **Check database connection**:
   - Open `admin/include/db_config.php` and ensure the database credentials match your setup
   - Default settings:
     ```php
     $host = "localhost";
     $user = "root";
     $pass = "";
     $db = "hotel";
     ```

## 🔐 Admin Panel

1. **Access the admin panel**:
   - Go to `http://localhost/hotel-booking-master/hotel-booking-master/admin/`

2. **Default admin credentials**:
   - Username: `admin`
   - Password: `admin123`

3. **Admin Features**:
   - Dashboard with booking statistics
   - Room management (add, edit, delete rooms)
   - Room category management
   - Booking management
   - User management

## 👤 User System

1. **Register a new user account**:
   - Go to `http://localhost/hotel-booking-master/hotel-booking-master/user_register.php`
   - Fill in the required fields
   - Submit the form

2. **Login with user account**:
   - Go to `http://localhost/hotel-booking-master/hotel-booking-master/user_login.php`
   - Enter email and password
   - Click "Login"

3. **User Features**:
   - Browse available rooms
   - Book rooms
   - View booking history
   - Manage account details

## 📂 Directory Structure

```
hotel-booking-master/
├── admin/                     # Admin panel files
│   ├── include/               # Admin backend files
│   │   ├── class.user.php     # User class with admin functions
│   │   └── db_config.php      # Database configuration
│   ├── css/                   # Admin CSS files
│   ├── js/                    # Admin JavaScript files
│   ├── index.php              # Admin login page
│   ├── admin.php              # Admin dashboard
│   └── [other admin files]    # Other admin pages
│
├── css/                       # Frontend CSS files
│   ├── bootstrap.min.css      # Bootstrap framework
│   ├── navbar.css             # Navigation styling
│   └── style.css              # Custom styling
│
├── js/                        # Frontend JavaScript files
│   └── bootstrap.bundle.min.js # Bootstrap JavaScript
│
├── images/                    # Image directory
│
├── index.php                  # Homepage
├── rooms.php                  # Room listing page
├── book.php                   # Booking form
├── booknow.php                # Booking processing
├── user_login.php             # User login page
├── user_register.php          # User registration page
├── user_dashboard.php         # User dashboard
├── booking_confirmation.php   # Booking confirmation
├── reservation.php            # Reservation lookup
├── logout.php                 # Logout script
│
├── hotel.sql                  # Database structure
└── README.md                  # Project documentation
```

## 📸 Screenshots
<details>
### Homepage
![Homepage](https://via.placeholder.com/800x400?text=Homepage)

### Room Listing
![Room Listing](https://via.placeholder.com/800x400?text=Room+Listing)

### Booking Form
![Booking Form](https://via.placeholder.com/800x400?text=Booking+Form)

### User Dashboard
![User Dashboard](https://via.placeholder.com/800x400?text=User+Dashboard)

### Admin Dashboard
![Admin Dashboard](https://via.placeholder.com/800x400?text=Admin+Dashboard)
</details>

## 🚀 Usage Flow

### For Users:
1. Browse available rooms on the homepage or rooms page
2. Select a room and click "Book Now"
3. Fill in the booking form with required information
4. Complete the booking process
5. Receive a booking confirmation with details
6. Login to the user dashboard to manage bookings

### For Admins:
1. Login to the admin panel
2. View booking statistics on the dashboard
3. Manage rooms and room categories
4. View and manage all bookings
5. Handle customer inquiries and requests

## 📝 Notes

- Make sure to set appropriate file permissions on the server
- The system uses a simple authentication method for demonstration purposes
- In a production environment, implement additional security measures
- Default database configuration assumes local development with XAMPP




