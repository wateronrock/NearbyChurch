<?php
    require_once "header.php";
    // header.php에는 이미 functions.php가 도입되어 있으므로 각종 함수를 사용할 수 있다.
    $uid = sanitizeRequest('uid');
    $pass = sanitizeRequest('pass');
    $uname = sanitizeRequest('uname');
    $query = $pdo->prepare('SELECT* FROM members WHERE uid = ?');
    $query->execute([$uid]);



    
    if($uid && $pass && $uname) {
        if($query->rowCount() <= 0) {

            $phone = sanitizeRequest('phone', false);
            $addr = sanitizeRequest('addr');

            $mdao->create_member($uid, $pass, $uname, $phone, $addr);
        } else {
            okGo("같은 아이디가 존재합니다.", "signup.php");
        }     
    } 
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
    // 콜백함수 이 때 매개변수 data는 응답받은 데이터이다. dataType은 서버에서 반환되는 데이터타입이다.
    // 기본 값은 지능형 추측(xml, json, script, html)
    var xhr = new XMLHttpRequest();
    var url = 'checkuser.php';
    var params = 'uid=' + encodeURIComponent(user.value);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = xhr.responseText;
                document.getElementById('used').innerHTML = data;
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    // .fail(function(jqXHR, textStatus, errorThrown){
    //     echo ("요청실패: ", errorThrown );
    // });
}

function checkPass() {
    var password1 = document.getElementById("pass1").value;
    var password2 = document.getElementById("pass2").value;
    if(password1 && password2){
        if (password1 !== password2) {
            document.getElementById("identical").innerHTML = "<span class='text-danger'>&nbsp; <i class='fa-sharp fa-solid fa-x'></i>&nbsp; 비밀번호가 일치하지 않습니다.</span><br><br>";
        } else {
         document.getElementById("identical").innerHTML = "<span class='text-success'>&nbsp; <i class='fa-solid fa-check'></i>&nbsp; 비밀번호가 일치합니다.</span><br><br>";
        }
    } else {
        document.getElementById("identical").innerHTML = "<span class='text-danger'>&nbsp; <i class='fa-sharp fa-solid fa-x'></i>&nbsp; 비밀번호를 입력하여 주세요.</span><br><br>";
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
                        <form action="signup.php?r=<?=$randstr ?>" method="post">
                            <div class="mb-3">
                                <input id='uid' name="uid" type="text" class="form-control" placeholder="" tabindex="0" onBlur='checkUser(this)'>
                            </div>
                            <div id="used"></div>
                            <div class="mb-3">
                                <input id='pass1' name="pass" type="password" class="form-control" placeholder="패스워드" >
                            </div>
                            <div class="mb-3">
                                <input id='pass2' type="password" class="form-control" placeholder="패스워드 확인" tabindex="" onBlur='checkPass()' >
                            </div>
                            <div id="identical"></div>
                            <div class="mb-3">
                                <input name="uname" type="text" class="form-control" placeholder="사용자명(실명)" >
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
