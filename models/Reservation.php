<?php

class Reservation {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO reservations (user_id, ticket_id) VALUES (:user_id, :ticket_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function getById($id) {
        $sql = "SELECT * FROM reservations WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancel($id) {
        $sql = "UPDATE reservations SET status = 'cancelled' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getByUser($userId) {
        $sql = "SELECT r.*, e.title, e.event_date, e.location 
                FROM reservations r 
                JOIN tickets t ON r.ticket_id = t.id 
                JOIN events e ON t.event_id = e.id 
                WHERE r.user_id = :user_id 
                ORDER BY e.event_date";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getParticipantsByEvent($event_id) {
        $sql = "SELECT u.id, u.first_name, u.last_name, u.email 
                FROM reservations r
                JOIN users u ON r.user_id = u.id
                JOIN tickets t ON r.ticket_id = t.id
                WHERE t.event_id = :event_id";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['event_id' => $event_id]);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}