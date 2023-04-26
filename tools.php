<?php
    require_once "MemberDao.php";
    define("MAIN_PAGE", "login_main.php");
    // member_path는 지금은 현재 폴더인 . 으로 지정되어 있지만 나중에는 
    // 웹사이트의 루트를 기준으로 로그인 프로그램이 있는 위치를 적게 된다.
    define("MEMBER_PATH", ".");

    $host = 'localhost';
    $dbname = 'churchdb';
    $dbuser = 'root';
    $dbpass = '1234';
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$dbname;charset=$chrs";
    $opts = 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new MemberDao($attr, $dbuser, $dbpass, $opts);
    // $pdo = new PDO($attr, $dbuser, $dbpass, $opts);

    function session_start_if_none() {
        if(session_status() == PHP_SESSION_NONE) session_start();
    }

    // get 또는 post로 보내진 값을 반환함
    function requestValue($name) {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : "";
    }

    // 세션변수의 값을 읽어와 반환
    function sessionVar($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : "";
    }

    function sanitizeString($var) {
        global $pdo;
        $var = strip_tags($var);
        $var = htmlentities($var);
        // php.ini에 있는 get_magic_quotes_gpc 속성의 값을 알려준다. 만일 on이면 PHP는 get, post, cookie자료에
        // addslashes()함수를 자동실행하여 다음 문자들 앞에 역슬래시를 넣는다. 외따옴표, 쌍따옴표, 역슬래시, NUL
        // 그러므로 전달된 값으로 사용하기 위해서는 자동으로 들어있는 역슬래시를 제거하여야 한다. 
        // 그러나 php 8.0부터는 get_magic_quotes_gpc()는 폐기되었으므로 오류가 난다. 
        // function_exists("get_magic_quotes_gpc")로 확인하고 사용하도록 한다.
        if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    
            $var = stripslashes($var);
        
        // 홀따옴표 첨가
        $result = $pdo->quote($var);
    
        // 혹시 쌍따옴표 바깥에 외따옴표 부가한 것 고침
        return str_replace("'", "", $result);
    }

    // url로 페이지 이동, 이 함수 뒤의 코드는 실행되지 않음
    function goNow($url) {
        // header함수는 아래의 코드를 다 실행하고 작동한다. 바로 exit()으로 끊어주면 바로 작동한다
        header("Location: $url");
        exit();
    }

    // 경고창에 오류 메시지 출력하고 이전 페이지로 돌아가는 함수
    // php가 자바스크립트의 alert창을 불러오는 기법
    // 아래에 기술되는 errorBack()이나 okGo() 함수는 일반적으로 로그인이나 회원가입을 할 때 
    // 오류메시지나 성공메시지를 보내고 원하는 페이지로 돌아가게 하는 필수기능

    function errorBack($msg){
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
    <script>
        // html에서 php의 변수값을 불러 올 때의 형식은 자바스크립트 내부에서도 통용, 
        // 경고창은 확인 버튼을 눌러야 다음 코드가 작동
        alert('<?=$msg?>');
        // 자바스크립트 내장함수로 이전 페이지로 돌림
        history.back();
    </script>
        
    </body>
    </html>

<?php
    exit();
    }

    // 경고창에 메시지 출력하고 지정된 페이지로 이동
    function okGo($msg, $url) {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <script>
        alert('<?=$msg?>');
        // 페이지로 이동하는 자바스크립트 내장함수
        location.href='<?=$url?>';
    </script>
</body>
</html>
<?php
    // 다른 페이지로 이동한 후에는 이후의 코드가 무의미하므로 중지하라는 명령
    exit();
    }
?>