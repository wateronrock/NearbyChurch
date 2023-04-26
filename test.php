<?php
    require_once "header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha512-DUC8yqWf7ez3JD1jszxCWSVB0DMP78eOyBpMa5aJki1bIRARykviOuImIczkxlj1KhVSyS16w2FSQetkD4UU2w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.js" referrerpolicy="no-referrer"></script>
<script>
    function checkUser(user) {
        // user.value에 값이 없다면 #used에 그냥 스페이스 하나 출력하고 빠져나가라        
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
</script>
    
<?php
    // 회원등록할 때에는 이전의 자료가 남아 있으면 안된다. 에러메시지, 사용자이름, 패스워드 다 지우고 세션도 파괴한다
    $error = $uid = $pass = $msg = "";
    if(isset($_SESSION['uid'])) destroySession();

    if(isset($_POST['uid'])) {
        $uid = sanitizeString(requestValue('uid'));
        $pass = sanitizeString(requestValue('pass'));
        $uname = sanitizeString(requestValue('uname'));
        $phone = sanitizeString(requestValue('phone'));
        $addr = sanitizeString(requestValue('addr'));

    if($uid == "" || $pass == "" || $uname == "" || $phone == "" || $addr == "") {
        $error = "모든 항목을 기입해 주세요";
    } else {
        /*PDOStatement는 데이터 베이스에서 select 쿼리문으로 받은 data를 보관하는 순환가능(iterable) 클래스이다. 
        그 객체는 여러 row의 정보로 이루어져 있다. PDOStatement::rowCount()는 row의 수를 정수로 반환*/

        $result = queryMysql("SELECT * FROM members WHERE uid = '$uid'");

        if($result->rowCount())
            $error = "본 아이디는 이미 존재합니다";

        else {
            queryMysql("INSERT INTO members VALUES('$uid', '$pass', '$uname', '$phone', '$addr')");
            $msg = "회원등록이 완료되었습니다. 로그인해주세요.";
            okGo($msg, MAIN_PAGE);
        }
    }

    if($error) errorBack($error);
    elseif($msg) okGo($msg, MAIN_PAGE);
}
    
    
?>


<!-- ----------------------------------회원등록 폼----------------------------------------- -->
<section id="signup">
    <div class="section-content">
      <div class="container">
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
                                <input name="pass" type="password" class="form-control" placeholder="패스워드">
                            </div>
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
</body>
</html>
