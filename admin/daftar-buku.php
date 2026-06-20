<?php
// Letakkan di bagian paling atas file admin/daftar-buku.php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari database MySQL
$stmt = $pdo->query("SELECT * FROM buku ORDER BY id_buku DESC");
$semua_buku = $stmt->fetchAll();
?>

<tbody id="bookTableBody">
    <?php foreach($semua_buku as $buku): ?>
    <tr>
        <td>
            <div class="book-title-cell">
                <div class="book-mini-cover">
                    <img src="../assets/covers/<?= htmlspecialchars($buku['cover']) ?>" alt="Cover">
                </div>
                <div>
                    <h6><?= htmlspecialchars($buku['judul']) ?></h6>
                    <small><?= htmlspecialchars($buku['kode_buku']) ?></small>
                </div>
            </div>
        </td>
        <td><?= htmlspecialchars($buku['penulis']) ?></td>
        <td><?= htmlspecialchars($buku['kategori']) ?></td>
        <td><?= htmlspecialchars($buku['lokasi_rak']) ?></td>
        <td><?= htmlspecialchars($buku['stok']) ?></td>
        <td>
            <span class="status-badge status-<?= htmlspecialchars($buku['status']) ?>">
                <i class="fa-solid fa-circle"></i>
                <?= ucfirst($buku['status']) ?>
            </span>
        </td>
        <td>
            <div class="action-buttons">
                <a class="btn btn-light" href="tambah-buku.php?edit=<?= $buku['id_buku'] ?>" title="Edit buku">
                    <i class="fa-solid fa-pen"></i>
                </a>
                <a class="btn btn-light text-danger" href="buku_proses.php?aksi=hapus&id=<?= $buku['id_buku'] ?>" 
                   onclick="return confirm('Hapus buku ini?')" title="Hapus buku">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
