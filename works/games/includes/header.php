<?php
  echo <<<HTML
  <header>
    <h1>YuyaGames</h1>
    <div class="welcomeText">
      <p>ようこそ　<span class="nameDisplay">ゲスト</span>さん</p>
      <button class="hamburgerBtn" aria-label="メニュー">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
    </div>
    <div class="drawerMenu">
      <ul class="signUpMenu">
        <li><button class="addNameBtn" onclick="addName()">名前を登録・変更する</button></li>
        <li><button class="deleteNameBtn" onclick="deleteName()">名前を削除する</button></li>
        <li>スコアを初期化する</li>
        <li>＊ご利用のブラウザに保存されます</li>
      </ul>
    </div>
  </header>
  <script src="javascript/header.js"></script>
  HTML
  ?>