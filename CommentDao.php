<?php

class CommentDao {
    private $pdo;
    private $tableName;
    //댓글의 테이블의 부모글 아이디 컬럼의 제목으로 들어갈 아이디
    private $id;

    // 이 클래스는 여러 댓글 테이블에 공통으로 이용된다. 그러므로 생성자에 댓글을 기록할 태이블 이름을 넣어준다
    public function __construct($pdo, $tableName) {
        try{
            $this->pdo = $pdo;
            // 이 때 $tableName 은 반드시 "img_comment"와 같이 "_"를 가져야 한다.
            $this->tableName = $tableName;
            // 테이블 이름에서 "_"이 나오기까지의 글자수를 세어, 거기까지 잘라 $prefix에 저장한다.
            $prefixpos = strpos($this->tableName, "_");
            // 모든 comments 테이블에는 자신의 id와 부모의 id 두 개의 컬럼이 있다. id, img_id, 와 같은 방식이다. 
            // 이 때 id는 자신의 글 번호이고, img_id는 사진 id 값에 대한 댓글이라는말이다. 그러므로 "_"을 가진 
            // id는 부모의 아이디이다.
            $this->id = substr($this->tableName, 0, $prefixpos)."_id";
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage;
        }
        
    }

    public function getId() {
        return $this->id;
    }

    public function getTableName() {
        return $this->tableName;
    }
    
    
    public function insertComment($parentId, $writer, $comment, $date) {
        $stmt = $this->pdo->prepare("INSERT INTO ".$this->tableName." (".$this->id.", writer, comment, date) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $parentId);
        $stmt->bindParam(2, $writer);
        $stmt->bindParam(3, $comment);
        $stmt->bindParam(4, $date);
        $stmt->execute();
    }

    // 부모 아이디로 자식 글을 모두 뽑아 내는 메소드
    public function getAllCommentsByParentId($parentId) {
        $stmt = $this->pdo->prepare("SELECT * FROM ".$this->tableName." WHERE ".$this->id." = ? ORDER BY id DESC");
        $stmt->bindParam(1, $parentId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 자식글의 아이디로 자신의 글을 가져오는 메소드
    public function getCommentById($comment_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ".$this->tableName." WHERE id = ?");
        $stmt->bindParam(1, $comment_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateComment($comment_id, $comment) {
        echo $this->tableName;
        $stmt = $this->pdo->prepare("UPDATE ".$this->tableName." SET comment = ? WHERE id = ?");
        $stmt->bindParam(1, $comment);
        $stmt->bindParam(2, $comment_id);
        if ($stmt->execute()) {
            echo "쿼리 실행 성공";
        } else {
            echo "쿼리 실행 실패: " . $stmt->errorInfo()[2];
        }
    }

    public function deleteComment($comment_id) {
        $stmt = $this->pdo->prepare("DELETE FROM ".$this->tableName." WHERE id = ?");
        $stmt->bindParam(1, $comment_id);
        $stmt->execute();
    }
}

?>
