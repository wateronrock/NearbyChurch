<?php
require_once "../dir_manage.php";
require_once $basePath."header.php";
$date = sanitizeRequest('date');

$offerNames = ["십일조", "주정", "감사", "선교", "건축", "구제", "천번", "절기", "기타"];
if($date != ""){
    $weekDetails = $offerdao->getOfferingByDate($date);
}else{
    $weekDetails = [];
}

?>

<section id="member_list">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                    <div class="d-flex justify-content-center align-items-center">
                            <h4 class="card-title text-dark my-3 text-center me-3">주별 헌금 상세</h4>
                            <a type="button" href="all_offerings.php" class="btn btn-primary">돌아가기</a>
                        </div>
                    </div>
                    <div class="card-body">
                    <table class="table table-stripped">
                            <thead>
                                <tr>
                                <th>이름</th>
                                <?php foreach($offerNames as $offerName): ?>
                                <th><?=$offerName?></th>
                                <?php endforeach;?>
                                <th>날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($weekDetails)>0): ?>
                                <?php foreach($weekDetails as $detail): ?>
                                <tr>
                                    <td><?=$detail['name']?></td>
                                    <td><?=$detail['tithe']?></td>
                                    <td><?=$detail['weekly']?></td>
                                    <td><?=$detail['thanks']?></td>
                                    <td><?=$detail['mission']?></td>
                                    <td><?=$detail['construct']?></td>
                                    <td><?=$detail['relief']?></td>
                                    <td><?=$detail['thousand']?></td>
                                    <td><?=$detail['festive']?></td>
                                    <td><?=$detail['etc']?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <?=$detail['date']?>
                                            <form action="offer_detail_edit.php" method="post">
                                                <input type="hidden" name="id" value="<?=$detail['id']?>">
                                                <button type="submit" class="btn btn-sm btn-warning ms-3">수정</button>
                                            </form>
                                            <form action="offer_delete.php" method="post">
                                                <input type="hidden" name="id" value="<?=$detail['id']?>">
                                                <input type="hidden" name='date' value="<?=$detail['date']?>">
                                                <button type="submit" class="btn btn-sm btn-danger ms-3" onclick="return showConfirm();">삭제</button></button>
                                            </form>
                                        </div>
                                    </td>                                   
                                </tr>
                            </tbody>                            
                            <?php endforeach; ?>
                            <?php endif;?> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once $basePath."footer.php";
?>
