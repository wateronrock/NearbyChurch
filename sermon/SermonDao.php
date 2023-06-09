<?php
class SermonDao {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createSermon($preacher, $title, $passage, $date, $audio_id) {
        $query = $this->pdo->prepare("INSERT INTO sermons (preacher, title, passage, date, audio_id) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$preacher, $title, $passage, $date, $audio_id]);
    }

    public function getSermonById($id) {
        $query = $this->pdo->prepare("SELECT * FROM sermons WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }

    public function getAllSermons() {
        $query = $this->pdo->prepare("SELECT * FROM sermons ORDER BY id DESC");
        $query->execute();
        return $query->fetchAll();
    }

    public function updateSermon($id, $preacher, $title, $passage, $date, $audio_id) {
        $query = $this->pdo->prepare("UPDATE sermons SET preacher = ?, title = ?, passage = ?, date = ?, audio_id = ? WHERE id = ?");
        $query->execute([$preacher, $title, $passage, $date, $audio_id, $id]);
    }

    public function deleteSermon($id) {
        $query = $this->pdo->prepare("DELETE FROM sermons WHERE id = ?");
        $query->execute([$id]);
    }
}

?>
