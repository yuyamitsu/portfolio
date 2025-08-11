<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|商品一覧</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem breadcrumbCurrent">商品一覧</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>
  <main>
    <div class="innerWrap">
      <h1 class="h1Text">商品一覧</h1>
    </div>
    <section class="mainMenuSection">
      <h2>メインメニュー</h2>
      <div class="productsBoard">
      <?php
        $config = require('includes/config.php');
        $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
        foreach ($pdo->query('SELECT * FROM products WHERE id <= 6') as $row) {
          $id = (int)$row['id'];
          $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
          $price = (int)$row['price'];
          $imgBase = isset($imageMap[$id]) ? $imageMap[$id] : 'defaultImage';
          echo '<div class="productsBoardCard">';
          echo '<a href="detail.php?id='.$id.'">';
          echo '<figure>';
          echo '<picture>';
          echo '<source srcset="images/'.$imgBase.'Pc.png" media="(min-width: 769px)">';
          echo '<source srcset="images/'.$imgBase.'Sp.png" media="(max-width: 768px)">';
          echo '<img src="images/'.$imgBase.'Sp.png" alt="' . $name . '">';
          echo '</picture>';
          echo '<figcaption>' . $name . '</figcaption>';
          echo '</figure>';
          echo '</a>';
          echo '<p class="productsItemPrice">税込 ￥' . $price . '</p>';
          echo '<form action="cart.php" method="post">';
          echo '<input type="hidden" name="count" value="1">';
          echo '<input type="hidden" name="id" value="' . $id . '">';
          echo '<button class="submitButton" type="submit">カートに入れる</button>';
          echo '</form>';
          echo '</div>';
        }
      ?>
      </div>
      </section>
    <section class="varietyMenuSection">
      <h2>バラエティセット</h2>
      <div class="productsBoard">
      <?php
        foreach ($pdo->query('SELECT * FROM products WHERE id >= 7') as $row) {
          $id = (int)$row['id'];
          $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
          $price = (int)$row['price'];
          $imgBase = isset($imageMap[$id]) ? $imageMap[$id] : 'defaultImage';
          echo '<div class="productsBoardCard">';
          echo '<a href="detail.php?id='.$id.'">';
          echo '<figure>';
          echo '<picture>';
          echo '<source srcset="images/'.$imgBase.'Pc.png" media="(min-width: 769px)">';
          echo '<source srcset="images/'.$imgBase.'Sp.png" media="(max-width: 768px)">';
          echo '<img src="images/'.$imgBase.'Sp.png" alt="' . $name . '">';
          echo '</picture>';
          echo '<figcaption>' . $name . '</figcaption>';
          echo '</figure>';
          echo '</a>';
          echo '<p class="productsItemPrice">税込 ￥' . $price . '</p>';
          echo '<form action="cart.php" method="post">';
          echo '<input type="hidden" name="count" value="1">';
          echo '<input type="hidden" name="id" value="' . $id . '">';
          echo '<button class="submitButton" type="submit">カートに入れる</button>';
          echo '</form>';
          echo '</div>';
        }
      ?>
      </div>
    </section>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>
</html>