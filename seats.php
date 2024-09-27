<?php
include 'db_connect.php';
$sql = "SELECT * FROM seats WHERE status = 'available'";
$result = $conn->query($sql);

// Step 3: Display available seats in HTML (modify as per your needs)
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='seat' data-seat-id='" . $row['seat_id'] . "'>" . $row['seat_type'] . " " . $row['seat_number'] . "</div>";
    }
} else {
    echo "No available seats.";
}

// Step 4: Handle seat booking via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get seat ID from form or AJAX
    $seat_id = $_POST['seat_id'];

    // Update seat status to booked
    $update_sql = "UPDATE seats SET status = 'booked' WHERE seat_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $seat_id);

    if ($stmt->execute()) {
        echo "Seat booked successfully!";
    } else {
        echo "Error booking seat: " . $stmt->error;
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
