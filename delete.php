<?php
include '../db.php';
$type = $_GET['type'];
$id = $_GET['id'];

$conn->query("DELETE FROM $type WHERE id=$id");

header("Location: dashboard.php");
exit;
?>
