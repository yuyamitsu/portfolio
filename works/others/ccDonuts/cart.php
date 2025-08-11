<?php 
  session_start();
  $pdo = null;
  $config = require('includes/config.php');
  $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
  if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'removeItem') {
    $productIdToRemove = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);

    if ($productIdToRemove !== false && $productIdToRemove > 0) {
      if (isset($_SESSION['cart'][$productIdToRemove])) {
        unset($_SESSION['cart'][$productIdToRemove]); 
        header('Location: cart.php');
        exit;
      }
    }
  }
// --- 数量更新処理 ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateQuantity') {
  foreach ($_POST as $key => $value) {
    if (strpos($key, 'count_') === 0) {
      $productId = (int)str_replace('count_', '', $key); // 'count_' 以降のIDを取得

      // filter_var() を使って数量をバリデーション
      $newCount = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]]);
      if ($productId > 0 && isset($_SESSION['cart'][$productId])) { // カートに存在する商品か確認
        if ($newCount !== false) { // 数量が有効な数値の場合
          $_SESSION['cart'][$productId]['count'] = $newCount; // カートの数量を更新
        } else {
        echo "<script>
          'use strict'
          window.alert('商品の数量が無効です。1個から10個の間で入力してください。')
        </script>";
        }
      }
    }
  }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['action']) || $_POST['action'] === 'addToCart')) {
    $productId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $count = filter_input(INPUT_POST, 'count', FILTER_VALIDATE_INT);
    if ($productId === false || $productId <= 0 || $count === false || $count <= 0 || $count > 10) {   
        echo "<script>
                'use strict' 
                window.alert('無効な商品IDまたは数量が指定されました。')
              </script>";
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id, name, price FROM products WHERE id = ?');
            $stmt->execute([$productId]);
            $product = $stmt->fetch();

          if ($product) {
              $productName = $product['name'];
              $productPrice = $product['price'];
              if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['count'] += $count;
              } else {
                  $_SESSION['cart'][$productId] = [
                    'id' => $productId,
                    'name' => $productName,
                    'price' => $productPrice,
                    'count' => $count
                  ];
              }
              header('Location: cart.php'); // 商品追加後はリダイレクト
              exit;
          } else {
            echo "<script>
              'use strict'
              window.alert('無効な商品IDまたは数量が指定されました。')
            </script>";
          }
        } catch (PDOException $e) {
            error_log("Cart add product error: " . $e->getMessage());
            echo "<script>
              'use strict'
              window.alert('商品の追加中にデータベースエラーが発生しました。')
            </script>";
          }
        }
    }
  // --- カートの内容を計算・表示するための変数 ---
$totalItems = 0;
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $totalItems += $item['count'];
    $totalPrice += ($item['price'] * $item['count']);
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|カート</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem breadcrumbCurrent">カート</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>
  <main>
    <div class="innerWrap">
      <div class="cartInfoDisplay">

        <p class="cartPurchasedItems">現在　商品
          <?=$totalItems?>点
        </p>
        <p class="cartPurchasedItems">ご注文合計：税込<span class="productsItemPrice">¥
            <?=$totalPrice?>
          </span></p>
        <form action="orderConfirm.php">
          <button class="submitButton" type="submit">購入確認へ進む</button>
        </form>
      </div>
      <div class="cartItemBoard">
        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cartItemList">
          <?php foreach ($_SESSION['cart'] as $productId => $item): ?>
          <?php
            $imgBase = isset($imageMap[$item['id']]) ? $imageMap[$item['id']] : 'defaultImage'; 
          ?>
          <div class="cartItem">
            <div class="cartItemImage">
              <a href="detail.php?id=<?=$item['id']?>">
                <img src="images/<?=$imgBase?>Pc.png" alt="">
              </a>
            </div>
            <div class="cartItemCaption">
              <p class="cartItemName">
                <?= htmlspecialchars($item['name']) ?>
              </p>
              <div class="cartItemPriceDisplay">
                <p class="cartItemPrice">
                  税込: &yen;
                  <?= number_format($item['price']) ?><br><br>
                  小計: &yen;
                  <?= number_format($item['price'] * $item['count']) ?>
                </p>
                <form action="cart.php" method="post">
                  <p class="cartItemCount"><span>数量</span>
                    <input class="countInput" type="number" name="count_<?= $item['id'] ?>"
                      value="<?= htmlspecialchars($item['count']) ?>" min="1" max="10"
                      inputmode="numeric"><span>個</span>
                  </p>
                  <input type="hidden" name="action" value="updateQuantity">
                  <button class="recalculation" type="submit">再計算</button>
                </form>
              </div>
              <form class="deleteForm" action="cart.php" method="post">
                <input type="hidden" name="productId" value="<?= htmlspecialchars($item['id']) ?>">
                <input type="hidden" name="action" value="removeItem"> <button class="deleteButton"
                  type="submit">削除する</button>
              </form>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>カートに商品はありません。</p>
        <?php endif; ?>
      </div>


      <div class="cartInfoDisplay">
        <p class="cartPurchasedItems">現在　商品
          <?=$totalItems?>点
        </p>
        <p class="cartPurchasedItems">ご注文合計：税込<span class="productsItemPrice">¥
            <?=$totalPrice?>
          </span></p>
        <form action="orderConfirm.php">
          <button class="submitButton" type="submit">購入確認へ進む</button>
        </form>
      </div>
      <button class="submitButton"><a href="products.php">買い物を続ける</a></button>
    </div>
  </main>

  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>