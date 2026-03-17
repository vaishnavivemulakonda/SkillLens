<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - SkillLens</title>
    <link rel="stylesheet" href="/skilllens_ai/assets/css/style.css">
    <link rel="stylesheet" href="/skilllens_ai/assets/css/layout.css">
</head>
<body>

<<header>
    <div class="logo">
        💎 <span>SkillLens</span>
    </div>

    <div class="nav-links">
        <a href="login.php">Login</a>
    </div>
</header>

<main>

<div class="auth-container">
    <div class="left-panel">
        Welcome to SkillLens
    </div>

    <div class="right-panel">
        <h2>Register</h2>

        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="register">

            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="btn">Register</button>
        </form>

        <a href="login.php" class="link">Already have an account? Login</a>
    </div>
</div>

</main>

<footer>
    © <?php echo date("Y"); ?> SkillLens. All rights reserved.
</footer>
</body>
</html>