<?php
define('DATA_FILE', __DIR__ . '/data.txt');

function readData() {
    if (!file_exists(DATA_FILE)) {
        return ['jadwal' => [], 'tugas' => []];
    }
    return unserialize(file_get_contents(DATA_FILE));
}

function writeData($data) {
    file_put_contents(DATA_FILE, serialize($data));
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
