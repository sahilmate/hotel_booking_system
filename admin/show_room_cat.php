<?php
include_once 'admin/include/class.user.php';
$user = new User();

// Fetch room categories from the database
$sql = "SELECT * FROM room_category";
$result = $user->db->query($sql);

if ($result && $result->num_rows > 0) {
    // Display each room category
    while ($row = $result->fetch_assoc()) {
        echo "<div class='room-category'>";
        echo "<h4>Room Name: " . htmlspecialchars($row['roomname']) . "</h4>";
        echo "<p>Number of Beds: " . htmlspecialchars($row['no_bed']) . " (" . htmlspecialchars($row['bedtype']) . " bed)</p>";
        echo "<p>Available Rooms: " . htmlspecialchars($row['available']) . "</p>";
        echo "<p>Booked Rooms: " . htmlspecialchars($row['booked']) . "</p>";
        echo "<p>Facilities: " . htmlspecialchars($row['facility']) . "</p>";
        echo "<p>Price: " . htmlspecialchars($row['price']) . " Rs/night</p>";
        echo "</div><hr>";
    }
} else {
    echo "<p>No room categories found.</p>";
}
?>
