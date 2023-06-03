<?php
// 서브 퐅더에서도 작동하게 
// 웹 루트 디렉토리 경로 가져오기
// 당연히 실제 서버에서는 아래가 루트가 되지만
// $webRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot = "/";


// 현재 스크립트의 경로 가져오기
$currentPath = $_SERVER['PHP_SELF'];
// 윈도우는 "\"로 경로를 주므로 dirname()은 내부에 "\"가 들어있다.
// 그러나 우리가 사용하는 환경은 linux 서버가 되므로 "/"를 사용해야 한다.
$currentDir = dirname($currentPath);
// 역슬래쉬를 슬래쉬로 일치시키기 위해

$currentDir = str_replace('\\', '/', $currentDir);

// 현재 디렉토리가 루트인지 아닌지 확인
$isRoot = ($currentDir == $webRoot);

// 분기 처리
if ($isRoot) {
    $basePath = "./";
} else {
    $basePath = "../";
}

?>
