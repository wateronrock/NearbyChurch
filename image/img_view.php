<?php
require_once "../dir_manage.php";
require_once $basePath."header.php";
session_start_if_none();
if(isset($_SESSION['uname'])){
    $uname = $_SESSION['uname'];
}


// 이미지의 id를 저장한다
$img_id = sanitizeRequest('img_id');

if($img_id) {
    $result = $imgdao->getImage($img_id);
} else {
    echo "\$img_id가 비었습니다.";
}



// 이미지 테이블의 id에 해당하는 $img_id 을 가진 관련 댓글을 다 모은다.
$img_comments = $img_comdao->getAllCommentsByParentId($img_id);


?>

<script>
//     $(document).ready(function() {
//   // 모달 버튼 클릭 이벤트
//   $('#commentModalBtn').click(function() {
//     // 조건에 따른 모달 열기
//     if (someCondition) {
//       $('#myModal').modal('show');
//     }
//   });
// });


</script>
<section id="photoview">
    <div class="section-content">
      <div class="container">
        <div class="row">
            <h5><i class="fa-regular fa-pen-to-square"></i> 그림보기/댓글보기/댓글쓰기</h5>
            <div class="col-md-8">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="card-body d-flex justify-content-center">
                        <img class="img-fluid" src="<?=$basePath?>assets/images/photos/<?= $result['file_name'] ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <table class="table table-striped ">
                    <tbody>
                        <?php if($result): ?>
                        <tr>
                            <th scope="row">작성자: </th>
                            <td><?= $result['uploader'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">제 &nbsp;&nbsp;목: </th>
                            <td><?= $result['title'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">설 &nbsp;&nbsp;명: </th>
                            <td><?= $result['description'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"colspan="2">
                                <a type="button" class="btn btn-primary btn-sm w-100" onclick="goBack()">돌아가기</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
                        <?php if($img_comments){
                            foreach ($img_comments as $comment){
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
                                        <button type="submit" class="btn btn-sm btn-danger">삭제</button>
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
                    <form action="img_comment_write.php" method="post">
                        <input type="hidden" id="img_id" name= "img_id" value="<?= $img_id ?>">
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
