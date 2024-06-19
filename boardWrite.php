<?php
    include "./util/connect.php";
    include "./util/session.php";
?>

<!DOCTYPE html>
<html lang="ko">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/board.scss">
    <? include "./common_include/lib.php" ?>
    <title>Pickstom : 글작성 페이지</title>
</head>

<body>
    <div id="wrap">
    <? include "./common_include/header.php" ?>
        <section class="board_section">
            <div class="container">
                <div class="board__write">
                    <form action="boardWriteSave.php" name="boardWriteSave" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <legend class="blind">글 작성하기</legend>
                            <div>
                                <label for="boardTitle">제목</label>
                                <input type="text" id="boardTitle" name="boardTitle" class="input-style" placeholder="제목을 적어주세요!">
                            </div>
                            <div>
                                <label for="boardContents">내용</label>
                                <textarea name="boardContents" id="boardContents" placeholder="내용을 적어주세요!"
                                    ></textarea>
                            </div>
                            <!-- <div class="file">
                                <label for="blogFile"></label>
                                <input type="file" id="blogFile" name="blogFile">
                                <p>* jpg, gif, png, webp 파일만 넣을 수 있습니다. 이미지 용량은 1MB를 넘길 수 없습니다.</p>
                            </div> -->
                            <div class="btn">
                                <button type="submit" class="btn-style">저장하기</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    <? include "./common_include/footer.php" ?>
    </div>
    
<script src="./assets/js/ckeditor.js"></script>
<script>
    ClassicEditor.
        create( document.querySelector( '#boardContents' ),{
            toolbar: [
                'none'
                ]
            } );
</script>
</body>

</html>




