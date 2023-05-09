<?php
require_once "header.php";

$members = $mdao->getAllMembers();
?>
<script>
    // 삭제 관련
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
            var id = this.dataset.id;
            if(confirm('정말 삭제하시겠습니까?')) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
                };
                xhr.open('POST', 'member_delete.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('uid=' + id);
            }
            });
        });
    }
    
    
    );

    
</script>

<section id="member_list">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">회원정보</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>비밀번호</th>
                                <th>이름</th>
                                <th>전화번호</th>
                                <th>주소</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($members as $member) { ?>
                                <tr>
                                    <td><?= $member['uid'] ?></td>
                                    <td><?= $member['pass'] ?></td>
                                    <td><?= $member['uname'] ?></td>
                                    <td><?= $member['phone'] ?></td>
                                    <td><?= $member['addr'] ?></td>
                                    <td>
                                        <a type="button" href="member_edit.php?uid=<?= $member['uid'] ?>" class="btn btn-sm btn-warning">수정</a>
                                        <button class="btn btn-sm btn-danger delete-button" data-id="<?= $member['uid'] ?>">삭제</button> 
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<!-- 수정모달 -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">회원 정보 수정</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit-form">
          <input type="hidden" class="form-control" name="uid" id="uidInput">
          
          <div class="form-group">
            <label for="pass">비밀번호</label>
            <input type="text" class="form-control" id="pass" name="pass">
          </div>
          <div class="form-group">
            <label for="uname">이름</label>
            <input type="text" class="form-control" id="uname" name="uname">
          </div>
          <div class="form-group">
            <label for="phone">전화번호</label>
            <input type="text" class="form-control" id="phone" name="phone">
          </div>
          <div class="form-group">
            <label for="addr">주소</label>
            <input type="text" class="form-control" id="addr" name="addr">
          </div>
          <button type="button" class="btn btn-primary edit-button  mt-1">수정</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<!-- 수정모달끝 -->


<?php
require_once "footer.php";
?>
