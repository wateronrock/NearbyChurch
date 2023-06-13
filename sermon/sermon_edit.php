<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";
$id = sanitizeRequest('id');

if($id != ''){
    $sermon = $serdao->getSermonById($id);
}
$preacher = sanitizeRequest('preacher');
$title = sanitizeRequest('title');
$passage = sanitizeRequest('passage');
$date = sanitizeRequest('date');
$audio_id = sanitizeRequest('audio_id');



if($preacher != '' && $title != '' && $passage != '' && $date != '' && $audio_id != '' ){
    $rowNum = $serdao->updateSermon($id, $preacher, $title, $passage, $date, $audio_id);
    if($rowNum>0){
        okGo("설교가 갱신되었습니다.", "all_sermons.php");
    } else {
        okGo("설교 갱신에 실패하였습니다.", "sermon_edit.php?id=$id");
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
                        <form action="sermon_edit.php" method="post">
                            <input type="hidden" name="id" value="<?=$id ?>">
                            <div class="mb-3">
                                <input name="preacher" type="text" class="form-control" value = "<?= $sermon['preacher'] ?>">
                            </div>
                            <div class="mb-3">
                                <input name="title" type="text" class="form-control" value = "<?= $sermon['title'] ?>" >
                            </div>
                            <div class="mb-3">
                                <textarea name="passage" class="form-control w-100"rows="5" ><?= $sermon['passage'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <input name="date" type="date" class="form-control" value = "<?= $sermon['date'] ?>">
                            </div>
                            <div class="mb-3">
                                <input name="audio_id" type="text" class="form-control" value = "<?= $sermon['audio_id'] ?>">
                            </div>
                            <p class="mb-3">
                                <button class="btn btn-primary w-100" type="submit" >수정</button>
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
