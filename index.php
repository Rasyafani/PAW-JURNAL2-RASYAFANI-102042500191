<?php
require 'functions.php';
require 'connect.php';

// TODO 1 (RINGKASAN)
// Hitung jumlah baris di tabel mata_kuliah, materi, dan tugas,
// lalu hitung juga tugas yang statusnya 'Aktif'.
// Simpan hasilnya ke empat variabel di bawah ini (gunakan COUNT, bukan mengambil semua baris).

$jumlah_mata_kuliah = 0;
$jumlah_materi      = 0;
$jumlah_tugas       = 0;
$jumlah_tugas_aktif = 0;

$sql_ringkasan = [
    'mata_kuliah' => "SELECT COUNT(*) AS total FROM mata_kuliah",
    'materi'      => "SELECT COUNT(*) AS total FROM materi",
    'tugas'       => "SELECT COUNT(*) AS total FROM tugas",
    'tugas_aktif' => "SELECT COUNT(*) AS total FROM tugas WHERE status = 'Aktif'"
];

foreach ($sql_ringkasan as $jenis => $sql) {
    $hasil = $conn->query($sql);

    if ($hasil) {
        $baris = $hasil->fetch_assoc();
        $total = (int) $baris['total'];

        switch ($jenis) {
            case 'mata_kuliah':
                $jumlah_mata_kuliah = $total;
                break;
            case 'materi':
                $jumlah_materi = $total;
                break;
            case 'tugas':
                $jumlah_tugas = $total;
                break;
            case 'tugas_aktif':
                $jumlah_tugas_aktif = $total;
                break;
        }

        $hasil->free();
    }
}


$pilihan_mk = pilihan_mata_kuliah($conn);

$judul = 'Beranda';
require 'header.php';
?>
<p class="eyebrow">Learning Management System</p>
<h1 class="hero">Kelola perkuliahan dalam satu tempat.</h1>
<p class="muted">Pengelolaan mata kuliah, materi pembelajaran, dan tugas.</p>

<div class="stats">
    <a class="card stat" href="mata_kuliah.php">
        <b><?= (int) $jumlah_mata_kuliah ?></b>
        <span>Mata kuliah</span>
    </a>
    <a class="card stat" href="materi.php">
        <b><?= (int) $jumlah_materi ?></b>
        <span>Materi</span>
    </a>
    <a class="card stat" href="tugas.php">
        <b><?= (int) $jumlah_tugas ?></b>
        <span>Tugas</span>
    </a>
    <a class="card stat" href="tugas.php?status=Aktif">
        <b><?= (int) $jumlah_tugas_aktif ?></b>
        <span>Tugas aktif</span>
    </a>
</div>

<h2>Mata kuliah tersedia</h2>
<?php if (count($pilihan_mk) === 0): ?>
    <p class="empty">Belum ada mata kuliah.</p>
<?php else: ?>
    <div class="card list">
        <?php foreach ($pilihan_mk as $id => $nama): ?>
            <a class="list-item" href="mata_kuliah.php?aksi=detail&id=<?= (int) $id ?>"><?= h($nama) ?></a>
        <?php endforeach ?>
    </div>
<?php endif ?>
<?php require 'footer.php'; ?>
