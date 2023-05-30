<?php
require_once "functions.php";
$img_id = sanitizeRequest('img_id');
$comment_id = sanitizeRequest('comment_id');
$comment = sanitizeRequest('comment');

$result = $img_comdao->updateComment($comment_id, $comment);
okGo("댓글이 수정되었습니다.", "img_view.php?img_id=$img_id");
?>
