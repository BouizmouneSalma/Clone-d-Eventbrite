<?php

class Admin extends User {
    protected $table = 'admins';

    public function create($data) {
    $sql = "INSERT INTO {$this->table} (email, password, first_name, last_name, admin_level) 
            VALUES (:email, :password, :first_name, :last_name, :admin_level)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'email' => $data['email'],
        'password' => $data['password'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'admin_level' => $data['admin_level'] ?? 1 
    ]);
    return $this->db->lastInsertId();
}


    public function getAllAdmins() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAdminLevel($adminId, $newLevel) {
        $sql = "UPDATE {$this->table} SET admin_level = :admin_level WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $adminId, 'admin_level' => $newLevel]);
    }
}