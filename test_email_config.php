<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "tahsin");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$result = $mysqli->query("SELECT * FROM email_config");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
