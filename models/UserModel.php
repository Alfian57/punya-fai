<?php
require_once 'Model.php';

/**
 * Model untuk mengelola data pengguna
 */
class UserModel extends Model
{
    // Properties data pengguna
    private $id;
    private $username;
    private $password;
    private $email;

    // Konstanta untuk tabel
    private const TABLE = 'pengguna';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Melakukan login user
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login($username, $password)
    {
        // Validasi input
        $username = $this->validate(['username' => $username])['username'];
        $password = $this->validate(['password' => $password])['password'];

        $query = "SELECT * FROM " . self::TABLE . " WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Periksa password (di masa depan, gunakan password_hash dan password_verify)
            if ($password === $row['password']) {
                // Set data session
                $this->startSession();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }

        return false;
    }

    /**
     * Memasukkan data user baru
     * @return bool
     */
    public function register()
    {
        // Validasi data
        if (empty($this->username) || empty($this->password) || empty($this->email)) {
            return false;
        }

        // Periksa username yang sudah ada
        if ($this->isUsernameExists($this->username)) {
            return false;
        }

        // Di masa depan, gunakan password_hash
        //$hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $hashedPassword = $this->password; // Untuk kompatibilitas dengan sistem saat ini

        $query = "INSERT INTO " . self::TABLE . " (username, password, email) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $this->username, $hashedPassword, $this->email);

        return $stmt->execute();
    }

    /**
     * Memeriksa apakah username sudah ada
     * @param string $username
     * @return bool
     */
    private function isUsernameExists($username)
    {
        $query = "SELECT id FROM " . self::TABLE . " WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->startSession();
        $_SESSION = array();
        session_destroy();
    }

    /**
     * Memulai session jika belum dimulai
     */
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Memeriksa apakah user sudah login
     * @return bool
     */
    public function isLoggedIn()
    {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    /**
     * Mendapatkan semua data pengguna
     * @return array
     */
    public function getAllUsers()
    {
        return $this->getAll(self::TABLE);
    }

    /**
     * Mendapatkan data pengguna berdasarkan ID
     * @param int $id
     * @return array|null
     */
    public function getUserById($id)
    {
        return $this->getById(self::TABLE, $id);
    }

    // Getter dan Setter
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}