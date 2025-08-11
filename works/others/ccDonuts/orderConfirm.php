<?php 
  session_start();
  require 'includes/authCheck.php';
  if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
  }
  if (empty($_SESSION['customer']['credit'])) {
    header('Location: shippingPayment.php');
    exit;
  }
  
  $totalPrice = 0;
  $totalCount = 0;
  $customer = $_SESSION['customer'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|購入確認（最終確認）</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">カート</li>
      <li class="breadcrumbItem breadcrumbCurrent">購入確認</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text">ご購入確認</h1>
      <div class="paymentDisplay">
        <section>
          <h2>ご購入商品</h2>
          <?php if (!empty($_SESSION['cart'])): ?>            
            <?php foreach ($_SESSION['cart'] as $productId => $item): ?>
              <div class="paymentItemBoard">
                <p>商品名　<span><?=$item['name'] ?></span></p>
                <p>数量　　<span><?=$item['count'] ?></span></p>
                <p>金額　　<span>&yen;<?=($item['price']* $item['count'])?></span></p>
              </div>
              <?php 
                $totalPrice += $item['price']* $item['count'];
                $totalCount += $item['count'];
              ?>
            <?php endforeach; ?>

            <div class="resultBoard">
              <p>合計数量<span><?=$totalCount?> </span></p>
              <p>合計金額<span>&yen;<?=$totalPrice?></span></p>
            </div>
          <?php endif; ?>
        </section>
        <section>
          <h2>お届け先</h2>
          <div class="paymentItemBoard">
            <p>お名前　<span><?=$customer['name']?></span></p>
            <p>郵便番号<span><?=$customer['postcodeA']."-".$customer['postcodeB']?></span></p>
            <p>住所　　 <span><?=$customer['address']?></span></p>
          </div>
        </section>
        <section>
          <h2>お支払方法</h2>
          <div class="paymentItemBoard">
            <p>お支払い<span>クレジットカード</span></p>
            <p>ブランド<span><?=$customer['credit']['brand']?></span></p>
          </div>
        </section>
        <form action="orderComplete.php">
          <button class="submitButton" type="submit">購入を確定する</button>
        </form>
      </div>
    </div>


  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>