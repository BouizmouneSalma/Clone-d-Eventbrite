<?php

class Middleware {
    public static function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireRole($role) {
        self::requireAuth();
        if ($_SESSION['user_role'] !== $role) {
            header('Location: /');
            exit;
        }
    }
}