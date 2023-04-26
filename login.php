<?php
    require_once "functions.php";
    session_start_if_none();

     // 에러 메시지 사용자 명 패스 모두 지운다
     $msg = $uid = $pass = "";
     $uid = requestValue('uid');
     $pass = requestValue('pass');
     $uid = sanitizeString($uid);
     $pass = sanitizeString($pass);
 
    if($uid == "" || $pass == "") {
        $msg = "모든 빈 칸을 채워주세요.";
    } else {
        $result = queryMysql("SELECT * FROM members WHERE uid = '$uid'");
        $row = $result->fetch();
        if($row) {
            $uname = $row['uname'];
            $_SESSION['uid'] = $uid;
            $_SESSION['uname'] = $uname;

            $msg = "로그인 되었습니다. 아이디: $uid, 사용자: $uname";
        }
        else $msg = "검색결과가 없습니다. 회원등록을 해 주세요.";
    }
    
    // 메시지를 띄우고 원래 페이지로 돌려 보낸다. 이제 원래 페이지에서 세션 변수에 
    // 'uid'와 'uname'으로 들어온 것이 있으면 로그인 완료창, 없으면 로그인 입력창을 띄운다
    okGo($msg, MAIN_PAGE);
     
?>

