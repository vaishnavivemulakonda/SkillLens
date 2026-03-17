<?php
session_start();
require_once "../config/database.php";

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit;
}

$userId = $_SESSION['user_id'];
$day = isset($_GET['day']) ? (int)$_GET['day'] : 1;


/* 30 Day Topics */

$topics = [

1=>"Percentages",
2=>"Profit and Loss",
3=>"Number Series",
4=>"Blood Relations",
5=>"Coding Decoding",
6=>"Reading Comprehension",
7=>"Pie Charts",
8=>"Seating Arrangement",
9=>"Probability",
10=>"Time and Work",

11=>"Ratio and Proportion",
12=>"Permutations and Combinations",
13=>"Data Sufficiency",
14=>"Syllogisms",
15=>"Analogies",
16=>"Distance and Direction",
17=>"Clocks and Calendars",
18=>"Mixtures and Alligations",
19=>"Simple Interest and Compound Interest",
20=>"Bar Charts",

21=>"Line Graphs",
22=>"Caselets",
23=>"Statement and Assumptions",
24=>"Statement and Arguments",
25=>"Course of Action",
26=>"Logical Puzzles",
27=>"Grid Puzzles",
28=>"Data Analysis",
29=>"Tables and Graphs",
30=>"Advanced Reasoning Techniques"

];

$topic = $topics[$day] ?? "Percentages";

/* Create YouTube Search Link */

$youtubeLink = "https://www.youtube.com/results?search_query=" . urlencode($topic . " aptitude placement");



/* Check if completed */

$stmt = $conn->prepare("
SELECT id 
FROM aptitude_progress 
WHERE user_id=? AND day_number=?
");

$stmt->bind_param("ii",$userId,$day);
$stmt->execute();
$result = $stmt->get_result();

$isCompleted = $result->num_rows > 0;

?>


<!DOCTYPE html>
<html>

<head>

<title>Aptitude Learning</title>

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

.video-container{
width:900px;
max-width:95%;
margin:120px auto;
}

.video-card{
background:#111827;
padding:40px;
border-radius:20px;
box-shadow:0 0 30px rgba(34,211,238,0.1);
text-align:center;
}


/* BUTTON */

.watch-btn{
display:inline-block;
margin-top:25px;
padding:14px 28px;
border-radius:30px;
background:linear-gradient(90deg,#22d3ee,#3b82f6);
color:white;
text-decoration:none;
font-weight:500;
}

.watch-btn:hover{
transform:scale(1.05);
}


.complete-btn{
margin-top:20px;
padding:12px 25px;
border-radius:30px;
background:#22d3ee;
border:none;
color:white;
cursor:pointer;
}

.completed-btn{
margin-top:20px;
padding:12px 25px;
border-radius:30px;
background:#22c55e;
border:none;
color:white;
}


/* BACK LINK */

.back{
display:inline-block;
margin-top:20px;
color:#22d3ee;
text-decoration:none;
}


/* FOOTER */

footer{
text-align:center;
padding:20px;
border-top:1px solid rgba(255,255,255,0.05);
color:#94a3b8;
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


<div class="video-container">

<h2>Day <?= $day ?> - <?= htmlspecialchars($topic) ?></h2>

<div class="video-card">

<a href="<?= $youtubeLink ?>" target="_blank" class="watch-btn">
▶ Watch Aptitude Video
</a>

<br>

<?php if(!$isCompleted): ?>

<form method="POST" action="complete_aptitude_day.php">

<input type="hidden" name="day_number" value="<?= $day ?>">

</form>

<?php else: ?>

<button class="completed-btn">
✔ Completed
</button>

<?php endif; ?>

</div>

<a class="back" href="aptitude_plan.php">← Back to Aptitude Plan</a>

</div>


<footer>

© <?= date("Y") ?> SkillLens

</footer>

</body>
</html>
