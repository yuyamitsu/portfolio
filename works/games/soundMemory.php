<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "サウンド記憶ゲーム";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
	<link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/soundMemory.css">
</head>

<body class="puzzleGameStyle">
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2><?=$title?></h2>
  <div class="innerWrap">
    <div class="soundType">
      音の種類:
      <select id="waveSelect">
        <option value="sine" selected>sine（シンプル音）</option>
        <option value="square">square（ピコピコ）</option>
        <option value="triangle">triangle（少し硬い）</option>
        <option value="sawtooth">sawtooth（金属的）</option>
      </select>
      難易度:
      <select name="difficulty" id="difficultySelect">
        <option value="easy">簡単</option>
        <option value="nomal" selected>普通</option>
        <option value="hard">難しい</option>
        <option value="veryHard">激ムズ</option>
      </select>
    </div>

    <div id="soudsButtonsArea">
    </div>

    <div id="operationButtonArea">
      <button onclick="startGame()" id="startButton">スタート</button>
      <button onclick="resetGame()" id="resetButton" class="none">最初から</button>
      <button onclick="check()" id="checkButton" class="none">正解確認</button>
    </div>

    <div id="messageDisplay">
      <p id="message"></p>
      <p>現在<span id="currentScoreMessage"></span>連勝中</p>
      <p>最高記録:<span id="maxScoreMessage"></span>連勝</p>
    </div>
    <?php require 'includes/pageNav.php';?>
  </div>
  	<?php require 'includes/footer.php';?>
  <script src="javascript/soundMemory.js"></script>
</body>

</html>