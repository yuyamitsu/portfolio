<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  if (!empty($_SESSION['user'])) {
    header('Location: gamePotal.php');
    exit;
  }
  $title = "ユーザー登録";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/reset.css">
  <link rel="stylesheet" href="styles/gamePotal.css">
  <title><?=$title?></title>
</head>

<body>
  <?php require_once __DIR__ . '/includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <div class="loginDisplay">
        <form method="post" action="register.php">
          <label>ユーザー名:
            <input type="text" name="username" required>
          </label>
          <label>パスワード:
            <input type="password" name="password" required>
          </label>
          <button type="submit">登録</button>
        </form>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="signUp.php">会員登録はこちら</a></li>
        </ul>
      </nav>
    </div>

  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>


























<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|会員登録</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">ログイン</li>
      <li class="breadcrumbItem breadcrumbCurrent">会員登録</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>

  <?php 
    $customer = $_SESSION['customer'] ?? [];
    $name     = $customer['name'] ?? '';
    $furigana = $customer['furigana'] ?? '';
    $postcodeA = $customer['postcode_a'] ?? '';
    $postcodeB = $customer['postcode_b'] ?? '';
    $address    = $customer['address'] ?? '';
    $mail = $customer['mail'] ?? '';
    $password = $customer['password'] ?? '';
  ?>
  <main>
    <div class="innerWrap">
      <h1 class="h1Text">会員登録</h1>
      <div class="signUpForm">
        <form action="signUpCheck.php" method="post">
          <div class="formInputBlock">  
            <label for="name">お名前<span class="mustInput">（必須）</span></label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES) ?>" required>
          </div>
          <div class="formInputBlock">  
            <label for="furigana">フリガナ<span class="mustInput">（必須）</span></label>
            <input type="text" id="furigana" name="furigana" value="<?= htmlspecialchars($furigana, ENT_QUOTES) ?>" required>
          </div>
          <div class="formInputBlock">  
            <label for="postcodeA">郵便番号<span class="mustInput">（必須）</span></label>
            <div class="postcordBlock">
              <input type="text" id="postcodeA" name="postcodeA" inputmode="numeric" pattern="\d{3}" value="<?= htmlspecialchars($postcodeA, ENT_QUOTES) ?>" required>
              <input type="text" id="postcodeB" name="postcodeB" inputmode="numeric" pattern="\d{4}" value="<?= htmlspecialchars($postcodeB, ENT_QUOTES) ?>" required>
            </div>
          </div>
          <div class="formInputBlock">  
            <label for="address">住所<span class="mustInput">（必須）</span></label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($address, ENT_QUOTES) ?>" required>
          </div>
          <div class="formInputBlock">  
            <label for="mail">メールアドレス<span class="mustInput">（必須）</span></label>
            <input type="email" id="mail" name="mail" pattern="[^\s@]+@[^\s@]+" value="<?= htmlspecialchars($mail, ENT_QUOTES) ?>" required>
          </div>
          <div class="formInputBlock">  
            <label for="mailCheck">メールアドレス(確認用)<span class="mustInput">（必須）</span></label>
            <input type="email" id="mailCheck" name="mailCheck" autocomplete="off" pattern="[^\s@]+@[^\s@]+" value="<?= htmlspecialchars($mail, ENT_QUOTES) ?>" required>
          </div>
          <div class="formInputBlock">  
            <label for="password">
              パスワード<span class="mustInput">（必須）</span><br>
              <span class="passwordFormText">半角英数字8文字以上20文字以内で入力してください。※記号の使用はできません</span>
            </label>
            <input type="password" id="password" name="password" pattern="^[A-Za-z0-9]{8,20}$"
             value="<?= htmlspecialchars($password, ENT_QUOTES) ?>" required title="半角英数字8～20文字で入力してください（記号不可）">
          </div>
          <div class="formInputBlock">  
            <label for="password">
              パスワード確認用<span class="mustInput">（必須）</span>
            </label>
            <input type="password" id="passwordCheck" name="passwordCheck" pattern="^[A-Za-z0-9]{8,20}$"
            value="<?= htmlspecialchars($password, ENT_QUOTES) ?>" required title="半角英数字8～20文字で入力してください（記号不可）">
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