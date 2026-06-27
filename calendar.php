<?php

require_once "config.php";
require_once "includes/get.php";
require_once "includes/get_calendar.php";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Takvim - HabitFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="app">

    <?php require_once "includes/sidebar.php"; ?>

    <main class="main">

        <section class="page-header">
            <h1>Takvim</h1>
            <p>Aylık alışkanlık tamamlama durumunu buradan takip edebilirsin.</p>
        </section>

        <div class="card calendar-page-card">

            <div class="card-header">
                <h3><?= $calendarTitle ?></h3>

                <div class="calendar-buttons">
                    <a href="calendar.php?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">
                        <i class="bi bi-chevron-left"></i>
                    </a>

                    <a href="calendar.php?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            <div class="calendar-large">

                <span>Pzt</span>
                <span>Sal</span>
                <span>Çar</span>
                <span>Per</span>
                <span>Cum</span>
                <span>Cmt</span>
                <span>Paz</span>

                <?php foreach ($calendarDays as $calendarDay): ?>

                    <div class="calendar-day <?= $calendarDay['status'] ?>">
                        <strong><?= $calendarDay["day"] ?></strong>
                        <small>
                            <?= $calendarDay['completed'] ?> / <?= $calendarDay['total'] ?>
                        </small>
                    </div>

                <?php endforeach; ?>

            </div>

            <div class="calendar-legend">
                <span><i class="done-dot"></i> Tamamlandı</span>
                <span><i class="partial-dot"></i> Kısmi</span>
                <span><i class="empty-dot"></i> Yok</span>
            </div>

        </div>

    </main>

</div>

</body>
</html>