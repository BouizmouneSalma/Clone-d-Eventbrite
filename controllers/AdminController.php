<?php

require_once '../models/User.php';
require_once '../models/Event.php';

class AdminController {
    private $userModel;
    private $eventModel;

    public function __construct() {
        $this->userModel = new User();
        $this->eventModel = new Event();
    }

    public function dashboard() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $users = $this->userModel->getAll();
        $pendingEvents = $this->eventModel->getPendingEvents();
        $stats = $this->getGlobalStats();

        require '../views/admin/dashboard.php';
    }

    public function manageUsers() {
        $users = $this->userModel->getAll();
        require '../views/admin/users.php';
    }

    public function updateUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $this->userModel->update($user_id, $first_name, $last_name, $email, $role);
            header('Location: /admin/users');
            exit;
        }
    }

    public function deleteUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $this->userModel->delete($user_id);
            header('Location: /admin/users');
            exit;
        }
    }

    public function banUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $this->userModel->ban($user_id);
            header('Location: /admin/users');
            exit;
        }
    }

    public function unbanUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $this->userModel->unban($user_id);
            header('Location: /admin/users');
            exit;
        }
    }

    public function manageEvents() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $event_id = $_POST['event_id'];
            $action = $_POST['action'];

            if ($action === 'approve') {
                $this->eventModel->approveEvent($event_id);
            } elseif ($action === 'reject') {
                $this->eventModel->rejectEvent($event_id);
            }

            header('Location: /admin/dashboard');
            exit;
        }

        $pendingEvents = $this->eventModel->getPendingEvents();
        require '../views/admin/dashboard.php';
    }

    private function getGlobalStats() {
      
        return [
            'total_users' => $this->userModel->getTotalUsers(),
            'total_events' => $this->eventModel->getTotalEvents(),
            'total_tickets_sold' => $this->eventModel->getTotalTicketsSold(),
        ];
    }
}