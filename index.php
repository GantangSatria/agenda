<?php
require 'functions.php';

// Ambil semua data dari file serialized
$data = readData();
$jadwal = $data['jadwal'];
$tugas = $data['tugas'];

// Filter jadwal hari ini
$hariIni = date("l");
$hariMap = [
    "Monday" => "Senin",
    "Tuesday" => "Selasa",
    "Wednesday" => "Rabu",
    "Thursday" => "Kamis",
    "Friday" => "Jumat",
    "Saturday" => "Sabtu",
    "Sunday" => "Minggu"
];
$jadwalHariIni = array_filter($jadwal, fn($j) => $j['hari'] === $hariMap[$hariIni]);

// Filter tugas belum selesai
$tugasBelum = array_filter($tugas, fn($t) => $t['status'] === "Belum Selesai");

// Tugas yang mendekati deadline
$alerts = tugasMendekatiDeadline($tugas);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agenda Digital Mahasiswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Dashboard Agenda Mahasiswa</h1>

    <!-- Alert tugas mendekati deadline -->
    <?php if (count($alerts) > 0): ?>
        <div class="alert">
            <strong>⚠ Peringatan:</strong> Ada tugas yang mendekati deadline!
            <ul>
                <?php foreach ($alerts as $a): ?>
                    <li><?= htmlspecialchars($a['nama']) ?> - Deadline: <?= htmlspecialchars($a['deadline']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <section>
        <h2>Jadwal Hari Ini (<?= $hariMap[$hariIni] ?>)</h2>
        <?php if (count($jadwalHariIni) == 0): ?>
            <p>Tidak ada jadwal untuk hari ini.</p>
        <?php else: ?>
            <table>
                <tr><th>Jam</th><th>Mata Kuliah</th><th>Ruangan</th><th>Dosen</th></tr>
                <?php foreach ($jadwalHariIni as $j): ?>
                    <tr>
                        <td><?= htmlspecialchars($j['jam']) ?></td>
                        <td><?= htmlspecialchars($j['mata_kuliah']) ?></td>
                        <td><?= htmlspecialchars($j['ruangan']) ?></td>
                        <td><?= htmlspecialchars($j['dosen']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </section>

    <section>
        <h2>Tugas Belum Selesai</h2>
        <?php if (count($tugasBelum) == 0): ?>
            <p>Tidak ada tugas yang belum selesai.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tugasBelum as $t): ?>
                    <li><?= htmlspecialchars($t['nama']) ?> - <?= htmlspecialchars($t['mata_kuliah']) ?> (Deadline: <?= htmlspecialchars($t['deadline']) ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <section>
        <h2>Total SKS: <?= totalSKS($jadwal) ?></h2>
    </section>

    <footer>
        <a href="jadwal.php">Kelola Jadwal</a> | <a href="tugas.php">Kelola Tugas</a>
    </footer>
</body>
</html>
