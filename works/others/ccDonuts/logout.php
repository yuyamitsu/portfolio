<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|ログアウト確認</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem breadcrumbCurrent">ログアウト</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>
  <main>
    <div class="innerWrap">
      <h1 class="h1Text">ログアウト</h1>
      <div class="logOutDisplay">
        <a href="logOutComplete.php" class="submitButton">ログアウトする</a>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="index.php">TOPページへもどる</a></li>
        </ul>
      </nav>
    </div>

  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>