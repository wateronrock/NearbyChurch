<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";

// 페이지네이션 시작

// 한 페이지에 표시할 이미지 개수
$perPage =5;

// 현재 페이지 번호, 처음에는 $$_GET['page']에 값이 없으므로 1로 할당한다.
$page = isset($_GET['page']) ? sanitizeRequest('page') : 1;

// 이미지 데이터 가져오기 배열로 가져오기
$sermons = $serdao->getAllSermons();

// 이미지 데이터 배열을 페이지네이션 처리하기
$totalSermons = count($sermons); // 전체 이미지 개수
$totalPages = ceil($totalSermons / $perPage); // 전체 페이지 수 예를 들면 그림이 13장이라도 3 페이지가 사용된다.

// 현재 페이지에 해당하는 이미지 데이터 추출
$start = ($page - 1) * $perPage;
$end = $start + $perPage;
$sermonsOnPage = array_slice($sermons, $start, $end - $start);

// 페이지네이션끝

?>

<section id="sermon_list">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <div class="d-flex justify-content-center align-items-center">
                        <h4 class="card-title text-dark my-3 text-center me-3">설교목록</h4>
                        <a href="sermon_upload.php" class="btn btn-primary">설교등록</a>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>설교자</th>
                                <th>설교제목</th>
                                <th>설교본문</th>
                                <th>설교일</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($sermons && count($sermons) > 0): ?>
                                <?php foreach ($sermonsOnPage as $sermon) { ?>
                                <tr>
                                    <td style="white-space: nowrap; height: auto"><?= $sermon['preacher'] ?></td>
                                    <td style="white-space: nowrap; height: auto"><?= $sermon['title'] ?></td>
                                    <td><?= $sermon['passage'] ?></td>
                                    <td style="white-space: nowrap; height: auto"><?= $sermon['date'] ?></td>
                                    <td style="white-space: nowrap; height: auto">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form action="sermon_edit.php" method="post">
                                                <input type="hidden" name="id" value="<?=$sermon['id'] ?>">
                                                <button type="submit" class="btn btn-warning btn-sm me-2">수정</button>
                                            </form>
                                            <form action="sermon_delete.php" method="post">
                                                <input type="hidden" name="id" value="<?=$sermon['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return showConfirm();">삭제</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php else: echo "등록된 설교가 없습니다.";?>
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
                                    <a class="page-link" href="?page=<?= $i; ?>"><?php echo $i; ?></a>
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
