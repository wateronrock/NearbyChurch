<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";
$preacher = sanitizeRequest('preacher');
$title = sanitizeRequest('title');
$passage = sanitizeRequest('passage');
$date = sanitizeRequest('date');
$audio_id = sanitizeRequest('audio_id');
if(isset($_POST['is_first'])){
    $isFirst = FALSE;
} else {
    $isFirst = TRUE;
}

if(!$isFirst) {
    if($preacher && $title && $passage && $date && $audio_id){
        $serdao->createSermon($preacher, $title, $passage, $date, $audio_id);
        okGo("설교가 등록되었습니다.", "all_sermons.php");
    } else {
        okGo("빈 칸을 다 메워주세요.", "sermon_upload.php");
    }
}

?>

<section id="sermonupload">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">설교 등록</h4>
                    </div>
                    <div class="card-body">
                        <form action="sermon_upload.php" method="post">
                            <div class="mb-3">
                                <input name="preacher" type="text" class="form-control" placeholder="설교자">
                            </div>
                            <div class="mb-3">
                                <input name="title" type="text" class="form-control" placeholder="설교제목" >
                            </div>
                            <div class="mb-3">
                                <textarea name="passage" class="form-control w-100"rows="10" placeholder="설교본문"></textarea>
                            </div>
                            <div class="mb-3">
                                <input name="date" type="date" class="form-control" placeholder="설교일" >
                            </div>
                            <div class="mb-3">
                                <input name="file_addr" type="text" class="form-control" placeholder="오디오파일주소">
                            </div>
                            <p class="mb-3">
                                <button name="is_first"class="btn btn-primary w-100" type="submit" value="">등록</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once $basePath ."footer.php";
?>
