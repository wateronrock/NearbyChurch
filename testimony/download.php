<?php
$file = $_GET['file'];

if (isset($file)) {
    // 파일을 로컬 폴더에 저장
    $saved = file_put_contents($savePath, file_get_contents($file));

    if ($saved !== false) {
        echo "파일이 성공적으로 저장되었습니다.";
    } else {
        echo "파일 저장에 실패했습니다.";
    }
} else {
    echo "파일을 찾을 수 없습니다.";
}
?>
