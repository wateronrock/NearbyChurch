<?php
session_start();
require_once "../dir_manage.php";
require_once $basePath."functions.php";
// 댓글에 관한 처리
// $img_id = sanitizeRequest('img_id');
$comment = sanitizeRequest('comment');
$img_id = sanitizeRequest('img_id');
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];



if(!$uid || !$uname){
    okGo("댓글을 쓰시려면 로그인 해주세요!", "index.php");
} else if($comment == ""){
    okGo("댓글을 적어주세요.", "img_view.php?img_id=$img_id");
} else if($img_id && $uname && $comment){
    $img_comdao->insertComment($img_id, $uname, $comment, date('Y-m-d H:i') );
    okGo("댓글을 입력했습니다.", "img_view.php?img_id=$img_id");
}
?>
