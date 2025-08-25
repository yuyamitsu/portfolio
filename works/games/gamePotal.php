<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "Game Portal";
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
<div>
  <button id="addNameBtn" onclick="addName()">名前を登録する</button>
</div>

  <div class="innerWrap">
    <template id="gameCardTemplate">
      <div class="gameCard">
        <img class="gameImage" src="" alt="">
        <h2 class="title"></h2>
        <a class="link">▶ ゲームスタート</a>
        <div class="score"></div>
      </div>
    </template>
    <div class="gameList" id="gameList">
    </div>
  </div>
  <?php require 'includes/footer.php';?>
  <script src="javascript/gamePotal.js"></script>

</body>

</html>