<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";
$id = sanitizeRequest('id');
if(!$id){
    okGo("부적절한 경로로 들어왔습니다.", $basePath."index.php");
}
$result = $tstdao->readTestimony($id);
// \r\n 표시를 <br>로 바꾼다.
$content = $result['content'];
$clean_content = str_replace('\r\n', '<br>', $content);
// $clean_content = "<pre>$content</pre>";
?>

<section id="tst_read">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">간증문</h4></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr >
                                    <td class="bg-light">작성자</td>
                                    <td><?=$result['author']?></td>
                                    <td class="bg-light">제목</td>
                                    <td><?=$result['title']?></td>
                                    <td class="bg-light">작성일</td>
                                    <td><?=$result['date']?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><?=$clean_content?></td>
                                </tr>
                            </tbody>
                        </table>                        
                        <div class="d-flex align-items-center">
                            <?php if($result['file_addr']) : ?>
                                <p class="me-5"><?=$result['file_addr']?></p>
                                <a href="uploads/<?=$result['file_addr']?>" download class="btn btn-primary me-3">파일 다운로드</a>                            
                            <?php endif; ?>
                            <a class="btn btn-primary" onclick="history.go(-1)">돌아가기</a>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once $basePath."footer.php";
?>
