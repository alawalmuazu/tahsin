<?php
define('BASEPATH', true);
require 'application/config/database.php';
$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM email_templates_details WHERE template_id = 2");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "branch_id: " . $row['branch_id'] . " - notified: " . $row['notified'] . "\n";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
