
<?php
    include "./util/connect.php";
    include "./util/session.php";

    if(isset($_GET['page'])){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

// 로그인 여부 확인 함수
function isUserLoggedIn() {
    return isset($_SESSION['userNum']); // 로그인된 사용자의 세션 정보가 있는지 확인
}
    $searchKeyword = $connect->real_escape_string(trim($_GET['searchKeyword']));

    $sql = "SELECT b.boardID, b.boardTitle, p.userNum, p.userName, b.regTime, b.boardView 
            FROM board b 
            JOIN pickstomuser p ON (b.userNum = p.userNum) 
            WHERE b.boardTitle LIKE '%{$searchKeyword}%' 
            ORDER BY boardID DESC";


    $result = $connect->query($sql);

    if ($result) {
        $totalCount = $result->num_rows;
    } else {
        echo "Error: " . $connect->error;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./common_include/lib.php"; ?>
    <link rel="stylesheet" href="./assets/css/board.css" type="text/css">
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
                    <p class="board_count">
                        *<em><?=$searchKeyword?></em>에 대한 검색 결과가 <em><?=$totalCount?></em>개 나왔습니다.
                    </p>
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
                            include "./util/connect.php";
                            include "./util/session.php";

                            if(isset($_GET['page'])){
                                $page = (int) $_GET['page'];
                            } else {
                                $page = 1;
                            }

                            $viewNum = 10;
                            $viewLimit = ($viewNum * $page) - $viewNum;

                            $searchKeyword = $connect->real_escape_string(trim($_GET['searchKeyword']));

                            $sql = "SELECT b.boardID, b.boardTitle, p.userNum, p.userName, b.regTime, b.boardView, b.boardType 
                                    FROM board b 
                                    JOIN pickstomuser p ON (b.userNum = p.userNum) 
                                    WHERE b.boardTitle LIKE '%{$searchKeyword}%' 
                                    ORDER BY boardID DESC 
                                    LIMIT {$viewLimit}, {$viewNum}";

                            $result = $connect->query($sql);

                            if ($result) {
                                $totalCount = $result->num_rows;

                                if ($totalCount > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                            if ($row['boardType'] == 1) {
                                                echo "<td><span class='notice'>공지</span></td>";
                                            } else {
                                                echo "<td><span class='normal'>일반</span></td>";
                                            }
                                            echo "<td><a href='./boardView.php?boardID={$row['boardID']}'>".$row['boardTitle']."</a></td>";
                                            echo "<td>".$row['userName']."</td>";
                                            echo "<td>".date('Y-m-d', $row['regTime'])."</td>"; // Ensure regTime is formatted correctly
                                            echo "<td>".$row['boardView']."</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>게시글이 없습니다.</td></tr>";
                                }
                            } else {
                                echo "Error: " . $connect->error;
                            }

                            $connect->close();
                            ?>  
                        </tbody>
                    </table>
                </div>
                <div class="board__pages">
                <?php
                    include "./util/connect.php";
                    include "./util/session.php";

                    if(isset($_GET['page'])){
                        $page = (int) $_GET['page'];
                    } else {
                        $page = 1;
                    }

                    $viewNum = 10;
                    $viewLimit = ($viewNum * $page) - $viewNum;

                    $searchKeyword = $connect->real_escape_string(trim($_GET['searchKeyword']));

                    // 전체 게시물 수를 구하는 쿼리
                    $countSql = "SELECT COUNT(*) AS total FROM board b 
                                JOIN pickstomuser p ON (b.userNum = p.userNum) 
                                WHERE b.boardTitle LIKE '%{$searchKeyword}%'";
                    $countResult = $connect->query($countSql);
                    $totalCountRow = $countResult->fetch_assoc();
                    $totalCount = $totalCountRow['total'];

                    // 페이지네이션 적용된 데이터 조회 쿼리
                    $sql = "SELECT b.boardID, b.boardTitle, p.userNum, p.userName, b.regTime, b.boardView 
                            FROM board b 
                            JOIN pickstomuser p ON (b.userNum = p.userNum) 
                            WHERE b.boardTitle LIKE '%{$searchKeyword}%' 
                            ORDER BY boardID DESC 
                            LIMIT {$viewLimit}, {$viewNum}";

                    $result = $connect->query($sql);

                    // 페이지네이션
                    $boardTotalCount = ceil($totalCount / $viewNum);

                    $pageView = 4;
                    $startPage = $page - $pageView;
                    $endPage = $page + $pageView;

                    if ($startPage < 1) $startPage = 1;
                    if ($endPage > $boardTotalCount) $endPage = $boardTotalCount;

                    echo "<ul class='pagination'>";

                    if ($page > 1) {
                        $prevPage = $page - 1;
                        echo "<li class='first'><a href='boardSearch.php?page=1&searchKeyword={$searchKeyword}'>처음으로</a></li>";
                        echo "<li class='prev'><a href='boardSearch.php?page={$prevPage}&searchKeyword={$searchKeyword}'>이전</a></li>";
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $active = "";
                        if ($i == $page) $active = "active";
                        echo "<li class='{$active}'><a href='boardSearch.php?page={$i}&searchKeyword={$searchKeyword}'>{$i}</a></li>";
                    }

                    if ($page < $boardTotalCount) {
                        $nextPage = $page + 1;
                        echo "<li class='next'><a href='boardSearch.php?page={$nextPage}&searchKeyword={$searchKeyword}'>다음</a></li>";
                        echo "<li class='last'><a href='boardSearch.php?page={$boardTotalCount}&searchKeyword={$searchKeyword}'>마지막으로</a></li>";
                    }

                    echo "</ul>";

                    $connect->close();
                ?>

                </div>
            </div>
        </section>
        <? include "./common_include/footer.php" ?>
    </div>
</body>
</html>