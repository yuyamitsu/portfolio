<?php 
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form'] = $_POST;
  } elseif (empty($_SESSION['form'])) {
    header('Location: login.php');
    exit;
  }
  $form = $_SESSION['form'];
  unset($_SESSION['form']);
  $messageLoginH1 = ""; 
  $messageLoginDisplay1 = ""; 
  $messageLoginDisplay2 = ""; 

  $config = require('includes/config.php');
  $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
  $sql=$pdo->prepare('select * from customers where mail=? and password=?');
  $sql->execute([$form['mail'], $form['password']]);
  foreach ($sql as $row) {
    $_SESSION['customer']=[
    'id'=>$row['id'], 'name'=>$row['name'], 
    'furigana'=>$row['furigana'], 'postcodeA'=>$row['postcode_a'],  'postcodeB'=>$row['postcode_b'],
      'address'=>$row['address'], 'mail'=>$row['mail'], 'password'=>$row['password']
    ];
    }
  if (!isset($_SESSION['customer']['credit'])) {
    $sql=$pdo->prepare('select * from credit_cards where customer_id=?');
    $sql->execute([$_SESSION['customer']['id']]);
    if($sql){
      foreach ($sql as $row) {
        $_SESSION['customer']['credit']=[
          'id'=>$row['id'], 'name'=>$row['name'], 
          'cardNumber'=>$row['card_number'], 'brand'=>$row['card_company'],  'securityCode'=>$row['security_code'],
          'expirationMonth'=>$row['exp_month'], 'expirationYear'=>$row['exp_year']
        ];
      }
    }
  }

  if (isset($_SESSION['customer'])) {
    $messageLoginH1 = "ログイン完了"; 
    $messageLoginDisplay1 = "ログインが完了しました。"; 
    $messageLoginDisplay2 = "引き続きお楽しみください。"; 
  } else {
    $messageLoginH1 = "ログインエラー"; 
    $messageLoginDisplay1 = "ログイン名またはパスワードが違います。"; 
    $messageLoginDisplay2 = "改めて入力して下さい"; 
  }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|<?=$messageLoginH1?></title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">ログイン</li>
      <li class="breadcrumbItem breadcrumbCurrent"><?=$messageLoginH1?></li>
    </ol>
  </nav>

 <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text"><?=$messageLoginH1?></h1>
      <div class="completeInfoDisplay">
        <p><?=$messageLoginDisplay1?></p>
        <p><?=$messageLoginDisplay2?></p>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="orderConfirm.php">購入確認ページへすすむ</a></li>
          <li><a href="index.php">TOPページへもどる</a></li>
        </ul>
      </nav>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>