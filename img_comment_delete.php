<?php
require_once "functions.php";
$comment_id = sanitizeRequest('comment_id');
$img_comdao->deleteComment($comment_id);
okGo("댓글을 삭제하였습니다.", "img_view.php");
?>


