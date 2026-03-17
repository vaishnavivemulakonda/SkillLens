<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$resumeId = $_GET['id'] ?? 0;

$stmt = $conn->prepare("
    SELECT * FROM roadmap_days
    WHERE resume_id = ?
    ORDER BY day_number ASC
");
$stmt->bind_param("i", $resumeId);
$stmt->execute();
$result = $stmt->get_result();

$basic = [];
$intermediate = [];
$advanced = [];

while ($row = $result->fetch_assoc()) {
    if ($row['level'] === 'basic') {
        $basic[] = $row;
    } elseif ($row['level'] === 'intermediate') {
        $intermediate[] = $row;
    } else {
        $advanced[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>30-Day Plan</title>
    <link rel="stylesheet" href="/skilllens_ai/assets/css/plan.css">
</head>
<body>

<header>
    <div class="plan-header">

    <div class="plan-logo">
        💎 SkillLens
    </div>

    <div class="plan-actions">

        <a href="dashboard.php" class="dashboard-btn">
            Dashboard
        </a>

        <a href="download_plan.php?id=<?= $resumeId ?>" class="download-btn">
            ↓ Download Full Plan (.txt)
        </a>

        <a href="aptitude_plan.php" class="start-btn">
        Aptitude Plan
        </a>

    </div>

</div>
</header>

<main class="plan-container">
<h2 class="plan-title">📅 Your 30-Day AI Upskilling Plan</h2>
<div class="plan-cards">
<div class="plan-card">
<!-- BASIC CARD -->
    <div class="card-content">
        <h3>🟢 Basic Level</h3>
        <p class="level-desc">Day 1 – Day 10</p>

        <?php foreach ($basic as $day): ?>
            <div class="topic-item">
                <a href="progress.php?resume_id=<?= $resumeId ?>&day=<?= $day['day_number'] ?>">
                    <?php if ($day['is_completed']): ?>
                <span style="color:#22c55e;">✔</span>
                 <?php endif; ?>
                    Day <?= $day['day_number']; ?> -
                    <?= htmlspecialchars($day['topic']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- INTERMEDIATE CARD -->
<div class="plan-card">

    <div class="card-content">
        <h3>🟡 Intermediate Level</h3>
        <p class="level-desc">Day 11 – Day 20</p>

        <?php foreach ($intermediate as $day): ?>
            <div class="topic-item">
                <a href="progress.php?resume_id=<?= $resumeId ?>&day=<?= $day['day_number'] ?>">
                    <?php if ($day['is_completed']): ?>
                <span style="color:#22c55e;">✔</span>
                <?php endif; ?>
                    Day <?= $day['day_number']; ?> -
                    <?= htmlspecialchars($day['topic']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- ADVANCED CARD -->
    <div class="plan-card">

    <div class="card-content">
        <h3>🔴 Advanced Level</h3>
        <p class="level-desc">Day 21 – Day 30</p>

        <?php foreach ($advanced as $day): ?>
            <div class="topic-item">
                <a href="progress.php?resume_id=<?= $resumeId ?>&day=<?= $day['day_number'] ?>">
                    <?php if ($day['is_completed']): ?>
                <span style="color:#22c55e;">✔</span>
                <?php endif; ?>
                    Day <?= $day['day_number']; ?> -
                    <?= htmlspecialchars($day['topic']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</main>

<footer>
    © <?= date("Y"); ?> SkillLens
</footer>

</body>
</html>