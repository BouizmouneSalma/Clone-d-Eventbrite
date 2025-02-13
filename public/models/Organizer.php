<?php

require_once 'User.php';

class Organizer extends User {
    protected $table = 'organizers';

    public function create($data) {
        $this->db->beginTransaction();

        try {
           
            $userSql = "INSERT INTO users (email, password, first_name, last_name, role) 
                        VALUES (:email, :password, :first_name, :last_name, :role)";
            $userStmt = $this->db->prepare($userSql);
            $userStmt->execute([
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':role' => 'organizer'
            ]);

            $userId = $this->db->lastInsertId();

           
            $organizerSql = "INSERT INTO organizers (id, email, password, first_name, last_name, role, company_name, website) 
                             VALUES (:id, :email, :password, :first_name, :last_name, :role, :company_name, :website)";
            $organizerStmt = $this->db->prepare($organizerSql);
            $organizerStmt->execute([
                ':id' => $userId,
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':role' => 'organizer',
                ':company_name' => $data['company_name'] ?? null,
                ':website' => $data['website'] ?? null
            ]);

            $this->db->commit();
            return $userId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error creating organizer: " . $e->getMessage());
            return false;
        }
    }
  
}

