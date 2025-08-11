<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|ログイン</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem breadcrumbCurrent">ログイン</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text">ログイン</h1>
      <div class="loginDisplay">
        <form action="loginComplete.php" method="post">
          <div class="formInputBlock">
            <label for="mail">メールアドレス</label>
            <input type="email" id="mail" name="mail" required>
          </div>
          <div class="formInputBlock">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
          </div>
          <button class="submitButton" type="submit">ログインする</button>
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