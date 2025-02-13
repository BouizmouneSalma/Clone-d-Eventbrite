<?php

class Ticket {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($eventId, $quantity) {
        $sql = "INSERT INTO tickets (event_id, ticket_number, status) VALUES (:event_id, :ticket_number, 'available')";
        $stmt = $this->db->prepare($sql);
        
        for ($i = 0; $i < $quantity; $i++) {
            $ticketNumber = $this->generateTicketNumber($eventId);
            $stmt->execute(['event_id' => $eventId, 'ticket_number' => $ticketNumber]);
        }
    }

    public function getAvailableTicket($event_id) {
        $sql = "SELECT * FROM tickets WHERE event_id = :event_id AND status = 'available' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['event_id' => $event_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($ticket_id, $status) {
        $sql = "UPDATE tickets SET status = :status WHERE id = :ticket_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['status' => $status, 'ticket_id' => $ticket_id]);
    }

    private function generateTicketNumber($eventId) {
        return $eventId . '-' . uniqid();
    }
}