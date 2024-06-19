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
    <title>Pickstom : 글수정 페이지</title>
</head>

<body>
    <div id="wrap">
    <? include "./common_include/header.php" ?>
        <section class="board_section">
            <div class="container">
                <div class="board__write">
                    <form action="boardModifySave.php" name="boardModifySave" method="POST">
                        <fieldset>
                            <legend class="blind">글 수정하기</legend>
                            <?php
                                $boardID = $_GET['boardID'];

                                $sql = "SELECT * FROM board WHERE boardID = {$boardID}";
                                $result = $connect -> query($sql);

                                if($result) {
                                    $info = $result -> fetch_array(MYSQLI_ASSOC);
                                    echo "<div class='num'><label for='boardID'>번호</label><input type='text' name='boardID' id='boardID' class='input-style' value='".$info['boardID']."' readonly></div>";
                                    echo "<div><label for='boardTitle'>제목</label><input type='text' id='boardTitle' name='boardTitle' class='input-style' value='".$info['boardTitle']."'></div>";
                                    echo "<div><label for='boardContents'>내용</label><textarea name='boardContents' id='boardContents' placeholder='내용을 적어주세요!' rows='20' class='input-style'>".$info['boardContents']."</textarea></div>";
                                    echo "<div><label for='boardPass'>비밀번호</label><input type='password' name='boardPass' id='boardPass' class='input-style mb10' autocomplete='off' placeholder='글을 수정하려면 로그인 비밀번호를 입력하셔야합니다.' required></div>";
                                }
                            ?>
                            <div class="btn">
                                <button type="submit" class="btn-style">수정하기</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    <? include "./common_include/footer.php" ?>
    </div>

    <!-- CKEditor 스크립트 추가 -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/translations/ko.js"></script> -->
    <script src="./assets/js/ckeditor.js"></script>
    <!-- <script>
        // CKEditor를 'boardContents' 요소에 적용
        ClassicEditor
            .create(document.querySelector('#boardContents'), {
                removePlugins: [ 'Heading' ],
                language: 'ko',
                placeholder: '내용을 적어주세요!' // placeholder 설정
            })
            .catch(error => {
                console.error(error);
            });
    </script> -->
    <script>ClassicEditor.
        create( document.querySelector( '#boardContents' ),{
            toolbar: [
                'none'
                ]
            } );
    </script>
</body>
</html>