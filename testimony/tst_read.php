<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";
$id = sanitizeRequest('id');
$tst_id = $id;

if(!$id){
    okGo("부적절한 경로로 들어왔습니다.", $basePath."index.php");
}
$result = $tstdao->readTestimony($id);
// \r\n 표시를 <br>로 바꾼다.
$content = $result['content'];
$clean_content = str_replace('\r\n', '<br>', $content);
// $clean_content = "<pre>$content</pre>";


$tst_comments = $tst_comdao->getAllCommentsByParentId($tst_id);


?>

<section id="tst_read">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h5 class="ms-3"><i class="fa-regular fa-pen-to-square"></i> 간증문/댓글보기/댓글쓰기</h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="card-title text-dark my-3 text-center me-3">간증문</h4>
                            <a class="btn btn-primary" onclick="history.go(-1)">돌아가기</a>
                        </div>
                        
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h4>댓글보기  &nbsp;
                <button type="button" class="btn btn-primary btn-sm" id="commentModalBtn"
                    data-bs-toggle="modal" data-bs-target="#commentModal">댓글쓰기</button></h4>
            <table class="table table-striped">
                    <thead>
                        <tr>
                        <th >작성자</th>
                        <th >댓글</th>
                        <th >작성일</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($tst_comments){
                            foreach ($tst_comments as $comment){
                        ?>

                        <tr>
                            <td style="white-space: nowrap; height: auto"><?= isset($comment['writer']) ? $comment['writer'] : '' ?></td>
                            <td><?= isset($comment['comment']) ? $comment['comment'] : '' ?></td>
                            <td style="white-space: nowrap; height: auto"><?= isset($comment['date']) ? $comment['date'] : '' ?></td>
                         
                            <?php if($uname && $comment['writer'] && $uname == $comment['writer']) {?> 
                                <td style="white-space: nowrap; height: auto">
                                <div class="btn-group" role="group" aria-label="Comment Actions">
                                    <button type="button" class="btn btn-sm btn-warning me-1" id="commentEditModalBtn"
                                        data-bs-toggle="modal" data-bs-target="#commentEditModal">수정</button>                                  
                                    <form action="img_comment_delete.php" method="post" style="display: inline;">
                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                        <input type="hidden" name="img_id" value="<?= $comment['img_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return showConfirm();">삭제</button>
                                    </form>
                                </div>

                                </td>
                            <?php }?>                                
                        </tr>

                        <?php }} else {
                            echo "댓글이 없습니다.";
                        
                        }?>
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 댓글 쓰기 모달 -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="commentModalLabel">댓글 쓰기</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">        
                    <form action="tst_comment_write.php" method="post">
                        <input type="hidden" name= "id" value="<?= $tst_id ?>">
                        <div class="mb-3">
                            <textarea class= "w-100" name="comment" id="comment" rows="5" placeholder="댓글을 입력하세요"></textarea>
                        </div>
                        <p class="mb-3">
                            <button class="btn btn-primary w-100" type="submit">댓글등록</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 댓글 수정 모달 -->
    <div class="modal fade" id="commentEditModal" tabindex="-1" aria-labelledby="commentEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="commentEditModalLabel">댓글 수정</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">        
                    <form action="img_comment_edit.php" method="post">
                        <input type="hidden" id="img_id" name= "img_id" value="<?= $img_id ?>">                        
                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                        <div class="mb-3">
                            <textarea class= "w-100" name="comment" id="comment" rows="5"><?=$comment['comment']?></textarea>
                        </div>                        
                        <p class="mb-3">
                            <button class="btn btn-primary w-100" type="submit">댓글수정</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
require_once $basePath."footer.php";
?>
