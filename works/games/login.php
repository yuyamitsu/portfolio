<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "ログイン";
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
        <form action="loginComplete.php" method="post">
          <div class="formInputBlock">
            <label for="userId">ユーザーID</label>
            <input id="userId" name="userId" required>
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