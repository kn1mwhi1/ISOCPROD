<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST["name"];
$email = $_POST["email"];
$page = $_POST["page"];
$issue = $_POST["issue"];
$recreate = $_POST["recreate"];

header("Location: confirm_issue.php");
}

?>