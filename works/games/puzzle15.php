<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "15パズル";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/puzzle15.css">
</head>

<body class="puzzleGameStyle">
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2><?=$title?></h2>
  <div class="puzzleGameLayoutWrap">
    <div id="controls">
      <label for="sizeSelect">サイズ:</label>
      <select id="sizeSelect"></select>
      <button id="startBtn">スタート</button>
    </div>

    <div id="imageSelector">
      <p>画像選択:</p>
      <label><input type="radio" name="imageOption" value="img/sky.png" checked> 青空</label>
      <label><input type="radio" name="imageOption" value="img/onsen.png"> 冬の温泉</label>
      <label><input type="radio" name="imageOption" value="img/redman.png"> ホラー</label>
      <label><input type="radio" name="imageOption" value="img/boy.jpg"> 男の子</label>
      <label><input type="radio" name="imageOption" value="img/dotPower.png"> ドット戦士</label>
      <label><input type="radio" name="imageOption" value="img/cats.png"> 子猫</label>
      <label><input type="radio" name="imageOption" value="custom"> 自分の画像</label><br>
      <input type="file" id="imageInput" accept="image/*" style="display:none;">
    </div>

    <div id="info">
      手数: <span id="moveCount">0</span> / タイマー: <span id="timer">0</span>s
    </div>

    <div>
      <label id="hintToggle">
        <input type="checkbox" id="showHint"> 番号を表示
      </label>
      <label for="hintColor">文字色:</label>
      <select id="hintColor">
        <option value="white" selected>white</option>
        <option value="black">black</option>
        <option value="red">red</option>
        <option value="blue">blue</option>
        <option value="yellow">yellow</option>
        <option value="navy">navy</option>
        <option value="aqua">aqua</option>
      </select>
    </div>

    <div id="board"></div>
    <?php require 'includes/pageNav.php';?>
  </div>
  <?php require 'includes/footer.php';?>
  <script src="javascript/puzzle15.js"></script>
</body>

</html>