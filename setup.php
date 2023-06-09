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
    와 같이 직접 주소창에 적어서 테이블을 세팅한다. 일일이 수작업으로 테이블을 만들지 않아도 된다.
    이 때 createTable()은 같은 이름의 테이블이 존재한다면 만들지 않기 때문에 몇 번을 실행해도 안전하다.*/

    createTable(
        'members',
        'uid varchar(16) NOT NULL PRIMARY KEY,
        pass varchar(16) NOT NULL,
        uname varchar(16) NOT NULL ,
        phone char(12),
        addr varchar(40),
        grade varchar(8),
        UNIQUE (uname)'
    );

    createTable(
        'images',
        'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        uploader VARCHAR(20) NOT NULL,
        title VARCHAR(30) NOT NULL,
        description VARCHAR(50),
        date DATE NOT NULL,
        file_name VARCHAR(50) NOT NULL'
    );
    // comments 류의 테이블의 이름은 반드시 "_"을 갖도록 작명한다. CommentDao에서 "_" 앞을 잘라서 사용하게 된다
    // 그리고 부모의 기록이 사라지면 관련 자식의 기록은 같이 사라지도록 ON DELETE CASCADE 설정을 해 두었다.
    createTable(
        'img_comments',
        'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        img_id INT NOT NULL,
        writer VARCHAR(20) NOT NULL,
        comment VARCHAR(250) NOT NULL,
        date DATE NOT NULL,
        FOREIGN KEY (img_id) REFERENCES images(id) ON DELETE CASCADE'
    );

    createTable(
        'emoticons',
        'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        code CHAR(5) NOT NULL,
        image_file CHAR(7) NOT NULL'
    );

    createTable(
        'sermons',
        'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        preacher VARCHAR(3) NOT NULL,
        title VARCHAR(20) NOT NULL,
        passage VARCHAR(1500) NOT NULL,
        date DATE NOT NULL,
        file_name VARCHAR(20) NOT NULL,
        file_id VARCHAR(50) NOT NULL'
    );

    createTable(
        'testimony',
        'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        author VARCHAR(10) NOT NULL,
        title VARCHAR(40) NOT NULL,
        content VARCHAR(2000) NOT NULL,
        date DATE NOT NULL,
        file_addr VARCHAR(50)'
    );

    createTable(
        'offerings',
        'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(16) NOT NULL,        
        tithe DECIMAL,
        weekly DECIMAL,
        thanks DECIMAL,
        mission DECIMAL,
        construct DECIMAL,
        relief DECIMAL,
        thousand DECIMAL,
        festive DECIMAL,
        etc DECIMAL,
        date DATE NOT NULL'
        
    );
    $query = $pdo->query("SELECT * FROM emoticons");
    $result = $query->fetchAll();
    if(count($result)==0){
        try{
            $pdo->query("INSERT INTO emoticons (code, image_file) VALUES
            (':001:', '001.png'), (':002:', '002.png'), (':003:', '003.png'), (':004:', '004.png'), (':005:', '005.png'), (':006:', '006.png'), 
            (':007:', '007.png'), (':008:', '008.png'), (':009:', '009.png'), (':010:', '010.png'), (':011:', '011.png'), (':012:', '012.png'), 
            (':013:', '013.png'), (':014:', '014.png'), (':015:', '015.png'), (':016:', '016.png'), (':017:', '017.png'), (':018:', '018.png'), 
            (':019:', '019.png'), (':020:', '020.png'), (':021:', '021.png'), (':022:', '022.png'), (':023:', '023.png'), (':024:', '024.png'), 
            (':025:', '025.png'), (':026:', '026.png'), (':027:', '027.png'), (':028:', '028.png'), (':029:', '029.png'), (':030:', '030.png'), 
            (':031:', '031.png'), (':032:', '032.png'), (':033:', '033.png'), (':034:', '034.png'), (':035:', '035.png'), (':036:', '036.png'), 
            (':037:', '037.png'), (':038:', '038.png'), (':039:', '039.png'), (':040:', '040.png'), (':041:', '041.png'), (':042:', '042.png'), 
            (':043:', '043.png'), (':044:', '044.png'), (':045:', '045.png'), (':046:', '046.png'), (':047:', '047.png')");
            echo "Emoticons inserted";
        } catch(PODException $e) {
            echo "Emoticon insertion failed";
        }
    } else {
        echo "Emoticons inserted already";
    }


    
    
?>
    <br>...done.
</body>
</html>
