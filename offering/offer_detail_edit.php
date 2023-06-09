<?php
require_once "../dir_manage.php";
require_once $basePath ."header.php";
$randstr = substr(uniqid(), 0, 6);
// **** 먼저 페이지를 구성하도록 환경을 조성하는 작업 ****
// 이름용 select에 들어갈 이름들을 미리 구한다.
$members = $mdao->getAllMembers();

// 헌금용 select에 들어갈 value($offerVars)들과 표시될 값($offerNames)을 가진 배열을 만든다. 
$offerNames = ["십일조 헌금", "주정 헌금", "감사 헌금", "선교 헌금", "건축 헌금", "구제 헌금", "일천번제 헌금", "절기 헌금", "기타 헌금"];
$offerVars = ["tithe", "weekly", "thanks", "mission", "construct", "relief", "thousand", "festive", "etc"];
// $offerVars내에 있는 모든 문자열 요소를 $을 붙여 변수로 선언하고 모두 "0"을 할당하여 초기화시킨다.
for($i = 0; $i < count($offerVars); $i++){
    ${$offerVars[$i]} = "0";
}

// ****************************************************************
// ****여기는 이전 페이지에서 기록의 id만 넘어 왔을 때의 처리이다.*****
$offer_id = sanitizeRequest("id");

$selectedDate = "";
$selectedId ="";
$selected = [];
if(isset($_POST['id']) && $offer_id != "") {
    $offering = $offerdao->getOfferingById($offer_id);
    $name = $offering['name'];
    $selectedDate = $offering['date'];
    $selectedId = $offering['id'];
   
    $selected = [];
    foreach ($offering as $key => $value) {
        if($key == "name"){
            $selected[$key] = $value;
        } else if ($key != "id" && $value != "0"){
            $selected[$key] = $value;
        }    
    }
    // 이미 선택된 이름 또는 헌금이름과 이름 및 헌금 액수를 따로 인덱스 배열로 지정한다.
    $selectedKeys = array_keys($selected);
    $selectedValues = array_values($selected);    
}


