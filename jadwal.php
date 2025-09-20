<?php
require 'functions.php';

// Baca data utama
$data = readData();
$jadwal = $data['jadwal'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newData = [
        "mata_kuliah" => $_POST['mata_kuliah'],
        "hari" => $_POST['hari'],
        "jam" => $_POST['jam'],
        "ruangan" => $_POST['ruangan'],
        "dosen" => $_POST['dosen'],
        "sks" => $_POST['sks']
    ];

    // Tambahkan data baru
    $jadwal[] = $newData;

    // Urutkan jadwal berdasarkan hari dan jam
    sortJadwal($jadwal);

    // Update kembali ke array utama
    $data['jadwal'] = $jadwal;
    writeData($data);

    // Refresh halaman agar tidak double submit
    header("Location: jadwal.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Jadwal Kuliah</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Kelola Jadwal Kuliah</h1>

    <!-- Form Tambah Jadwal -->
    <form method="POST">
        <input type="text" name="mata_kuliah" placeholder="Mata Kuliah" required>
        <select name="hari" required>
            <option>Senin</option>
            <option>Selasa</option>
            <option>Rabu</option>
            <option>Kamis</option>
            <option>Jumat</option>
            <option>Sabtu</option>
            <option>Minggu</option>
        </select>
        <input type="time" name="jam" required>
        <input type="text" name="ruangan" placeholder="Ruangan" required>
        <input type="text" name="dosen" placeholder="Dosen" required>
        <input type="number" name="sks" placeholder="SKS" required>
        <button type="submit">Tambah</button>
    </form>

    <h2>Daftar Jadwal</h2>
    <?php if (count($jadwal) === 0): ?>
        <p>Belum ada data jadwal.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Kuliah</th>
                <th>Ruangan</th>
                <th>Dosen</th>
                <th>SKS</th>
            </tr>
            <?php foreach ($jadwal as $j): ?>
                <tr>
                    <td><?= htmlspecialchars($j['hari']) ?></td>
                    <td><?= htmlspecialchars($j['jam']) ?></td>
                    <td><?= htmlspecialchars($j['mata_kuliah']) ?></td>
                    <td><?= htmlspecialchars($j['ruangan']) ?></td>
                    <td><?= htmlspecialchars($j['dosen']) ?></td>
                    <td><?= htmlspecialchars($j['sks']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <footer>
        <a href="index.php">Kembali ke Dashboard</a>
    </footer>
</body>
</html>
