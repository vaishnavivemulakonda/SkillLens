<?php
$result = $conn->query("
    SELECT r.*, 
           IFNULL(p.is_completed, 0) as completed
    FROM roadmap r
    LEFT JOIN progress p 
    ON r.user_id = p.user_id AND r.day_number = p.day_number
    WHERE r.user_id = $userId
    ORDER BY r.day_number ASC
");
?>

<?php while($row = $result->fetch_assoc()): ?>

<div class="day-card <?= $row['is_unlocked'] ? '' : 'locked' ?>">

    <h3>Day <?= $row['day_number'] ?> - <?= $row['topic'] ?></h3>

    <?php if($row['is_unlocked']): ?>

        <?php if(!$row['completed']): ?>
            <form method="POST" action="../controllers/ProgressController.php">
                <input type="hidden" name="day_number" value="<?= $row['day_number'] ?>">
                <button class="complete-btn">Mark Complete</button>
            </form>
        <?php else: ?>
            <span class="completed-badge">✔ Completed</span>
        <?php endif; ?>

    <?php else: ?>
        <span class="locked-icon">🔒 Locked</span>
    <?php endif; ?>

</div>

<?php endwhile; ?>