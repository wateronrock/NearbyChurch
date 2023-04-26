<?php
// 아래 실행문은 이 파일이 불려지는 순간 실행되며 데이터베이스 접속이 시도된다.
class MemberDao {
    private $pdo;
    private $bCon = PDO::PARAM_STR;

    // 생성자는 세개의 인자를 가지지만 내부적으로는 네개의 인자를 처리한다
    public function __construct($attr, $dbuser, $dbpass, $opts) {
        try {
            $pdo = new PDO($attr, $dbuser,  $dbpass, $opts);
        } catch(PDOExcepion $e) {
            // PDOException(에러메시지, 에러코드)
            exit($e->getMessage());
        }
    }

    // public function quote($str) {
    //     $this->pdo->quote($str);
    // }

    public function getMember($uid) {
        try {
            $query = $this->pdo->query("SELECT * FROM members WHERE uid = '$uid'");
            
           
            $result = $query->fetch();

            

        } catch (PDOexception $e) {
            exit($e->getMessage());
        }

        // $result는 위에서 설정한 fetchmode 설정으로 인해 연관배열로 반환된다
        return $result;
    }

    public function insertMember($uid, $pass, $uname, $phone, $address) {
        try {
            $query = $this->pdo->prepare("INSERT INTO members VALUES (:uid, :pass, :uname, :phone, :address)");
            $query->bindValue(":uid", $uid, $bindCon);
            $query->bindValue(":pass", $pass, $bindCon);
            $query->bindValue(":uname", $uname, $bindCon);
            $query->bindValue(":phone", $phone, $bindCon);
            $query->bindValue(":address", $address, $bindCon);
            $query->excute();
        } catch (PDOexception $e) {
            exit($e->getMessage());
        }
    }

    public function updateMember($uid, $pass, $uname, $phone, $address) {
        try {
            $query = $this->pdo->prepare("UPDATE members SET pass=:pass, uname=:uname, phone=:phone,
             address=:address  WHERE uid=:uid");
            $query->bindValue(":pass", $pass, $bindCon);
            $query->bindValue(":uname", $uname, $bindCon);
            $query->bindValue(":phone", $phone, $bindCon);
            $query->bindValue(":address", $address, $bindCon);
            $query->bindValue(":uid", $uid, $bindCon);
            $query->excute();
        } catch (PDOexception $e) {
            exit($e->getMessage());
        }
    }
}

?>
