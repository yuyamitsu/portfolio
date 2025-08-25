<?php
  $isLoggedIn = isset($_SESSION['user']['name']);
  $welcomeName = $isLoggedIn? $_SESSION['user']['name'] : "ゲスト";
  $linkHref = $isLoggedIn ? 'logout.php' : 'login.php';
  $linkText = $isLoggedIn ? 'ログアウトする' : 'ログインする';
  $linkClass = $isLoggedIn ? 'logoutBtn' : 'loginBtn';

  echo <<<HTML
  <header>
    <h1>{$title}</h1>
    <div>
      <p class="welcomeText">ようこそ　{$welcomeName}さん<a href={$linkHref} class={$linkClass}>{$linkText}</a></p>
    </div>
  </header>  
  HTML
  ?>