<?php
require_once "../config.php";

$habit_id = $_POST["id"] ?? 0;
$today = date("Y-m-d");

if (!$habit_id) {
    echo json_encode([
        "success" => false,
        "message" => "ID bulunamadı"
    ]);
    exit;
}

/*
    Bugünkü log var mı?
*/

$sorgu = $db->prepare("
    SELECT *
    FROM habit_logs
    WHERE habit_id = :habit_id
    AND log_date = :log_date
");

$sorgu->execute([
    "habit_id" => $habit_id,
    "log_date" => $today
]);

$log = $sorgu->fetch(PDO::FETCH_ASSOC);

/*
    Log yoksa oluştur.
    Varsa durumunu tersine çevir.
*/

if (!$log) {

    $isCompleted = 1;

    $ekle = $db->prepare("
        INSERT INTO habit_logs 
        (habit_id, log_date, current_value, is_completed)
        VALUES 
        (:habit_id, :log_date, :current_value, :is_completed)
    ");

    $ekle->execute([
        "habit_id" => $habit_id,
        "log_date" => $today,
        "current_value" => 1,
        "is_completed" => 1
    ]);

} else {

    $isCompleted = $log["is_completed"] ? 0 : 1;

    $guncelle = $db->prepare("
        UPDATE habit_logs
        SET is_completed = :is_completed,
            current_value = :current_value
        WHERE id = :id
    ");

    $guncelle->execute([
        "is_completed" => $isCompleted,
        "current_value" => $isCompleted ? 1 : 0,
        "id" => $log["id"]
    ]);
}

/*
    Güncel habit bilgisini çek
*/

$habitQuery = $db->prepare("
    SELECT *
    FROM habits
    WHERE id = :id
");

$habitQuery->execute([
    "id" => $habit_id
]);

$habit = $habitQuery->fetch(PDO::FETCH_ASSOC);

/*
    Günlük istatistikleri tekrar hesapla
*/

$totalHabits = (int) $db
    ->query("SELECT COUNT(*) FROM habits")
    ->fetchColumn();

$completedQuery = $db->prepare("
    SELECT COUNT(DISTINCT habit_id)
    FROM habit_logs
    WHERE log_date = :today
    AND is_completed = 1
");

$completedQuery->execute([
    "today" => $today
]);

$completedHabits = (int) $completedQuery->fetchColumn();

$completionRate = $totalHabits > 0
    ? round(($completedHabits / $totalHabits) * 100)
    : 0;

/*
    JSON cevap dön
*/

header("Content-Type: application/json");

echo json_encode([
    "success" => true,
    "habit_id" => $habit_id,
    "is_completed" => $isCompleted,
    "target_value" => $habit["target_value"],
    "unit" => $habit["unit"],
    "completedHabits" => $completedHabits,
    "totalHabits" => $totalHabits,
    "completionRate" => $completionRate
]);

exit;