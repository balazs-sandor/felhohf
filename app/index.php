<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="hu">

<?php include 'head.html'; ?>

<body>
<?php include 'navbar.html'; ?>
    <h2>Feltöltött képek</h2>
    <?php
    $result = $conn->query("SELECT * FROM images ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        $imgData = base64_encode($row['detectionimage']);
        echo "<div style='margin-bottom:20px;'>";
        echo "<p><strong>Leírás:</strong> " . htmlspecialchars($row['description']) . "</p>";
        echo "<p><strong>Emberek száma:</strong> " . $row['people'] . "</p>";
        echo "<img src='data:image/jpeg;base64,{$imgData}' width='400'>";
        echo "</div>";
    }
    ?>
</body>
</html>
