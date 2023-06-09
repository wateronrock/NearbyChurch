<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";

if(!$uid || !$uname){
    okGo("간증을 작성하시려면 로그인 해주세요.", $basePath."index.php");
} else {
    if(isset($_POST["title"]) && isset($_POST["content"])) {
        // 폼 데이터 처리
        $author = $uname;
        $date = date('Y-m-d H:i');
        $title = sanitizeRequest('title');
        $content = sanitizeRequest('content');
        if(mb_strlen($content)> 990) {
            okGo("한글 1000까지만 적을 수 있습니다(12포인트 A4 지 한 장 반정도)", "tst_upload.php");
        }


        // 파일 업로드 처리 시 파일을 선택하지 않아도 $_FILES['file']에 
        // 값이 실린다. 그래서 error코드를 확인한다.
        
        if(isset($_FILES['file'])) {
            // 파일이 선택되었을 때의 처리
            if($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];
                $file_addr = $tstdao->uploadFile($file);
            } else {
                $file_addr = null;
            }
        } else {
           $file_addr = null;
        }

        $insertId = $tstdao->createTestimony($author, $title, $content, $date, $file_addr);
        if($insertId>0){
            okGo("간증이 등록되었습니다", "all_testimonies.php");
        }

    }
}
?>

<section id="tst_upload">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">간증기록</h4>
                    </div>
                    <div class="card-body">
                        <form action="tst_upload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input name="title" type="text" class="form-control" placeholder="제목" >
                            </div>
                            <div class="mb-3">
                                <textarea class="w-100" id="content" name="content" rows="10" placeholder="1000자까지 작성, 한글이나 워드 파일은 12포인트 한 장 반 이내로 맞춰 주세요."></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="file"  id="file" name="file"> <span id="charCount" class="float-end">(0/1000)</span>
                            </div>                            
                            <p class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">간증제출</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<script>
    var contentInput = document.getElementById("content");
    var charCountDisplay = document.getElementById("charCount");

    contentInput.addEventListener("input", function() {
      var content = contentInput.value;
      var charCount = "(" + content.length + "/1000)";
      if(content.lenth> 1000){
        alert ("허용 글자수를 넘었습니다.");
      }
      charCountDisplay.textContent = charCount;
    });
 </script>
<?php
require_once $basePath ."footer.php";
?>
