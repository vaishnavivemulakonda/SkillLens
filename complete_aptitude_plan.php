<?php
session_start();
require_once "../config/database.php";

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit;
}

$userId = $_SESSION['user_id'];
$day = (int)$_POST['day_number'];


/* Mark Day Completed */

$stmt = $conn->prepare("
UPDATE aptitude_days
SET is_completed = 1
WHERE user_id=? AND day_number=?
");

$stmt->bind_param("ii",$userId,$day);
$stmt->execute();


/* Redirect to Next Day */

$nextDay = $day + 1;

if($nextDay <= 30){
header("Location: aptitude_video.php?day=".$nextDay);
}
else{
header("Location: aptitude_plan.php");
}
?>
