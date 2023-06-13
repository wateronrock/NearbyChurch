<?php
    require_once "functions.php";
    session_start_if_none();

     // 에러 메시지 사용자 명 패스 모두 지운다
     $msg =$uid = $pass = "";
     $uid = sanitizeRequest('uid');
     $pass = sanitizeRequest('pass');

    if($uid == "" || $pass == "") {
        $msg = "모든 빈 칸을 채워주세요.";
    } else {
        $result = $mdao->read_member($uid);
        if($result) {
            $uname = $result['uname'];
            $grade = $result['grade'];
            echo "등급은 $qual 입니다.";
            if($result && $pass==$result['pass']) {
                $_SESSION['uid'] = $uid;
                $_SESSION['uname'] = $uname;
                $_SESSION['grade'] = $grade;
            }elseif($pass != $result['pass']) {
                $msg = "비밀번호가 일치하지 않습니다.";
            }
        }        
        else $msg = "검색결과가 없습니다. 회원등록을 해 주세요.";
    }
    
    // 메시지를 띄우고 원래 페이지로 돌려 보낸다. 이제 원래 페이지에서 세션 변수에 
    // 'uid'와 'uname'으로 들어온 것이 있으면 로그인 완료창, 없으면 로그인 입력창을 띄운다
    if($msg){
        okGo($msg, MAIN_PAGE);
    } else {
        goNow(MAIN_PAGE);
    }
    
     
?>

