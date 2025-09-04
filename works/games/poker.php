<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "ポーカーゲーム";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/poker.css">
</head>

<body class="cardGameStyle">
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2><?=$title?></h2>
  <div class="cardGameLayoutWrap">
    <main >
      <div id="settingSheet">
        <div>
          <ul id="scoreSheet">
            <li class="scoreName">ロイヤルストレートフラッシュ<span class="scorePoint" data-score="100"></span></li>
            <li class="scoreName">ストレートフラッシュ<span class="scorePoint" data-score="50"></span></li>
            <li class="scoreName">フォーカード<span class="scorePoint" data-score="10"></span></li>
            <li class="scoreName">フルハウス<span class="scorePoint" data-score="5"></span></li>
            <li class="scoreName">フラッシュ<span class="scorePoint" data-score="4"></span></li>
            <li class="scoreName">ストレート<span class="scorePoint" data-score="3"></span></li>
            <li class="scoreName">スリーカード<span class="scorePoint" data-score="2"></span></li>
            <li class="scoreName">ツーペア<span class="scorePoint" data-score="2"></span></li>
            <li class="scoreName">ワンペア<span class="scorePoint" data-score="1"></span></li>
          </ul>
        </div>
        <div>
          <ul id="pointSheet">
            <li>所持pt <span id="havingPoints">100</span></li>
            <li>ベットするpt
              <span id="betPoints">
                <select name="betPoint" id="betPointSelect">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="5" selected>5</option>
                  <option value="10">10</option>
                </select>
              </span>
            </li>
          </ul>
        </div>
      </div>
      <h3 id="roleName" class="pop"></h3>
      <div id="gameTable" class="none">
        <label class="cardLabel none">
          <input type="checkbox" class="cardCheck" data-index="0">
          <img class="cardImage">
          <p class="changeStay">のこす</p>
        </label>
        <label class="cardLabel none">
          <input type="checkbox" class="cardCheck" data-index="1">
          <img class="cardImage">
          <p class="changeStay">のこす</p>
        </label>
        <label class="cardLabel none">
          <input type="checkbox" class="cardCheck" data-index="2">
          <img class="cardImage">
          <p class="changeStay">のこす</p>
        </label>
        <label class="cardLabel none">
          <input type="checkbox" class="cardCheck" data-index="3">
          <img class="cardImage">
          <p class="changeStay">のこす</p>
        </label>
        <label class="cardLabel none">
          <input type="checkbox" class="cardCheck" data-index="4">
          <img class="cardImage">
          <p class="changeStay">のこす</p>
        </label>
      </div>
      <div id="btnArea">
        <button id="startBtn">ゲームスタート！</button>
        <button id="change" class="none">交換する</button>
        <button id="reset" class="none">もういちどチャレンジ!</button>
      </div>
    </main>
    <?php require 'includes/pageNav.php';?>
  </div>
  <?php require 'includes/footer.php';?>
  <script src="javascript/deckInit.js"></script>
  <script src="javascript/poker.js"></script>
</body>

</html>