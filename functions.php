<?php
// Baca data JSON
function readData($filename) {
    if (!file_exists($filename)) {
        return [];
    }
    $data = file_get_contents($filename);
    return json_decode($data, true) ?? [];
}

// Tulis data JSON
function writeData($filename, $data) {
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}

// Urutkan jadwal berdasarkan hari dan jam
function sortJadwal(&$jadwal) {
    usort($jadwal, function($a, $b) {
        $hariOrder = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
        if ($a['hari'] == $b['hari']) {
            return strcmp($a['jam'], $b['jam']);
        }
        return array_search($a['hari'], $hariOrder) - array_search($b['hari'], $hariOrder);
    });
}

// Hitung total SKS
function totalSKS($jadwal) {
    $total = 0;
    foreach ($jadwal as $item) {
        $total += (int)$item['sks'];
    }
    return $total;
}

// Cek tugas yang mendekati deadline (< 2 hari lagi)
function tugasMendekatiDeadline($tugas) {
    $alerts = [];
    $now = strtotime(date("Y-m-d"));
    foreach ($tugas as $t) {
        $deadline = strtotime($t['deadline']);
        if ($deadline - $now <= 2 * 24 * 60 * 60 && $t['status'] == "Belum Selesai") {
            $alerts[] = $t;
        }
    }
    return $alerts;
}
?>
