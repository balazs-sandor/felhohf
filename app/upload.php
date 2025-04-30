<?php
include 'db.php';
require 'detect_faces.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $image = $_FILES['image'];

    if ($image['error'] === 0) {


        $detectionResult = detectFacesRaw($image['tmp_name']);

        $detectionImage = $detectionResult['detectionImage'];
        $peopleDetected = $detectionResult['detectionCount'];


        $stmt = $conn->prepare("INSERT INTO images (description, image, detectionimage, people) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $description, $imageData, $detectionImage, $peopleDetected);

        $stmt->send_long_data(1, $imageData);
        $stmt->send_long_data(2, $detectionImage);
        $stmt->execute();
        $stmt->close();

        require 'notify_subscribers.php';
        notifySubscribers($description, $peopleDetected);

        header("Location: index.php");
        exit();
    } else {
        echo "Hiba a fájlfeltöltés során.";
    }
}
?>


<!DOCTYPE html>
<html lang="hu">
<?php include 'head.html'; ?>

<body>
<?php include 'navbar.html'; ?>
    <h1>Kép feltöltése</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        Leírás: <input type="text" name="description" maxlength="500" required><br><br>
        Kép: <input type="file" name="image" accept="image/*" required><br><br>
        <input type="submit" value="Feltöltés">
    </form>
</body>
</html>