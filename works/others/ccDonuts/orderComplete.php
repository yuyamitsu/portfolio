<?php 
  session_start();
  unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|ご購入完了</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">カート</li>
      <li class="breadcrumbItem">購入確認</li>
      <li class="breadcrumbItem breadcrumbCurrent">購入完了</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>
  <main>
    <div class="innerWrap">
      <h1 class="h1Text">ご購入完了</h1>
      <div class="completeInfoDisplay">
        <p>ご購入いただきありがとうございます。</p>
        <p>今後ともご愛顧の程、宜しくお願いいたします。</p>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="index.php">TOPページへすすむ</a></li>
        </ul>
      </nav>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>