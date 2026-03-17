<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - SkillLens</title>
    <link rel="stylesheet" href="/skilllens_ai/assets/css/style.css">
    <link rel="stylesheet" href="/skilllens_ai/assets/css/layout.css">
</head>
<body>

<header>
    <div class="logo">
        💎 <span>SkillLens</span>
    </div>

    <div class="nav-links">
        <a href="/skilllens_ai/public/progress.php" class="dashboard-btn">
        Progress
        </a>
        <a href="aptitude_plan.php" class="start-btn">
        Aptitude Preparation
        </a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<main>

<div class="dashboard-wrapper">
    
    <h2 style="margin-bottom:5px;">
        Welcome, <?= $_SESSION['username']; ?> 👋
    </h2>

    <p class="subtitle">
        Your Resume Skill Analyzer Dashboard
    </p>

    <form action="../controllers/ResumeController.php"
          method="POST"
          enctype="multipart/form-data">

        <!-- Upload Resume -->
        <div class="dashboard-card">

            <div class="card-left">
                <h3>📄 Upload Your Resume</h3>
                <p>Upload your resume in PDF or DOCX format.</p>
            </div>

            <input type="file"
                   name="resume"
                   accept=".pdf,.doc,.docx"
                   required
                   class="file-input">
        </div>

        <!-- Target Role -->
        <div class="dashboard-card">

            <div class="card-left">
                <h3>🎯 Target Job Role</h3>
                <p>Select the role you are preparing for.</p>
            </div>

            <select name="target_role"
                    required
                    class="role-select">
                <option value="">Select role</option>
                <option>Software Developer</option>
                <option>Frontend Developer</option>
                <option>Backend Developer</option>
                <option>Full Stack Developer</option>
                <option>Data Analyst</option>
                <option>AI/ML Engineer</option>
            </select>
        </div>

        <!-- Analyze Resume -->
        <div class="dashboard-card" style="flex-direction:column; align-items:stretch;">

            <div class="card-left" style="margin-bottom:15px;">
                <h3>🚀 Analyze Resume</h3>
                <p>Get skill gap analysis and a 30-day upskilling plan.</p>
            </div>

            <button type="submit" class="analyze-btn">
                Analyze Resume
            </button>

        </div>

    </form>

</div>

</main>
<footer>
    © <?php echo date("Y"); ?> SkillLens. All rights reserved.
</footer>

</body>
</html>