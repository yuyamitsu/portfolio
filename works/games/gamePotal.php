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
        <a class="link"></a>
      </div>
    </template>
    <div class="gameList" id="gameList">
    </div>
  </div>
  <?php require 'includes/footer.php';?>
  <script src="javascript/gamePotal.js"></script>

</body>

</html>