<?php
    include "./util/connect.php";
    include "./util/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/board.css" type="text/css">
    <?php include "./common_include/lib.php"; ?>
    <title>Pickstom : 글보기</title>
</head>
<body>
    <div id="wrap">
        <?php include "./common_include/header.php"; ?>
        <section class="board_section">
            <div class="container">
                <div class="board__view">
                <?php
                    $boardID = $_GET['boardID'];

                    // 데이터베이스 연결 확인
                    if ($connect->connect_error) {
                        die("데이터베이스 연결 실패: " . $connect->connect_error);
                    }

                    // 조회수 증가 쿼리
                    $sql = "UPDATE board SET boardView = boardView + 1 WHERE boardID = {$boardID}";
                    $connect->query($sql);

                    // 게시물 정보 가져오기 쿼리 (userName을 기준으로 조인)
                    $sql = "SELECT b.boardTitle, p.userName, b.regTime, b.boardView, b.boardContents, b.boardType, b.userNum, p.userAuthority
                            FROM board b 
                            JOIN pickstomuser p ON (b.userNum = p.userNum) 
                            WHERE b.boardID = {$boardID}";
                    $result = $connect->query($sql);

                    if ($result) {
                        $info = $result->fetch_array(MYSQLI_ASSOC);
                        ?>
                        <div class="board_head">
                            <div class="title">
                                <div class="top">
                                    <?php if($info['boardType'] == 1){ ?>
                                        <span>공지</span>
                                    <?php } ?>
                                    <h1><?php echo $info['boardTitle']; ?></h1>
                                </div>
                                <nav class="nav">
                                    <p><?php echo $info['userName']; ?></p>
                                    <p><?php echo date('Y-m-d', $info['regTime']); ?></p>
                                    <p><span>조회수</span><?php echo $info['boardView']; ?></p>
                                </nav>
                            </div>
                        </div>
                        <div class="board_main"><?php echo $info['boardContents']; ?></div>
                        <?php
                    } else {
                        echo "<tr><td colspan='2'>게시글 정보를 가져오는 데 실패했습니다.</td></tr>";
                    }
                ?>
                    <div class="board_btn">
                        <?php
                            // 현재 로그인한 사용자의 userNum과 게시물 작성자의 userNum을 비교 또는 관리자 권한 확인
                            if(isset($_SESSION['userNum']) && ($_SESSION['userNum'] == $info['userNum'] || (isset($_SESSION['userAuthority']) && $_SESSION['userAuthority'] == 'admin'))){
                        ?>
                            <a href="./boardModify.php?boardID=<?php echo $_GET['boardID']; ?>" class="btn-style">수정하기</a>
                        <?php
                            }
                            // 게시물 삭제는 작성자 또는 관리자만 가능
                            if(isset($_SESSION['userNum']) && ($_SESSION['userNum'] == $info['userNum'] || (isset($_SESSION['userAuthority']) && $_SESSION['userAuthority'] == 'admin'))){
                        ?>
                            <a href="./boardDelete.php?boardID=<?php echo $_GET['boardID']; ?>" class="btn-style" onclick="return confirm('정말 삭제하겠습니까?');">삭제하기</a>
                        <?php
                            }
                        ?>
                        <a href="./board.php" class="btn-style">목록보기</a>
                    </div>
                </div>
            </div>
        </section>
                
        <?php include "./common_include/footer.php"; ?>
    </div>
</body>
</html>
