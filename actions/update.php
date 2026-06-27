<?php

require_once "../config.php";

$id = $_POST["id"] ?? 0;
$title = $_POST["title"] ?? "";
$description = $_POST["description"] ?? "";
$category = $_POST["category"] ?? "";
$target_value = $_POST["target_value"] ?? 1;
$unit = $_POST["unit"] ?? "gün";

$allowedReturns = ["index.php", "habits.php"];
$returnPage = $_POST["return"] ?? "habits.php";

if (!in_array($returnPage, $allowedReturns)) {
    $returnPage = "habits.php";
}

if (!$id || $title == "") {
    header("Location: ../" . $returnPage);
    exit;
}

$guncelle = $db->prepare("
    UPDATE habits
    SET 
        title = :title,
        description = :description,
        category = :category,
        target_value = :target_value,
        unit = :unit
    WHERE id = :id
");

$guncelle->execute([
    "title" => $title,
    "description" => $description,
    "category" => $category,
    "target_value" => $target_value,
    "unit" => $unit,
    "id" => $id
]);

header("Location: ../" . $returnPage);
exit;