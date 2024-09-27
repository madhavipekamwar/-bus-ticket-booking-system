<?php
include 'db_connect.php';
// Step 2: Get form data from POST
$start = $_POST['start_destination'];
$end = $_POST['end_destination'];
$seat_type = $_POST['seat_type'];

// Step 3: Retrieve base price from the database for the selected route
$query = "SELECT price FROM destinations WHERE start = '$start' AND end = '$end'";
$result = mysqli_query($conn, $query);
$base_price = mysqli_fetch_assoc($result)['price'];

// Step 4: Calculate the total price based on seat type
if ($seat_type == 'single') {
    $total_price = $base_price + 300; // Add premium for single seat
} else {
    $total_price = $base_price; // Regular price for double seat
}

// Step 5: Output the total price
echo "Total Price: ₹" . $total_price;

// Close the database connection
$conn->close();
?>

