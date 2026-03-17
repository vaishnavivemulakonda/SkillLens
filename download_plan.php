<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$resumeId = $_GET['id'] ?? 0;

$stmt = $conn->prepare("
    SELECT day_number, topic 
    FROM roadmap_days 
    WHERE resume_id = ?
    ORDER BY day_number ASC
");

$stmt->bind_param("i", $resumeId);
$stmt->execute();
$result = $stmt->get_result();

$filename = "SkillLens_30_Day_Plan.txt";

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=$filename");

while ($row = $result->fetch_assoc()) {
    echo "Day " . $row['day_number'] . ": " . $row['topic'] . "\n\n";
}

exit;
?>