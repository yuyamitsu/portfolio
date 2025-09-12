<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';

  const DEBUG_PASSWORD = 'uusshmhmba';

  // デバッグモード OFF
  if (isset($_GET['debugOff'])) {
      unset($_SESSION['debugMode']);
  }

  // デバッグモード ON
  if (!empty($_POST['debugPass']) && trim($_POST['debugPass']) === DEBUG_PASSWORD) {
      $_SESSION['debugMode'] = true;
  }
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
  <?php if (!empty($_SESSION['debugMode'])): ?>
    
  <!-- デバッグモード中だけ出すUI -->
   <p>デバッグ中だよん　　　<a href="?debugOff=1">デバッグモード終了</a></p>
  <?php else: ?>
    <!-- デバッグモードに入るフォーム -->
    <form method="post">
      <input type="password" autocomplete="off" name="debugPass" placeholder="……">
      <button type="submit">？？？</button>
    </form>
  <?php endif; ?>
  
  <script>
    const debugMode = <?php echo !empty($_SESSION['debugMode']) ? 'true' : 'false'; ?>;
  </script>
  <script src="javascript/deckInit.js"></script>
  <script src="javascript/memoryGame.js"></script>
</body>

</html>