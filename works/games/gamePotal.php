<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "Game Portal";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="stylesheet" href="styles/gamePotal.css">
</head>

<body>
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2>ゲームポータル</h2>
  <div class="innerWrap">
    <template id="gameCardTemplate">
      <div class="gameCard">
        <img class="gameImage" src="" alt="">
        <h3 class="gameTitle"></h3>
        <div class="score"></div>
        <button class="clearScore">スコアの初期化</button>
        <a class="link" target="_blank"></a>
      </div>
    </template>
    <div class="gameList" id="gameList">
    </div>
  </div>
  <?php require 'includes/bgm.php';?>
  <?php require 'includes/footer.php';?>
  <script src="javascript/gamePotal.js" defer></script>

</body>

</html>