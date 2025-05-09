<?php
require_once '../controllers/Controller.php';
require_once '../models/BayiModel.php';

/**
 * Controller untuk menangani operasi data bayi
 */
class BayiController extends Controller
{
    // Model data bayi
    private $bayiModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bayiModel = new BayiModel();
    }

    /**
     * Menampilkan halaman dashboard dengan daftar data bayi
     */
    public function index()
    {
        $this->requireLogin();

        $dataBayi = $this->bayiModel->getAllBayi();
        $flashMessage = $this->getFlashMessage();

        $this->view('bayi/index', [
            'dataBayi' => $dataBayi,
            'flashMessage' => $flashMessage
        ]);
    }

    /**
     * Menampilkan form tambah data bayi
     */
    public function tambahForm()
    {
        $this->requireLogin();
        $this->view('bayi/tambah');
    }

    /**
     * Menangani proses tambah data bayi
     */
    public function tambah()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set data dari form
            $this->bayiModel->setNama($_POST['nama']);
            $this->bayiModel->setTinggi($_POST['tinggi']);
            $this->bayiModel->setBerat($_POST['berat']);
            $this->bayiModel->setJenisKelamin($_POST['jenisKelamin']);
            $this->bayiModel->setTanggalLahir($_POST['tanggalLahir']);
            $this->bayiModel->setRiwayat($_POST['riwayat']);
            $this->bayiModel->setCatatan($_POST['catatan']);

            // Proses tambah data
            if ($this->bayiModel->tambah()) {
                $this->setFlashMessage('success', 'Data bayi berhasil ditambahkan');
            } else {
                $this->setFlashMessage('error', 'Gagal menambahkan data bayi');
            }
        }

        $this->redirect('../views/bayi/index.php');
    }

    /**
     * Menampilkan form edit data bayi
     * @param int $id
     */
    public function editForm($id)
    {
        $this->requireLogin();

        $dataBayi = $this->bayiModel->getBayiById($id);

        if (!$dataBayi) {
            $this->setFlashMessage('error', 'Data bayi tidak ditemukan');
            $this->redirect('../views/bayi/index.php');
        }

        $this->view('bayi/edit', [
            'dataBayi' => $dataBayi
        ]);
    }

    /**
     * Menangani proses edit data bayi
     */
    public function edit()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            // Set data dari form
            $this->bayiModel->setNama($_POST['nama']);
            $this->bayiModel->setTinggi($_POST['tinggi']);
            $this->bayiModel->setBerat($_POST['berat']);
            $this->bayiModel->setJenisKelamin($_POST['jenisKelamin']);
            $this->bayiModel->setTanggalLahir($_POST['tanggalLahir']);
            $this->bayiModel->setRiwayat($_POST['riwayat']);
            $this->bayiModel->setCatatan($_POST['catatan']);

            // Proses update data
            if ($this->bayiModel->update($id)) {
                $this->setFlashMessage('success', 'Data bayi berhasil diperbarui');
            } else {
                $this->setFlashMessage('error', 'Gagal memperbarui data bayi');
            }
        }

        $this->redirect('../views/bayi/index.php');
    }

    /**
     * Menangani proses hapus data bayi
     * @param int $id
     */
    public function hapus($id)
    {
        $this->requireLogin();

        if ($this->bayiModel->hapus($id)) {
            $this->setFlashMessage('success', 'Data bayi berhasil dihapus');
        } else {
            $this->setFlashMessage('error', 'Gagal menghapus data bayi');
        }

        $this->redirect('../views/bayi/index.php');
    }

    /**
     * Menangani pencarian data bayi
     */
    public function search()
    {
        $this->requireLogin();

        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $dataBayi = $this->bayiModel->search($keyword);

        $this->view('bayi/index', [
            'dataBayi' => $dataBayi,
            'keyword' => $keyword
        ]);
    }
}