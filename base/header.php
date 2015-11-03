<?php
// Початок буферу.
ob_start();
// Початок або продовження сесії.
session_start();
// Створюємо змінну $editor, у якій міститься інформація про роль користувача на сайті.
$editor = (bool) $_SESSION['login'];

// Якщо раніше заголовок сторінки не був заданий, тоді ми його задаємо.
if (!isset($page_title)) {
  $page_title = 'Blog site';
}

?>
<!-- Виводимо основну структуру сайту. -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print $page_title; ?></title>
  <link rel="stylesheet" href="default.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
</head>
<body>
<!-- Будуємо меню сайту. -->
<div class="header" style="width:70%;margin:0 auto;border:1px solid black;">
  <ul class="main-menu">
    <li><a href="/">Головна сторінка<a></li>
    <?php if ($editor): ?>
      <li><a href="/add.php">Додати статтю<a></li>
      <li><a href="/logout.php">Вихід<a></li>
    <?php endif; ?>
    <?php if (!$editor): ?>
      <li><a href="/login.php">Вхід<a></li>
    <?php endif; ?>
  </ul>
</div>
<!-- Вітальне повідомленя на головній сторінці. -->
<h1 class="hello"> Welcome to blog site!</h1>
