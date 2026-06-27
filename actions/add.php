<?php
require_once "../config.php";

$title = $_POST["title"] ?? "";
$description = $_POST["description"] ?? "";
$category = $_POST["category"] ?? "";
$target_value = $_POST["target_value"] ?? 1;
$unit = $_POST["unit"] ?? "gün";

if ($title == "") {
    header("Location: ../index.php");
    exit;
}

$ekle = $db->prepare("
    INSERT INTO habits 
    (user_id, title, description, category, target_value, unit)
    VALUES 
    (:user_id, :title, :description, :category, :target_value, :unit)
");

$ekle->execute([
    "user_id" => 1,
    "title" => $title,
    "description" => $description,
    "category" => $category,
    "target_value" => $target_value,
    "unit" => $unit
]);

header("Location: ../index.php");
exit;