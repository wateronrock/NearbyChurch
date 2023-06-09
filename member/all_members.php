<?php

// 이미지 파일의 경로 설정
// $imagePath = $basePath . "/images/image.jpg";

// 이미지 태그 출력
// echo "<img src='$imagePath' alt='Image'>";

require_once "../dir_manage.php";
require_once $basePath."header.php";

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
                                <th>회차</th>
                                <th></th>
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
<?php
require_once $basePath."footer.php";
?>
