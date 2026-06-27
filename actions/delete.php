<?php

require_once "../config.php";

$id = $_POST["id"] ?? 0;

if (!$id) {
    header("Location: ../index.php");
    exit;
}

/*
    Önce bu alışkanlığa ait günlük logları sil.
    Sonra alışkanlığın kendisini sil.
*/

$logSil = $db->prepare("
    DELETE FROM habit_logs
    WHERE habit_id = :id
");

$logSil->execute([
    "id" => $id
]);

$sil = $db->prepare("
    DELETE FROM habits
    WHERE id = :id
");

$sil->execute([
    "id" => $id
]);

header("Location: ../index.php");
exit;