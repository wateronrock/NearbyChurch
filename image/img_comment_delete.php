<?php
require_once "../dir_manage.php";
require_once $basePath ."functions.php";
$img_id = sanitizeRequest('img_id');
$comment_id = sanitizeRequest('comment_id');
$img_comdao->deleteComment($comment_id);
okGo("댓글을 삭제하였습니다.", "img_view.php?img_id=$img_id");
?>


