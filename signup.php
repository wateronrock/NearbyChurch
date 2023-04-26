<?php
    require_once "header.php";
    // header.php에는 이미 functions.php가 도입되어 있으므로 각종 함수를 사용할 수 있다.
?>


<script>
    function checkUser(user) {
    // user.value에 값이 없다면 #used에 그냥 스페이스 하나 출력하고 빠져나가라   
    // 아래에서 사용되는 매개변수는 this이며, 이는 input요소를 의미한다. 그 속성 value를 받아야 그 안의 값을 알 수 있다.

    if(user.value=='') {
        $('#used').html('&nbsp;');
        return;
    }
    // 먼저 매개변수를 체크하여 아무 것도 없으면 빈 칸 하나를 #used에 출력하고 이 함수를 종료하라
    // 만일 매개변수에 어떤 값이 있다면 ajax를 이용하여 post방식으로 checkuser.php로 그 값을 보내어 응답을
    // 받아와서 #used 자리에 표시하라.
    // $.post(url[, data][, success(data, textStatus, jqXHR)][, dataType]) 반환 타입은 jqXHR이다.
    // jQuery함수이며 url에 정보를 post방식으로 요청, data는 서버로 보낼 data, success는 요청이 성공하면 실행될
    // 콜백함수 이 때 매개변수 data는 응답받은 데이터이다. dataType은 서버에서 반환되는 데이터 사입이다.
    // 기본 값은 지능형 추측(xml, json, script, html)
    $.post
    (
        'checkuser.php',
         { uid : user.value },
        function(data){
            $('#used').html(data);
        }
    )
}

function checkPass() {
    var password1 = $('#pass1').val();
    var password2 = $('#pass2').val();

    if (password1 === password2) {
        $('#identical').html("<span class='text-success'>&nbsp; <i class='fa-solid fa-check'></i>".
            "&nbsp; 패스워드가 일치합니다..</span><br><br>");
    } else {
        $('#identical').html("<span class='text-danger'>&nbsp; <i class='fa-sharp fa-solid fa-x'></i>".
            "&nbsp; 패스워드가 일치하지 않습니다.</span><br><br>");
    }
}
</script>
    



<!-- ----------------------------------회원등록 폼----------------------------------------- -->
<section id="signup">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">회원가입</h4>
                    </div>
                    <div class="card-body">
                        <form action="signup.php" method="post">
                            <div class="mb-3">
                                <input id='uid' name="uid" type="text" class="form-control" placeholder="아이디" onBlur='checkUser(this)'>
                            </div>
                            <div id="used"></div>
                            <div class="mb-3">
                                <input id='pass1' name="pass1" type="password" class="form-control" placeholder="패스워드">
                            </div>
                            <div class="mb-3">
                                <input id='pass2' name="pass2" type="password" class="form-control" placeholder="패스워드 확인" >
                            </div>
                            <div id="identical"></div>
                            <div class="mb-3">
                                <input name="uname" type="text" class="form-control" placeholder="사용자명(실명)">
                            </div>
                            <div class="mb-3">
                                <input name="phone" type="text" class="form-control" placeholder="핸드폰번호 '-'없이 기입">
                            </div>
                            <div class="mb-3">
                                <input name="addr" type="text" class="form-control" placeholder="주소">
                            </div>
                            <p class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">회원가입</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>
<!-- ----------------------- 회원가입 폼 마침 ------------------------------- -->
<?php
    require_once "footer.php";
?>
