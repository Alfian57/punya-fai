<?php
class Bayi {
    private $id;
    private $nama;
    private $tinggi;
    private $berat;
    private $jenisKelamin;
    private $tanggalLahir;
    private $riwayat;
    private $catatan;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambah() {
        $query = "INSERT INTO databayi (nama, tinggi, berat, jenisKelamin, tanggalLahir, riwayat, catatan)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sddssss", $this->nama, $this->tinggi, $this->berat,
                          $this->jenisKelamin, $this->tanggalLahir, $this->riwayat, $this->catatan);
        return $stmt->execute();
    }

    public function update($id) {
        $query = "UPDATE databayi SET nama=?, tinggi=?, berat=?, jenisKelamin=?, tanggalLahir=?, riwayat=?, catatan=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sddssssi", $this->nama, $this->tinggi, $this->berat,
                          $this->jenisKelamin, $this->tanggalLahir, $this->riwayat, $this->catatan, $id);
        return $stmt->execute();
    }

    public function hapus($id) {
        $query = "DELETE FROM databayi WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Getter dan Setter
    public function setNama($nama) { $this->nama = $nama; }
    public function getNama() { return $this->nama; }

    public function setTinggi($tinggi) { $this->tinggi = $tinggi; }
    public function getTinggi() { return $this->tinggi; }

    public function setBerat($berat) { $this->berat = $berat; }
    public function getBerat() { return $this->berat; }

    public function setJenisKelamin($jenisKelamin) { $this->jenisKelamin = $jenisKelamin; }
    public function getJenisKelamin() { return $this->jenisKelamin; }

    public function setTanggalLahir($tanggalLahir) { $this->tanggalLahir = $tanggalLahir; }
    public function getTanggalLahir() { return $this->tanggalLahir; }

    public function setRiwayat($riwayat) { $this->riwayat = $riwayat; }
    public function getRiwayat() { return $this->riwayat; }

    public function setCatatan($catatan) { $this->catatan = $catatan; }
    public function getCatatan() { return $this->catatan; }
}
