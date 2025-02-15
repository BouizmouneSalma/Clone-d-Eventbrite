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
                'valid_to' => $_POST['valid_to'],
                'max_uses' => $_POST['max_uses']
            ];

            $promoCodeId = $this->promoCodeModel->create($data);

           

            if ($promoCodeId) {
                header('Location: /organizer/promo-codes');
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
    public function manageSales() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $organizerId = $_SESSION['user_id'];
        $events = $this->eventModel->getByOrganizer($organizerId);

        $salesData = [];
        foreach ($events as $event) {
            $salesData[$event['id']] = [
                'event' => $event,
                'reservations' => $this->reservationModel->getByEvent($event['id']),
                'total_sales' => $this->reservationModel->getTotalSalesByEvent($event['id']),
            ];
        }

        require '../views/organizer/sales.php';
    }
    public function cancelReservation($reservationId) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $organizerId = $_SESSION['user_id'];
        $reservation = $this->reservationModel->getById($reservationId);

        if (!$reservation) {
            header('Location: /organizer/sales?error=ReservationIntrouvable');
            exit;
        }

        $event = $this->eventModel->getById($reservation['event_id']);
      

        $isCancelled = $this->reservationModel->cancel($reservationId);

        if ($isCancelled) {
            header('Location: /organizer/manage-sales');
        } else {
            header('Location: /organizer/manage-sales');
        }
        exit;
    }

    public function ActiveReservation($reservationId) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $organizerId = $_SESSION['user_id'];
        $reservation = $this->reservationModel->getById($reservationId);

        if (!$reservation) {
            header('Location: /organizer/sales?error=ReservationIntrouvable');
            exit;
        }

        $event = $this->eventModel->getById($reservation['event_id']);
    
        $isCancelled = $this->reservationModel->active($reservationId);

        if ($isCancelled) {
            header('Location: /organizer/manage-sales');
        } else {
            header('Location: /organizer/manage-sales');
        }
        exit;
    }
    public function listPromoCodes() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $organizerId = $_SESSION['user_id'];
        $promoCodes = $this->promoCodeModel->getByOrganizer($organizerId);

        require '../views/organizer/promo_codes.php';
    }

    public function editPromoCode($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $promoCode = $this->promoCodeModel->getById($id);
        if (!$promoCode) {
            $_SESSION['error'] = "Code promo non trouvé.";
            header('Location: /organizer/promo-codes');
            exit;
        }

        $event = $this->eventModel->getById($promoCode['event_id']);
        if ($event['organizer_id'] != $_SESSION['user_id']) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'code' => $_POST['code'],
                'discount_percentage' => $_POST['discount_percentage'],
                'valid_from' => $_POST['valid_from'],
                'valid_to' => $_POST['valid_to'],
                'max_uses' => $_POST['max_uses']
            ];

            if ($this->promoCodeModel->update($data)) {
                $_SESSION['success'] = "Le code promo a été mis à jour avec succès.";
                header('Location: /organizer/promo-codes');
                exit;
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la mise à jour du code promo.";
            }
        }

        $events = $this->eventModel->getByOrganizer($_SESSION['user_id']);
        require '../views/organizer/edit_promo_code.php';
    }

    public function deletePromoCode($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        $promoCode = $this->promoCodeModel->getById($id);
        if (!$promoCode) {
            $_SESSION['error'] = "Code promo non trouvé.";
            header('Location: /organizer/promo-codes');
            exit;
        }

        $event = $this->eventModel->getById($promoCode['event_id']);
        if ($event['organizer_id'] != $_SESSION['user_id']) {
            header('Location: /login');
            exit;
        }

        if ($this->promoCodeModel->delete($id)) {
            $_SESSION['success'] = "Le code promo a été supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la suppression du code promo.";
        }

        header('Location: /organizer/promo-codes');
        exit;
    }
}