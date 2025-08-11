<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <?php
$pdo = null; // PDOオブジェクトを初期化

try {
  $config = require('includes/config.php');
  $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
  } catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    echo "データベース接続エラーが発生しました。しばらくしてから再度お試しください。<br>";
    echo $e->getMessage();
    exit;
}
  ?>

  <?php require 'includes/welcomeText.php';?>
  <main>
    <div class="hero">
      <picture>
        <source srcset="images/heroPc.png" media="(min-width: 769px)">
        <source srcset="images/heroSp.png" media="(max-width: 768px)">
        <img src="images/heroSp.png" alt="ドーナツ画像">
      </picture>
    </div>
    <div class="innerWrap">
      <div class="introductionFirstLine">
        <div class="newProductImage">
          <form action="detail.php">
            <input type="hidden" name="id" value="5">
            <button type="submit">
              <picture>
                <source srcset="images/newProductPc.png" media="(min-width: 769px)">
                <source srcset="images/newProductSp.png" media="(max-width: 768px)">
                <img src="images/newProductSp.png" alt="新商品画像">
              </picture>
              <span class="eyeCatch">新商品</span>
              <span class="newProductImageText">サマーシトラス</span>
            </button>
          </form>
        </div>
        <div class="donutsLifeImage">
          <picture>
            <source srcset="images/donutsLifePc.png" media="(min-width: 769px)">
            <source srcset="images/donutsLifeSp.png" media="(max-width: 768px)">
            <img src="images/donutsLifeSp.png" alt="ドーナツのある生活">
          </picture>
          <span class="donutsLifeImageText">ドーナツのある生活</span>
        </div>
      </div>
      <div class="donutsListImage">
        <a href="products.php">
        <picture>
            <source srcset="images/donutsListPc.png" media="(min-width: 769px)">
            <source srcset="images/donutsListSp.png" media="(max-width: 768px)">
            <img src="images/donutsListSp.png" alt="商品一覧">
          </picture>
          <span class="donutsListImageText">商品一覧</span>
        </a>
      </div>
    </div>
    <div class="philosophyImage">
      <picture>
        <source srcset="images/philosophyPc.png" media="(min-width: 769px)">
        <source srcset="images/philosophySp.png" media="(max-width: 768px)">
        <img src="images/philosophySp.png" alt="フィロソフィー背景">
      </picture>
      <div class="philosophyText">
        <p class="philosophyEnTitle">Philosophy</p>
        <p class="philosophyJaTitle">私たちの信念</p>
        <p class="philosophyCatch">"Creating Connections"</p>
        <p class="philosophyCatch">「ドーナツでつながる」</p>
      </div>
    </div>
    <div class="innerWrap">
      <section>
        <h1 class="h1Text">人気ランキング</h1>

        <div class="productsBoard">
          <?php
            $numbers = range(1, 12);
            shuffle($numbers);
            $randomNumbers = array_slice($numbers, 0, 6);

            // プレースホルダをIDの数だけ作成
            $placeholders = implode(',', array_fill(0, count($randomNumbers), '?'));
            $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
            $stmt->execute($randomNumbers);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rankCounter = 1;
            foreach ($rows as $row) {
              $id = (int)$row['id'];
              $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
              $price = (int)$row['price'];
              $imageBase = isset($imageMap[$id]) ? $imageMap[$id] : 'defaultImage';
              echo '<div class="productsBoardCard">';
              echo '<form action="detail.php">';
              echo '<input type="hidden" name="id" value="'.$id.'">';
              echo '<button type="submit">';
              echo '<p class="rank">'.$rankCounter.'</p>';
              echo '<figure><picture>';
              echo '<source srcset="images/'.$imageBase.'Pc.png" media="(min-width: 769px)">';
              echo '<source srcset="images/'.$imageBase.'Sp.png" media="(min-width: 769px)">';
              echo '<img src="images/'.$imageBase.'Sp.png" alt="オリジナルドーナツ">';
              echo '</picture><figcaption>';
              echo $name;
              echo '</figcaption></figure>';
              echo '</button>';
              echo '</form>';
              echo '<p class="productsItemPrice">税込 ￥'.$price.'</p>';
              echo '<form action="cart.php" method="post">';
              echo '<input type="hidden" name="count" value="1">';
              echo '<input type="hidden" name="id" value="'.$id.'">';
              echo '<button class="submitButton" type="submit">カートに入れる</button>';
              echo '</form></div>';
              $rankCounter++;
            }
          ?>
        </div>
      </section>
    </div>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>