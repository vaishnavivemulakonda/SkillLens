<?php
session_start();
require_once "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

/* Latest resume */

$stmt = $conn->prepare("
SELECT * FROM resumes
WHERE user_id = ?
ORDER BY id DESC
LIMIT 1
");

$stmt->bind_param("i",$userId);
$stmt->execute();
$res = $stmt->get_result();
$resume = $res->fetch_assoc();

$resumeId = $resume['id'] ?? 0;
$targetRole = $resume['target_role'] ?? 'Software Developer';


/* Learning Progress */

$stmt2 = $conn->prepare("
SELECT COUNT(*) as completed
FROM roadmap_days
WHERE resume_id = ? AND is_completed = 1
");

$stmt2->bind_param("i",$resumeId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$data = $result2->fetch_assoc();
$testsTaken = $data['tests'] ?? 0;
$avgScore = round($data['avg_score'],2);

$completedDays = $data['completed'] ?? 0;
$totalDays = 30;

$percentage = round(($completedDays/$totalDays)*100);
?>


<!DOCTYPE html>
<html>
<head>

<title>My Profile | SkillLens</title>

<link rel="stylesheet" href="../assets/css/profile.css?v=1">

</head>

<body>


<!-- HEADER -->

<div class="header">

<div class="logo">💎 SkillLens</div>

<div class="nav-links">
<a href="login.php" class="logout-btn">Logout</a>
</div>

</div>



<!-- PROFILE CONTENT -->

<div class="profile-container">

<div class="profile-title">
<h1>👤 My Profile</h1>
<p>Your learning & progress overview</p>
</div>


<!-- CARD 1 -->

<div class="profile-card">

<h3>📋 Basic Information</h3>

<div class="info-row">
<span>Name</span>
<strong><?= htmlspecialchars($userName ?? 'Student') ?></strong>
</div>

<div class="info-row">
<span>Target Role</span>
<strong><?=$targetRole?></strong>
</div>

</div>


<!-- CARD 2 -->

<div class="profile-card">

<h3>📊 Learning Progress</h3>

<p><?=$completedDays?> / <?=$totalDays?> days completed</p>

<p><strong><?=$percentage?>% completed</strong></p>

<div class="progress-bar">
<div class="progress-fill" style="width:<?=$percentage?>%"></div>
</div>

<a href="plan.php?id=<?=$resumeId?>" class="continue-btn">
▶ Continue Learning
</a>
</div>

</div>

<!-- FOOTER -->
<div class="footer">
© 2026 SkillLens. All rights reserved.
</div>
</body>
</html>