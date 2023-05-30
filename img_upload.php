<?php
require_once "header.php";
if(!$uid || !$uname){
    okGo("사진을 올리시려면 로그인 해주세요!", "index.php");
} else {
    if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_FILES['image'])) {
        // 폼 데이터 처fl
        $uploader = $uname;
        $date = date('Y-m-d H:i');
        $title = sanitizeRequest('title');
        $description = sanitizeRequest('description');

        // 파일 업로드 처리
        $file = $_FILES['image'];
        $fileName = $imgdao->saveImageFile($file);
        $imgid = $imgdao->insertImage($uploader, $title, $description, $date, $fileName);

        if($fileName && $imgid>0){
            okGo("사진이 등록되었습니다.", "all_photos.php");
        }

    }
?>
<section id="img_upload">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">사진 올리기</h4>
                    </div>
                    <div class="card-body">
                        <form action="img_upload.php" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="title">제목:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">설명:</label>
                                <textarea name="description" class="w-100" id="description" cols="100" rows="2" placeholder="최대 20자까지 입력"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">사진:</label>
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                            <p class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">업로드</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<?php } ?>
<?php
require_once "footer.php";
?>
