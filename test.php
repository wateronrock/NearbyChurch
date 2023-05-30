<?php
require_once "header.php";
// 댓글 삽입
$img_id = 1; // 이미지 ID
$writer = "John"; // 작성자
$comment = "This is a comment."; // 댓글 내용
$date = date("Y-m-d H:i:s"); // 날짜
$img_comdao->insertComment(11, "John", "That was a comment", $date);

// 부모 아이디(img_id)로 댓글 조회
$parent_id = 1; // 이미지 ID
$comments = $img_comdao->getAllCommentsByParentId($parent_id);

// 댓글 출력
foreach ($comments as $comment) {
    echo "Writer: " . $comment['writer'] . "<br>";
    echo "Comment: " . $comment['comment'] . "<br>";
    echo "Date: " . $comment['date'] . "<br>";
    echo "<br>";
}

?>


<?php
require_once "footer.php";
?>
