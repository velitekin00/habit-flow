<?php

$returnPage = $_GET["return"] ?? "habits.php";

$allowedReturns = ["index.php", "habits.php"];

if (!in_array($returnPage, $allowedReturns)) {
    $returnPage = "habits.php";
}

require_once "config.php";
require_once "includes/get.php";

$id = $_GET["id"] ?? 0;

if (!$id) {
    header("Location: " . $returnPage);
    exit;
}

$sorgu = $db->prepare("
    SELECT *
    FROM habits
    WHERE id = :id
");

$sorgu->execute([
    "id" => $id
]);

$habit = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$habit) {
    header("Location: " . $returnPage);
    exit;
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Alışkanlık Düzenle - HabitFlow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="app">

    <?php require_once "includes/sidebar.php"; ?>

    <main class="main">

        <section class="page-header">
            <h1>Alışkanlık Düzenle</h1>
            <p>Seçili alışkanlığın bilgilerini buradan güncelleyebilirsin.</p>
        </section>

        <div class="card edit-card">

            <div class="card-header">
                <h3><?= htmlspecialchars($habit["title"]) ?></h3>

                <a href="<?= htmlspecialchars($returnPage) ?>" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    Geri Dön
                </a>
            </div>

            <form action="actions/update.php" method="POST" class="edit-form">

                <input type="hidden" name="id" value="<?= $habit['id'] ?>">
                <input type="hidden" name="return" value="<?= htmlspecialchars($returnPage) ?>">

                <div class="input-group">
                    <label>Görev Adı</label>
                    <input 
                        type="text" 
                        name="title"
                        value="<?= htmlspecialchars($habit["title"]) ?>"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Açıklama</label>
                    <input 
                        type="text" 
                        name="description"
                        value="<?= htmlspecialchars($habit["description"]) ?>"
                    >
                </div>

                <div class="input-group">
                    <label>Kategori</label>

                    <select name="category">
                        <option value="İş" <?= $habit["category"] == "İş" ? "selected" : "" ?>>İş</option>
                        <option value="Kişisel" <?= $habit["category"] == "Kişisel" ? "selected" : "" ?>>Kişisel</option>
                        <option value="Sağlık" <?= $habit["category"] == "Sağlık" ? "selected" : "" ?>>Sağlık</option>
                        <option value="Spor" <?= $habit["category"] == "Spor" ? "selected" : "" ?>>Spor</option>
                        <option value="Eğitim" <?= $habit["category"] == "Eğitim" ? "selected" : "" ?>>Eğitim</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Hedef</label>
                    <input 
                        type="number" 
                        name="target_value"
                        value="<?= htmlspecialchars($habit["target_value"]) ?>"
                        min="1"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Birim</label>

                    <select name="unit">
                        <option value="gün" <?= $habit["unit"] == "gün" ? "selected" : "" ?>>gün</option>
                        <option value="bardak" <?= $habit["unit"] == "bardak" ? "selected" : "" ?>>bardak</option>
                        <option value="sayfa" <?= $habit["unit"] == "sayfa" ? "selected" : "" ?>>sayfa</option>
                        <option value="dk" <?= $habit["unit"] == "dk" ? "selected" : "" ?>>dk</option>
                        <option value="saat" <?= $habit["unit"] == "saat" ? "selected" : "" ?>>saat</option>
                        <option value="adet" <?= $habit["unit"] == "adet" ? "selected" : "" ?>>adet</option>
                    </select>
                </div>

                <div class="edit-form-actions">
                    <a href="<?= htmlspecialchars($returnPage) ?>" class="cancel-btn">
                        Vazgeç
                    </a>

                    <button type="submit" class="save-btn">
                        <i class="bi bi-check-lg"></i>
                        Kaydet
                    </button>
                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>