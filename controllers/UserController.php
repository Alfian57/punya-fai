<?php
require_once '../controllers/Controller.php';
require_once '../models/UserModel.php';

/**
 * Controller untuk menangani operasi data pengguna
 */
class UserController extends Controller
{
    // Model data pengguna
    private $userModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan halaman login
     */
    public function loginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('../views/dashboard.php');
        }

        $this->view('auth/login');
    }

    /**
     * Menangani proses login
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';

            if ($this->userModel->login($username, $password)) {
                $this->redirect('../views/dashboard.php');
            } else {
                $this->setFlashMessage('error', 'Username atau password salah');
                $this->redirect('../views/login.php');
            }
        } else {
            $this->redirect('../views/login.php');
        }
    }

    /**
     * Menangani proses logout
     */
    public function logout()
    {
        $this->userModel->logout();
        $this->redirect('../views/login.php');
    }

    /**
     * Menampilkan halaman registrasi
     */
    public function registerForm()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('../views/dashboard.php');
        }

        $this->view('auth/register');
    }

    /**
     * Menangani proses registrasi
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';

            $this->userModel->setUsername($username);
            $this->userModel->setPassword($password);
            $this->userModel->setEmail($email);

            if ($this->userModel->register()) {
                $this->setFlashMessage('success', 'Registrasi berhasil, silakan login');
                $this->redirect('../views/login.php');
            } else {
                $this->setFlashMessage('error', 'Registrasi gagal, username mungkin sudah digunakan');
                $this->redirect('../views/register.php');
            }
        } else {
            $this->redirect('../views/register.php');
        }
    }
}