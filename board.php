<?php
session_start(); // 세션 시작
include "./util/connect.php";

// 로그인 여부 확인 함수
function isUserLoggedIn() {
    return isset($_SESSION['userNum']); // 로그인된 사용자의 세션 정보가 있는지 확인
}

// 총 게시글 갯수
$sql = "SELECT count(boardID) FROM board";
$result = $connect->query($sql);

$boardTotalCount = $result->fetch_array(MYSQLI_ASSOC);
$boardTotalCount = $boardTotalCount['count(boardID)'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/board.scss" type="text/css">
    <? include "./common_include/lib.php" ?>
    <title>Pickstom : 게시판</title>
    <script>
        function checkLogin() {
            <?php if (isUserLoggedIn()) { ?>
                // 로그인되어 있을 경우 boardWrite.php로 이동
                window.location.href = 'boardWrite.php';
            <?php } else { ?>
                // 로그인되어 있지 않을 경우 팝업을 띄우고 로그인 페이지로 이동
                alert('로그인이 필요합니다. 로그인 페이지로 이동합니다.');
                window.location.href = 'signin.php';
            <?php } ?>
        }
    </script>
</head>
<body>
    <div id="wrap">
        <? include "./common_include/header.php" ?>
        <section class="board_section">
            <div class="container">
                <div class="board_header">
                    <p class="board_count">총 <span><?=$boardTotalCount?></span>개의 개시글이 있습니다.</p>
                    <div class="board_search_wrapper">
                        <form action="boardSearch.php" name="boardSearch" method="get">
                            <label for="searchBox"></label>
                            <input type="text" id="searchBox" name="searchKeyword" class="input_style" placeholder="제목을 검색해주세요.">
                            <button type="submit" class="system_btn">검색</button>
                            <?php
                                if(isset($_SESSION['userNum'])){
                            ?>
                                <button type="button" class="system_btn" onclick="checkLogin()">글쓰기</button>
                            <?php
                                }
                            ?>
                        </form>
                    </div>
                </div>

                <div class="board_content">
                    <table>
                        <thead>
                            <th></th>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>작성일</th>
                            <th>조회수</th>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($_GET['page'])){
                                    $page = (int) $_GET['page'];
                                }else {
                                    $page = 1;
                                }
                                $viewNum = 10;
                                $viewLimit = ($viewNum * $page) - $viewNum;

                                // 공지 게시글 조회
                                $sqlNotice = "SELECT b.boardID, b.boardTitle, p.userNum, p.userName, b.regTime, b.boardView, b.boardType 
                                            FROM board b 
                                            JOIN pickstomuser p ON(b.userNum = p.userNum) 
                                            WHERE b.boardType = 1 
                                            ORDER BY b.boardID DESC";
                                $resultNotice = $connect->query($sqlNotice);
                                if($resultNotice){
                                    while($notice = $resultNotice->fetch_array(MYSQLI_ASSOC)){
                                        echo "<tr>";
                                        echo "<td><span class='notice'>공지</span></td>";
                                        echo "<td><a href='./boardView.php?boardID={$notice['boardID']}'>".$notice['boardTitle']."</a></td>";
                                        echo "<td>".$notice['userName']."</td>";
                                        echo "<td>".date('Y-m-d',$notice['regTime'])."</td>";
                                        echo "<td>".$notice['boardView']."</td>";
                                        echo "</tr>";
                                    }
                                }

                                // 일반 게시글 조회
                                $sql = "SELECT b.boardID, b.boardTitle, p.userNum, p.userName, b.regTime, b.boardView, b.boardType 
                                        FROM board b 
                                        JOIN pickstomuser p ON(b.userNum = p.userNum) 
                                        WHERE b.boardType = 0 
                                        ORDER BY b.boardID DESC 
                                        LIMIT {$viewLimit}, {$viewNum}";
                                $result = $connect -> query($sql);
                                if($result){
                                    $count = $result -> num_rows;
                                    if($count > 0){
                                        for($i = 0; $i < $count; $i++){
                                            $info = $result -> fetch_array(MYSQLI_ASSOC);

                                            echo "<tr>";
                                                echo "<td><span class='normal'>일반</span></td>";
                                                echo "<td><a href='./boardView.php?boardID={$info['boardID']}'>".$info['boardTitle']."</a></td>";
                                                echo "<td>".$info['userName']."</td>";
                                                echo "<td>".date('Y-m-d',$info['regTime'])."</td>";
                                                echo "<td>".$info['boardView']."</td>";
                                            echo "</tr>";
                                        }

                                    }else {
                                        echo "<tr><td colspan='5'>게시글이 없습니다.<td></tr>";
                                    }
                                }else {
                                    echo "<script>alert('에러발생!!! 관리자에게 문의하세요!');</script>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="board__pages">
                    <ul>
                        <?php
                            $boardTotalCount = ceil($boardTotalCount / $viewNum);
                            $pageView = 4;
                            $startPage = $page - $pageView;
                            $endPage = $page + $pageView;
                            if ($startPage < 1) {
                                $startPage = 1;
                                $endPage = min($boardTotalCount, 9);
                            }
                            if ($endPage > $boardTotalCount) {
                                $endPage = $boardTotalCount;
                                $startPage = max(1, $endPage - 8);
                            }
                            if ($page != 1) {
                                $prev = $page - 1;
                                echo "<li class='first'><a href='./board.php?page=1'>처음으로</a></li>";
                                echo "<li class='prev'><a href='./board.php?page={$prev}'>이전</a></li>";
                            }
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                if ($page == $i) {
                                    echo "<li class='active'><a href='./board.php?page={$i}'>{$i}</a></li>";
                                } else {
                                    echo "<li><a href='./board.php?page={$i}'>{$i}</a></li>";
                                }
                            }
                            if ($page != $boardTotalCount && $boardTotalCount > 1) { // 수정된 부분
                                $next = $page + 1;
                                echo "<li class='next'><a href='./board.php?page={$next}'>다음</a></li>";
                                echo "<li class='last'><a href='./board.php?page={$boardTotalCount}'>마지막으로</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </section>
        <? include "./common_include/footer.php" ?>
    </div>
</body>
</html>