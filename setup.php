<!DOCTYPE html>
<html lang="en">
<head>
    <title>Setting up database</title>
</head>
<body>
    <h3>Setting up....</h3>
<?php
    require_once 'functions.php';

    /*이 페이지는 관리자가 직접 페이지를 불러와서 사용한다. 예를 들면 https://www.example.com/setup.php 
    와 같이 직접 주소창에 적어서 테이블을 세팅한다. 일일이 수작업으로 테이블을 만들지 않아도 된다.*/

    createTable(
        'members',
        'uid varchar(16) NOT NULL PRIMARY KEY,
        pass varchar(16) NOT NULL,
        uname varchar(16) NOT NULL,
        phone char(12),
        addr varchar(40),
        grade varchar(8)'
    );
?>
    <br>...done.
</body>
</html>
