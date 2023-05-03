<?php
require_once "functions.php";
if(isset($_POST['uid'])) {
    $uid = $_POST['uid'];
    $stmt = $mdao->delete_member($uid);
}
?>
