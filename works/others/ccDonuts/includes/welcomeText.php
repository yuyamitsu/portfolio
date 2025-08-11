  <?php
  $welcomeName = isset($_SESSION['customer']['name'])? $_SESSION['customer']['name'] : "ゲスト";
  echo '<p class="welcomeText">ようこそ　'.$welcomeName.'様</p>'
  ?>