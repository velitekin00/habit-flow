<?php

require_once "config.php";
require_once "includes/get.php";
require_once "includes/get_weekly_stats.php";
require_once "includes/get_streak.php";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İstatistikler - HabitFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="app">

    <?php require_once "includes/sidebar.php"; ?>

    <main class="main">

        <section class="page-header">
            <h1>İstatistikler</h1>
            <p>Alışkanlık performansını grafiklerle incele.</p>
        </section>

        <section class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div>
                    <p>Günlük Tamamlama</p>
                    <h2>%<?= $completionRate ?></h2>

                    <div class="progress">
                        <span style="width: <?= $completionRate ?>%;"></span>
                    </div>

                    <small><?= $completedHabits ?> / <?= $totalHabits ?> tamamlandı</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-fire"></i>
                </div>

                <div>
                    <p>Seri</p>
                    <h2><?= $currentStreak ?> <span>gün</span></h2>
                    <small class="green-text">Üst üste tamamlanan gün</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-list-ul"></i>
                </div>

                <div>
                    <p>Toplam Görev</p>
                    <h2><?= $totalHabits ?></h2>
                    <small>Aktif alışkanlık</small>
                </div>
            </div>

        </section>

        <div class="card chart-card stats-chart-card">

            <div class="card-header">
                <h3>Haftalık İlerleme</h3>
                <select>
                    <option>Son 7 Gün</option>
                </select>
            </div>

            <div class="chart-box">
                <canvas id="weeklyChart"></canvas>
            </div>

        </div>

    </main>

</div>

<script>
    const weeklyLabels = <?= json_encode($weeklyLabels) ?>;
    const weeklyRates = <?= json_encode($weeklyRates) ?>;
</script>

<script src="assets/js/app.js"></script>

</body>
</html>