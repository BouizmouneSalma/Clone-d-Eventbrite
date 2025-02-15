<?php
require_once '../models/Ticket.php';
require_once '../models/Reservation.php';
require_once '../models/Event.php';

class TicketController {
    private $ticketModel;
    private $reservationModel;
    private $eventModel;

    public function __construct() {
        $this->ticketModel = new Ticket();
        $this->reservationModel = new Reservation();
        $this->eventModel = new Event();
    }


    public function reserve() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour réserver.']);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $event_id = $data['event_id'] ?? null;

            if (!$event_id) {
                echo json_encode(['success' => false, 'message' => 'ID d\'événement manquant.']);
                exit;
            }

            $ticket = $this->ticketModel->getAvailableTicket($event_id);

            if ($ticket) {
                
                $reservation = $this->reservationModel->create([
                    'user_id' => $_SESSION['user_id'],
                    'ticket_id' => $ticket['id']
                ]);

                if ($reservation) {
                    
                    $this->ticketModel->updateStatus($ticket['id'], 'reserved');
                    echo json_encode(['success' => true, 'message' => 'Réservation effectuée avec succès.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de la réservation.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Aucun billet disponible.']);
            }
            exit;
        }
    }

  
    public function cancel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour annuler une réservation.']);
                exit;
            }

            $reservation_id = $_POST['reservation_id'];
            $reservation = $this->reservationModel->getById($reservation_id);

            if ($reservation && $reservation['user_id'] == $_SESSION['user_id']) {
                if ($this->reservationModel->cancel($reservation_id)) {
                    $this->ticketModel->updateStatus($reservation['ticket_id'], 'available');
                    echo json_encode(['success' => true, 'message' => 'Réservation annulée avec succès.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'annulation de la réservation.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Réservation non trouvée ou non autorisée.']);
            }
            exit;
        }
    }
    
}
?>
