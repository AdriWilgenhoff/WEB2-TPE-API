<?php
require_once 'db.model.php';

class UserModel extends Model {

    public function getUser($username) {
        $query = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
