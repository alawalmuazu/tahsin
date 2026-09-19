<?php
$mysqli = new mysqli("localhost", "root", "", "tahsin", 3306, "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock");
$result = $mysqli->query("SELECT * FROM staff_designation");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
$result = $mysqli->query("SELECT * FROM staff_department");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
