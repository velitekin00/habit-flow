<?php

$weeklyLabels = [];
$weeklyRates = [];

$dayNames = [
    "Monday" => "Pzt",
    "Tuesday" => "Salı",
    "Wednesday" => "Çar",
    "Thursday" => "Per",
    "Friday" => "Cum",
    "Saturday" => "Cmt",
    "Sunday" => "Paz"
];

for ($i = 6; $i >= 0; $i--) {

    $date = date("Y-m-d", strtotime("-$i days"));
    $dayName = date("l", strtotime($date));

    $weeklyLabels[] = $dayNames[$dayName];

    $totalQuery = $db->query("
        SELECT COUNT(*) 
        FROM habits
    ");

    $totalHabitsForDay = (int) $totalQuery->fetchColumn();

    $completedQuery = $db->prepare("
        SELECT COUNT(DISTINCT habit_id)
        FROM habit_logs
        WHERE log_date = :log_date
        AND is_completed = 1
    ");

    $completedQuery->execute([
        "log_date" => $date
    ]);

    $completedForDay = (int) $completedQuery->fetchColumn();

    $rate = $totalHabitsForDay > 0
        ? round(($completedForDay / $totalHabitsForDay) * 100)
        : 0;

    $weeklyRates[] = min($rate, 100);
}