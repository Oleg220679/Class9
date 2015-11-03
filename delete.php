<?php
// Задаємо заголовок сторінки.
$page_title = 'Delete article';

require('base/header.php');

// Якщо на сторінку зайшов НЕ редактор, тоді даємо у відповідь статус 403 та пишемо повідомлення.
if (!$editor) {
  header('HTTP/1.1 403 Unauthorized');
  print 'Доступ заборонено.';
  // Підключаємо футер та припиняємо роботу скрипта.
  require('base/footer.php');
  exit;
}

// Підключення БД, адже нам необхідне підключення для видалення статті.
require('base/db.php');

// Якщо ми отримали дані з ГЕТа, тоді обробляємо їх .
if (isset($_GET['id'])) {
	 try {
    $stmt = $conn->prepare('DELETE FROM content WHERE id=:id');

       // Екрануємо теги у полях короткого та повного опису.
    $stmt->bindParam(':id', htmlspecialchars($_GET['id']));
   
      // Виконуємо запит, результат запиту знаходиться у змінній $status.
    // Якщо $status рівне TRUE, тоді запит відбувся успішно.
    $status = $stmt->execute();

  } catch(PDOException $e) {
    // Виводимо на екран помилку.
    print "ERROR: {$e->getMessage()}";
    // Закриваємо футер.
    require('base/footer.php');
    // Зупиняємо роботу скрипта.
    exit;
  }

  // При успішному запиті повідомляємо про вдале видалення.
  if ($status) {
    print 'Запис успішно видалений';
    exit;
  }
  else {
    // Вивід повідомлення про невдале додавання матеріалу.
    print "Запис не був видалений.";
  }
}
?>

<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>

