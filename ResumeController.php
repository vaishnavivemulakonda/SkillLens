<?php
session_start();
require_once "../config/database.php";
require_once "../services/GroqService.php";
require_once "../services/YouTubeService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

/* =====================================================
   NEW CHECK (DO NOT CREATE NEW RESUME IF EXISTS)
===================================================== */

$stmtCheck = $conn->prepare("
    SELECT id FROM resumes
    WHERE user_id = ?
    ORDER BY id DESC
    LIMIT 1
");

$stmtCheck->bind_param("i", $userId);
$stmtCheck->execute();
$resCheck = $stmtCheck->get_result();

if ($resCheck->num_rows > 0) {

    $row = $resCheck->fetch_assoc();
    $resumeId = $row['id'];

    /* Store resume id in session */
    $_SESSION['active_resume_id'] = $resumeId;

    /* Redirect to existing plan */
    header("Location: ../public/plan.php?id=" . $resumeId);
    exit;
}

/* =====================================================
   EXISTING CODE STARTS (UNCHANGED)
===================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/dashboard.php");
    exit;
}

/* ===============================
   Validate Target Role
================================ */
$targetRole = $_POST['target_role'] ?? '';

if (empty($targetRole)) {
    die("Please select a target role.");
}

/* ===============================
   Validate Resume Upload
================================ */
if (!isset($_FILES['resume']) || $_FILES['resume']['error'] != 0) {
    die("No resume uploaded.");
}

$allowed = ['pdf','doc','docx'];
$fileName = $_FILES['resume']['name'];
$fileTmp  = $_FILES['resume']['tmp_name'];
$fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowed)) {
    die("Invalid file type! Only PDF, DOC, DOCX allowed.");
}

/* ===============================
   Upload File
================================ */
$uploadDir = "../assets/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$newFileName = time() . "_" . basename($fileName);
$filePath = $uploadDir . $newFileName;

if (!move_uploaded_file($fileTmp, $filePath)) {
    die("Resume upload failed.");
}

/* ===============================
   Extract Resume Text
================================ */
$resumeText = "User uploaded a resume. Generate roadmap for role: " . $targetRole;

/* ===============================
   Generate AI Plan (Groq)
================================ */
$groq = new GroqService();
$plan = $groq->generatePlan($resumeText, $targetRole);

if (empty($plan)) {
    die("AI RESPONSE: " . $plan);
}

/* ===============================
   Save Resume Record
================================ */
$stmt = $conn->prepare("
    INSERT INTO resumes (user_id, file_name, file_path, target_role, upskilling_plan)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("issss",
    $userId,
    $fileName,
    $filePath,
    $targetRole,
    $plan
);

$stmt->execute();

$stmt = $conn->prepare("
    SELECT id FROM resumes
    WHERE user_id = ?
    ORDER BY id DESC
    LIMIT 1
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$resumeId = $row['id'];

/* ===============================
   Break Plan into Clean Days
================================ */
$days = [];

/* Extract only proper Day lines */
preg_match_all('/Day\s*\d+\s*:\s*(.*)/i', $plan, $matches);

if (!empty($matches[0])) {
    $days = $matches[0];
}

/* Ensure only 30 days */
$days = array_slice($days, 0, 30);

/* ===============================
   Insert Roadmap Days
================================ */
$yt = new YouTubeService();

foreach ($days as $index => $topic) {

    $dayNumber = $index + 1;

    if ($dayNumber <= 10) {
        $level = 'basic';
    } elseif ($dayNumber <= 20) {
        $level = 'intermediate';
    } else {
        $level = 'advanced';
    }

    $videoId = $yt->getVideo($topic);
    if (!$videoId) {
        $videoId = null;
    }

    $stmtDay = $conn->prepare("
        INSERT INTO roadmap_days
        (resume_id, day_number, level, topic, video_id)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmtDay->bind_param("iisss",
        $resumeId,
        $dayNumber,
        $level,
        $topic,
        $videoId
    );

    $stmtDay->execute();
}

/* ===============================
   Redirect to Plan Page
================================ */
$_SESSION['active_resume_id'] = $resumeId;

header("Location: ../public/plan.php?id=" . $resumeId);
exit;
?>