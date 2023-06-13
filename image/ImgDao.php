<?php
// require_once "../dir_manage.php";
// require_once $basePath ."functions.php";

class ImgDao {
    private $pdo;

    // 생성자를 통해 PDO 객체를 전달받음
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 이미지를 데이터베이스에 저장하고, 저장된 이미지의 ID 값을 반환하는 메소드
    public function insertImage($uploader, $title, $description, $date, $fileName) {
        // 데이터베이스에 이미지 정보를 저장하기 위한 SQL문
        $sql = "INSERT INTO images (uploader, title, description, date, file_name) VALUES (:uploader, :title, :description, :date, :fileName)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uploader', $uploader);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':fileName', $fileName);
        $stmt->execute();
        // 이 때 반환되는 id는 sql에서 insert가 실행될 때마다 auto_increment에 의해 자동으로 발생하는 값이다
        return $this->pdo->lastInsertId();
    }

    // 이미지 파일을 "/assets/images/photos" 폴더에 저장하고 파일 이름을 반환하는 메소드
    // public function saveImageFile($file) {
    //     // uniqid()는 날짜와 시간을 기초로 한 13자리 숫자를 지정하므로 혹시 파일 이름이 같다 할지라도 덮어쓰지 않게 한다.
    //     // 이때 업로드 한 파일이 sunny_day.jpg라면 $file['name']은 sunny_day이며 PATHINFO_EXTENSION는  jpg이다. 
    //     // pathinfo()는 이 두 문자열을 합쳐 sunny_day.jpg로 만들어 준다
    //     $imgfiletype = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    //     $imgtypes = ["jpg", "jpeg", "png", "gif", "tif"];
    //     if(in_array($imgfiletype,$imgtypes)){
    //         $fileName = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    //         $targetFile = "/assets/images/photos/" . $fileName;
    //         // 위의 예에서 보면 $_SERVER['DOCUMENT_ROOT'] . $targetFile은 "/assets/images/photos/13자리숫자id.sunny_day.jpg"가 된다.
    //         move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $targetFile);
    //         return $fileName;
    //     }else{
    //         goBack("jpg, jpeg, png, gif, tif 이미지 파일만 올릴 수 있습니다. ");
    //     }
        
    // }
    public function saveImageFile($file) {
        // 300 kb이상을 줄여주는 코드가 포함된다.
        $maxFileSize = 300 * 1024; // 300KB
        $imgtypes = ["jpg", "jpeg", "png", "gif", "tif"];
        $maxWidth = 2048;
    
        // Check file type
        $imgfiletype = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($imgfiletype, $imgtypes)) {
            goBack("jpg, jpeg, png, gif, tif 이미지 파일만 올릴 수 있습니다.");
        }
    
        // 최대 크기(300kb를 넘으면?)
        if ($file['size'] > $maxFileSize) {
            // Resize the image
            // imagecreatefromstring()함수는 바이너리 데이터(문자열로 이루어짐)로 부터 이미지 파일을 생성
            // 이는 imagecreatefromjpg()같이 특정유형에 특화된 함수보다 유연하다
            // 성공시 resource 타입의 자료를 반환하고 실패시 false를 반환한다
            // file_get_contents() 함수는 해당 경로의 파일 내용을 문자열로 반환
            // magecreatefromstring(), imagescale() 은 둘다 성공시 gd에서 다루는 이미지 자료형을 반환하고
            // 실패시 둘다 false를 반환한다.
            $sourceImage = imagecreatefromstring(file_get_contents($file['tmp_name']));
            $width = imagesx($sourceImage);
            $height = imagesy($sourceImage);
            // 0.9를 얼마만큼 곱해야 가로가 300px 이내로 들어오는 지를 계산하기 위한 변수
            $mulNum = 0;

            if($sourceImage != false){
                // for 구문에서 0.9를 지속적으로 곱하여 이미지의 너비가 최대너비보다 작아지는 횟수를 구한다
                for($i=0;$i<200;$i++){
                    if($width>=$maxWidth){
                        $width *= 0.9;
                        $mulNum = $i;
                    } 
                }
                // 실제로 너비에다 0.9를 구한 횟수만큼 구한 수를 곱하여 너비를 만든다.
                // 이 때 세로는 뒤에 ($newWidth/$width)만큼을 곱해야 원본이미지 비율이 유지된다.`
                $powNum = pow(0.9, $mulNum);
                $newWidth = $width*$powNum;
                $newHeight = $height*$powNum*($newWidth/$width);

                $scaledImage = imagescale($sourceImage, $newWidth, $newHeight, IMG_BILINEAR_FIXED);

                if($scaledImage !== false) {                        
                    imagedestroy($sourceImage);

                    $fileName = uniqid() . '.' . $imgfiletype;
                    $targetFile = "/assets/images/photos/" . $fileName;
                    imagejpeg($scaledImage, $_SERVER['DOCUMENT_ROOT'] . $targetFile, 90);
                    imagedestroy($scaledImage);
                    return $fileName;
                } else {
                    return false;
                }
            }
        } else {
            // 처음부터 300kb가 넘지 않으면 바로 이경로를 탄다.
            $fileName = uniqid() . '.' . $imgfiletype;
            $targetFile = "/assets/images/photos/" . $fileName;
            move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $targetFile);
            return $fileName;
        }
    }
    

    // 이미지 정보를 가져오는 메소드
    public function getImage($id) {
        $sql = "SELECT * FROM images WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 모든 이미지 정보를 가져오는 메소드
    public function getAllImages() {
        $sql = "SELECT * FROM images ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 이미지 기록을 삭제하는 메소드
    public function deleteImage($id) {
        $sql = "DELETE FROM images WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        // execute()함수의 반환값은 항상 bool 값이다
        $result = $stmt->execute();
        return $result;
    }

    //

    // 댓글을 추가하는 메소드
    public function addComment($imageId, $comment) {
        $sql = "INSERT INTO comments (image_id, comment) VALUES (:imageId, :comment)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':imageId', $imageId);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();
    }

    // 해당 이미지의 모든 댓글을 가져오는 메소드
    public function getComments($imageId) {
        $sql = "SELECT * FROM comments WHERE image_id = :imageId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':imageId', $imageId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>
