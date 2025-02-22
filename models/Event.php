<?php

class Event {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    public function create($data) {
    $sql = "INSERT INTO events (organizer_id, category_id, title, description, event_date, location, total_tickets, price, image) 
            VALUES (:organizer_id, :category_id, :title, :description, :event_date, :location, :total_tickets, :price, :image)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute($data);
    $eventId = $this->db->lastInsertId();

    if ($eventId) {
        $this->generateTickets($eventId, $data['total_tickets']);
    }

    return $eventId;
}


private function generateTickets($eventId, $totalTickets) {
    $sql = "INSERT INTO tickets (event_id, ticket_number, status) VALUES (:event_id, :ticket_number, 'available')";
    $stmt = $this->db->prepare($sql);

    for ($i = 1; $i <= $totalTickets; $i++) {
        $stmt->execute([
            'event_id' => $eventId,
            'ticket_number' => "TCK-" . strtoupper(uniqid()) . "-$i"
        ]);
    }
}


    public function delete($id) {
    $sql = "DELETE FROM events WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

    public function getAll() {
        $sql = "SELECT * FROM events WHERE is_approved = true ORDER BY event_date";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function approveEvent($eventId) {
        $sql = "UPDATE events SET is_approved = TRUE WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $eventId]);
    }

    public function rejectEvent($eventId) {
    $sql = "DELETE FROM events WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['id' => $eventId]);
}

public function getPendingEvents() {
    $sql = "SELECT DISTINCT e.*, u.first_name, u.last_name 
            FROM events e 
            JOIN users u ON e.organizer_id = u.id 
            WHERE e.is_approved = FALSE 
            ORDER BY e.event_date";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getTotalEvents() {
        $sql = "SELECT COUNT(*) FROM events WHERE is_approved = TRUE";
        return $this->db->query($sql)->fetchColumn();
    }

    public function getTotalTicketsSold() {
        $sql = "SELECT SUM(tickets_sold) FROM events WHERE is_approved = TRUE";
        return $this->db->query($sql)->fetchColumn();
    }

    public function countByCategory($categoryId) {
        $sql = "SELECT COUNT(*) FROM events WHERE category_id = :category_id AND is_approved = TRUE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchColumn();
    }
    public function countAll() {
    $sql = "SELECT COUNT(*) FROM events WHERE is_approved = TRUE";
    return $this->db->query($sql)->fetchColumn();
}

    public function getByCategoryPaginated($categoryId, $page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM events WHERE category_id = :category_id AND is_approved = TRUE ORDER BY event_date LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPaginated($page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM events WHERE is_approved = TRUE ORDER BY event_date LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearch($query) {
        $sql = "SELECT COUNT(*) FROM events WHERE is_approved = TRUE AND (title ILIKE :query OR description ILIKE :query)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['query' => "%$query%"]);
        return $stmt->fetchColumn();
    }

    public function search($query, $page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM events WHERE is_approved = TRUE AND (title ILIKE :query OR description ILIKE :query) ORDER BY event_date LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByOrganizer($organizerId) {
    $sql = "SELECT e.*, 
       (e.total_tickets - COUNT(t.id)) AS remaining_tickets, 
       COUNT(t.id) AS tickets_sold
FROM events e
LEFT JOIN tickets t ON e.id = t.event_id AND t.status = 'reserved'
WHERE e.organizer_id = :organizer_id
GROUP BY e.id, e.total_tickets
ORDER BY e.event_date;
";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['organizer_id' => $organizerId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getRemainingTickets($eventId) {
    $sql = "SELECT e.id, 
                   e.total_tickets - COUNT(t.id) AS remaining_tickets
            FROM events e
            LEFT JOIN tickets t ON e.id = t.event_id AND t.status = 'reserved'
            WHERE e.id = :event_id
            GROUP BY e.id, e.total_tickets";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['event_id' => $eventId]);
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}


    public function getParticipants($eventId) {
        $sql = "SELECT u.id, u.first_name, u.last_name, u.email FROM users u 
                JOIN reservations r ON u.id = r.user_id 
                JOIN tickets t ON r.ticket_id = t.id 
                WHERE t.event_id = :event_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['event_id' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalEventsByOrganizer($organizerId) {
        $sql = "SELECT COUNT(*) FROM events WHERE organizer_id = :organizer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['organizer_id' => $organizerId]);
        return $stmt->fetchColumn();
    }

    public function getTotalTicketsSoldByOrganizer($organizerId)
{
    $sql = "SELECT COUNT(*) as total_tickets_sold
            FROM reservations 
            JOIN tickets ON reservations.ticket_id = tickets.id
            JOIN events ON tickets.event_id = events.id
            WHERE events.organizer_id = :organizer_id
            AND reservations.status = 'active'";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['organizer_id' => $organizerId]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['total_tickets_sold'] ?? 0;
}


public function getTotalRevenueByOrganizer($organizerId)
{
    $sql = "SELECT SUM(events.price) as total_revenue
            FROM reservations
            JOIN tickets ON reservations.ticket_id = tickets.id
            JOIN events ON tickets.event_id = events.id
            WHERE events.organizer_id = :organizer_id
            AND reservations.status = 'active'";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['organizer_id' => $organizerId]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;
}
public function decrementTicketsSold($eventId) {
        $sql = "UPDATE events SET tickets_sold = tickets_sold - 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $eventId]);
    }}
