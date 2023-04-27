<?php
    require_once "functions.php";
    // signup.php에서 정의된 js 함수 checkUser()에서 매개변수로 받은 값을 ajax를 이용해서 post 방식으로
    // 보내는 목표 파일이 checkuser.php이다
    // checkUser()함수는 input의 입력란에서 커서가 벗어나면 바로 작동하여 그 결과를 ajax로 바로 보여준다.
    // 즉 이름에 대한 유효성 검사를 위해 $.post로 checkUser.php로 이름을 한번 보내고
    // 통과하면 전체적으로 폼에 의하여 post로 자신의 페이지로 다시 값을 보내어 이름과 패스워드과 함께
    //  회원으로 등록완료한다.
?>
<?php
    if(isset($_POST['uid'])) {
        // $uid = sanitizeString($_POST['uid']);
        $uid = sanitizeString($_POST['uid']);
        
        $result = $pdo->query("SELECT * FROM members WHERE uid= '$uid'");
        if($result->rowCount())
            // echo 명령어는 화면에 출력한다. signup.php의 폼에서 이름이 ajax.post로 지금의 파일
            // checkuser.php로 넘어와 결과값을 전달한다. 그 결과 값이 echo 이하이다. ajax로 받은 것이므로 signup.php의 폼
            // 바로 아래의 #used에 리로딩없이 실시간으로 표시된다.
            echo "<span class='text-danger'>&nbsp; <i class='fa-sharp fa-solid fa-x'></i>".
            "&nbsp; 아이디 {$uid}가 이미 존재합니다.</span><br><br>";
        else
            echo "<span class='text-success'>&nbsp; <i class='fa-solid fa-check'></i>".
            "&nbsp; {$uid}는 아이디로 사용가능합니다.</span><br><br>";
    }

    
?>
