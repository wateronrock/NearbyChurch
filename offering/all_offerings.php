<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";

$offerNames = ["십일조", "주정", "감사", "선교", "건축", "구제", "천번", "절기", "기타"];
// 만일 12월이라면 회계년도가 다음 해로 넘어간다.
$month = date("m");
if($month == "12") {
    $thisYear = date("Y") + 1;
} else {
    $thisYear = date("Y");
}
 // 연도만 추출합니다.


$prevYear = $thisYear -1;
// $start = "2022-12-01";
// $end = "2023-11-30";
$start = $prevYear."-12-01";
$end = $thisYear."-11-30";

$offerings = $offerdao->getWeeklyOfferingsInRange($start, $end);

?>

</script>

<section id="member_list">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="card-title text-dark my-3 text-center me-3">주별 헌금</h4>
                            <a type="button" class="btn btn-primary btn-sm" href="offer_insert.php">헌금 입력</a>              
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th class="text-center">회차</th>
                                <?php foreach($offerNames as $offer): ?>
                                <th><?=$offer?></th>
                                <?php endforeach;?>
                                <th>날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($offerings)>0): 
                                    $i=0;
                                ?>
                                    
                                <?php foreach($offerings as $offer):
                                     $i+=1;
                                ?>
                                <tr>
                                    <td class="text-center"><?=$i?></td>
                                    <td><?=$offer['total_tithe']?></td>
                                    <td><?=$offer['total_weekly']?></td>
                                    <td><?=$offer['total_thanks']?></td>
                                    <td><?=$offer['total_mission']?></td>
                                    <td><?=$offer['total_construct']?></td>
                                    <td><?=$offer['total_relief']?></td>
                                    <td><?=$offer['total_thousand']?></td>
                                    <td><?=$offer['total_festive']?></td>
                                    <td><?=$offer['total_etc']?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <?=$offer['date']?>
                                            <form action="offer_weekly_detail.php" method="post">
                                                <input type="hidden" name="date" value="<?=$offer['date']?>">
                                                <button type="submit" class="btn btn-sm btn-warning ms-3">상세</button>
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
require_once $basePath ."footer.php";
?>
