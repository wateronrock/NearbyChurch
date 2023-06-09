<?php
require_once "dir_manage.php";
require_once "BaseDao.php";
require_once "member/MemberDao.php";
require_once "image/ImgDao.php";
require_once "CommentDao.php";
require_once "sermon/SermonDao.php";
require_once "testimony/TestimonyDao.php";
require_once "offering/OfferingDao.php";

$host = 'localhost';
$dbname = 'churchdb';
$dbuser = 'root';
$dbpass = '1234';
$chrs = 'utf8mb4';
$basedao = new BaseDao($host, $dbname, $dbuser,$dbpass, $chrs);
// 아래의 pdo는 부모로부터 물려받은 것이니 따로 생성하지 않는다. 
// 어느 객체의 부모라도 동일하니, basedao에서 얻은 pdo는 pdo 객체를 이용하는 모든 DAO에서 이용한다.
// DAO객체를 중복해서 생성하지 않기 위해서이다.
$pdo = $basedao->getPdo();
$mdao = new MemberDao($pdo);
$imgdao = new ImgDao($pdo);
$img_comdao = new CommentDao($pdo, "img_comments" );
$serdao = new SermonDao($pdo);
$tstdao = new TestimonyDao($pdo);
$offerdao = new OfferingDao($pdo);

define("MAIN_PAGE", "index.php");

function createTable($name, $query) 
{
    global $pdo;
    // sql문 create table 테이블이름(`id` CHAR(8) NOT NULL, `address` CHAR(20) NOT NULL)와 같은 형식
    $pdo->query("create table if not exists $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function destroySession() {
    // 먼저 $_SESSION 변수를 비운다
    $_SESSION = array();

    // 세션아이디가 있거나, 쿠키 변수에 세션이름이 있으면 쿠키변수에 있는 이름을 삭제한다
    if(session_id() !="" | isset($_COOKIE[(session_name())]))
        setcookie(session_name(), '', time()-259200, '/');
    
    // 세션을 제거한다
    session_destroy();
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

function showProfile($user) {
    global $pdo;
    if(file_exists("images/profiles/$user.jpg")) {
        echo "<img src='images/profiles/$user.jpg' style='float:left;'>";
    }      

    $result = $pdo->query("select * from profiles where uid = '$uid'");

    if ($result->rowCount()){
        // $result에는 $user이름을 가진 기록을 가져와 담겨있다. fetch()메소드는 그 기록물을 연관배열로 변환하여 반환
        // $row는 하나의 record에 해당하며 $row['text']는 그 기록에서 text라는 제목으로 들어있는 값을 가진다.
        $row = $result->fetch();
        echo(stripslashes($row['text'])."<br style='clear:left;'><br>");
    } else echo "<p>Nothing to see here, yet</p><br>";
        
}

function abbreviateString($string, $maxLength) {    
    $abbreviatedString = $string;
    
    if (mb_strlen($string) > $maxLength) {
        $abbreviatedString = mb_substr($string, 0, $maxLength - 3, "UTF-8")."...";        
    }
    
    if(mb_strlen($abbreviatedString)<66){
        $abbreviatedString = $abbreviatedString . "<br><br>";
    }
    return $abbreviatedString;
}

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

function goBack($msg){
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

function sanitizeRequest($var){
    $result = requestValue("$var");
    $result = sanitizeString($result);
    return $result;
}

// 숫자를 세자리로 표현하되 모자란 자리수는 0으로 채운다
function padNumber($number){
    $paddedNumber = sprintf('%03d', $number);
    return $paddedNumber;
}
?>
