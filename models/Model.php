<?php
/**
 * Kelas Model dasar untuk semua model
 */
abstract class Model
{
    // Properti koneksi database
    protected $conn;

    /**
     * Constructor dengan koneksi database
     */
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Validasi input data
     * @param array $data Data yang akan divalidasi
     * @return array Data yang sudah dibersihkan
     */
    protected function validate($data)
    {
        $clean = [];
        foreach ($data as $key => $value) {
            // Sanitasi dasar
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            $clean[$key] = $value;
        }
        return $clean;
    }

    /**
     * Mendapatkan semua data dari tabel
     * @param string $table Nama tabel
     * @param string $orderBy Kolom untuk pengurutan
     * @param string $order Arah pengurutan (ASC/DESC)
     * @return array|false
     */
    protected function getAll($table, $orderBy = 'id', $order = 'DESC')
    {
        $query = "SELECT * FROM {$table} ORDER BY {$orderBy} {$order}";
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }

        return [];
    }

    /**
     * Mendapatkan satu baris data dari tabel berdasarkan ID
     * @param string $table Nama tabel
     * @param int $id ID yang dicari
     * @return array|null
     */
    protected function getById($table, $id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM {$table} WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    /**
     * Menghapus data dari tabel berdasarkan ID
     * @param string $table Nama tabel
     * @param int $id ID yang akan dihapus
     * @return bool Berhasil atau tidak
     */
    protected function delete($table, $id)
    {
        $id = (int) $id;
        $query = "DELETE FROM {$table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}