<?php

include 'db.php';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
$query = "SELECT * FROM corpo";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
mysqli_close($conn);

?>