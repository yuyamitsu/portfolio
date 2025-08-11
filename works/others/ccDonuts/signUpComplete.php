<?php session_start();?>
<?php 
  if (empty($_SESSION['form'])) {
    header('Location: signUp.php');
    exit;
  }
  $form = $_SESSION['form'];
  unset($_SESSION['form']);
  $messageH1 = "";
  $messageDisplay = "";
  $config = require('includes/config.php');
  $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
  if (isset($_SESSION['customer'])) {
    $id=$_SESSION['customer']['id'];
    $sql=$pdo->prepare('select * from customers where id!=? and mail=?');
    $sql->execute([$id, $form['mail']]);
  } else {
    $sql=$pdo->prepare('select * from customers where mail=?');
    $sql->execute([$form['mail']]);
  }
if (empty($sql->fetchAll())) {
	if (isset($_SESSION['customer'])) {
		$sql=$pdo->prepare('update customers set name=?, furigana=?, postcode_a=?, postcode_b=?, address=?, mail=?, password=? where id=?');
		$sql->execute([
			$form['name'], $form['furigana'], 
			$form['postcodeA'], $form['postcodeB'],
      $form['address'], $form['mail'], $form['password'], $id]);
		$_SESSION['customer']=[
			'id'=>$id, 'name'=>$form['name'], 
			'furigana'=>$form['furigana'], 'postcodeA'=>$form['postcodeA'],  'postcodeB'=>$form['postcodeB'],
      'address'=>$form['address'], 'mail'=>$form['mail'], 'password'=>$form['password']];
    $messageH1 = "情報更新完了";
		$messageDisplay = 'お客様情報を更新しました。';
	} else {
		$sql=$pdo->prepare('INSERT INTO customers (name, furigana, postcode_a, postcode_b, address, mail, password)
     VALUES (?, ?, ?, ?, ?, ?, ?)');
		$sql->execute([
			$form['name'], $form['furigana'], 
			$form['postcodeA'], $form['postcodeB'],
      $form['address'], $form['mail'], $form['password']]);
    $messageH1 = "会員登録完了";
		$messageDisplay = 'お客様情報を登録しました。';
	}
} else {
  $messageH1 = "登録エラー";
	$messageDisplay = 'メールアドレスがすでに使用されていますので、変更してください。';
}
?>




<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require 'includes/head.php';?>
  <title>C.C.Donuts|会員登録完了</title>
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
      <li class="breadcrumbItem">会員登録確認</li>
      <li class="breadcrumbItem breadcrumbCurrent">会員登録完了</li>
    </ol>
  </nav>

  <?php require 'includes/welcomeText.php';?>

  <main>
    <div class="innerWrap">
      <h1 class="h1Text"><?=$messageH1?></h1>
      <div class="completeInfoDisplay">
        <p><?=$messageDisplay?></p>
        <p><a href="login.php">ログインページ</a>へお進みください</p>
      </div>
      <nav class="afterComplete">
        <ul>
          <li><a href="index.php">TOPページへもどる</a></li>
        </ul>
      </nav>
  </main>
  <?php require 'includes/footer.php';?>
  <script src="scripts/script.js" defer></script>
</body>

</html>