<?php
require_once "../dir_manage.php";
require_once $basePath ."functions.php";
if(isset($_POST['uid'])) {
    $uid = $_POST['uid'];
    $delNum = $stmt = $mdao->delete_member($uid);    
}
?>
