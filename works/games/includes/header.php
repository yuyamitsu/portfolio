<?php
  echo <<<HTML
  <header>
    <h1>YuyaGames</h1>
    <div class="welcomeText">
      <p>ようこそ <span class="nameDisplay">ゲスト</span>さん</p>
      <button class="hamburgerBtn" aria-label="メニュー">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
    </div>
    <div class="drawerMenu">
      <ul class="signUpMenu">
        <li><a href="gamePotal.php" target="_blank">ゲームポータルTopへ</a></li>
        <li><a href="ranking.php" target="_blank">ランキングページへ</a></li>
        <li><button class="addNameBtn" onclick="addName()">名前を登録・変更する</button></li>
        <li><button class="deleteAllBtn" onclick="deleteAll()">全データを削除する</button></li>
      </ul>
      <p class="nameInfo">※名前やid・スコアはご利用のブラウザに保存されます<br>ランキング登録するとデータベースに保存されます</p>
    </div>
  <script src="javascript/header.js" defer></script>
  </header>
  HTML
  ?>