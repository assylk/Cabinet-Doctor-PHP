<?php
include('includes/dbconnection.php');



// Get the specialization from the request
$specialization = $_GET['specialization'];

// Prepare SQL query to retrieve doctors based on specialization
$sql = "SELECT name, email FROM doctors WHERE specialization = '$specialization'";

$result = $conn->query($sql);

$doctors = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $doctor = array(
            "name" => $row["name"],
            "email" => $row["email"]
        );
        $doctors[] = $doctor;
    }
}

// Close connection
$conn->close();

// Output doctors data in JSON format
header('Content-Type: application/json');
echo json_encode($doctors);
?>