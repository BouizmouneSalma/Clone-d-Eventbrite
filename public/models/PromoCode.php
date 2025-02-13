<?php

class PromoCode {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO promo_codes (event_id, code, discount_percentage, valid_from, valid_to) VALUES (:event_id, :code, :discount_percentage, :valid_from, :valid_to)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function getByCode($code) {
        $sql = "SELECT * FROM promo_codes WHERE code = :code AND NOW() BETWEEN valid_from AND valid_to";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEvent($eventId) {
        $sql = "SELECT * FROM promo_codes WHERE event_id = :event_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['event_id' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}