<?php
include "db_config.php";

class User
{
    public $db;

    public function __construct()
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        if (mysqli_connect_errno()) {
            echo "Error: Could not connect to database. " . mysqli_connect_error();
            exit;
        }
    }

    public function reg_user($name, $username, $password, $email)
    {
        $sql = "SELECT * FROM manager WHERE uname=? OR uemail=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $check = $stmt->get_result();
        $count_row = $check->num_rows;

        if ($count_row == 0) {
            $sql1 = "INSERT INTO manager (uname, upass, fullname, uemail) VALUES (?, ?, ?, ?)";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->bind_param("ssss", $username, $password, $name, $email); // No hashing
            $result = $stmt1->execute();
            return $result;
        } else {
            return false;
        }
    }

    public function check_login($emailusername, $password)
    {
        $sql2 = "SELECT uid, upass FROM manager WHERE uemail=? OR uname=?";
        $stmt = $this->db->prepare($sql2);
        $stmt->bind_param("ss", $emailusername, $emailusername);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();

        // Debug: Check the output
        if ($user_data) {
            echo "User Found: UID=" . $user_data['uid'] . " UPASS=" . $user_data['upass'] . "<br>";
        } else {
            echo "User Not Found.<br>";
        }

        // Simple password check without hashing
        if ($user_data && $password === $user_data['upass']) {
            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user_data['uid'];
            return true;
        } else {
            echo "Password verification failed.<br>";
            return false;
        }
    }

    public function add_room($roomname, $room_qnty, $no_bed, $bedtype, $facility, $price)
{
    $available = $room_qnty; // Number of available rooms
    $booked = 0; // Initial booked rooms count

    // SQL query to insert room details into room_category
    $sql = "INSERT INTO room_category (roomname, available, booked, room_qnty, no_bed, bedtype, facility, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    
    // Ensure that the bind_param types and count match the SQL statement
    $stmt->bind_param("siisssss", $roomname, $available, $booked, $room_qnty, $no_bed, $bedtype, $facility, $price);
    
    if (!$stmt->execute()) {
        die(mysqli_connect_errno() . " Data cannot be inserted");
    }

    // Loop to add rooms based on quantity
    for ($i = 0; $i < $room_qnty; $i++) {
        $sql2 = "INSERT INTO rooms (room_cat, book) VALUES (?, 'false')";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bind_param("s", $roomname);
        $stmt2->execute();
    }

    return true; // Return true if room addition was successful
}



public function edit_room_cat($roomname, $room_qnty, $no_bed, $bedtype, $facility, $price, $room_cat)
{
    // First delete existing rooms of this category
    $sql2 = "DELETE FROM rooms WHERE room_cat=?";
    $stmt2 = $this->db->prepare($sql2);
    $stmt2->bind_param("s", $room_cat);
    $stmt2->execute();

    // Insert new room records
    for ($i = 0; $i < $room_qnty; $i++) {
        $sql3 = "INSERT INTO rooms SET room_cat=?, book='false'";
        $stmt3 = $this->db->prepare($sql3);
        $stmt3->bind_param("s", $roomname);
        $stmt3->execute();
    }

    // Update the room category details
    $available = $room_qnty; // Update available rooms
    $booked = 0; // Reset booked rooms

    $sql = "UPDATE room_category SET roomname=?, available=?, booked=?, room_qnty=?, no_bed=?, bedtype=?, facility=?, price=? WHERE roomname=?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("siisssss", $roomname, $available, $booked, $room_qnty, $no_bed, $bedtype, $facility, $price, $room_cat);
    $send = $stmt->execute();

    return $send ? "Updated Successfully!!" : "Sorry, Internal Error";
}

public function check_available($checkin, $checkout) {
    $sql = "SELECT * FROM rooms WHERE checkin >= ? AND checkout <= ?";
    $stmt = $this->db->prepare($sql);

    if ($stmt === false) {
        return false; // Query failed to prepare
    }

    // Bind the checkin and checkout dates to the query
    $stmt->bind_param('ss', $checkin, $checkout);
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    // Check for errors or empty results
    if ($result === false || $result->num_rows === 0) {
        return false;
    }

    return $result;
}

public function booknow($checkin, $checkout, $name, $phone, $roomname) {
    // Get room details from the room_category table
    $sql = "SELECT available, booked FROM room_category WHERE roomname = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $roomname);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $available_rooms = $row['available'];
        
        if ($available_rooms > 0) {
            // Get a specific room from the rooms table for booking
            $sql2 = "SELECT room_id FROM rooms WHERE room_cat = ? AND book = 'false' LIMIT 1";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bind_param("s", $roomname);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            
            if ($result2->num_rows > 0) {
                $room = $result2->fetch_assoc();
                $room_id = $room['room_id'];
                
                // Insert booking into the bookings table
                $sql3 = "INSERT INTO bookings (room_id, user_id, check_in, check_out) VALUES (?, ?, ?, ?)";
                $stmt3 = $this->db->prepare($sql3);
                $user_id = 1; // Replace with actual user ID from session or input
                $stmt3->bind_param("iiss", $room_id, $user_id, $checkin, $checkout);
                $result3 = $stmt3->execute();
                
                if ($result3) {
                    // Update room_category and rooms tables
                    $sql4 = "UPDATE room_category SET available = available - 1, booked = booked + 1 WHERE roomname = ?";
                    $stmt4 = $this->db->prepare($sql4);
                    $stmt4->bind_param("s", $roomname);
                    $stmt4->execute();
                    
                    $sql5 = "UPDATE rooms SET book = 'true', checkin = ?, checkout = ?, name = ?, phone = ? WHERE room_id = ?";
                    $stmt5 = $this->db->prepare($sql5);
                    $stmt5->bind_param("ssssi", $checkin, $checkout, $name, $phone, $room_id);
                    $stmt5->execute();
                    
                    return "Room successfully booked!";
                } else {
                    return "Failed to book the room.";
                }
            } else {
                return "No available rooms in this category.";
            }
        } else {
            return "No rooms available for booking.";
        }
    } else {
        return "Room category not found.";
    }
}




public function edit_all_room($checkin, $checkout, $name, $phone, $id) {
    // Prepare the SQL query to update the room details
    $sql = "UPDATE rooms SET checkin = ?, checkout = ?, name = ?, phone = ? WHERE room_id = ?";
    $stmt = $this->db->prepare($sql);
    
    // Bind parameters to the query
    $stmt->bind_param("ssssi", $checkin, $checkout, $name, $phone, $id);
    
    // Execute the query
    if ($stmt->execute()) {
        return "Room details successfully updated!";
    } else {
        return "Failed to update room details: " . $this->db->error;
    }
}

    public function get_session()
    {
        return $_SESSION['login'];
    }

    public function user_logout()
    {
        $_SESSION['login'] = false;
        session_destroy();
    }
}
