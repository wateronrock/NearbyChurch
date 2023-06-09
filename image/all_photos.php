<?php
require_once "../dir_manage.php";
require_once $basePath."header.php";

// 한 페이지에 표시할 이미지 개수
$perPage = 6;

// 현재 페이지 번호, 처음에는 $$_GET['page']에 값이 없으므로 1로 할당한다.
$page = isset($_GET['page']) ? sanitizeRequest('page') : 1;

// 이미지 데이터 가져오기 배열로 가져오기
$images = $imgdao->getAllImages();

// 이미지 데이터 배열을 페이지네이션 처리하기
$totalImages = count($images); // 전체 이미지 개수
$totalPages = ceil($totalImages / $perPage); // 전체 페이지 수 예를 들면 그림이 13장이라도 3 페이지가 사용된다.

// 현재 페이지에 해당하는 이미지 데이터 추출
$start = ($page - 1) * $perPage;
$end = $start + $perPage;
$imagesOnPage = array_slice($images, $start, $end - $start);
?>
<section id="gallery2">
    <div class="section-content">
      <div class="container gallery">
        <div class="gallery-header text-center mb-5">
            <p class="lead text-secondary d-inline">주와 함께 가장 밝은 우리 순간들 &nbsp;&nbsp;</p>
            <a href="../image/img_upload.php" type="button" class="btn btn-primary btn-sm d-inline">그림 올리기</a>
        </div>
        <div class="row gallery-body">
        <?php if($images && count($images) > 0): ?>
        <?php foreach ($imagesOnPage as $image):?>
          <div class="col-md-4 col-sm-6 mb-4 gallery-item">
            <!-- 카드인데 경계선이 없고 안쪽 여백도 없다 -->
            <div class="card card-body border-0 p-0 ">
              <div class="card-bg rounded" style="background-image: 
                url('<?=$basePath?>assets/images/photos/<?= $image['file_name'] ?>');">
                <div class="overlay d-flex flex-column justify-content-center align-items-center h-100 w-100 border-2">
                <h2 class="gallery-title"><?= $image['title'] ?></h2>
                <p class="leap">작성자: <?= $image['uploader']?>; 작성일: <?= $image['date']?></p>
                <form action="img_view.php" method="post">
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
        <!-- 페이지네이션 -->
        <div class="row">
          <div class="col-md-12">
            <ul class="pagination pagination-sm justify-content-center">
              <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                  <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
require_once $basePath."footer.php";
  ?>
