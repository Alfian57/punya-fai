<?php
require_once 'Model.php';

/**
 * Model untuk mengelola data bayi/balita
 */
class BayiModel extends Model
{
    // Properties data bayi
    private $id;
    private $nama;
    private $tinggi;
    private $berat;
    private $jenisKelamin;
    private $tanggalLahir;
    private $riwayat;
    private $catatan;

    // Konstanta untuk tabel
    private const TABLE = 'databayi';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mendapatkan semua data bayi
     * @return array
     */
    public function getAllBayi()
    {
        return $this->getAll(self::TABLE);
    }

    /**
     * Mendapatkan data bayi berdasarkan ID
     * @param int $id
     * @return array|null
     */
    public function getBayiById($id)
    {
        return $this->getById(self::TABLE, $id);
    }

    /**
     * Menambahkan data bayi baru
     * @return bool
     */
    public function tambah()
    {
        // Validasi data
        if (empty($this->nama) || empty($this->jenisKelamin)) {
            return false;
        }

        $query = "INSERT INTO " . self::TABLE . " (nama, tinggi, berat, jenisKelamin, tanggalLahir, riwayat, catatan)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sddssss",
            $this->nama,
            $this->tinggi,
            $this->berat,
            $this->jenisKelamin,
            $this->tanggalLahir,
            $this->riwayat,
            $this->catatan
        );

        return $stmt->execute();
    }

    /**
     * Memperbarui data bayi
     * @param int $id
     * @return bool
     */
    public function update($id)
    {
        // Validasi data
        if (empty($this->nama) || empty($this->jenisKelamin)) {
            return false;
        }

        $query = "UPDATE " . self::TABLE . " SET 
                  nama=?, 
                  tinggi=?, 
                  berat=?, 
                  jenisKelamin=?, 
                  tanggalLahir=?, 
                  riwayat=?, 
                  catatan=? 
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sddssssi",
            $this->nama,
            $this->tinggi,
            $this->berat,
            $this->jenisKelamin,
            $this->tanggalLahir,
            $this->riwayat,
            $this->catatan,
            $id
        );

        return $stmt->execute();
    }

    /**
     * Menghapus data bayi
     * @param int $id
     * @return bool
     */
    public function hapus($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    /**
     * Mencari data bayi berdasarkan nama
     * @param string $keyword
     * @return array
     */
    public function search($keyword)
    {
        $keyword = "%{$keyword}%";
        $query = "SELECT * FROM " . self::TABLE . " WHERE nama LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
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

    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function getTinggi()
    {
        return $this->tinggi;
    }

    public function setTinggi($tinggi)
    {
        $this->tinggi = (float) $tinggi;
    }

    public function getBerat()
    {
        return $this->berat;
    }

    public function setBerat($berat)
    {
        $this->berat = (float) $berat;
    }

    public function getJenisKelamin()
    {
        return $this->jenisKelamin;
    }

    public function setJenisKelamin($jenisKelamin)
    {
        $this->jenisKelamin = $jenisKelamin;
    }

    public function getTanggalLahir()
    {
        return $this->tanggalLahir;
    }

    public function setTanggalLahir($tanggalLahir)
    {
        $this->tanggalLahir = $tanggalLahir;
    }

    public function getRiwayat()
    {
        return $this->riwayat;
    }

    public function setRiwayat($riwayat)
    {
        $this->riwayat = $riwayat;
    }

    public function getCatatan()
    {
        return $this->catatan;
    }

    public function setCatatan($catatan)
    {
        $this->catatan = $catatan;
    }
}