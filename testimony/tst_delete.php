<?php
require_once "../dir_manage.php";
require_once $basePath ."functions.php";

// get 방식으로 넘어오면 보안위험
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tst_id = sanitizeRequest('tst_id');
    if ($tst_id != "") {
        $tstdao->deleteTestimony($tst_id) ;
        okGo("간증이 삭제되었습니다.", "all_testimonies.php");
    }
}
 ?>

