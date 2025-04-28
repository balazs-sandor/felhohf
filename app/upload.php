<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $image = $_FILES['image'];

    if ($image['error'] === 0) {
        $imageData = file_get_contents($image['tmp_name']);

        require 'detect_faces.php';
        $detectionImageData = detectFacesRaw($image['tmp_name']);

        $stmt = $conn->prepare("INSERT INTO images (description, image, detectionimage, people) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $description, $imageData, $detectionImageData, $peopleDetected);

        $peopleDetected = rand(1, 5);
        $stmt->send_long_data(1, $imageData);
        $stmt->send_long_data(2, $detectionImageData);
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
