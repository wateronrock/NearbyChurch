<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";

// 페이지네이션 시작

$perPage = 5;

// 현재 페이지 번호, 처음에는 $$_GET['page']에 값이 없으므로 1로 할당한다.
$page = isset($_GET['page']) ? sanitizeRequest('page') : 1;

// 설교 데이터 배열로 가져오기
$sermons = $serdao->getAllSermons();

// 이미지 데이터 배열을 페이지네이션 처리하기
$totalSermons = count($sermons); // 전체 이미지 개수
$totalPages = ceil($totalSermons / $perPage); // 전체 페이지 수 예를 들면 그림이 13장이라도 3 페이지가 사용된다.

// 현재 페이지에 해당하는 이미지 데이터 추출
$start = ($page - 1) * $perPage;
$end = $start + $perPage;
$sermonsOnPage = array_slice($sermons, $start, $end - $start);

// 페이지네이션끝

$sermons = $serdao->getAllSermons();
?>

<section id="sermon_list">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">설교목록</h4>
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
                                <?php foreach ($sermons as $sermon) { ?>
                                <tr>
                                    <td style="white-space: nowrap; height: auto"><?= $sermon['preacher'] ?></td>
                                    <td style="white-space: nowrap; height: auto"><?= $sermon['title'] ?></td>
                                    <td><?= $sermon['passage'] ?></td>
                                    <td style="white-space: nowrap; height: auto"><?= $sermon['date'] ?></td>
                                    <td style="white-space: nowrap; height: auto">
                                        <a type="button" href="sermon_edit.php?id=<?= $sermon['id'] ?>" class="btn btn-sm btn-warning">수정</a>
                                        <button class="btn btn-sm btn-danger delete-button" data-id="<?= $sermon['id'] ?>">삭제</button> 
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
