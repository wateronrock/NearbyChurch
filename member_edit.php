<?php
require_once "header.php";
$uid = sanitizeRequest('uid');
$pass = sanitizeRequest('pass');
$uname = sanitizeRequest('uname');
$phone = sanitizeRequest('phone');
$addr = sanitizeRequest('addr');

if($uid && !$pass && !$uname) {
    $record = $mdao->read_member($uid);
    $pass = $record['pass'];
    $uname = $record['uname'];
    $phone = $record['phone'];
    $addr = $record['addr'];
} else {
    $mdao->update_member($uid, $pass, $uname, $phone, $addr);
    okGo("회원정보를 수정하였습니다.", "./all_members.php");
}
?>

<script>
    function checkPass() {
    var password1 = document.getElementById("pass1").value;
    var password2 = document.getElementById("pass2").value;
    if (password1 !== password2) {
      document.getElementById("identical").innerHTML = "<span class='text-danger'>&nbsp; <i class='fa-sharp fa-solid fa-x'></i>&nbsp; 비밀번호가 일치하지 않습니다.</span><br><br>";
    } else {
      document.getElementById("identical").innerHTML = "<span class='text-success'>&nbsp; <i class='fa-solid fa-check'></i>&nbsp; 비밀번호가 일치합니다.</span><br><br>";
    }
}
</script>

<!-- 회원정보 수정 폼 -->
<section id="edit-member">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">회원정보수정</h4></h4>
                    </div>
                    <div class="card-body">
                        <form action="member_edit.php" method="post">
                            <input id='uid' name="uid" type="hidden" class="form-control" value="<?=$uid?>">
                            <div class="mb-3">
                                <input id='pass1' name="pass" type="password" class="form-control" value="<?=$pass?>">
                            </div>
                            <div class="mb-3">
                                <input id='pass2' type="password" class="form-control" placeholder="패스워드 확인" onBlur='checkPass()' >
                            </div>
                            <div id="identical"></div>
                            <div class="mb-3">
                                <input name="uname" type="text" class="form-control" value="<?=$uname?>">
                            </div>
                            <div class="mb-3">
                                <input name="phone" type="text" class="form-control" value="<?=$phone?>">
                            </div>
                            <div class="mb-3">
                                <input name="addr" type="text" class="form-control" value="<?=$addr?>">
                            </div>
                            <p class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">수정</button>
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
require_once "footer.php";
?>
