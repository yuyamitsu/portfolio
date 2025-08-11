<?php 
  session_start();
  require 'includes/authCheck.php';
  if(isset($_SESSION['customer']['credit'])){
    header('Location: orderConfirm.php');
    exit;
  }
  
  
  ?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|クレジットカード情報入力</title>
</head>

<body>
  <script>
    'use strict'
    window.alert('当サイトは模擬サイトですので、実際のクレジットカード情報は登録しないでください')
  </script>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">カート</li>
      <li class="breadcrumbItem">購入確認</li>
      <li class="breadcrumbItem breadcrumbCurrent">カード情報</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>
  <main>
    <div class="innerWrap">
      <h1 class="h1Text">カード情報登録</h1>
      <p style="text-align:center;"> <span style="color:red; font-weight:bold; font-size:48px;">当サイトは模擬サイトですので、<br>実際のクレジットカード情報は登録しないでください</span></p>
      <div class="signUpForm">
        <form action="creditInputCheck.php" method="post">
          <div class="formInputBlock">
            <label for="name">お名前<span class="mustInput">（必須）</span></label>
            <input type="text" id="name" name="name" value="" required>
          </div>
          <div class="formInputBlock">
            <label for="cardNumber">カード番号<span class="mustInput">（必須）</span></label>
            <input type="text" id="cardNumber" name="cardNumber" value="" required>
          </div>
          <div class="formInputBlock">
            <p>カード会社<span class="mustInput">（必須）</span></p>
            <div class="chooseBrand">
              <label><input type="radio" name="brand" value="JCB">JCB</label>
              <label><input type="radio" name="brand" value="Visa">Visa</label>
              <label><input type="radio" name="brand" value="Mastercard">Mastercard</label>
            </div>
          </div>
          <div class="formInputBlock">
            <label for="expirationA">有効期限<span class="mustInput">（必須）</span></label>
            <div class="expirationBlock">
              <label>
                <input type="text" id="expirationA" name="expirationMonth" inputmode="numeric" pattern="^(0[1-9]|1[0-2])$"
                  value="" maxlength="2" required>月
              </label>
              <label>
                <input type="text" id="expirationB" name="expirationYear" inputmode="numeric" pattern="^\d{2}$" value=""
                  maxlength="2" required>年
              </label>
            </div>
          </div>
          <div class="formInputBlock">
            <label for="securityCode">セキュリティコード<span class="mustInput">（必須）</span></label>
            <input type="text" id="securityCode" name="securityCode" value="" required>
          </div>
          <button class="submitButton" type="submit">入力確認をする</button>
        </form>
      </div>
    </div>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>