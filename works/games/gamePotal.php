<?php
session_start();
require_once __DIR__ . '/../../../../db.php';
$title = "ゲームポータル";

// DB からゲーム一覧を取得
$gamesStmt = $pdo->query("SELECT id, name, title FROM games ORDER BY id ASC");
$games = $gamesStmt->fetchAll();

// JSON を JS に渡す
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php require_once __DIR__ . '/includes/headCommon.php'; ?>
  <link rel="stylesheet" href="styles/gamePotal.css">
</head>
<body>
  <?php require_once __DIR__ . '/includes/header.php'; ?>
  <h2><?=$title?></h2>
  <div class="innerWrap">
    <template id="gameCardTemplate">
      <div class="gameCard">
        <img class="gameImage" src="" alt="">
        <h3 class="gameTitle"></h3>
        <a class="link" target="_blank"></a>
        <div class="score"></div>
        <button class="registerBtn">ランキング登録</button>
        <button class="clearScore">スコアの初期化</button>
        <div class="registerResult"></div>
      </div>
    </template>
    <div class="gameList" id="gameList"></div>
  </div>
  <p class="rankingLink"><a href="ranking.php" target="_blank">ランキングページへ</a></p>

  <?php require 'includes/bgm.php'; ?>
  <?php require 'includes/footer.php'; ?>

  <!-- PHP から JS にゲームデータを渡す -->
  <script>
    const gameIds = <?= json_encode($games, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  </script>
  <script src="javascript/gamePotal.js" defer></script>
</body>
</html>
