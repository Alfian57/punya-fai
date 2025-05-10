<?php
/**
 * Kelas Controller dasar untuk semua controller
 */
class Controller
{
    /**
     * Memuat view dengan data yang disediakan
     * @param string $view Path ke file view
     * @param array $data Data yang akan dikirim ke view
     */
    protected function view($view, $data = [])
    {
        // Ekstrak data ke variabel
        extract($data);

        // Berikan path lengkap ke view
        $viewPath = "../views/{$view}.php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View {$view} tidak ditemukan!");
        }
    }

    /**
     * Redirect ke URL tertentu
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Memulai session jika belum dimulai
     */
    protected function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Memeriksa apakah user sudah login
     * @return bool
     */
    protected function isLoggedIn()
    {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    /**
     * Memastikan user harus login untuk mengakses
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('../views/auth/login.php');
        }
    }

    /**
     * Set pesan flash untuk ditampilkan ke user
     * @param string $type Tipe pesan (success, error, warning, info)
     * @param string $message Pesan yang akan ditampilkan
     */
    protected function setFlashMessage($type, $message)
    {
        $this->startSession();
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Mendapatkan pesan flash dan menghapusnya dari session
     * @return array|null
     */
    protected function getFlashMessage()
    {
        $this->startSession();
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
}