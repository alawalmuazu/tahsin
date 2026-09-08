<?php
$mysqli = new mysqli("localhost", "root", "", "smartschool");
$res = $mysqli->query("DESCRIBE branch");
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
