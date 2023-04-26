<!DOCTYPE html>
<html lang="en">
<head>
    <title>Setting up database</title>
</head>
<body>
    <h3>Setting up....</h3>
<?php
    require_once 'functions.php';

    /*functions.php에 정의된 createTable($tableName, $query)함수는 다음과 같이 작동한다.
    create table $tableName (`id` CHAR(8) NOT NULL, `address` CHAR(20) NOT NULL); 
    이 때 ()안의 문구를 $query로 사용할 수 있다. 첫 매개변수는 테이블의 이름으로 따옴표로 둘러 싸여 있으며
    나머지는 테이블의 구성 요소이며 역시 전체를 포함하는 따옴표로 둘러 싸여 있다. 마지막에 index(user(6))는 user
    의 16자리 중에서 6자리만 인덱스로 등록하겠다는 말이다.*/

    createTable(
        'members',
        'uid varchar(16) NOT NULL PRIMARY KEY,
        pass varchar(16) NOT NULL,
        uname varchar(16) NOT NULL,
        phone char(12),
        address varchar(22)'
    );
?>
    <br>...done.
</body>
</html>
