<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "ハイ＆ロー";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/highLow.css">
</head>

<body class="cardGameStyle">
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2><?=$title?></h2>
  <div class="cardGameLayoutWrap">
    <main>
      <div id="chipStatus">
        <p>所持チップ: <span id="chipTotal">100</span></p>
        <div id="betControl">
          <label for="betSelect"> 💰 ベット額<span class="betIcon animate" title="ここでチップ数を選べます">▼</span></label>
          <select id="betSelect">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5" selected>5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>
        <p>獲得予定チップ: <span id="chipPotential">0</span></p>
      </div>
      <div id="gameTable">
        <div id="originDeck">
          <img src="img/cardBack.png" alt="カードの裏面">
        </div>
        <div id="highLowDisplay">
        </div>
      </div>
      <div id="btnArea">
        <button id="startBtn">ゲームスタート！</button>
        <button id="highBtn" class="none">たかい</button>
        <button id="lowBtn" class="none">ひくい</button>
        <button id="dropBtn" class="none">おりる</button>
        <button id="reset" class="none">もういちどチャレンジ！</button>
      </div>
      <div id="promptArea">
        <div id="characterImageArea"></div>
        <p id="resultMessage">次のカードの数が「たかい」か「ひくい」か選ぶゲームです！(Aが一番たかくて2が一番ひくいです)</p>
      </div>
      <div id="messageSelect">
        <input type="radio" id="typeDefault" name="messageType" value="default" checked>
        <label for="typeDefault">デフォルト</label>
        <input type="radio" id="typeFunny" name="messageType" value="funny">
        <label for="typeFunny">自称おもしろ</label>
        <input type="radio" id="typeEnglish" name="messageType" value="english">
        <label for="typeEnglish">英語</label>
        <input type="radio" id="typeBodybuilding" name="messageType" value="bodybuilding">
        <label for="typeBodybuilding">ボディビル</label>
        <input type="radio" id="typeYankee" name="messageType" value="yankee">
        <label for="typeYankee">ヤンキー</label>
        <input type="radio" id="typeSengoku" name="messageType" value="sengoku">
        <label for="typeSengoku">戦国武将</label>
        <input type="radio" id="typeAnnouncer" name="messageType" value="announcer">
        <label for="typeAnnouncer">実況アナ</label>
        <input type="radio" id="typeOnee" name="messageType" value="onee">
        <label for="typeOnee">オネエ風</label>
        <input type="radio" id="typeGrandma" name="messageType" value="grandma">
        <label for="typeGrandma">おばあちゃん風</label>
        <input type="radio" id="typeChuuni" name="messageType" value="chuuni">
        <label for="typeChuuni">厨二病風</label>
        <input type="radio" id="typeHiromaru" name="messageType" value="hiromaru">
        <label for="typeHiromaru">ひ〇ゆき風</label>
      </div>
    </main>
    <?php require 'includes/pageNav.php';?>
  </div>
  <?php require 'includes/bgm.php';?>
  <?php require 'includes/footer.php';?>
  <script src="javascript/deckInit.js"></script>
  <script src="javascript/highLow.js"></script>
</body>

</html>