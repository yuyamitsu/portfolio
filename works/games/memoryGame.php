<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="styles/reset.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/memoryGame.css">
  <title>神経衰弱</title>
</head>

<body class="cardGameStyle">
  <header>
    <h1>神経衰弱</h1>
  </header>
  <div class="layoutWrap">
    <main>
      <div id="gameTable">
      </div>
      <div id="btnArea">
        <button id="reset">リセットする</button>
      </div>
    </main>
    <nav class="pageNav">
      <h2 class="navTitle">他のゲームへ</h2>
      <ul>
        <li><a href="highLow.html">High&Low</a></li>
        <li><a href="pokerGame.html">ポーカー</a></li>
        <li><a href="memoryGame.html">神経衰弱</a></li>
        <li><a href="puzzle15.html">15パズル</a></li>
        <li><a href="lightsOut.html">ライツアウト</a></li>
        <li><a href="soundMemory.html">soundMemory</a></li>
        <li><a href="../../index.html">ポートフォリオトップへ</a></li>
      </ul>
    </nav>
  </div>
  <footer>
    <p>&copy; 2025 Yuya Mitsugi</p>
  </footer>
  <script src="javascript/common.js"></script>
  <script src="javascript/memoryGame.js"></script>
</body>

</html>