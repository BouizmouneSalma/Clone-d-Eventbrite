<?php

class User {
    protected $db;
    protected $table = 'users';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (email, password, first_name, last_name, role) VALUES (:email, :password, :first_name, :last_name, :role)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function banUser($userId) {
        $sql = "UPDATE {$this->table} SET is_banned = TRUE WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId]);
    }

    public function changeRole($userId, $newRole) {
        $sql = "UPDATE {$this->table} SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId, 'role' => $newRole]);
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUsers() {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        return $this->db->query($sql)->fetchColumn();
    }

    public function update($user_id, $first_name, $last_name, $email, $role){
        $sql = "UPDATE {$this->table} SET first_name = :first_name, last_name = :last_name, email = :email, role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'role' => $role]);
    }

    public function delete($user_id){
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $user_id]);
    }

    public function ban($userId) {
        $sql = "UPDATE {$this->table} SET is_banned = :is_banned WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId, 'is_banned' => 1]);
    }
    
    public function unban($userId) {
        $sql = "UPDATE {$this->table} SET is_banned = :is_banned WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId, 'is_banned' => 0]);
    }
}