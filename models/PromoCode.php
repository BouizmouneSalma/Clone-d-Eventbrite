<?php

class PromoCode {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO promo_codes (event_id, code, discount_percentage, valid_from, valid_to,max_uses) VALUES (:event_id, :code, :discount_percentage, :valid_from, :valid_to , :max_uses)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM promo_codes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 

    public function update($data) {
        $sql = "UPDATE promo_codes 
                SET code = :code, discount_percentage = :discount_percentage, 
                    valid_from = :valid_from, valid_to = :valid_to, max_uses = :max_uses 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $data['id'],
            ':code' => $data['code'],
            ':discount_percentage' => $data['discount_percentage'],
            ':valid_from' => $data['valid_from'],
            ':valid_to' => $data['valid_to'],
            ':max_uses' => $data['max_uses']
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM promo_codes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }

    public function getByOrganizer($organizerId) {
    $sql = "SELECT pc.*, e.title as event_title, 
                       (SELECT COUNT(*) FROM reservations r 
                        JOIN tickets t ON r.ticket_id = t.id 
                        WHERE t.event_id = e.id AND r.promo_code_id = pc.id) as uses_count
                FROM promo_codes pc
                JOIN events e ON pc.event_id = e.id
                WHERE e.organizer_id = :organizer_id
                ORDER BY pc.valid_from DESC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['organizer_id' => $organizerId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}