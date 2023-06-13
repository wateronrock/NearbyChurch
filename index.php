<?php
  require_once "header.php"; 
  
  // 설교 표시
  $sermons = $serdao->getAllSermons();
  $newSixSer = array_slice($sermons, 0, 6);

  // 그림표시
  $images = $imgdao->getAllImages();
  $newSixImg = array_slice($images,0, 6);

  // 구글 드라이버 이용시 오디오 주소 베이스
  $audioBasePath = "https://drive.google.com/uc?export=open&id=";

  // 간증 표시
  $testimonies = $tstdao->getAllTestimonies();
  $newThreeTst = array_slice($testimonies, 0, 3);
?>

  <section id="top">
    <div class="section-content overlay d-flex justify-content-center align-items-center">
      <div class="container">
        <!-- 상단에서 .row를 하나 개설할 때 .align-items-center도 같이 하는 것이 보기에 좋다. -->
        <div class="row align-items-center">
          <!-- 환영인사는 md 이상에서 .container의 9/12, 즉 3/4를 차지한다 -->
          <div class="col-md-9 welcome">
            <h2 class="welcome-title fw-light">우리 <span class="text-warning fw-bold">가까운 교회</span> 
              를 방문해 주셔서 감사합니다. <div class="mt-2"> 하나님께서 주신 복음, 기쁜 소식을 함께 나누어요.</div></h2>
            <div class="divider"></div>
            <!-- 이하의 .row에서는 md 이상의 크기에서는 가로줄 전체를 다 차지하는 상세 설명 부분과 button이 있다. 
              그러나 그 이하의 크기에서는 글씨가 5/6 너비, 버튼이 1/6너비로 변한다 -->
            <div class="row welcome-desc">
              <p class="col-sm-10 col-md-12 lead">사도행전17:31 "이는 정하신 사람으로 하여금 천하를 공의로 심판할 날을 작정하시고 이에 그를 죽은 자 가운데서 다시 살리신 것으로 모든 사람에게 믿을 만한 증거를 주셨음이니라 하니라"</p>
              <p class="col-sm-2 col-md-12">
                <!-- a 요소에 .btn을 부가하여 완벽한 버튼으로 하고 있다 -->
                <a href="#" class="btn btn-primary">Read More</a>
              </p>
            </div>
          </div>
          <!-- md이상의 크기에서만 이 카드를 볼 수 있다. 크기는 .container의 3/12, 즉 1/4이다.-->
          <div class="col-md-3 letsgo">
            <!-- 카드의 형식은 .card 및 .card-body 내에 .card-title, .card-subtitle, .card-text, 
              .card-link를 넣는다 -->
            <div class="card card-body letsgo-card">
            
              <!-- $uid가 없는 경우 -->
              <?php if(!$uid): ?>
              <div class="my-3">
                <h4 class="letsgo-title card-title text-dark mb-3 text-center">로그인!</h4>
                <!-- <p class="card-text text-secondary">로그인으로 모든 메뉴를 이용하세요.</p> -->
              </div>
              <div class="letsgo-card-form">
                <form action="login.php" method="post">
                  <div class="mb-3">
                    <input name="uid" type="text" class="form-control" placeholder="아이디">
                  </div>
                  <div class="mb-3">
                    <input name="pass" type="password" class="form-control" placeholder="패스워드">
                  </div>
                  <!-- 체크 박스와 라디오 버튼은 .form-check하에서 작성한다. input.form-check-input,
                     label.form-check-label 두개가 짝을 이루며, type에 checkbox인지 radio인지를 지정한다-->
                  <!-- <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="flexCheckDefault">
                    <label for="flexCheckDefault" class="form-check-label text-secondary">
                      개인정보 사용동의
                    </label>
                  </div> -->
                  <p class="mb-3">
                    <button class="btn btn-primary w-48" type="submit">로그인</button>
                    <a href="signup.php" class="btn btn-primary w-48">회원가입</a>
                    <!-- <button class="btn btn-primary w-48" type="submit">회원가입</button> -->
                  </p>
                </form>
              </div>

              <!-- $uid가 있는 경우? -->
              <?php else: ?>                
                  <div class= "d-flex justify-content-center align-items-center">
                    <h5 class="text-dark text-center"><?= $uname ?>님 로그인</h5>
                    <!-- <p class="card-text text-secondary">로그인으로 모든 메뉴를 이용하세요.</p> -->
                    <p class="mt-2 ms-5">
                      <a href="logout.php" class="btn btn-primary btn-sm">로그아웃</a>
                    </p>
                  </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- navbar의 메뉴를 클릭시 찾아가는 #intro -->
  
  <section id="intro">
    <!-- 아래 위로 4rem의 padding을 두는 .section-content -->
    <div class="section-content">
      <div class="container intro">
        <div class="row align-items-center">
          <!-- .container를 1/2씩 나눈다. 먼저 왼쪽 -->
          <div class="col-md-6 intro-first">
            <!-- md 이상에서 좌우로 1rem의 패딩을 둔다 -->

            <div class="row px-md-3">
              <div class="col-12">
                <div class="card card-body my-3 position-relative rounded-3 shadow-lg intro-first-card">
                  <div class="overlay d-flex justify-content-center align-items-center position-absolute h-100 w-100 shadow-lg">
                    <div class="row ms-3 mt-2">
                      <h3 class="col-12 text-white fw-light d-block">
                        예배시간
                      </h3>
                      <ul class="col-12 text-light">
                        <li>주일예배  -  주일 오전 11시</li>
                        <li>수요예배 - 수요일 저녁 7시 30분</li>
                        <li>금요기도회 - 금요일 저녁 8시</li>
                        <li>새벽기도회 - 월~금 새벽 5시</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card card-body my-3 position-relative rounded-3 shadow-lg intro-first-card">
                  <!-- <div class="overlay d-flex justify-content-center align-items-center position-absolute h-100 w-100 shadow-lg">
                    <h3 class="fw-light">
                      <a href="#" class=" text-decoration-none">Link 2</a>
                    </h3>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
          <!-- 다음으로 오른 쪽 -->
          <div class="col-md-6 intro-second">
            <!-- <h5 class="fw-light">평안하신가요?</h5> -->
            <h1 class="mb-4">사랑합니다 예수님...</h1>
            <div class="intro-text">
              <p class="lead">&nbsp;&nbsp;&nbsp;&nbsp;사람들은 하나님의 살아계심을 알지 못하였고, 성경도 믿지 못했었습니다. 심지어 예수 그 분이 하나님의 아들이신 것을 믿지 못하여, 그를 십자가에 못 박아 죽이기도 하였습니다. 그러나 예수께서는 말씀하신 대로 살아나셔서, 당신의 죽음이 우리 죄를 위함인 것을 증명하셨고, 영원한 생명과 영원한 나라를 분명히 보였습니다. 우리 선배 그리스도인들은 부활하신 주를 뵙고 죽음도 두려워하지 않았습니다.</p>
              <p class="lead">&nbsp;&nbsp;&nbsp;&nbsp;우리 교회도 이 놀라운 사건의 연속선 상에서 부름을 받았습니다. 우리는 복음으로 인하여 "오직 예수"라 선포하며, 분명한 확신과 기쁨으로 예배합니다.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 이번 섹션은 슬릭 슬라이더 홈 페이지에 가서 여러 동작 방식에 대한 공부를 하는 것이 좋다 -->
  <section id="services">
    <div class="section-content">
      <div class="container services">
        <div class="services-header text-center mb-5">
          <h1 class="display-5">설 교</h1>
          <div class="divider"></div>
          <p class="lead text-secondary service-text">
            시119:105 "주의 말씀은 내 발에 등이요 내 길에 빛이니이다"
          </p>
        </div>
        <div id="slick-slide" class="services-body">
          <!-- #top요소에서는 .card.card-body가 같은 div에서 선언되었지만, 지금은 .card와 .card-body가 분리되어 선언되었고
            그 중간에 그림이 하나 들어온다. 그림이 이 사이에 옴을 기억하자. -->
            <!-- 카드는 부모 너비를 따른다. 높이는 컨텐츠의 높이이다. 그래서 커라우젤 js가 없다면 그냥 전체 너비를 차지하는 카드에 불과하다. 
            화면에 몇개를 보일지 app.js에서 설정함에 따라 크기가 결정된다. --> 
            
          
        <?php if($sermons && count($sermons) > 0): 
        $i =0;
        ?>
        <?php foreach ($newSixSer as $sermon):
        $i+=1;
        
        $passage = abbreviateString($sermon['passage'], 100);
        
        ?>
          <div class="services-col mx-2 my-3">                      
            <div class="card">
              <a href="#">
                <img src="assets/images/port<?=$i?>.jpg" alt="" class="card-img-top">
              </a>
              <div class="card-body row">
                <h4 class="card-title"><?=$sermon['title'] ?></h4>
                <p class="card-text fw-light mb-4"><?=$passage ?></p>
                <!-- <div class="col-12"> -->
                <audio controls class="d-block mx-auto mb-3">
                  <source src="<?=$audioBasePath?><?=$sermon['audio_id']?>" type="audio/mp3">
                  Your browser does not support the audio element.
                </audio>
                <!-- </div> -->
                

              </div>
            </div>
          </div>          
          <?php endforeach; ?>
          <?php else: 
              echo "등록된 설교가 없습니다.";
          ?>
          <?php endif;  ?>

        </div>
      </div>
    </div>
  </section>

  <!-- 여기서는 그리드를 복습할 수 있다 -->
  <section id="testimony">
    <div class="section-content overlay d-flex aign-items-center h-100">
      <div class="container">
        <!-- 슬로건 카드는 md 이상에서는 6/12 차지하는 너비를 가진다. -->
        <div class="col-lg-6">
          <div class="card card-body testimony-card pt-4 pb-4 ps-5 pe-5">
            <div class="d-flex align-items-center">
              <h1 class="mb-3 me-auto"> 우리의 간증 ... </h1>
              <a type="button" class="btn btn-primary btn-sm me-3" href="testimony/all_testimonies.php">전체 보기</a>
              <a type="button" class="btn btn-primary btn-sm" href="testimony/tst_upload.php">간증 쓰기</a>              
            </div>
            <p class="lead">&nbsp;&nbsp;&nbsp;&nbsp; 내 귀가 열려 주의 음성을 듣게 하시고, 주의 말씀으로 내가 웃게도 하시고, 내가 울게도 하시며, 내가 기쁘게도 하시고, 내가 애통하게도 하옵소서. 주의 음성이 들리매 반가워, 내가 춤추게도 하시며, 내가 가슴을 치게도 하옵소서.</p>
            <p class="lead">마11:17 "이르되 우리가 너희를 향하여 피리를 불어도 너희가 춤추지 않고 우리가 슬피 울어도 너희가 가슴을 치지 아니하였다 함과 같도다"</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="friendship">
    <div class="section-content">
      <div class="container friendship">
        <div class="row">
          <?php if($newThreeTst): ?>
          <?php foreach($newThreeTst as $tst):
            $content = $tst['content'];
            $clean_content = str_replace('\r\n', '<br>', $content);
            $shorTst = abbreviateString($clean_content, 200);
          ?>
          <div class="col-md-4 mb-3">
            <div class="card card-body shadow border-0 friendship-card">
              <h5 class="card-title mb-3">
                <span class="fw-bold"><?=$tst['title']?></span>
                <span class="float-end fs-6"><?=$tst['author']?>&nbsp;&nbsp;<?=$tst['date']?></span>
              </h5>
              <p class="card-text fw-light"><?=$shorTst?></p>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
          
        </div>
      </div>
    </div>
  </section>

  <section id="gallery">
    <div class="section-content">
      <div class="container gallery">
        <div class="gallery-header text-center mb-5">
          <h1 class="display-4">기쁜 순간들</h1>
          <div class="divider"></div>
          <p class="lead text-secondary">주 예수로 기뻐하는 우리의 시간을 기억하고자 합니다. 감사와 찬양이 넘치게 하소서. 
          <a type="button" class="btn btn-primary btn-sm" href="image/all_photos.php" > 더 보기</a></p>          
        </div>
        <div class="row gallery-body">
        <?php if($images && count($images) > 0): ?>
        <?php foreach ($newSixImg as $image):?>
          <div class="col-md-4 col-sm-6 mb-4 gallery-item">
            <!-- 카드인데 경계선이 없고 안쪽 여백도 없다 -->
            <div class="card card-body border-0 p-0 ">
              <div class="card-bg rounded" style="background-image: 
                url('assets/images/photos/<?= $image['file_name'] ?>');">
                <div class="overlay d-flex flex-column justify-content-center align-items-center h-100 w-100 border-2">
                <h2 class="gallery-title"><?= $image['title'] ?></h2>
                <p class="leap">작성자: <?= $image['uploader']?>; 작성일: <?= $image['date']?></p>
                <!-- <a class="link-warning text-decoration-none" href="img_view.php?id=<?= $image['id'] ?>">View this photo</a> -->
                <form action="image/img_view.php" method="post">
                  <input type="hidden" name="img_id" value="<?= $image['id'] ?>">
                  <input type="submit" value="View this photo" class="text-warning" style="background-color:rgba(0, 0, 0, 0); border :none; ">
                </form>
              </div>
              </div>
            </div>
          </div>          
          <?php endforeach; ?>
          <?php else: 
              echo "아무 것도 없습니다. 사진을 올려 주세요.";
          ?>
          <?php endif;  ?>
      </div>
    </div>
  </section>

  <section id="cta" class="position-relative">
    <!-- 세로 방향으로 중앙을 차지하게 하겠다. d-flex flex-column justify-content-center align-items-center -->
    <div class="section-content overlay w-100 h-100 position-absolute d-flex flex-column justify-content-center align-items-center">
      <div class="container text-center ">
        <div class="row">
          <div class="offset-lg-0 col-lg-8 offset-1 col-10 text-start d-flex flex-column justify-content-center ">
            <h3 class="display-6 text-warning">
              언제든 연락 주세요!
            </h3>
            <h2 class="display-5 text-light">
              우리 인생의 해결책은 <br>오직 그리스도께 있습니다.
            </h2>
            <p class="lead text-light mb-4">요14:6 "예수께서 가라사대 내가 곧 길이요 진리요 생명이니 나로 말미암지 않고는 아버지께로 올 자가 없느니라"</p>
            <h1 class="mt-0 mb-4">
              <!-- 모바일에서 전화 연결 코드 -->
              <a href="tel:052-237-1660 " class="link-warning text-decoration-none">052-237-1660</a>
            </h1>
          </div>
          <div class="offset-lg-0 col-lg-4 offset-1 col-10 find-us rounded">
            <h3>이메일!</h3>
            <div class="divider"></div>
            <p class="text-secondary">인생의 해결책은 오직 그 분에게!</p>
            <div class="d-flex flex-column text-secondary text-start">
              <p class="fw-bold me-5">
                <span class="text-uppercase">전화번호</span>: 
                <a href="tel:052-237-1660" class="text-decoration-none">052-237-1660</a>
              </p>
              <p class="fw-bold">
                <span class="text-uppercase">이메일</span>: 
                <a href="mailto:pastor@nearbychurch.kr" class="text-decoration-none">pastor@nearbychurch.kr</a>
              </p>
            </div>
            <form action="">
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="이름">
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" placeholder="이메일">
              </div>
              <div class="mb-3">
                <textarea rows="3" class="form-control" placeholder="상담할 내용을 적어주세요."></textarea>
              </div>
              <div class="mb-3">
                <!-- <input type="checkbox" id="checkDefault" class="form-check-input">
                <label for="checkDefault" class="form-check-label text-secondary">
                  I agree to privide privacy!
                </label> -->
              </div>
              <p class="mb-3">
                <button class="btn btn-primary w-100">이메일 보내기</button>
              </p>
            </form>
          </div>
        </div>        
      </div>
    </div>
  </section>

  <section id="aboutus">
    <div class="section-content">
      <div class="container">
        <div class="row">
          <!-- 여기서 왼쪽 탭부분 -->
          <div class="col-lg-6">
            <h3 class="mb-5">환영합니다</h3>
            <!-- 이부분은 bs 문서의 네비게이션과 탭에서 JavaScript 비헤이비어 아래의 탭부분을 복사하여 사용 -->
            <!-- 위의 탭부분을 담당하는 ul>li 요소, 그리고 내용을 담당하는 div.tab-content 부분으로 구성된다 -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <!-- 첫번째 보이는 탭은 .active -->
                <button class="nav-link active" id="team-tab" data-bs-toggle="tab" data-bs-target="#team-tab-pane" type="button" role="tab" aria-controls="team-tab-pane" aria-selected="true">꾸벅</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos-tab-pane" type="button" role="tab" aria-controls="photos-tab-pane" aria-selected="false">사진들</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <!-- 첫번째 보이는 내용은 .show.active -->
              <div class="tab-pane fade show active" id="team-tab-pane" role="tabpanel" aria-labelledby="team-tab" tabindex="0">
                <img src="assets/images/church_school.jpg" alt="" class="img-fluid shadow-xl my-5 wow slideInLeft">
                <p>든든한 다음 세대를 풍성히 양육하게 하소서.</p>
              </div>
              <div class="tab-pane fade" id="photos-tab-pane" role="tabpanel" aria-labelledby="photos-tab" tabindex="0">
                <!-- 사진 네 장에 대하여는 라이트 박스 효과를 준다. 이미 관련 js 설치됨, lightbox2 홈페이지를 참조 -->
                <div class="image-lightbox my-5">
                  <!-- .row.row-cols-2는 자식으로 .col을 갖는다. 즉 부모에서 이미 열 수 2개로 지정할 때 사용 -->
                  <div class="row row-cols-2">
                    <!-- 이 속에 썸네일이 들어가고 클릭하면 라이트박스의 효과 -->
                    <div class="col my-4">
                      <!-- 그림 위주소는 lightbox에 표시될 그림, 아래 주소는 썸네일로 표시될 주소 -->
                      <a href="assets/images/church_04.jpg" data-lightbox="LightBox" data-title="Title1" data-alt="title-1">
                        <!-- 이 섬네일이 되는 이미지의 크기는 가로세로가 동일한 것이 좋다. 스타일로 지정한다  -->
                        <img src="assets/images/church_01.jpg" alt="title-1" class="img-fluid shadow-xl">
                      </a>
                    </div>
                    <div class="col my-4">
                      <a href="assets/images/church_02.jpg" data-lightbox="LightBox" data-title="Title2" data-alt="title-2">
                        <img src="assets/images/church_02.jpg" alt="title-1" class="img-fluid shadow-xl">
                      </a>
                    </div>
                    <div class="col my-4">
                      <a href="assets/images/church_03.jpg" data-lightbox="LightBox" data-title="Title3" data-alt="title-3">
                        <img src="assets/images/church_03.jpg" alt="title-1" class="img-fluid shadow-xl">
                      </a>
                    </div>
                    <div class="col my-4">
                      <a href="assets/images/church_04.jpg" data-lightbox="LightBox" data-title="Title4" data-alt="title-4">
                        <img src="assets/images/church_04.jpg" alt="title-1" class="img-fluid shadow-xl">
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- 여기까지 탭부분 -->

          <!-- 아래에는 왼쪽 컬럼에 아코디언 -->          
          <div class="col-lg-6">
            <div class="faq">
              <h3 class="mb-5">우리 교회는요...</h3>
              <!-- 이하부터 아코디언, ver4까지는 아코디어이 컬랩스 내부에 존재. 지금은 독립, 하여간 컬랩스 기능 이용 -->
              <!-- 문서에서 .accordion-flush 부분을 복사하여 사용해도 되지만 어렵지 않으니 직접 작성해 본다 -->
              <div class="accordion accordion-flush" id="accordionFlushFaq">

                <!-- 여기부터가 개별 아이템 -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                    <!-- aria-expanded="true"란 스크린 리더 사용자에게 메뉴 아이템이 열려 있음을 고지 -->
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                      로고의 의미
                    </button>
                  </h2>
                  <!-- .show는 웹페이지가 로딩될 때 먼저 보이는 컨텐츠 -->
                  <div id="flush-collapseOne" class="accordion-collapse collapse show"
                  aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushFaq">
                    <div class="accodion-body px-4">
                      <img src="assets/images/church_logo.png" alt="Logo" class="float-start me-3" width="64px">
                      <div class="mt-3">
                        <p>본 로고는 요나가 물고기 뱃속에서 사흘만에 나온 것처럼, 성경대로 우리 죄를 위하여 죽으시고 성경대로 사흘만에 부활하신 그리스도의 십자가를 형상화하였습니다.</p>
                        <p>마12:39 "예수께서 대답하여 이르시되 악하고 음란한 세대가 표적을 구하나 선지자 요나의 표적 밖에는 보일 표적이 없느니라"</p>
                      </div>    
                    </div>
                  </div>
                </div>
                <!-- 개별아이템 끝. 이것을 복사하여 여러 개로 만든다.-->

                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingTwo">
                    <!-- .aria-expended를 false -->
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                      조직
                    </button>
                  </h2>
                  <!-- .show를 삭제한다. -->
                  <div id="flush-collapseTwo" class="accordion-collapse collapse"
                  aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushFaq">
                    <div class="accodion-body px-4">
                      <ul class="mt-3">
                        <li>형제목장 - 문상돌</li>
                        <li>한나목장 - 한선녀</li>
                        <li>마리아목장 - 신영순</li>
                        <li>에스더목장 - 노정희</li>
                        <li>청년부</li>
                        <li>주일학교</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                      섬김이
                    </button>
                  </h2>
                  <div id="flush-collapseThree" class="accordion-collapse collapse"
                  aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushFaq">
                      <div class="accodion-body px-4">
                        <ul class="mt-3">
                          <li>목사 - 조욱희</li>
                          <li>사모 - 노정희</li>
                          <li>찬양인도 - 노정희</li>
                          <li>차량봉사 - 김옥이</li>
                          <li>이름없이 수고하는 지체들</li>
                        </ul>               
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- 여기까지가 오른쪽 아코디언 -->
        </div>
      </div>
    </div>
  </section>

  <section id="find-us">
    <!-- 여기서는 가로를 전부 써야 하니 .container-fluid를 붙인다. 대신 자동으로 padding 설정된 것을 좌우 0으로 -->
    <div class="container-fluid px-0">
      <div id="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3249.8937789479487!2d129.29065845108263!3d35.45742404972365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x35662b99f9ed75b9%3A0x750a33959c78bf77!2z6rCA6rmM7Jq06rWQ7ZqM!5e0!3m2!1sko!2skr!4v1669613549401!5m2!1sko!2skr" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>    
  </section>

  <script>
    // 카드 div 요소의 id 배열
var cardIds = ["card01", "card02", "card03", "card04", "card05", "card06"];

// 최대 높이 변수 초기화
var maxHeight = 0;

// 각 div의 높이를 확인하고 최대값 갱신
for (var i = 0; i < cardIds.length; i++) {
  var cardId = cardIds[i];
  var cardElement = document.getElementById(cardId);
  var cardHeight = cardElement.offsetHeight;

  if (cardHeight > maxHeight) {
    maxHeight = cardHeight;
  }
}

// 모든 div 요소의 높이를 최대값에 일치시킴
for (var i = 0; i < cardIds.length; i++) {
  var cardId = cardIds[i];
  var cardElement = document.getElementById(cardId);
  cardElement.style.height = maxHeight + "px";
}

  </script>

<?php
  require_once "footer.php";
?>
