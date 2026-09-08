<?php
$mysqli = new mysqli("localhost", "root", "", "smartschool");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$queries = [
    "ALTER TABLE login_credential MODIFY username VARCHAR(100) NULL DEFAULT NULL",
    "ALTER TABLE login_credential MODIFY password VARCHAR(250) NULL DEFAULT NULL",
    "ALTER TABLE login_credential ADD setup_token VARCHAR(255) NULL DEFAULT NULL AFTER role",
    "ALTER TABLE branch ADD public_registration TINYINT(1) NOT NULL DEFAULT 0 AFTER grd_default_password"
];

foreach ($queries as $query) {
    if ($mysqli->query($query) === TRUE) {
        echo "Successfully executed: $query\n";
    } else {
        echo "Error executing $query: " . $mysqli->error . "\n";
    }
}
$mysqli->close();
echo "Migration complete.\n";
