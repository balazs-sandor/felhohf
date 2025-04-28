<?php
function notifySubscribers($description, $peopleCount) {
    include 'db.php';

    $result = $conn->query("SELECT email FROM subscriptions");
    while ($row = $result->fetch_assoc()) {
        $to = $row['email'];
        $subject = "Új kép került feltöltésre!";
        $message = "Új kép lett feltöltve!\n\nLeírás: $description\nEmberek száma: $peopleCount";
        $headers = "From: noreply@example.com";

        @mail($to, $subject, $message, $headers);
    }
}
?>
