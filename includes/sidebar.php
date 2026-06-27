<?php
$currentPage = basename($_SERVER["PHP_SELF"]);
?>

<aside class="sidebar">

    <div class="logo">
        <div class="logo-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <div>
            <h2>HabitFlow</h2>
            <p>Alışkanlıklarını Yönet</p>
        </div>
    </div>

    <nav class="menu">

        <a href="index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">
            <i class="bi bi-grid"></i>
            Dashboard
        </a>

        <a href="habits.php" class="<?= $currentPage == 'habits.php' ? 'active' : '' ?>">
            <i class="bi bi-list-check"></i>
            Alışkanlıklar
        </a>

        <a href="calendar.php" class="<?= $currentPage == 'calendar.php' ? 'active' : '' ?>">
            <i class="bi bi-calendar3"></i>
            Takvim
        </a>

        <a href="stats.php" class="<?= $currentPage == 'stats.php' ? 'active' : '' ?>">
            <i class="bi bi-bar-chart"></i>
            İstatistikler
        </a>

        <a href="settings.php" class="<?= $currentPage == 'settings.php' ? 'active' : '' ?>">
            <i class="bi bi-gear"></i>
            Ayarlar
        </a>

    </nav>
    <div class="sidebar-summary">
    <p>Bugün</p>
    <h3><?= $completedHabits ?? 0 ?> / <?= $totalHabits ?? 0 ?></h3>
    <span>tamamlandı</span>
    </div>

</aside>