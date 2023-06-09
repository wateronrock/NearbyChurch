<?php
require_once "../functions.php";
$date = sanitizeRequest('date');
if(isset($_POST['id']) && $_POST['id'] !=""){
    $offer_id = $_POST['id'];
    $delNum = $offerdao->deleteOffering($offer_id);
    if($delNum >0){
        okGo("삭제되었습니다.", "offer_weekly_detail.php?date=$date");
    }
}

?>
