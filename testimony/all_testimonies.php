<?php
require_once "../dir_manage.php";
require_once $basePath."header.php";

if(!$uid || !$uname){
    okGo("간증을 작성하시려면 로그인 해주세요.", $basePath."index.php");
}

// 페이지네이션 시작

$perPage = 5;

// 현재 페이지 번호, 처음에는 $$_GET['page']에 값이 없으므로 1로 할당한다.
$page = isset($_GET['page']) ? sanitizeRequest('page') : 1;

// 설교 데이터 배열로 가져오기
$testimonies = $tstdao->getAllTestimonies();

// 이미지 데이터 배열을 페이지네이션 처리하기
$totalTestimoinies = count($testimonies); // 전체 이미지 개수
$totalPages = ceil($totalTestimoinies / $perPage); // 전체 페이지 수 예를 들면 그림이 13장이라도 3 페이지가 사용된다.

// 현재 페이지에 해당하는 이미지 데이터 추출
$start = ($page - 1) * $perPage;
$end = $start + $perPage;
$tstOnPage = array_slice($testimonies, $start, $end - $start);
// 페이지네이션끝
?>

<section id="testimony_list">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">간증목록</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>작성자</th>
                                <th>제목</th>
                                <th>간증내용</th>
                                <th>날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($testimonies && count($testimonies) > 0): ?>
                                <?php foreach ($tstOnPage as $testimony) { 
                                    $content = $testimony['content'];
                                    $clean_content = str_replace('\r\n', '<br>', $content);
                                ?>
                                <tr>
                                    <td style="white-space: nowrap; height: auto"><?= $testimony['author'] ?></td>
                                    <td style="white-space: nowrap; height: auto"><?= $testimony['title'] ?></td>
                                    <td><?= $clean_content ?></td>
                                    <td style="white-space: nowrap; height: auto"><?= $testimony['date'] ?></td>
                                    <td style="white-space: nowrap; height: auto">
                                        <div class="d-flex">
                                            <a type="button" href="tst_read.php?id=<?= $testimony['id'] ?>" class="btn btn-sm btn-warning">더보기</a>
                                            <?php if($uname == $testimony['author']): ?>
                                            <form class="ms-2" action="tst_delete.php" method="post">  
                                                <input type="hidden" name="tst_id" value="<?=$testimony['id']?>">
                                                <!-- 아래 버튼의 경우 만일 showConfirm()에서 false를 
                                                반환한다면 이 버튼 클릭을 취소하므로 전송되지 않는다 -->
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return showConfirm()" >삭제</button> 
                                            </form>
                                            
                                            <?php endif; ?>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php else: echo "등록된  간증이 없습니다.";?>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- 페이지네이션 시작 -->
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
                    <!-- 페이지네이션 끝 -->
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once $basePath."footer.php";
?>
