<?php

require_once "config.php";
require_once "includes/get.php";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Alışkanlıklar - HabitFlow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="app">

    <?php require_once "includes/sidebar.php"; ?>

    <main class="main">

        <section class="page-header">
            <h1>Alışkanlıklar</h1>
            <p>Tüm alışkanlıklarını buradan yönetebilirsin.</p>
        </section>

        <div class="card">

            <div class="card-header">
                <h3>Tüm Alışkanlıklar</h3>
                <span><?= $totalHabits ?> alışkanlık</span>
            </div>

            <div class="habit-list">

                <?php foreach ($habits as $habit): ?>

                    <div class="habit-item" data-habit-id="<?= $habit['id'] ?>">

                        <form class="ajax-toggle-form" action="actions/toggle.php" method="POST">
                            <input type="hidden" name="id" value="<?= $habit['id'] ?>">

                            <button 
                                type="submit"
                                class="check-btn <?= $habit['is_completed'] ? 'active' : '' ?>"
                            >
                                ✓
                            </button>
                        </form>

                        <div class="habit-info">
                            <h4><?= htmlspecialchars($habit["title"]) ?></h4>
                            <p><?= htmlspecialchars($habit["description"]) ?></p>
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

                            <a href="edit.php?id=<?= $habit['id'] ?>&return=habits.php" class="edit-btn">
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

        </div>

    </main>

</div>

<script src="assets/js/app.js?v=<?= time() ?>"></script>

</body>
</html>