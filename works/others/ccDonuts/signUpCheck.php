<?php 
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form'] = $_POST;
  } elseif (empty($_SESSION['form'])) {
    header('Location: input.php');
    exit;
  }
  $form = $_SESSION['form'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|会員登録確認</title>
</head>

<body>
  <?php require 'includes/header.php';?>
  <nav class="breadcrumbNav" aria-label="パンくずリスト">
    <ol class="breadcrumbList">
      <li class="breadcrumbItem">
        <a href="index.php" class="breadcrumbLink">TOP</a>
      </li>
      <li class="breadcrumbItem">ログイン</li>
      <li class="breadcrumbItem">会員登録</li>
      <li class="breadcrumbItem breadcrumbCurrent">会員登録確認</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text">入力確認</h1>
      <div class="checkList">
        <dl>
          <dt>お名前</dt>
          <dd>
            <?= htmlspecialchars($form["name"], ENT_QUOTES) ?>
          </dd>
          <dt>お名前(フリガナ)</dt>
          <dd>
            <?= htmlspecialchars($form["furigana"], ENT_QUOTES) ?>
          </dd>
          <dt>郵便番号</dt>
          <dd>
            <?= htmlspecialchars($form["postcodeA"], ENT_QUOTES).htmlspecialchars($form["postcodeB"], ENT_QUOTES) ?>
          </dd>
          <dt>住所</dt>
          <dd>
            <?= htmlspecialchars($form["address"], ENT_QUOTES) ?>
          </dd>
          <dt>メールアドレス</dt>
          <dd>
            <?= htmlspecialchars($form["mail"], ENT_QUOTES) ?>
          </dd>
          <dt>メールアドレス(確認用)</dt>
          <dd>
            <?= htmlspecialchars($form["mailCheck"], ENT_QUOTES) ?>
          </dd>
          <dt>パスワード</dt>
          <dd>
            <?= htmlspecialchars($form["password"], ENT_QUOTES) ?>
          </dd>
          <dt>パスワード(確認用)</dt>
          <dd>
            <?= htmlspecialchars($form["passwordCheck"], ENT_QUOTES) ?>
          </dd>
        </dl>
      </div>
      <form action="signUpComplete.php" method="post">
        <button class="submitButton" type="submit">登録する</button>
      </form>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>