<?php
// admin/buku_proses.php
session_start();
require_once '../koneksi.php';

// Proteksi halaman: pastikan hanya admin yang bisa memproses CRUD buku
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak. Anda bukan admin.");
}

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

// --- PROSES TAMBAH & EDIT BUKU ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_buku      = isset($_POST['id_buku']) ? $_POST['id_buku'] : '';
    $kode_buku    = trim($_POST['bookCode']);
    $judul        = trim($_POST['bookTitle']);
    $penulis      = trim($_POST['bookAuthor']);
    $kategori     = $_POST['bookCategory'];
    $stok         = intval($_POST['bookStock']);
    $lokasi_rak   = trim($_POST['bookLocation']);
    $status       = strtolower($_POST['bookStatus']); // MySQL enum menggunakan huruf kecil
    $sinopsis     = trim($_POST['bookSynopsis']);
    
    // Default cover
    $cover_name = "default.jpg";

    // Handle Upload Cover jika ada
    if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['bookCover']['tmp_name'];
        $file_name = time() . "_" . $_FILES['bookCover']['name'];
        $upload_dir = "../assets/covers/";
        
        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            $cover_name = $file_name;
        }
    } elseif (!empty($_POST['old_cover'])) {
        $cover_name = $_POST['old_cover'];
    }

    if (empty($id_buku)) {
        // Aksi Insert (Tambah)
        $query = "INSERT INTO buku (kode_buku, judul, penulis, kategori, stok, lokasi_rak, status, sinopsis, cover) 
                  VALUES (:kode_buku, :judul, :penulis, :kategori, :stok, :lokasi_rak, :status, :sinopsis, :cover)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'kode_buku'  => $kode_buku, 'judul' => $judul, 'penulis' => $penulis,
            'kategori'   => $kategori, 'stok' => $stok, 'lokasi_rak' => $lokasi_rak,
            'status'     => $status, 'sinopsis' => $sinopsis, 'cover' => $cover_name
        ]);
    } else {
        // Aksi Update (Edit)
        $query = "UPDATE buku SET kode_buku = :kode_buku, judul = :judul, penulis = :penulis, kategori = :kategori, 
                  stok = :stok, lokasi_rak = :lokasi_rak, status = :status, sinopsis = :sinopsis, cover = :cover 
                  WHERE id_buku = :id_buku";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'kode_buku'  => $kode_buku, 'judul' => $judul, 'penulis' => $penulis,
            'kategori'   => $kategori, 'stok' => $stok, 'lokasi_rak' => $lokasi_rak,
            'status'     => $status, 'sinopsis' => $sinopsis, 'cover' => $cover_name,
            'id_buku'    => $id_buku
        ]);
    }

    header("Location: daftar-buku.php?pesan=sukses");
    exit();
}

// --- PROSES HAPUS BUKU ---
if ($aksi === 'hapus') {
    $id_buku = intval($_GET['id']);
    if ($id_buku > 0) {
        $stmt = $pdo->prepare("DELETE FROM buku WHERE id_buku = :id_buku");
        $stmt->execute(['id_buku' => $id_buku]);
    }
    header("Location: daftar-buku.php?pesan=terhapus");
    exit();
}
?>
