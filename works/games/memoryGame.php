<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "神経衰弱";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/memoryGame.css">
</head>

<body class="cardGameStyle">
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2><?=$title?></h2>
  <div class="layoutWrap">
    <main>
      <div id="gameTable">
      </div>
      <div id="btnArea">
        <button id="reset">リセットする</button>
      </div>
    </main>
    <?php require 'includes/pageNav.php';?>
  </div>
  <?php require 'includes/bgm.php';?>
  <?php require 'includes/footer.php';?>
  <script src="javascript/deckInit.js"></script>
  <script src="javascript/memoryGame.js"></script>
</body>

</html>