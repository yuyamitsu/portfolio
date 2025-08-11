<?php 
  session_start();
  if (!isset($_SESSION['creditAccessToken'])) {
    header('Location: creditInput.php');
    exit;
  }
  $id = $_SESSION['customer']['id'];
  $form = $_SESSION['form'];
  $config = require('includes/config.php');
  $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
  if (isset($_SESSION['customer']['credit'])) {
    $sql=$pdo->prepare('update credit_cards set name=?, card_number=?, card_company=?, security_code=?, exp_month=?, exp_year=?, where customer_id=?');
    $sql->execute([
      $form['name'], $form['cardNumber'], 
      $form['brand'], $form['securityCode'],
      $form['expirationMonth'], $form['expirationYear'], $id]);
    $_SESSION['customer']['credit']=[
      'id'=>$id, 'name'=>$form['name'], 
      'cardNumber'=>$form['cardNumber'], 'brand'=>$form['brand'],  'securityCode'=>$form['securityCode'],
      'expirationMonth'=>$form['expirationMonth'], 'expirationYear'=>$form['expirationYear']];
    $messageH1 = "情報更新完了";
    $messageDisplay = 'お客様情報を更新しました。';
  } else {
    $sql=$pdo->prepare('INSERT INTO credit_cards (customer_id, name, card_number, card_company, security_code, exp_month, exp_year)
    VALUES (?,?, ?, ?, ?, ?, ?)');
    $sql->execute([
      $id, $form['name'], 
      $form['cardNumber'], $form['brand'],
      $form['securityCode'], $form['expirationMonth'], $form['expirationYear']]);
    $_SESSION['customer']['credit']=[
    'id'=>$id, 'name'=>$form['name'], 
    'cardNumber'=>$form['cardNumber'], 'brand'=>$form['brand'],  'securityCode'=>$form['securityCode'],
    'expirationMonth'=>$form['expirationMonth'], 'expirationYear'=>$form['expirationYear']];
    $messageH1 = "クレジットカード登録完了";
    $messageDisplay = 'クレジットカード情報を登録しました。';
  }
  unset($_SESSION['form']);
  unset($_SESSION['creditAccessToken']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|クレジットカード情報登録完了</title>
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
      <li class="breadcrumbItem">情報確認</li>
      <li class="breadcrumbItem breadcrumbCurrent">登録完了</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>
  
  <main>
    <div class="innerWrap">
      <h1 class="h1Text">カード情報登録完了</h1>
      <div class="completeInfoDisplay">
        <p>支払い情報登録が完了しました。</p>
        <p>続けて購入確認ページへお進みください</p>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="orderConfirm.php">購入確認ページへすすむ</a></li>
        </ul>
      </nav>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>