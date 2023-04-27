<?php
require_once "functions.php";
// PDO를 통하여 객체를 생성하여 사용하는 특징
// 1. prepare문에 ? 를 사용하는 것만으로도 SQL injection을 훌륭하게 방어하므로 
// query()와 같이 따옴표를 삽입하는 메소드를 사용할 필요가 없다.
// 2. 뿐만아니라 bindParam(), bindValue()와 같은 보안을 강화하는 방법도 있지만 ?를 사용하는 것만으로도 충분하다.
// 3. pdo를 사용하면 데이터베이스와 연결이 끝나면 자동으로 끊기 때문에 close()메소드를 사용할 필요가 없다.
// 4.각 테이블마다 독립적인 DAO 클래스를 만들어 쓰는 것이 좋으며, 
// 5. pdo 객체를 꺼내 쓸 수 있도록 getPdo() 메소드를 만들어둔다.
class MemberDao {
    private $pdo;
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
  
    public function __construct($host, $db_name, $username, $password, $charset) {
      $this->host = $host;
      $this->db_name = $db_name;
      $this->username = $username;
      $this->password = $password;
      $this->charset = $charset;
  
      $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset";
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];
  
      try {
        $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
      } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    public function getPdo() {
        return $this->pdo;
    }
  
    public function create_member($uid, $pass, $uname, $phone, $addr) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO members (uid, pass, uname, phone, addr) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$uid, $pass, $uname, $phone, $addr]);
            okGo("회원등록이 완료되었습니다.", MAIN_PAGE);
        } catch(PDOException $e) {
            errorBack("회원등록이 실패하였습니다." + $e->getMessage());
        }
      
    }
  
    public function read_member($uid) {
      $stmt = $this->pdo->prepare("SELECT * FROM members WHERE uid = ?");
      $stmt->execute([$uid]);
      $result = $stmt->fetch();
      return $result;
    }
  
    public function update_member($uid, $pass, $uname, $phone, $addr) {
      $stmt = $this->pdo->prepare("UPDATE members SET pass = ?, uname = ?, phone = ?, addr = ? WHERE uid = ?");
      $stmt->execute([$pass, $uname, $phone, $addr, $uid]);
    }
  
    public function delete_member($uid) {
      $stmt = $this->pdo->prepare("DELETE FROM members WHERE uid = ?");
      $stmt->execute([$uid]);
    }
  }
  

?>
