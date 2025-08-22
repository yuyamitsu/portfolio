<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/reset.css">
  <link rel="stylesheet" href="styles/gamePotal.css">
  <title>ステータス画面</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f0f8ff;
      text-align: center;
    }

    h1 {
      font-size: 2em;
      margin-bottom: 30px;
    }

    .gameList {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .gameCard {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 375px;
      padding: 15px;
      text-align: center;
      transition: transform 0.2s;
    }

    .gameCard:hover {
      transform: translateY(-5px);
    }

    .gameCard a {
      text-decoration: none;
      color: #007acc;
      font-weight: bold;
      display: block;
      margin: 10px 0;
    }

    .gameImage {
      width: 100%;
      height: auto;
    }

    .score {
      font-size: 1.2em;
      color: #333;
    }

    @media (max-width: 768px) {
      body {
        min-width: 375px;
      }
    }
  </style>
</head>

<body>
  <header>
    <h1>My Game Portal</h1>
  </header>
  <button onclick="resetAllScore()">初期化する</button>
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
  <footer>
    <p>&copy; 2025 Yuya Mitsugi</p>
  </footer>
  <script src="javascript/gamePotal.js"></script>

</body>

</html>