<?php
require_once "header.php";
?>

<!-- 댓글 쓰기 버튼 -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
  댓글 작성
</button>

<!-- 댓글 쓰기 모달 -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commentModalLabel">댓글 작성</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <form action="comment_insert.php" method="post">
          <div class="form-group">
            <label for="comment">댓글</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="댓글을 입력하세요"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary">댓글 작성</button>
      </div>
    </div>
  </div>
</div>


<?php
require_once "footer.php";
?>
