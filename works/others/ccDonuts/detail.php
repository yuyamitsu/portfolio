<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|商品詳細</title>
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
    <?php
// DB接続
  $config = require('includes/config.php');
  $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
  $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;
  $sql = $pdo->prepare('SELECT * FROM products WHERE id = ?');
  $sql->execute([$id]);
  foreach ($sql as $row) {
    $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
    $introduction = htmlspecialchars($row['introduction'], ENT_QUOTES, 'UTF-8');
    $price = number_format((int)$row['price']); // 価格を3桁区切り
    $imgBase = isset($imageMap[$row['id']]) ? $imageMap[$row['id']] : 'defaultImage';

    echo '<div class="detailDisplay">';
    // 画像部分
    echo '<div class="detailImage">';
    echo '<picture>';
    echo '<source srcset="images/' . $imgBase . 'Pc.png" media="(min-width: 769px)">';
    echo '<source srcset="images/' . $imgBase . 'Sp.png" media="(max-width: 768px)">';
    echo '<img src="images/' . $imgBase . 'Sp.png" alt="' . $name . '">';
    echo '</picture>';
    echo '</div>';

    // 商品詳細部分
    echo '<div class="detailIntroduction">';
    echo '<p class="detailIntroductionTitle">' . $name . '</p>';
    echo '<p class="detailIntroductionCaption">' . nl2br($introduction) . '</p>';
    echo '<p class="productsItemPrice">税込 ￥' . $price . '</p>';

    // フォーム部分
    echo '<form action="cart.php" method="post">';
    echo '<div class="countInputWrap">';
    echo '<input class="countInput" type="number" name="count" pattern="^(10|[1-9])$" 
          min="1" max="10" value="1" inputmode="numeric"><span>個</span>';
    echo '</div>';
    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
    echo '<div class="detailIntroductionSubmit">';
    echo '<button class="submitButton" type="submit">カートに入れる</button>';
    echo '<a href="#"></a>';
    echo '</div>';
    echo '</form>';

    echo '</div>';
    echo '</div>';
}
?>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>