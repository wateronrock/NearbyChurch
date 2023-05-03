<?php
class BaseDao {
    protected $pdo;
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    
    public function __construct($host, $db_name, $username, $password, $charset) {
      $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];
    
      try {
        $this->pdo = new PDO($dsn, $username, $password, $options);
      } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    public function getPdo() {
        return $this->pdo;
    }
  }
?>
