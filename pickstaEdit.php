<?php
include "./util/connect.php";
include "./util/session.php";

// 로그인 여부 확인
if (!isset($_SESSION['userNum'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickstaID = $_POST['pickstaID'];
    $pickstaTitle = $_POST['pickstaTitle'];
    $pickstaCont = $_POST['pickstaCont'];
    $selectedImage = $_POST['selectedImage'];

    $sql = "UPDATE picksta SET pickstaTitle = ?, pickstaCont = ?, pickstaImgFile = ? WHERE pickstaID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sssi", $pickstaTitle, $pickstaCont, $selectedImage, $pickstaID);
    $stmt->execute();

    header("Location: pickstaRead.php");
    exit();
} else {
    $pickstaID = $_GET['pickstaID'];

    $sql = "SELECT * FROM picksta WHERE pickstaID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $pickstaID);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    // 업로드된 이미지 목록 가져오기
    $userNum = $_SESSION['userNum'];
    $sqlImages = "SELECT * FROM userImages WHERE userNum = ?";
    $stmtImages = $connect->prepare($sqlImages);
    $stmtImages->bind_param("i", $userNum);
    $stmtImages->execute();
    $resultImages = $stmtImages->get_result();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/picksta.css">
    <?php include "./common_include/lib.php"; ?>
    <title>게시글 수정</title>
</head>
<body>
<?php include "./common_include/header.php"; ?>
    <section class="picksta__create_inner picksta_section">
        <div class="container">
            <div class="picksta__create">
                <div class="picksta__title">픽스타그램 게시글 수정하기</div>
                <form id="pickstaEditForm" action="pickstaEdit.php" name="pickstaEditForm" method="post">
                    <fieldset>
                        <legend class="blind">글수정하기</legend>
                        <div>
                            <label for="pickstaTitle" class="blind">제목</label>
                            <input type="text" id="pickstaTitle" name="pickstaTitle" placeholder="제목을 적어주세요!" required class="input_style" value="<?php echo htmlspecialchars($post['pickstaTitle']); ?>">
                        </div>
                        <div>
                            <label for="pickstaCont" class="blind">내용</label>
                            <textarea id="pickstaCont" name="pickstaCont" placeholder="내용을 적어주세요!" required class="input_style"><?php echo htmlspecialchars($post['pickstaCont']); ?></textarea>
                        </div>
                        <div class="file">
                            <label for="pickstaFile" class="blind">파일</label>
                            <div id="imageList">
                                <?php
                                while ($row = $resultImages->fetch_assoc()) {
                                    $activeClass = ($row['imagePath'] == $post['pickstaImgFile']) ? ' active' : '';
                                    echo "<div class='image-item$activeClass' data-filename='" . $row['imagePath'] . "'>";
                                    echo "<img src='./" . $row['imagePath'] . "' alt='" . htmlspecialchars($row['userFileName']) . "'>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                            <input type="hidden" id="selectedImage" name="selectedImage" value="<?php echo $post['pickstaImgFile']; ?>">
                            <p>* 이미지를 선택해주세요. 선택하지 않으면 글을 수정할 수 없습니다.</p>
                        </div>
                        <input type="hidden" name="pickstaID" value="<?php echo $post['pickstaID']; ?>">
                        <div class="btn">
                            <button type="submit" class="btn-style">수정하기</button>
                        </div>
                    </fieldset>
                </form>
                <!-- //picksta__create -->
            </div>
        </div>
    </section>
<?php include "./common_include/footer.php"; ?>
<!-- //picksta__inner -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const imageItems = document.querySelectorAll(".image-item");
        let selectedImageInput = document.getElementById("selectedImage");

        imageItems.forEach(item => {
            item.addEventListener("click", function() {
                imageItems.forEach(i => i.classList.remove("active"));
                item.classList.add("active");
                selectedImageInput.value = item.dataset.filename;
            });
        });

        document.getElementById("pickstaEditForm").addEventListener("submit", function(event) {
            if (!selectedImageInput.value) {
                alert("이미지를 선택해주세요.");
                event.preventDefault();
            }
        });
    });
</script>
</body>
</html>
