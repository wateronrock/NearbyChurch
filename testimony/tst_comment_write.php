<?php
session_start();
require_once "../dir_manage.php";
require_once $basePath."functions.php";
// 댓글에 관한 처리
// $img_id = sanitizeRequest('img_id');

$comment = sanitizeRequest('comment');

$tst_id = sanitizeRequest('id');
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];



if(!$uid || !$uname){
    okGo("댓글을 쓰시려면 로그인 해주세요!", "index.php");
} else if($comment == ""){
    okGo("댓글을 적어주세요.", "tst_write.php?tst_id=$tst_id");
} else if($tst_id && $uname && $comment){
    $tst_comdao->insertComment($tst_id, $uname, $comment, date('Y-m-d H:i') );
    goNow("tst_read.php?id=$tst_id");
}
?>
