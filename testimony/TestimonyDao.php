<?php
class TestimonyDao {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createTestimony($author, $title, $content, $date, $file_addr) {
        // 파일 업로드 처리하고 파일 경로를 얻어냄
        $stmt = $this->pdo->prepare("INSERT INTO testimony (author, title, content, date, file_addr) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$author, $title, $content, $date, $file_addr]);

        // 데이터베이스에 새로운 테스트모니를 생성
       
        return $this->pdo->lastInsertId();
    }

    public function readTestimony($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM testimony WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateTestimony($id, $author, $title, $content, $date, $file) {
        // 파일 업로드 처리
        $file_addr = $this->uploadFile($file);

        // 데이터베이스의 기존 테스트모니를 업데이트
        $stmt = $this->pdo->prepare("UPDATE testimony SET author = ?, title = ?, content = ?, date = ?, file_addr = ? WHERE id = ?");
        $stmt->execute([$author, $title, $content, $date, $file_addr, $id]);
    }

    public function deleteTestimony($id) {
        $stmt = $this->pdo->prepare("DELETE FROM testimony WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function uploadFile($file) {
        $target_dir = "uploads/";
        // 아래의 basename($file["name"])은 확장자를 포함하는 원래의 파일이름이다.
        $basename = basename($file["name"]);
        $target_file = $target_dir . $basename;

        // pathinfo($path)를 실행하면 연관배열이 얻어지는데 그 key는 다음과 같다.
        // dirname: 파일이 위치한 디렉토리 경로
        // basename: 파일의 기본 이름 (확장자 포함)
        // extension: 파일의 확장자
        // // filename: 파일의 이름 (확장자 제외)
        // 그러나 $extension = pathinfo($path, PATHINFO_EXTENSION);와 같이 두번째 인수로 
        // PATHINFO_EXTENSION를 사용하면 확장자만 얻어진다.
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $fileTypes = ["txt", "hwp", "doc", "docx"];

        // 파일 업로드 유효성 검사
        // 필요한 검사 (예: 파일 크기, 파일 형식)를 수행하고, $uploadOk를 조정하여 유효한 경우에만 파일을 저장합니다.

        if (in_array($fileType, $fileTypes)) {
            move_uploaded_file($file["tmp_name"], $target_file);
            return $basename;
        } else {
            goBack("txt, hwp, doc 파일만 업로드할 수 있습니다.");
        }
    }

    public function getAllTestimonies() {
        $stmt = $this->pdo->prepare("SELECT * FROM testimony ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
