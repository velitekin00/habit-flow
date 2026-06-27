<?php

$currentStreak = 0;

/*
    Toplam alışkanlık sayısı
*/

$totalHabitsQuery = $db->query("
    SELECT COUNT(*) 
    FROM habits
");

$totalHabits = (int) $totalHabitsQuery->fetchColumn();

/*
    Hiç alışkanlık yoksa seri 0 olur
*/

if ($totalHabits > 0) {

    /*
        Bugünden geriye doğru kontrol ediyoruz.
        365 gün sınır koyduk, sonsuz döngü olmasın.
    */

    for ($i = 0; $i < 365; $i++) {

        $date = date("Y-m-d", strtotime("-$i days"));

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

        /*
            O gün tüm alışkanlıklar tamamlandıysa seri artar.
            Eksik varsa seri durur.
        */

        if ($completedCount >= $totalHabits) {
            $currentStreak++;
        } else {
            break;
        }
    }
}