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

    $boardID = $_GET['boardID'];
    $userNum = $_SESSION['userNum'];
    $userAuthority = $_SESSION['userAuthority'];

    if($userAuthority == 'admin') {
        $sql = "DELETE FROM board WHERE boardID = {$boardID}";
        $connect -> query($sql);
        echo "<script>alert('게시글이 삭제 되었습니다.'); window.location.href=</script>";
    }else {
        // 게시글 소유자 확인
        $sql = "SELECT userNum FROM board WHERE boardID ={$boardID}";
        $result = $connect -> query($sql);
        if($result){
            $info = $result -> fetch_array(MYSQLI_ASSOC);
            $boardOwnerID = $info['userNum'];
    
            // 로그인 userNum 게시글 userNum 일치 여부
            if($userNum == $boardOwnerID){
                $sql = "DELETE FROM board WHERE boardID = {$boardID}";
                $connect -> query($sql);
                echo "<script>alert('게시글이 삭제 되었습니다.'); window.location.href=</script>";
            }else {
                echo "<script>alert('관리자에게 문의하세요.');</script>";
            }
        }
    }
?>
<script>window.location.href='board.php'</script>
    
</body>
</html>
