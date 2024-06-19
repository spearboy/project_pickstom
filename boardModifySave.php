<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    include "./util/connect.php";
    include "./util/session.php";
    include "./util/sessionCheck.php";

    $boardID = mysqli_real_escape_string($connect, $_POST['boardID']);
    $boardTitle = mysqli_real_escape_string($connect, $_POST['boardTitle']);
    $boardContents = mysqli_real_escape_string($connect, $_POST['boardContents']);
    $boardPass = $_POST['boardPass'];
    $userNum = $_SESSION['userNum'];

    // Debugging output
    echo "boardID: $boardID<br>";
    echo "boardTitle: $boardTitle<br>";
    echo "boardContents: $boardContents<br>";
    echo "boardPass: $boardPass<br>";
    echo "userNum: $userNum<br>";

    $sql = "SELECT * FROM pickstomuser WHERE userNum = {$userNum}";
    $result = $connect->query($sql);

    if($result){
        $info = $result->fetch_array(MYSQLI_ASSOC);

        if(password_verify($boardPass, $info['userPass'])){
            $sql = "SELECT * FROM board WHERE boardID = {$boardID}";
            $boardResult = $connect->query($sql);

            if ($boardResult) {
                $boardInfo = $boardResult->fetch_array(MYSQLI_ASSOC);

                // Debugging output
                echo "boardInfo: ";
                var_dump($boardInfo);

                if($boardInfo['userNum'] == $userNum){
                    $sql = "UPDATE board SET boardTitle = '{$boardTitle}', boardContents = '{$boardContents}' WHERE boardID = '{$boardID}'";
                    if ($connect->query($sql)) {
                        echo "<script>alert('게시글이 성공적으로 수정 되었습니다.');</script>";
                        echo "<script>window.location.href = 'board.php';</script>";
                    } else {
                        echo "Error updating record: " . $connect->error;
                    }
                } else {
                    echo "<script>alert('사용자가 일치하지 않습니다.');</script>";
                    echo "<script>window.history.back();</script>";
                }
            } else {
                echo "Error fetching board info: " . $connect->error;
            }
        } else {
            echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        echo "Error fetching user info: " . $connect->error;
    }
    ?>    
</body>
</html>
