<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO subscriptions (email) VALUES (?)");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">
<?php include 'head.html'; ?>

<body>
<?php include 'navbar.html'; ?>
    <h2>Feliratkozás értesítésekre</h2>
    <form action="subscribe.php" method="POST">
        Email: <input type="email" name="email" maxlength="320" required><br><br>
        <input type="submit" value="Feliratkozás">
    </form>
</body>
</html>