<?php
require_once "../dir_manage.php";
require_once $basePath ."functions.php";
if(isset($_POST['id']) && $_POST['id'] != ''){
    $img_id = $_POST['id'];
    $photo = $imgdao->getImage($img_id);
    if($photo){
        $fileName = $photo['file_name'];
    }
    $filePath = $_SERVER['DOCUMENT_ROOT'] ."/assets/images/photos/$fileName";
    $result =$imgdao->deleteImage($img_id);    
    if(file_exists($filePath) && $result == true){
        unlink($filePath);
        okGo("그림삭제에 성공하였습니다.", "all_photos.php");
    } else {
        okGo("사진 삭제에 실패하였습니다.", "img_view.php?img_id=$img_id");
    }
}
?>
