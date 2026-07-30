<?php
$mysqli = new mysqli('localhost', 'root', 'abc_123', 'lms_multitenant');
$res = $mysqli->query('SHOW CREATE TABLE users');
$row = $res->fetch_assoc();
print_r($row);
