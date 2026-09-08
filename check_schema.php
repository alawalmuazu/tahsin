<?php
$mysqli = new mysqli("localhost", "root", "", "smartschool");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$res = $mysqli->query("DESCRIBE login_credential");
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . " - Null: " . $row['Null'] . "\n";
}
echo "\nDESCRIBE global_settings\n";
$res = $mysqli->query("DESCRIBE global_settings");
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
