<?php
include "./util/connect.php";
include "./util/session.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pickstaID = $_POST['pickstaID'];
    $commentAuthor = $_POST['commentAuthor'];
    $userNum = $_POST['userNum'];
    $commentContent = $_POST['commentContent'];

    $sql = "INSERT INTO comments (pickstaID, commentAuthor, userNum, commentContent, commentRegTime) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("isis", $pickstaID, $commentAuthor, $userNum, $commentContent);

    if ($stmt->execute()) {
        header("Location: pickstaRead.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>