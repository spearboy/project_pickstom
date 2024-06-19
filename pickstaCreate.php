<?php
include "./util/connect.php";
include "./util/session.php";
include "./util/sessionCheck.php";

// 업로드된 이미지 목록 가져오기
$userNum = $_SESSION['userNum'];
$sql = "SELECT * FROM userImages WHERE userNum = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $userNum);
$stmt->execute();
$result = $stmt->get_result();

// 이미지가 있는지 확인
$imageCount = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/picksta.css">
    <?php include "./common_include/lib.php"; ?>
    <title>PICKSTOM</title>
</head>
<body>
<?php include "./common_include/header.php"; ?>
    <section class="picksta__create_inner picksta_section">
        <div class="container">
            <div class="picksta__create">
                <div class="picksta__title">픽스타그램 게시글 작성하기</div>
                <form id="pickstaCreateForm" action="pickstaCreateSave.php" name="pickstaCreateSave" method="post" style="margin-bottom: 100px">
                    <fieldset>
                        <legend class="blind">글작성하기</legend>
                        <div>
                            <label for="pickstaTitle" class="blind">제목</label>
                            <input type="text" id="pickstaTitle" name="pickstaTitle" placeholder="제목을 적어주세요!" required class="input_style">
                        </div>
                        <div>
                            <label for="pickstaCont" class="blind">내용</label>
                            <textarea id="pickstaCont" name="pickstaCont" placeholder="내용을 적어주세요!" required class="input_style"></textarea>
                        </div>
                        <div class="file">
                            <label for="pickstaFile" class="blind">파일</label>
                            <div id="imageList">
                                <?php
                                if ($imageCount > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='image-item' data-filename='" . $row['imagePath'] . "'>";
                                        echo "<img src='./" . $row['imagePath'] . "' alt='" . htmlspecialchars($row['userFileName']) . "'>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<script>alert('커스텀 아이템이 최소 1개 이상이여야 글을 작성하실 수 있습니다.'); history.back();</script>";
                                }
                                ?>
                            </div>
                            <input type="hidden" id="selectedImage" name="selectedImage">
                            <p>* 이미지를 선택해주세요. 선택하지 않으면 글을 올릴 수 없습니다.</p>
                        </div>
                        <div class="btn">
                            <button type="submit" class="btn-style">저장하기</button>
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

        document.getElementById("pickstaCreateForm").addEventListener("submit", function(event) {
            if (!selectedImageInput.value) {
                alert("이미지를 선택해주세요.");
                event.preventDefault();
            }
        });
    });
</script>
</body>
</html>
