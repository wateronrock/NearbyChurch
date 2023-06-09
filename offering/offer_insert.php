<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";
$randstr = substr(uniqid(), 0, 6);
$members = $mdao->getAllMembers();
$offerNames = ["십일조 헌금", "주정 헌금", "감사 헌금", "선교 헌금", "건축 헌금", "구제 헌금", "일천번제 헌금", "절기 헌금", "기타 헌금"];
$offerVars = ["tithe", "weekly", "thanks", "mission", "construct", "relief", "thousand", "festive", "etc"];
$name = sanitizeRequest('name');
// $offerVars내에 있는 모든 문자열 요소를 $을 붙여 변수로 선언하고 모두 "0"을 할당하여 초기화시킨다.
for($i = 0; $i < count($offerVars); $i++){
    ${$offerVars[$i]} = "0";
}
$date = "";
// 받은 날짜가 비어있다면 오늘 날짜로
if(isset($_POST['date']) && $_POST['date'] != ""){
    $date =sanitizeRequest('date');    
} else {
    $date = date("Y-m-d");
}





if(isset($_POST['name'])){    
    $name = sanitizeRequest('name');
    if($name == ''){
        okGo("입력된 이름이 없습니다.", "offer_insert.php?r=$randstr");
    }
    $offers = []; // 새로 들어온 키=>값을 요소로 하는 연관배열
    $offerKeys = []; // 새로 들어온 키만을 요소로 하는 배열
    for($i = 1; $i < 6; $i++){
        if(isset($_POST["key_{$i}"]) && isset($_POST["val_{$i}"])){
            // 만일 헌금 항목이 중복이 발생한다면 나중에 입력된 것만 등록된다.
            
            $key = $_POST["key_{$i}"];
                $value = $_POST["val_{$i}"];
                if($key !="" && $value != "" && $value >0) {
                    $offers[$key] = $value;
                }
        }
    }

    // 이미 위에서 모든 변수는 "0"으로 초기화되어있다. 여기서 받은 값만 갱신하면 된다.
    if(count($offers)>0){
        foreach($offers as $key => $value){
            ${$key} = $value;
        }
        $insertId = $offerdao->insertOffering($name, $tithe, $weekly, $thanks, $mission, $construct, $relief, $thousand, $festive, $etc, $date);
        if($insertId>0){
            okGo("헌금 입력 완료", "offer_insert.php?r=$randstr");
        }else{
            okGo("헌금 입력에 실패하였습니다.", "offer_insert.php?r=$randstr");
        }
    } else {
        okGo("입력된 헌금이 없습니다.", "offer_insert.php?r=$randstr");
    }
}
?>



<section id="signup">
    <div class="section-content">
      <div class="container-md">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card my-3 rounded-3 shadow-lg">
                    <div class="my-3">
                        <h4 class="card-title text-dark my-3 text-center">헌금입력</h4>
                    </div>
                    <div class="card-body">
                    <table class="table table-borderless">
                    <form action="offer_insert.php" method="post">
                        <tbody>
                            <tr>
                                <th scope="row">이름</th>
                                <td>
                                    <select name="name" class="form-select">
                                        <option value=""></option>
                                        <?php if (!empty($members)): ?>
                                            <?php foreach ($members as $member): ?> 
                                                <option value="<?= $member['uname'] ?>"><?= $member['uname'] ?></option>
                                            <?php endforeach; ?>
                                                <option value="무명">무명</option>
                                        <?php else: ?>
                                            <option value="">데이터 없음</option>
                                        <?php endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 1</th>
                                <td>
                                    <select name="key_1" class="form-select">
                                        <option value=""></option>
                                        <?php for($i = 0; $i < count($offerNames); $i++) : ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endfor;?>
                                    </select>
                                </td>
                                <td>
                                    <input class="numberInput" name="val_1" type="number" step="1000" min="1000" oninput="convertToKorean(event)"><span class="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 2</th>
                                <td>
                                    <select name="key_2" class="form-select">
                                        <option value=""></option>
                                        <?php for($i = 0; $i < count($offerNames); $i++) : ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endfor;?>
                                    </select>
                                </td>
                                <td>
                                    <input class="numberInput" name="val_2" type="number" step="1000" min="1000" oninput="convertToKorean(event)"><span class="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 3</th>
                                <td>
                                    <select name="key_3" class="form-select">
                                        <option value=""></option>
                                        <?php for($i = 0; $i < count($offerNames); $i++) : ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endfor;?>
                                    </select>
                                </td>
                                <td>
                                    <input class="numberInput" name="val_3" type="number" step="1000" min="1000" oninput="convertToKorean(event)"><span class="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 4</th>
                                <td>
                                    <select name="key_4" class="form-select">
                                        <option value=""></option>
                                        <?php for($i = 0; $i < count($offerNames); $i++) : ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endfor;?>
                                    </select>
                                </td>
                                <td>
                                    <input class="numberInput" name="val_4" type="number" step="1000" min="1000" oninput="convertToKorean(event)"><span class="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 5</th>
                                <td>
                                    <select name="key_5" class="form-select">
                                        <option value=""></option>
                                        <?php for($i = 0; $i < count($offerNames); $i++) : ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endfor;?>
                                    </select>
                                </td>
                                <td>
                                    <input class="numberInput" name="val_5" type="number" step="1000" min="1000" oninput="convertToKorean(event)"><span class="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">날짜</th>
                                <td><input type="date" name="date"></td>
                                <td>미기입시 오늘날짜</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary w-25 me-5">입력</button>
                                        <a type="button" href="all_offerings.php" class="btn btn-primary w-25">주별 헌금 내역</a>
                                    </div>                                    
                                </td>
                            </tr>
                        </tbody>
                    </form>
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
