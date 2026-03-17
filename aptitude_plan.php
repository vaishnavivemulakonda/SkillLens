<?php
session_start();

if (!isset($_SESSION['user_id'])) {
header("Location: login.php");
exit;
}

/* 30-Day Aptitude Plan */

$days = [

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
?>

<!DOCTYPE html>
<html>

<head>

<title>Aptitude Plan</title>

<style>

/* BODY */

body{
margin:0;
font-family:'Inter',sans-serif;
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
font-size:20px;
font-weight:600;
}

.nav-links a{
margin-left:20px;
color:#cbd5e1;
text-decoration:none;
}

.nav-links a:hover{
color:#22d3ee;
}


/* CONTAINER */

.plan-container{
width:1200px;
max-width:95%;
margin:120px auto 80px auto;
}


/* TITLE */

.plan-title{
text-align:center;
font-size:34px;
margin-bottom:60px;
}


/* CARD WRAPPER */

.plan-cards{
display:flex;
flex-direction:column;
gap:40px;
}


/* CARD */

.plan-card{
background:linear-gradient(145deg,#111827,#0b1220);
padding:40px;
border-radius:20px;
box-shadow:0 0 30px rgba(34,211,238,0.08);
transition:0.3s ease;
}

.plan-card:hover{
transform:translateY(-5px);
box-shadow:0 0 40px rgba(34,211,238,0.25);
}


/* LEVEL TITLE */

.plan-card h3{
font-size:22px;
margin-bottom:8px;
}


/* LEVEL DESCRIPTION */

.level-desc{
color:#94a3b8;
margin-bottom:20px;
}


/* TOPIC ITEMS */

.topic-item{
padding:10px 0;
border-bottom:1px solid rgba(255,255,255,0.05);
}

.topic-item a{
color:#cbd5e1;
text-decoration:none;
display:block;
}

.topic-item a:hover{
color:#22d3ee;
padding-left:6px;
}


/* FOOTER */

footer{
text-align:center;
padding:25px;
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


<div class="plan-container">

<h2 class="plan-title">
📅 Your 30-Day Aptitude Preparation Plan
</h2>


<div class="plan-cards">

<!-- BASIC LEVEL -->

<div class="plan-card">

<h3>🟢 Basic Level</h3>

<p class="level-desc">Day 1 – Day 10</p>

<?php for($i=0;$i<10;$i++): ?>

<div class="topic-item">

<a href="aptitude_video.php?day=<?= $i+1 ?>">
Day <?= $i+1 ?> - <?= $days[$i+1] ?>
</a>

</div>

<?php endfor; ?>

</div>



<!-- INTERMEDIATE LEVEL -->

<div class="plan-card">

<h3>🟡 Intermediate Level</h3>

<p class="level-desc">Day 11 – Day 20</p>

<?php for($i=10;$i<20;$i++): ?>

<div class="topic-item">

<a href="aptitude_video.php?day=<?= $i+1 ?>">

Day <?= $i+1 ?> - <?= htmlspecialchars($days[$i] ?? "") ?>

</a>

</div>

<?php endfor; ?>

</div>



<!-- ADVANCED LEVEL -->

<div class="plan-card">

<h3>🔴 Advanced Level</h3>

<p class="level-desc">Day 21 – Day 30</p>

<?php for($i=20;$i<30;$i++): ?>

<div class="topic-item">

<a href="aptitude_video.php?day=<?= $i+1 ?>">

Day <?= $i+1 ?> - <?= htmlspecialchars($days[$i] ?? "") ?>

</a>

</div>

<?php endfor; ?>

</div>


</div>

</div>


<footer>

© <?= date("Y") ?> SkillLens

</footer>

</body>
</html>