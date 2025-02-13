<?php
require_once '../models/Event.php';
require_once '../models/Category.php';
class EventController {
    private $eventModel;
    private $categoryModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->categoryModel = new Category();
    }

    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $category_id = $_GET['category_id'] ?? null;

        $totalEvents = $category_id ? $this->eventModel->countByCategory($category_id) : $this->eventModel->countAll();
        $totalPages = ceil($totalEvents / $perPage);

        $events = $category_id 
            ? $this->eventModel->getByCategoryPaginated($category_id, $page, $perPage)
            : $this->eventModel->getAllPaginated($page, $perPage);

        $categories = $this->categoryModel->getAll();
        
        require '../views/events/list.php';
    }

    public function listEventsByCategory($categoryId) {
        $category = $this->categoryModel->getById($categoryId);
        $eventCount = $this->eventModel->countByCategory($categoryId);
        $events = $this->eventModel->getByCategoryPaginated($categoryId, 1, 10); // Page 1, 10 events per page

    }
    public function detail($id) {
        $event = $this->eventModel->getById($id);
        if (!$event) {
            header('Location: /events');
            exit;
        }
        require '../views/events/detail.php';
    }

public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'organizer') {
                header('Location: /login');
                exit;
            }

            $errors = $this->validateEventData($_POST);

            if (empty($errors)) {
                $data = [
                    'organizer_id' => $_SESSION['user_id'],
                    'category_id' => $_POST['category_id'],
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'event_date' => $_POST['event_date'],
                    'location' => $_POST['location'],
                    'total_tickets' => $_POST['total_tickets'],
                    'price' => $_POST['price']
                ];

                $eventId = $this->eventModel->create($data);

                if ($eventId) {
                    header('Location: /events/' . $eventId);
                    exit;
                } else {
                    $error = "La création de l'événement a échoué. Veuillez réessayer.";
                }
            }
        }

        $categories = $this->categoryModel->getAll();
        require '../views/events/create.php';
    }
     private function validateEventData($data) {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = "Le titre est obligatoire.";
        }

        if (empty($data['description'])) {
            $errors['description'] = "La description est obligatoire.";
        }

        if (empty($data['event_date'])) {
            $errors['event_date'] = "La date de l'événement est obligatoire.";
        } elseif (strtotime($data['event_date']) < time()) {
            $errors['event_date'] = "La date de l'événement doit être dans le futur.";
        }

        if (empty($data['location'])) {
            $errors['location'] = "Le lieu est obligatoire.";
        }

        if (empty($data['total_tickets']) || !is_numeric($data['total_tickets']) || $data['total_tickets'] <= 0) {
            $errors['total_tickets'] = "Le nombre de billets doit être un nombre positif.";
        }

        if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] < 0) {
            $errors['price'] = "Le prix doit être un nombre positif ou zéro.";
        }

        return $errors;
    }
    public function delete($id) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'organizer') {
            header('Location: /login');
            exit;
        }

        if ($this->eventModel->delete($id)) {
            header('Location: /organizer/dashboard');
            exit;
        } else {
            echo "Erreur lors de la suppression de l'événement.";
        }
    }

}
?>

    
   