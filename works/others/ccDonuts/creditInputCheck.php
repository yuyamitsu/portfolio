<?php 
  session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form'] = $_POST;
    $_SESSION['creditAccessToken'] = true;
} 
else if (!isset($_SESSION['creditAccessToken'])) {
    header('Location: creditInput.php');
    exit;
}

$form = $_SESSION['form'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|会員登録確認</title>
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
      <li class="breadcrumbItem">カード情報</li>
      <li class="breadcrumbItem breadcrumbCurrent">情報確認</li>
    </ol>
  </nav>


  <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text">入力情報確認</h1>
      <div class="checkList">
        <dl>
          <dt>お名前</dt>
          <dd>
            <?= htmlspecialchars($form["name"], ENT_QUOTES) ?>
          </dd>
          <dt>カード番号</dt>
          <dd>
            <?= htmlspecialchars($form["cardNumber"], ENT_QUOTES) ?>
          </dd>
          <dt>カード会社</dt>
          <dd>
            <?= htmlspecialchars($form["brand"], ENT_QUOTES) ?>
          </dd>
          <dt>有効期限</dt>
          <dd>
            <?= htmlspecialchars($form["expirationMonth"], ENT_QUOTES) ?>
          </dd>
          <dd>
            <?= htmlspecialchars($form["expirationYear"], ENT_QUOTES) ?>
          </dd>
          
          <dt>セキュリティコード</dt>
          <dd>
            <?= htmlspecialchars($form["securityCode"], ENT_QUOTES) ?>
          </dd>
        </dl>
      </div>
      <form action="creditComplete.php" method="post">
        <button class="submitButton" type="submit">登録する</button>
      </form>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>