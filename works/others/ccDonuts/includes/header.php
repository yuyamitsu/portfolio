<?php
$isLoggedIn = isset($_SESSION['customer']);
$linkHref = $isLoggedIn ? 'logout.php' : 'login.php';
$linkText = $isLoggedIn ? 'ログアウト' : 'ログイン';
$imageMap = [
  1 => 'donutsOriginal',
  2 => 'donutsChocolate',
  3 => 'donutsCaramel',
  4 => 'donutsPlain',
  5 => 'donutsCitrus',
  6 => 'donutsStrawberry',
  7 => 'donutsFruitSet12',
  8 => 'donutsFruitSet14',
  9 => 'donutsBestSelect',
  10 => 'donutsClushBox',
  11 => 'donutsCleamBox4',
  12 => 'donutsCleamBox9'
];
?>


<header>
  <div class="drawerMenu">
    <button class="drawerCloseButton"></button>
    <nav class="headerNavWrapper">
      <ul class="headerNavList">
        <li><a href="index.php">TOP</a></li>
        <li><a href="products.php">商品一覧</a></li>
        <li><a href="#">よくある質問</a></li>
        <li><a href="#">問い合わせ</a></li>
        <li><a href="#">当サイトのポリシー</a></li>
      </ul>
    </nav>
  </div>
  <div id="headerLogoArea">
    <!-- ハンバーガーボタン -->
    <button class="drawerOpenButton" aria-label="メニューを開閉する">
    </button>
    <div class="loginCart">
      <div class="loginButton">
        <a href="<?= htmlspecialchars($linkHref) ?>">
          <button>
            <picture>
              <source srcset="images/loginLogoPc.png" media="(min-width: 769px)">
              <source srcset="images/loginLogoSp.png" media="(max-width: 768px)">
              <img src="images/loginLogoSp.png" alt="<?= htmlspecialchars($linkText) ?>">
            </picture>
            <p>
              <?= htmlspecialchars($linkText) ?>
            </p>
          </button>
        </a>
      </div>
      <div class="cartButton">
        <a href="cart.php">
          <button>
            <picture>
              <!-- PC用画像 -->
              <source srcset="images/cartLogoPc.png" media="(min-width: 769px)">
              <!-- スマホ用画像 -->
              <source srcset="images/cartLogoSp.png" media="(max-width: 768px)">
              <!-- フォールバック(通常のimg)-->
              <img src="images/cartLogoSp.png" alt="ショッピングカート">
            </picture>
            <p>カート</p>
          </button>
        </a>
      </div>
    </div>
  </div>
  <div id="searchArea">
    <form action="">
      <button type="submit"></button>
      <input type="text" name="searchItem">
    </form>
  </div>

</header>