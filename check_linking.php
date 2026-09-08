<?php
$mysqli = new mysqli("localhost", "root", "", "smartschool");
$res = $mysqli->query("DESCRIBE student");
while ($row = $res->fetch_assoc()) {
    if ($row['Field'] == 'parent_id' || $row['Field'] == 'guardian_id') {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
}
$res = $mysqli->query("DESCRIBE parent");
while ($row = $res->fetch_assoc()) {
    if ($row['Field'] == 'student_id') {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
}
