<?php
include "./util/connect.php";
include "./util/session.php";

// 로그인 여부 확인
$isLoggedIn = isset($_SESSION['userNum']);
$userNum = $isLoggedIn ? $_SESSION['userNum'] : null;
$userName = $isLoggedIn ? $_SESSION['userName'] : null;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./common_include/lib.php"; ?>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/picksta.css">
    <title>Pickstom : picksta</title>
</head>
<body data-user-num="<?php echo $userNum; ?>" data-user-name="<?php echo $userName; ?>">
    <?php include "./common_include/header.php"; ?>
    <section class="picksta_section">
        <div class="container">
            <div class="picksta__inner">
                <div class="head_wrapper">
                    <p>픽스타그램에서 커스텀을 보여주세요!</p>
                    <button onclick="location.href='pickstaCreate.php'" class="system_btn">
                        글쓰기
                    </button>
                </div>
                <div class="card__style">
                    <?php
                        // 카테고리 값에 따라 쿼리문 실행
                        if ($category) {
                            $sql = "SELECT * FROM picksta WHERE pickstaDelete = 1 AND pickstaCate = ? ORDER BY pickstaRegTime DESC LIMIT 10";
                            $stmt = $connect->prepare($sql);
                            $stmt->bind_param("s", $category);
                        } else {
                            $sql = "SELECT * FROM picksta WHERE pickstaDelete = 1 ORDER BY pickstaRegTime DESC LIMIT 10";
                            $stmt = $connect->prepare($sql);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $pickstaID = $row['pickstaID'];
                                $pickstaTitle = $row['pickstaTitle'];
                                $pickstaCont = $row['pickstaCont'];
                                $pickstaCate = $row['pickstaCate'];
                                $pickstaAuthor = $row['pickstaAuthor'];
                                $pickstaRegTime = date('Y.m.d', $row['pickstaRegTime']);
                                $pickstaImgFile = $row['pickstaImgFile'];
                                $pickstaView = $row['pickstaView'];
                                $pickstaLike = $row['pickstaLike'];

                                // 좋아요 상태 확인
                                $liked = false;
                                if ($isLoggedIn) {
                                    $sqlLiked = "SELECT * FROM likes WHERE userNum = ? AND pickstaID = ?";
                                    $stmtLiked = $connect->prepare($sqlLiked);
                                    $stmtLiked->bind_param("ii", $userNum, $pickstaID);
                                    $stmtLiked->execute();
                                    $resultLiked = $stmtLiked->get_result();
                                    if ($resultLiked->num_rows > 0) {
                                        $liked = true;
                                    }
                                }

                                // 좋아요 수 확인
                                $sqlLikeCount = "SELECT COUNT(*) as likeCount FROM likes WHERE pickstaID = ?";
                                $stmtLikeCount = $connect->prepare($sqlLikeCount);
                                $stmtLikeCount->bind_param("i", $pickstaID);
                                $stmtLikeCount->execute();
                                $resultLikeCount = $stmtLikeCount->get_result();
                                $likeCount = $resultLikeCount->fetch_assoc()['likeCount'];
                                ?>

                                <div class="card">
                                    <figure class="card__img">
                                        <img src="<?php echo $pickstaImgFile; ?>" alt="<?php echo $pickstaTitle; ?>">
                                    </figure>
                                    <div class="card__info">
                                        <div class="header">
                                            <div class="prof_name">
                                                <a href="#" class="author"><?php echo $pickstaAuthor; ?></a>
                                                <span class="date"><?php echo $pickstaRegTime; ?></span>
                                            </div>
                                            <span class="like" data-picksta-id="<?php echo $pickstaID; ?>">
                                            <img src="./assets/images/<?php echo $liked ? 'heart02.png' : 'heart01.png'; ?>" alt="좋아요 아이콘">
                                            <span class="like-count"><?php echo $likeCount; ?></span>
                                            </span>
                                            <div class="more_img" onclick="toggleOptions(event)">
                                                <img src="./assets/images/more.png" alt="More options">
                                                <div class="options-menu">
                                                    <p onclick="editPost(<?php echo $pickstaID; ?>)">피드 수정하기</p>
                                                    <p onclick="deletePost(<?php echo $pickstaID; ?>)">피드 삭제하기</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment">
                                            <p><?php echo $pickstaCont; ?></p>
                                            <!-- 댓글 기능 시작 -->
                                            <div class="comments">
                                                <?php
                                                $sqlComments = "SELECT * FROM comments WHERE pickstaID = ? ORDER BY commentRegTime DESC";
                                                $stmtComments = $connect->prepare($sqlComments);
                                                $stmtComments->bind_param("i", $pickstaID);
                                                $stmtComments->execute();
                                                $resultComments = $stmtComments->get_result();

                                                if ($resultComments->num_rows > 0) {
                                                    while ($comment = $resultComments->fetch_assoc()) {
                                                        echo "<div class='comment' id='comment-{$comment['commentID']}' data-user-num='{$comment['userNum']}'>";
                                                            echo "<p><strong>" . htmlspecialchars($comment['commentAuthor']) . "</strong> " . "<span class='comment-content'>" . htmlspecialchars($comment['commentContent']) . "</span></p>";
                                                            echo "<span class='date'>" . date('Y.m.d H:i', strtotime($comment['commentRegTime'])) . "</span>";
                                                            echo "<div class='more_img' onclick='toggleCommentOptions(event)'>";
                                                                echo "<img src='./assets/images/more.png' alt='More options'>";
                                                                echo "<div class='options-menu'>";
                                                                    echo "<p onclick='enableCommentEdit(" . $comment['commentID'] . ")'>댓글 수정하기</p>";
                                                                    echo "<p onclick='deleteComment(" . $comment['commentID'] . ")'>댓글 삭제하기</p>";
                                                                echo "</div>";
                                                            echo "</div>";
                                                        echo "</div>";
                                                    }
                                                } else {
                                                    echo "<p class='empty'>댓글이 없습니다.</p>";
                                                }
                                                ?>
                                            </div>
                                            <?php if ($isLoggedIn): ?>
                                                <form id="commentForm" method="post" action="commentSubmit.php">
                                                    <input type="hidden" name="pickstaID" value="<?php echo $pickstaID; ?>">
                                                    <input type="hidden" name="commentAuthor" value="<?php echo $_SESSION['userName']; ?>">
                                                    <input type="hidden" name="userNum" value="<?php echo $_SESSION['userNum']; ?>">
                                                    <textarea name="commentContent" id="commentContent" rows="4" required></textarea>
                                                    <button type="submit">댓글 달기</button>
                                                </form>
                                            <?php else: ?>
                                                <p class="please_login">댓글을 작성하려면 <a href="./signin.php">로그인</a>하세요.</p>
                                            <?php endif; ?>
                                            <!-- 댓글 기능 끝 -->
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            echo "<p class='center'>게시글이 없습니다.</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php include "./common_include/footer.php"; ?>
    <script src="./assets/js/picksta.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.5/lottie.min.js"></script>
</body>
</html>
