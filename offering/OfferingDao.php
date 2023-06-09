<?php
class OfferingDao {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 기록 추가
    public function insertOffering($name, $tithe, $weekly, $thanks, $mission, $construct, $relief, $thousand, $festive, $etc, $date) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO offerings (name, tithe, weekly, thanks, mission, construct, relief, thousand, festive, etc, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $tithe, $weekly, $thanks, $mission, $construct, $relief, $thousand, $festive, $etc, $date]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo 'Insert failed: ' . $e->getMessage();
        }
    }

    // 이름으로 기간 별 기록 조회
    public function getOfferingInRageByName($name, $start, $end) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM offerings WHERE date BETWEEN ? AND ? AND name = ? ORDER BY date DESC"
            );
            $stmt->execute([$name, $start, $end]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Select failed: ' . $e->getMessage();
        }
    }

    // 아이디로 기록 조회
    public function getOfferingById($offerId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM offerings WHERE id = ?");
            $stmt->execute([$offerId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'Select failed: ' . $e->getMessage();
        }
    }

    // 날짜별 기록 조회
    public function getOfferingByDate($date) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM offerings WHERE date = ? ORDER BY name DESC");
            $stmt->execute([$date]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Select failed: ' . $e->getMessage();
        }
    }



    // 기간 별 기록조회(회기년도 별)
    public function getWeeklyOfferingsInRange($start, $end) {
        try {    
            $stmt = $this->pdo->prepare("SELECT 
            SUM(tithe) AS total_tithe,
            SUM(weekly) AS total_weekly,
            SUM(thanks) AS total_thanks,
            SUM(mission) AS total_mission,
            SUM(construct) AS total_construct,
            SUM(relief) AS total_relief,
            SUM(thousand) AS total_thousand,
            SUM(festive) AS total_festive,
            SUM(etc) AS total_etc,
            date
            FROM offerings 
            WHERE date BETWEEN :start AND :end            
            GROUP BY date 
            ORDER BY date ASC");
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
    
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Select failed: ' . $e->getMessage();
        }
    }
    


    // 기록 수정
    public function updateOffering($id, $name, $tithe, $weekly, $thanks, $mission, $construct, $relief, $thousand, $festive, $etc, $date) {
        try {
            $stmt = $this->pdo->prepare("UPDATE offerings SET name = ?, tithe = ?, weekly = ?, thanks = ?, mission = ?, construct = ?, relief = ?, thousand = ?, festive = ?, etc = ?, date = ? WHERE id = ?");
            $result = $stmt->execute([$name, $tithe, $weekly, $thanks, $mission, $construct, $relief, $thousand, $festive, $etc, $date, $id]);
            
            return $result;
        } catch (PDOException $e) {
            echo 'Update failed: ' . $e->getMessage();
        }
    }
    

    // 기록 삭제
    public function deleteOffering($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM offerings WHERE id = ?");
            $stmt->execute([$id]);
            $deletedRows = $stmt->rowCount();
            return $deletedRows;
        } catch (PDOException $e) {
            echo 'Delete failed: ' . $e->getMessage();
        }
    }

    // 모든 기록 보기
    public function getAllOfferings() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM offerings ORDER BY id ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Select all failed: ' . $e->getMessage();
        }
    }


}
?>
