<?php

require_once "config.php";
require_once "includes/get.php";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ayarlar - HabitFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="app">

    <?php require_once "includes/sidebar.php"; ?>

    <main class="main">

        <section class="page-header">
            <h1>Ayarlar</h1>
            <p>Profil ve uygulama tercihlerini buradan yönetebilirsin.</p>
        </section>

        <div class="settings-grid">

            <div class="card">
                <div class="card-header">
                    <h3>Profil Bilgileri</h3>
                </div>

                <div class="settings-form">
                    <div class="input-group">
                        <label>Ad Soyad</label>
                        <input type="text" value="Veli Tekin">
                    </div>

                    <div class="input-group">
                        <label>E-posta</label>
                        <input type="email" value="veli@example.com">
                    </div>

                    <button class="save-btn">Kaydet</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Uygulama</h3>
                </div>

                <div class="settings-option">
                    <div>
                        <h4>Bildirimler</h4>
                        <p>Günlük alışkanlık hatırlatmaları</p>
                    </div>

                    <input type="checkbox" checked>
                </div>

                <div class="settings-option">
                    <div>
                        <h4>Koyu Tema</h4>
                        <p>Arayüzü koyu modda kullan</p>
                    </div>

                    <input type="checkbox">
                </div>
            </div>

        </div>

    </main>

</div>

</body>
</html>