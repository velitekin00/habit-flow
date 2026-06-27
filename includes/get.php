<?php

$today = date("Y-m-d");

$sorgu = $db->prepare("
    SELECT 
        habits.*,
        COALESCE(habit_logs.is_completed, 0) AS is_completed,
        COALESCE(habit_logs.current_value, 0) AS current_value
    FROM habits
    LEFT JOIN habit_logs 
        ON habits.id = habit_logs.habit_id
        AND habit_logs.log_date = :today
    ORDER BY habits.id DESC
");

$sorgu->execute([
    "today" => $today
]);

$habits = $sorgu->fetchAll(PDO::FETCH_ASSOC);

$totalHabits = count($habits);

$completedHabits = 0;

foreach ($habits as $habit) {
    if ($habit["is_completed"]) {
        $completedHabits++;
    }
}

$completionRate = $totalHabits > 0
    ? round(($completedHabits / $totalHabits) * 100)
    : 0;