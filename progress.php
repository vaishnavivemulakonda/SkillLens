<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

/* Get user's resume */

$stmt = $conn->prepare("
SELECT id FROM resumes
WHERE user_id = ?
LIMIT 1
");

$stmt->bind_param("i",$userId);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$resumeId = $row['id'] ?? 0;

/* Total roadmap days */

$totalDays = 30;

/* Completed days */

$stmt = $conn->prepare("
SELECT COUNT(*) as completed
FROM roadmap_days
WHERE resume_id=? AND is_completed=1
");

$stmt->bind_param("i",$resumeId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$completed = $data['completed'] ?? 0;
$remaining = $totalDays - $completed;

$percentage = ($completed / $totalDays) * 100;
?>

<!DOCTYPE html>
<html>

<head>

<title>Learning Progress</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
margin:0;
font-family:Inter, sans-serif;
background:linear-gradient(to bottom,#0b1220,#0f172a);
color:white;
}

/* HEADER */

.header{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 80px;
background:#0b1220;
border-bottom:1px solid rgba(255,255,255,0.05);
}

.logo{
font-weight:600;
}

.nav-links a{
margin-left:20px;
text-decoration:none;
color:#cbd5e1;
}

.nav-links a:hover{
color:#22d3ee;
}

/* CONTAINER */

.progress-container{
width:900px;
max-width:95%;
margin:120px auto;
text-align:center;
}

/* CARD */

.progress-card{
background:#111827;
padding:40px;
border-radius:20px;
box-shadow:0 0 30px rgba(34,211,238,0.1);
}

/* STATS */

.progress-stats{
display:flex;
justify-content:center;
gap:40px;
margin-top:30px;
flex-wrap:wrap;
}

.stat-box{
background:#0f172a;
padding:20px;
border-radius:12px;
width:180px;
text-align:center;
}

.stat-box h3{
margin:0;
font-size:28px;
color:#22d3ee;
}

/* CHART */

.chart-wrapper{
display:flex;
justify-content:center;
align-items:center;
margin-top:40px;
}

.chart-wrapper canvas{
max-width:320px;
max-height:320px;
}

/* FOOTER */

footer{
text-align:center;
padding:20px;
border-top:1px solid rgba(255,255,255,0.05);
color:#94a3b8;
margin-top:80px;
}

</style>

</head>

<body>

<header class="header">

<div class="logo">💎 SkillLens</div>

<div class="nav-links">
<a href="dashboard.php">Dashboard</a>
<a href="profile.php">Profile</a>
<a href="logout.php">Logout</a>
</div>

</header>

<div class="progress-container">

<h2>📊 Your Learning Progress</h2>

<div class="progress-card">

<div class="progress-stats">

<div class="stat-box">
<h3><?= $completed ?></h3>
<p>Completed</p>
</div>

<div class="stat-box">
<h3><?= $remaining ?></h3>
<p>Remaining</p>
</div>

<div class="stat-box">
<h3><?= round($percentage) ?>%</h3>
<p>Progress</p>
</div>

</div>

<div class="chart-wrapper">
<canvas id="progressChart"></canvas>
</div>

</div>

</div>

<footer>

© <?= date("Y") ?> SkillLens

</footer>

<script>

const completed = <?= $completed ?>;
const remaining = <?= $remaining ?>;

const ctx = document.getElementById('progressChart');

new Chart(ctx, {

type: 'pie',

data: {

labels: ['Completed Topics', 'Remaining Topics'],

datasets: [{
data: [completed, remaining],
backgroundColor: [
'#22c55e',
'#334155'
],
borderWidth:1
}]

},

options:{
responsive:true,
maintainAspectRatio:true,

plugins:{
legend:{
position:'top',
labels:{
color:'white',
font:{
size:14
}
}
}
}
}

});

</script>

</body>
</html>