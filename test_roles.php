<?php
$mysqli = new mysqli("localhost", "root", "", "tahsin", 3306, "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$result = $mysqli->query("SELECT * FROM roles");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
