<?php
include "db_connect.php";
$sql = "SELECT * FROM seats WHERE status = 'available'";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}

$availableSeats = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $availableSeats[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seat_id = $_POST['seat_id'];

    $update_sql = "UPDATE seats SET status = 'booked' WHERE seat_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $seat_id);

    if ($stmt->execute()) {
        echo "<script>alert('Seat booked successfully!');</script>";
    } else {
        echo "<script>alert('Error booking seat: " . $stmt->error . "');</script>";
    }

    $stmt->close();

    $sql = "SELECT * FROM seats WHERE status = 'available'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $availableSeats[] = $row;
        }
    }
}
$conn->close();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking System</title>
    <style>
        .seat-layout {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }
        .seat {
            border: 1px solid #007BFF;
            padding: 10px;
            margin: 5px;
            cursor: pointer;
        }
        .available {
            background-color: #28A745; /* Green for available */
        }
        .booked {
            background-color: #DC3545; /* Red for booked */
        }
    </style>
</head>
<body>

<h2>Available Seats</h2>
<div class="seat-layout">
<?php
if (!empty($availableSeats)) {
    foreach ($availableSeats as $seat) {
        echo "<div class='seat available' data-seat-id='" . $seat['seat_id'] . "'>" . $seat['seat_type'] . " " . $seat['seat_number'] . "</div>";
    }
} else {
    echo "No available seats.";
}
?>
</div>

<form id="booking-form" method="POST">
    <input type="hidden" name="seat_id" id="seat_id" value="">
    <button type="submit">Book Now</button>
</form>

<script>
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function() {
            const seatId = this.getAttribute('data-seat-id');
            document.getElementById('seat_id').value = seatId;
            this.classList.remove('available');
            this.classList.add('booked');
            this.innerText += ' (Booked)';
        });
    });
</script>

</body>
</html>
