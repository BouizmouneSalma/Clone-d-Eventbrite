<?php

require_once '../models/Event.php';
require_once '../models/PromoCode.php';
require_once '../models/Reservation.php';

class OrganizerController {
    private $eventModel;
    private $promoCodeModel;
    private $reservationModel;

    public function __construct() {
       $this->eventModel = new Event();
       $this->promoCodeModel = new PromoCode();
       $this->reservationModel = new Reservation();

    }

    public function dashboard() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $organizer_id = $_SESSION['user_id'];
        $events = $this->eventModel->getByOrganizer($organizer_id);
        $stats = $this->getOrganizerStats($organizer_id);

        require '../views/organizer/dashboard.php';
    }

    public function createPromoCode() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'event_id' => $_POST['event_id'],
                'code' => $_POST['code'],
                'discount_percentage' => $_POST['discount_percentage'],
                'valid_from' => $_POST['valid_from'],
                'valid_to' => $_POST['valid_to']
            ];

            $promoCodeId = $this->promoCodeModel->create($data);

            //hna diro location dyal code promo bch t2aficchiw veiw dyal code promo

            if ($promoCodeId) {
                header('Location: /organizer/dashboard');
                exit;
            } else {
                $error = "La création du code promo a échoué. Veuillez réessayer.";
            }
        }

        $organizer_id = $_SESSION['user_id'];
        $events = $this->eventModel->getByOrganizer($organizer_id);
        require '../views/organizer/create_promo_code.php';
    }

   
    private function getOrganizerStats($organizer_id) {
        
        return [
            'total_events' => $this->eventModel->getTotalEventsByOrganizer($organizer_id),
            'total_tickets_sold' => $this->eventModel->getTotalTicketsSoldByOrganizer($organizer_id),
            'total_revenue' => $this->eventModel->getTotalRevenueByOrganizer($organizer_id),
        ];
    }

    public function gerer() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $organizer_id = $_SESSION['user_id'];
        $events = $this->eventModel->getByOrganizer($organizer_id);

        foreach ($events as &$event) {
            $event['participants'] = $this->reservationModel->getParticipantsByEvent($event['id']);
        }

        require '../views/organizer/manage_sales.php';
    }

   
}
