<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - SkillLens</title>
    <link rel="stylesheet" href="/skilllens_ai/assets/css/style.css">
    <link rel="stylesheet" href="/skilllens_ai/assets/css/layout.css">
</head>
<body>

<header>
    <div class="logo">
        💎 <span>SkillLens</span>
    </div>

    <div class="nav-links">
        <a href="register.php">Register</a>
    </div>
</header>

<main>

<div class="auth-container">
    <div class="left-panel">
        Welcome Back
    </div>

    <div class="right-panel">
        <h2>Login</h2>

        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="login">

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="btn">Login</button>
        </form>

        <a href="register.php" class="link">Don't have an account? Register</a>
    </div>
</div>

</main>

<footer>
    © <?php echo date("Y"); ?> SkillLens. All rights reserved.
</footer>
</body>
</html>