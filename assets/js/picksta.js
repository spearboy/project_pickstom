document.addEventListener("DOMContentLoaded", function() {
    const loggedInUserNum = document.body.dataset.userNum;

    const moreImgElements = document.querySelectorAll('.more_img');
    
    moreImgElements.forEach(el => {
        el.addEventListener('click', function(event) {
            event.stopPropagation();
            const optionsMenu = el.querySelector('.options-menu');
            optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
        });
    });

    document.addEventListener('click', function(event) {
        moreImgElements.forEach(el => {
            const optionsMenu = el.querySelector('.options-menu');
            if (!el.contains(event.target)) {
                optionsMenu.style.display = 'none';
            }
        });
    });

    window.editPost = function(pickstaID) {
        location.href = `pickstaEdit.php?pickstaID=${pickstaID}`;
    };

    window.deletePost = function(pickstaID) {
        if (confirm("정말로 삭제하시겠습니까?")) {
            location.href = `pickstaDelete.php?pickstaID=${pickstaID}`;
        }
    };

    const likeButtons = document.querySelectorAll(".like");

    likeButtons.forEach(button => {
        button.addEventListener("click", function() {
            const pickstaID = this.dataset.pickstaId;
            const img = this.querySelector("img");
            const likeCountSpan = this.querySelector(".like-count");

            fetch("like.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `pickstaID=${pickstaID}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "liked") {
                    img.src = "./assets/images/heart02.png";
                    likeCountSpan.textContent = parseInt(likeCountSpan.textContent) + 1;
                } else if (data.status === "unliked") {
                    img.src = "./assets/images/heart01.png";
                    likeCountSpan.textContent = parseInt(likeCountSpan.textContent) - 1;
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });

    // 댓글 수정 및 삭제 기능 추가
    window.editComment = function(commentID) {
        const commentElement = document.getElementById(`comment-${commentID}`);
        const commentUserNum = commentElement.dataset.userNum;

        if (commentUserNum !== loggedInUserNum) {
            alert("본인의 댓글만 수정할 수 있습니다.");
            return;
        }

        const newContent = prompt("댓글을 수정하세요:");
        if (newContent) {
            const form = new FormData();
            form.append("commentID", commentID);
            form.append("commentContent", newContent);

            fetch("commentEdit.php", {
                method: "POST",
                body: form
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("댓글 수정에 실패했습니다.");
                }
            });
        }
    };

    window.deleteComment = function(commentID) {
        const commentElement = document.getElementById(`comment-${commentID}`);
        const commentUserNum = commentElement.dataset.userNum;

        if (commentUserNum !== loggedInUserNum) {
            alert("본인의 댓글만 삭제할 수 있습니다.");
            return;
        }

        if (confirm("정말로 이 댓글을 삭제하시겠습니까?")) {
            const form = new FormData();
            form.append("commentID", commentID);

            fetch("commentDelete.php", {
                method: "POST",
                body: form
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("댓글 삭제에 실패했습니다.");
                }
            });
        }
    };

    const commentMoreImgElements = document.querySelectorAll('.comment .more_img');
    
    commentMoreImgElements.forEach(el => {
        el.addEventListener('click', function(event) {
            event.stopPropagation();
            const optionsMenu = el.querySelector('.options-menu');
            optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
        });
    });

    document.addEventListener('click', function(event) {
        commentMoreImgElements.forEach(el => {
            const optionsMenu = el.querySelector('.options-menu');
            if (!el.contains(event.target)) {
                optionsMenu.style.display = 'none';
            }
        });
    });

    window.toggleCommentOptions = function(event) {
        event.stopPropagation();
        const optionsMenu = event.currentTarget.querySelector('.options-menu');
        optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
    };

    window.enableCommentEdit = function(commentID) {
        const commentElement = document.getElementById(`comment-${commentID}`);
        const commentUserNum = commentElement.dataset.userNum;

        if (commentUserNum !== loggedInUserNum) {
            alert("본인의 댓글만 수정할 수 있습니다.");
            return;
        }

        const commentContentElement = commentElement.querySelector('.comment-content');
        const currentContent = commentContentElement.textContent;
        commentContentElement.innerHTML = `
            <textarea class="edit-comment-textarea">${currentContent}</textarea>
            <button class="save-comment-button" onclick="saveCommentEdit(${commentID})">저장</button>
            <button class="cancel-comment-button" onclick="cancelCommentEdit(${commentID}, '${currentContent}')">취소</button>
        `;
    };

    window.saveCommentEdit = function(commentID) {
        const commentElement = document.getElementById(`comment-${commentID}`);
        const newContent = commentElement.querySelector('.edit-comment-textarea').value;

        const form = new FormData();
        form.append("commentID", commentID);
        form.append("commentContent", newContent);

        fetch("commentEdit.php", {
            method: "POST",
            body: form
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                commentElement.querySelector('.comment-content').textContent = newContent;
                const editButtons = commentElement.querySelectorAll('.save-comment-button, .cancel-comment-button');
                editButtons.forEach(button => button.remove());
            } else {
                alert("댓글 수정에 실패했습니다.");
            }
        });
    };

    window.cancelCommentEdit = function(commentID, originalContent) {
        const commentElement = document.getElementById(`comment-${commentID}`);
        commentElement.querySelector('.comment-content').textContent = originalContent;
        const editButtons = commentElement.querySelectorAll('.save-comment-button, .cancel-comment-button');
        editButtons.forEach(button => button.remove());
    };
});
