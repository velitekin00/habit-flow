<?php

$calendarDays = [];

$selectedMonth = $_GET["month"] ?? date("m");
$selectedYear = $_GET["year"] ?? date("Y");

$selectedMonth = (int) $selectedMonth;
$selectedYear = (int) $selectedYear;

/*
    Ay sınır kontrolü
*/

if ($selectedMonth < 1) {
    $selectedMonth = 12;
    $selectedYear--;
}

if ($selectedMonth > 12) {
    $selectedMonth = 1;
    $selectedYear++;
}

/*
    Önceki / sonraki ay linkleri için
*/

$prevMonth = $selectedMonth - 1;
$prevYear = $selectedYear;

if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;
}

$nextMonth = $selectedMonth + 1;
$nextYear = $selectedYear;

if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;
}

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);

$totalHabitsQuery = $db->query("
    SELECT COUNT(*) 
    FROM habits
");

$totalHabits = (int) $totalHabitsQuery->fetchColumn();

for ($day = 1; $day <= $daysInMonth; $day++) {

    $date = sprintf("%04d-%02d-%02d", $selectedYear, $selectedMonth, $day);

    $completedQuery = $db->prepare("
        SELECT COUNT(DISTINCT habit_id)
        FROM habit_logs
        WHERE log_date = :log_date
        AND is_completed = 1
    ");

    $completedQuery->execute([
        "log_date" => $date
    ]);

    $completedCount = (int) $completedQuery->fetchColumn();

    if ($totalHabits == 0 || $completedCount == 0) {
        $status = "empty";
    } elseif ($completedCount < $totalHabits) {
        $status = "partial";
    } else {
        $status = "done";
    }

    $calendarDays[] = [
        "day" => $day,
        "date" => $date,
        "status" => $status,
        "completed" => $completedCount,
        "total" => $totalHabits
    ];
}

/*
    Türkçe ay adları
*/

$monthNames = [
    1 => "Ocak",
    2 => "Şubat",
    3 => "Mart",
    4 => "Nisan",
    5 => "Mayıs",
    6 => "Haziran",
    7 => "Temmuz",
    8 => "Ağustos",
    9 => "Eylül",
    10 => "Ekim",
    11 => "Kasım",
    12 => "Aralık"
];

$calendarTitle = $monthNames[$selectedMonth] . " " . $selectedYear;