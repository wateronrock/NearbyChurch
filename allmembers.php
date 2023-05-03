<?php
require_once "header.php";
?>



<section id="members">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">회원명부</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>아이디</th>
                                    <th>이름</th>
                                    <th>전화번호</th>
                                    <th>주소</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $members = $mdao->getAllMembers();

                                // 회원 정보 출력
                                foreach ($members as $member): 
                                ?>
                                <tr>
                                    <td><?= $member['uid']?></td>
                                    <td><?= $member['uname']?></td>
                                    <td><?= $member['phone']?></td>
                                    <td><?= $member['addr']?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-button" data-id="<?= $member['uid']?>">삭제</button>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<script>
    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            if(confirm('정말 삭제하시겠습니까?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if(xhr.status === 200) {
                        location.reload();
                    }
                };
                xhr.send('uid=' + id);
            }
        });
    });
</script>

<?php
require_once "footer.php";
?>
