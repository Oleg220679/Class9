<?php
// Задаємо заголовок сторінки.
$page_title = 'Edit article';

require('base/header.php');

// Якщо на сторінку зайшов НЕ редактор, тоді даємо у відповідь статус 403 та пишемо повідомлення.
if (!$editor) {
  header('HTTP/1.1 403 Unauthorized');
  print 'Доступ заборонено.';
  // Підключаємо футер та припиняємо роботу скрипта.
  require('base/footer.php');
  exit;
}

// Підключення БД, адже нам необхідне підключення для редагування статті.
require('base/db.php');

// Якщо ми отримали дані з ГЕТа, тоді обробляємо їх .
if (isset($_GET['id'])) {
	 try {
    $stmt = $conn->prepare('SELECT*FROM content WHERE id=:id');

       // Екрануємо теги у полях короткого та повного опису.
    $stmt->bindParam(':id', htmlspecialchars($_GET['id']), PDO::PARAM_INT);
   
      // Виконуємо запит, результат запиту знаходиться у змінній $row.
    // Якщо $row рівне TRUE, тоді запит відбувся успішно.
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC); 
    
  } catch(PDOException $e) {
    // Виводимо на екран помилку.
    print "ERROR: {$e->getMessage()}";
    // Закриваємо футер.
    require('base/footer.php');
    // Зупиняємо роботу скрипта.
    exit;
  }
}
  // Підключення БД, адже нам необхідне підключення для редагування статті.
require('base/db.php');
  //Якщо ми отримали дані з ПОСТа, тоді обробляємо їх та вставляємо.
if (isset($_POST['submit'])) {

  try {
    $stmt = $conn->prepare('UPDATE content SET id=:id, title=:title, short_desc=:short_desc, full_desc=:full_desc, timestamp=:timestamp WHERE id=:id');
   
    //Обрізаємо усі теги у загловку.
    $stmt->bindParam(':title', strip_tags($_POST['title']));

    // Екрануємо теги у полях короткого та повного опису.
    $stmt->bindParam(':id', htmlspecialchars($_GET['id']), PDO::PARAM_INT);// чомусь з ГЕТа в id завжди вертає нуль,
    // пів-дня боровся- нічого зробити не можу, відповідно редагується тільки запис з id=0.
    $stmt->bindParam(':short_desc', htmlspecialchars($_POST['short_desc']));
    $stmt->bindParam(':full_desc', htmlspecialchars($_POST['full_desc']));

    // Беремо дату та час, переводимо у UNIX час.
    $date = "{$_POST['date']}  {$_POST['time']}";
    $stmt->bindParam(':timestamp', strtotime($date));
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

  // При успішному запиту перенаправляємо користувача на сторінку перегляду статті.
  if ($status) {
    // За допомогою методу lastInsertId() ми маємо змогу отрмати ІД статті, що була вставлена.
    header("Location: article.php?id={$conn->lastInsertId()}");
    exit;
  }
  else {
    // Вивід повідомлення про невдале додавання матеріалу.
    print "Запис не був доданий.";
  }
}
?>
<!-- Пишемо форму, метод ПОСТ, форма відправляє данні на цей же скрипт. -->
<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">

  <div class="field-item">
    <label for="title">Заголовок</label>
    <input type="text" name="title" id="title" required value="<? print($row['title']); ?>" required maxlength="255">
  </div>

  <div class="field-item">
    <label for="short_desc">Короткий зміст</label>
    <input type="text" name="short_desc" size="100" id="short_desc" required value="<? print($row['short_desc']); ?>" reqiured maxlength="600">  
  </div> <!--як затягнути дані в texarea не знайшов.-->

  <div class="field-item">
    <label for="full_desc">Повний зміст</label>
    <input type="text" name="full_desc" size="100" id="full_desc" required value="<? print($row['full_desc']); ?>" required>
  </div>

  <div class="field-item">
    <label for="date">День створення</label>
    <input type="date" name="date" id="date" required value="<?php print date('Y-m-d')?>">
    <label for="time">Час створення</label>
    <input type="time" name="time" id="time" required value="<?php print date('G:i')?>">
  </div>

  <input type="submit" name="submit" value="Зберегти">

</form>
 
<?php
// Підключаємо футер сайту.
require('base/footer.php');
?>

