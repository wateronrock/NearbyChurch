<?php
require_once "../functions.php";
if(isset($_POST['id']) && $_POST['id'] !=""){
    $sermon_id = $_POST['id'];
    $delNum = $serdao->deleteSermon($sermon_id);
    if($delNum >0){
        okGo("삭제되었습니다.", "all_sermons.php");
    }
}

?>
