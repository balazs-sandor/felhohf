<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Képfeltöltés ember detektálással</title>
</head>
<body>
    <h1>Kép feltöltése</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        Leírás: <input type="text" name="description" maxlength="500" required><br><br>
        Kép: <input type="file" name="image" accept="image/*" required><br><br>
        <input type="submit" value="Feltöltés">
    </form>

    <h2>Feliratkozás értesítésekre</h2>
    <form action="subscribe.php" method="POST">
        Email: <input type="email" name="email" maxlength="320" required><br><br>
        <input type="submit" value="Feliratkozás">
    </form>

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