// 여기부터는 이 페이지의 전송버튼을 눌러 둘어 왔을 때의 처리이다.
if(isset($_POST['name'])){    
    $name = sanitizeRequest('name');
    if($name == ''){
        okGo("입력된 이름이 없습니다.", "offer_insert.php?r=$randstr");
    }
    $offers = [];
    for($i = 1; $i < 6; $i++){
        if(isset($_POST["key_{$i}"]) && isset($_POST["val_{$i}"])){
            $key = $_POST["key_{$i}"];
            $value = $_POST["val_{$i}"];
            echo $key . ": " . $value;

            if($value != "" && $value >0) {
                $offers[$key] = $value;
            }
            
        }
    }
 
    if(count($offers)>0){
        foreach($offers as $key => $value){
            ${$key} = $value;
        }

        $updatedRowNum = $offerdao->updateOffering($selectedId, $name, $tithe, $weekly, $thanks, $mission, $construct, $relief, $thousand, $festive, $etc, $selectedDate);
        if($updatedRowNum >0){
            okGo("헌금 내역 수정 완료", "offer_weekly_detail.php?date=$selectedDate");
        }else{
            okGo("헌금 헌금 내역 수정실패", "offer_weekly_detail.php?date=$offer_id" );
        }
    } else {
        okGo("입력된 헌금이 없습니다.", "offer_detail_edit.php");
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
                        <div class="d-flex justify-content-center align-items-center">
                            <h4 class="card-title text-dark my-3 text-center me-3">헌금수정</h4>
                            <a type="button" href="all_offerings.php" class="btn btn-primary">돌아가기</a>
                        </div>
                        
                    </div>
                    <div class="card-body">
                    <table class="table table-borderless">
                    <form action="offer_detail_edit.php" method="post">
                        <tbody>
                            <tr>
                                <th scope="row">이름</th>
                                <td>
                                    <select name="name" class="form-select">
                                        <!-- 빈 값을 하나 둔다 -->
                                        <option value=""></option>
                                        <?php foreach ($members as $member): ?> 
                                            <!-- $had의 name키와 맞으면 selected 속성을 부가한다 -->
                                            <?php if($selectedValues[0] == $member['uname']):?>
                                                <option value="<?= $member['uname'] ?>" selected><?= $member['uname'] ?></option>
                                            <?php else:?>
                                                <option value="<?= $member['uname'] ?>"><?= $member['uname'] ?></option>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                        <?php if($selectedValues[0] == "무명"):?>
                                            <option value="무명" selected>무명</option>
                                        <?php else:?>
                                            <option value="무명">무명</option>
                                        <?php endif;?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 1</th>
                                <td>
                                    <select name="key_1" class="form-select">
                                        <option value=""></option>
                                        <?php 
                                        // 한글이름 전부의 수에 대하여
                                            for($i = 0; $i < count($offerNames); $i++) : 
                                                // $selectedKeys[0] 은 "name"이고 $selectedKeys[1] 은 첫 번재 헌금이름
                                               if(1<=count($selectedKeys)):
                                                if($selectedKeys[1] == $offerVars[$i]) :
                                        ?>
                                            <option value="<?= $offerVars[$i]?>" selected><?= $offerNames[$i]?> </option>
                                        <?php else: ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endif; endif; endfor;?> 
                                    </select>
                                   
                                </td>
                                <td>
                                    <input id="numberInput" name="val_1" type="number" step="1000" min="1000" oninput="convertToKorean(event)"
                                     value="<?=$selectedValues[1]?>"><span id="koreanOutput"></span><span>원</span>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 2</th>
                                <td>
                                    <select name="key_2" class="form-select">
                                        <option value=""></option>                                        
                                        <?php 
                                        // 한글이름 전부의 수에 대하여
                                            for($i = 0; $i < count($offerNames); $i++) : 
                                                // $selectedKeys[0] 은 "name"이고 $selectedKeys[1] 은 첫 번재 헌금이름
                                               
                                               if(2<=count($selectedKeys)):
                                                if($selectedKeys[2] == $offerVars[$i]) :
                                        ?>
                                            <option value="<?= $offerVars[$i]?>" selected><?= $offerNames[$i]?> </option>
                                        <?php else: ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endif; endif; endfor;?> 
                                    </select>
                                </td>
                                <td>
                                    <input id="numberInput" name="val_2" type="number" step="1000" min="1000" oninput="convertToKorean(event)"
                                     value="<?=$selectedValues[2]?>"><span id="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 3</th>
                                <td>
                                    <select name="key_3" class="form-select">
                                        <option value=""></option>
                                        <?php 
                                        // 한글이름 전부의 수에 대하여
                                            for($i = 0; $i < count($offerNames); $i++) : 
                                                // $selectedKeys[0] 은 "name"이고 $selectedKeys[1] 은 첫 번재 헌금이름

                                               if(3<=count($selectedKeys)):
                                                if($selectedKeys[3] == $offerVars[$i]) :
                                        ?>
                                            <option value="<?= $offerVars[$i]?>" selected><?= $offerNames[$i]?> </option>
                                        <?php else: ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endif; endif; endfor;?> 
                                    </select>
                                </td>
                                <td>
                                    <input id="numberInput" name="val_3" type="number" step="1000" min="1000" oninput="convertToKorean(event)"  
                                    value="<?=$selectedValues[3]?>"><span id="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 4</th>
                                <td>
                                    <select name="key_4" class="form-select">
                                        <option value=""></option>
                                        <?php 
                                        // 한글이름 전부의 수에 대하여
                                            for($i = 0; $i < count($offerNames); $i++) : 
                                                // $selectedKeys[0] 은 "name"이고 $selectedKeys[1] 은 첫 번재 헌금이름
                                               $count = 4;
                                               if($count<=count($selectedKeys)):
                                                if($selectedKeys[$count] == $offerVars[$i]) :
                                        ?>
                                            <option value="<?= $offerVars[$i]?>" selected><?= $offerNames[$i]?> </option>
                                        <?php else: ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endif; endif; endfor;?> 
                                    </select>
                                </td>
                                <td>
                                    <input id="numberInput" name="val_4" type="number" step="1000" min="1000" oninput="convertToKorean(event)"
                                    value="<?=$selectedValues[4]?>"><span id="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">헌금 5</th>
                                <td>
                                    <select name="key_5" class="form-select">
                                        <option value=""></option>
                                        <?php 
                                        // 한글이름 전부의 수에 대하여
                                            for($i = 0; $i < count($offerNames); $i++) : 
                                                // $selectedKeys[0] 은 "name"이고 $selectedKeys[1] 은 첫 번재 헌금이름
                                               $count = 5;
                                               if($count<=count($selectedKeys)):
                                                if($selectedKeys[$count] == $offerVars[$i]) :
                                        ?>
                                            <option value="<?= $offerVars[$i]?>" selected><?= $offerNames[$i]?> </option>
                                        <?php else: ?>
                                            <option value="<?= $offerVars[$i]?>"><?= $offerNames[$i]?> </option>
                                        <?php endif; endif; endfor;?> 
                                    </select>
                                </td>
                                <td>
                                    <input id="numberInput" name="val_5" type="number" step="1000" min="1000" oninput="convertToKorean(event)"
                                    value="<?=$selectedValues[5]?>"><span id="koreanOutput"></span><span>원</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">날짜</th>
                                <td><input type="date" name="date" value="<?=$selectedDate?>"></td>
                                <td>미기입시 오늘날짜</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="d-flex justify-content-center">
                                        <button name="id" type="submit" class="btn btn-primary w-25 me-5" value="<?= $selectedId?>">업데이트</button>
                                        <a type="button" href="all_offerings.php" class="btn btn-primary w-25">주별 헌금 상황</a>
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

