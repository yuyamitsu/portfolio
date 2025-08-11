<?php session_start();?>
<?php 
  $logOutText = "ログアウトしました。";
  if (isset($_SESSION['customer'])) {
    unset($_SESSION['customer']);
  } else {
    $logOutText = 'すでにログアウトしています。';
  }
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|ログアウト完了</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">ログアウト確認</li>
      <li class="breadcrumbItem breadcrumbCurrent">ログアウト完了</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text">ログアウト完了</h1>
      <div class="completeInfoDisplay">
        <p><?=$logOutText?></p>
        <p>またのご利用お待ちしております。</p>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="index.php">TOPページへもどる</a></li>
        </ul>
      </nav>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>