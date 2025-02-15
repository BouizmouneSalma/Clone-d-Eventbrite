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
        $sql = "UPDATE reservations SET status = 'canceled' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    public function active($id) {
        $sql = "UPDATE reservations SET status = 'active' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    

    public function getPastEventsByUser($userId) {
    $currentDate = date('Y-m-d H:i:s');
    $sql = "SELECT e.*,r.id as res, t.ticket_number 
            FROM reservations r 
            JOIN tickets t ON r.ticket_id = t.id 
            JOIN events e ON t.event_id = e.id 
            WHERE r.user_id = :user_id 
            AND e.event_date <= :current_date 
            AND r.status = 'active'
            ORDER BY e.event_date DESC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'user_id' => $userId, 
        'current_date' => $currentDate
    ]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    public function getByEvent($eventId) {
        $sql = "SELECT r.*, u.email as user_email 
                FROM reservations r 
                JOIN tickets t ON r.ticket_id = t.id 
                JOIN users u ON r.user_id = u.id 
                WHERE t.event_id = :event_id 
                ORDER BY r.reservation_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['event_id' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSalesByEvent($eventId) {
        $sql = "SELECT SUM(e.price) as total_sales 
                FROM reservations r 
                JOIN tickets t ON r.ticket_id = t.id 
                JOIN events e ON t.event_id = e.id 
                WHERE t.event_id = :event_id AND r.status = 'active'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['event_id' => $eventId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;
    }
    public function getLastReservedEventByUser($userId) {
    $sql = "SELECT r.id as res, e.*, t.ticket_number 
            FROM reservations r 
            JOIN tickets t ON r.ticket_id = t.id 
            JOIN events e ON t.event_id = e.id 
            WHERE r.user_id = :user_id 
            AND r.status = 'active' 
            ORDER BY r.reservation_date DESC 
            LIMIT 1";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}