<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";
require_once "includes/get.php";
require_once "includes/get_weekly_stats.php";
require_once "includes/get_calendar.php";
require_once "includes/get_streak.php";

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>HabitFlow Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="app">

    <?php require_once "includes/sidebar.php"; ?>

    <main class="main">

        <!-- Topbar -->
        <header class="topbar">
            <div></div>

            <div class="user-area">
                <i class="bi bi-bell"></i>
                <img src="images/vt.png" alt="Profil">
                <span>Veli Tekin</span>
                <i class="bi bi-chevron-down"></i>
            </div>
        </header>

        <!-- Welcome -->
        <section class="welcome">
            <h1>İyi Günler, Veli</h1>
            <p>Bugünkü alışkanlıklarını takip et.</p>
        </section>

        <!-- Add Task -->
        <form class="add-task-card" action="actions/add.php" method="POST">

            <div class="input-group">
                <label>Görev Adı</label>
                <input 
                    type="text" 
                    name="title"
                    placeholder="Örn: Su iç"
                    required
                >
            </div>

            <div class="input-group">
                <label>Açıklama</label>
                <input 
                    type="text" 
                    name="description"
                    placeholder="Örn: Günde 8 bardak"
                >
            </div>

            <div class="input-group">
                <label>Kategori</label>
                <select name="category">
                    <option value="İş">İş</option>
                    <option value="Kişisel">Kişisel</option>
                    <option value="Sağlık">Sağlık</option>
                    <option value="Spor">Spor</option>
                    <option value="Eğitim">Eğitim</option>
                </select>
            </div>

            <div class="input-group">
                <label>Hedef</label>
                <input 
                    type="number" 
                    name="target_value"
                    value="1"
                    min="1"
                    required
                >
            </div>

            <div class="input-group">
                <label>Birim</label>
                <select name="unit">
                    <option value="gün">gün</option>
                    <option value="bardak">bardak</option>
                    <option value="sayfa">sayfa</option>
                    <option value="dk">dk</option>
                    <option value="saat">saat</option>
                    <option value="adet">adet</option>
                </select>
            </div>

            <button type="submit">Hızlı Ekle</button>

        </form>

        <!-- Stats -->
        <section class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div>
                    <p>Günlük Tamamlama</p>
                    <h2 id="dailyRate">%<?= $completionRate ?></h2>

                    <div class="progress">
                        <span id="dailyProgressBar" style="width: <?= $completionRate ?>%;"></span>
                    </div>

                    <small id="dailyCompletedText">
                        <?= $completedHabits ?> / <?= $totalHabits ?> tamamlandı
                    </small>
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

        <!-- Content Grid -->
        <section class="content-grid">

            <!-- Today's Habits -->
            <div class="card habits-card">

                <div class="card-header">
                    <h3>Bugünün Alışkanlıkları</h3>
                </div>

                <div class="habit-list">

                    <?php foreach ($habits as $habit): ?>

                        <div class="habit-item" data-habit-id="<?= $habit['id'] ?>">

                            <form class="ajax-toggle-form" action="actions/toggle.php" method="POST">
                                <input 
                                    type="hidden" 
                                    name="id" 
                                    value="<?= $habit['id'] ?>"
                                >

                                <button 
                                    type="submit"
                                    class="check-btn <?= $habit['is_completed'] ? 'active' : '' ?>"
                                >
                                    ✓
                                </button>
                            </form>

                            <div class="habit-info">
                                <h4><?= htmlspecialchars($habit["title"] ?? "Başlıksız görev") ?></h4>
                                <p><?= htmlspecialchars($habit["description"] ?? "") ?></p>
                            </div>

                            <div class="habit-progress">
                                <span class="habit-progress-text">
                                    <?= $habit['is_completed'] ? $habit["target_value"] : 0 ?>
                                    /
                                    <?= $habit["target_value"] ?>
                                    <?= htmlspecialchars($habit["unit"]) ?>
                                </span>

                                <div class="progress small">
                                    <span 
                                        class="habit-progress-bar"
                                        style="width: <?= $habit['is_completed'] ? '100' : '0' ?>%;"
                                    ></span>
                                </div>
                            </div>

                            <div class="habit-actions">

                                <a href="edit.php?id=<?= $habit['id'] ?>&return=index.php" class="edit-btn">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form 
                                    action="actions/delete.php" 
                                    method="POST"
                                    onsubmit="return confirm('Bu alışkanlığı silmek istediğine emin misin?');"
                                >
                                    <input type="hidden" name="id" value="<?= $habit['id'] ?>">

                                    <button type="submit" class="delete-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

                <a href="habits.php" class="see-all">
                    Tümünü Gör <i class="bi bi-chevron-right"></i>
                </a>

            </div>

            <!-- Chart -->
            <div class="card chart-card">

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

            <!-- Calendar -->
            <div class="card calendar-card">

                <div class="card-header">
                    <h3><?= $calendarTitle ?></h3>

                    <div class="calendar-buttons">
                        <a href="index.php?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>

                        <a href="index.php?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <div class="calendar-mini">

                    <span>Pzt</span>
                    <span>Sal</span>
                    <span>Çar</span>
                    <span>Per</span>
                    <span>Cum</span>
                    <span>Cmt</span>
                    <span>Paz</span>

                    <?php foreach ($calendarDays as $calendarDay): ?>

                        <button 
                            class="<?= $calendarDay['status'] ?>"
                            title="<?= $calendarDay['completed'] ?> / <?= $calendarDay['total'] ?> tamamlandı"
                        >
                            <?= $calendarDay["day"] ?>
                        </button>

                    <?php endforeach; ?>

                </div>

                <div class="calendar-legend">
                    <span><i class="done-dot"></i> Tamamlandı</span>
                    <span><i class="partial-dot"></i> Kısmi</span>
                    <span><i class="empty-dot"></i> Yok</span>
                </div>

            </div>

        </section>

    </main>

</div>

<script>
    const weeklyLabels = <?= json_encode($weeklyLabels ?? []) ?>;
    const weeklyRates = <?= json_encode($weeklyRates ?? []) ?>;
</script>

<script src="assets/js/app.js?v=<?= time() ?>"></script>

</body>
</html>