<?php
require_once 'functions.php';
session_start_if_none();

// session_start_if_none();
$randstr = substr(md5(rand()), 0, 7);

$uid = sessionVar('uid');
$uname = sessionVar('uname');
$grade = sessionVar('grade');

?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap css 먼저 연결 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!-- 다음 fontawsome css 연결 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" 
  integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- 슬릭(bs 캐러셀과 조금 다른)을 사용하기 위해 css와 theme css는 상단에 연결, js는 body 하단에 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" 
  integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" 
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" 
  integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" 
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/css/app.css">

 
 
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.js"
  referrerpolicy="no-referrer"></script> -->
    

  <title>가까운 교회 | 기독교한국침례회</title>
</head>
<body>  
  <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 shadow-lg sticky-top">
    <div class="container">    
      <a href="index.php" class="navbar-brand align-middle">
        <h3 class="m-0">          
          <img src="assets/images/church_logo.png" alt="Logo" height="36px">
          <div class="ms-3 float-end">
            <h6 id="church-branch" class="mb-0 mt-0">기독교한국침례회</h6>
            <h4 id="church-name" class="mt-0 mb-0">가까운교회</h4>
          </div>          
        </h3>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="index.php#top" class="nav-link">
              홈
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#intro" class="nav-link">
              소개
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#services" class="nav-link">
              말씀
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#testimony" class="nav-link">
              간증
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#gallery" class="nav-link">
              최신소식
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#cta" class="nav-link">
              연락처
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#find-us" class="nav-link">
              길찾기
            </a>
          </li>
          <?php if($grade == "manager"): ?>
            <li class="nav-item">
            <a href="all_members.php" class="nav-link">
              회원관리
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php#find-us" class="nav-link">
              헌금관리
            </a>
          </li>
          <?php endif;?>
        </ul>
      </div>
    </div>
  </nav>
