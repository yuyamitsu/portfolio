<?php
session_start();
require_once __DIR__ . '/../../../../db.php';
$title = "ランキング";

// ゲーム一覧を取得
$gamesStmt = $pdo->query("SELECT id, title FROM games ORDER BY id ASC");
$games = $gamesStmt->fetchAll();

// ランキング取得用の配列
$rankings = [];

foreach ($games as $game) {
  $stmt = $pdo->prepare(
    "SELECT user_name, best_score
     FROM best_scores
     WHERE game_id = :game_id
     ORDER BY best_score DESC, updated_at ASC
     LIMIT 10"
  );
  $stmt->execute([':game_id' => $game['id']]);
  $rankings[$game['id']] = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="stylesheet" href="styles/ranking.css">
</head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<h2><?=$title?></h2>
<div class="rankingWrap">
<?php foreach ($games as $game): ?>
  <div class="gameRanking">
    <h3 class="gameTitle"><?= htmlspecialchars($game['title']) ?></h3>
    <table>
      <thead>
        <tr>
          <th>順位</th>
          <th>ユーザー名</th>
          <th>スコア</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($rankings[$game['id']])): ?>
          <?php foreach ($rankings[$game['id']] as $index => $row): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($row['user_name']) ?></td>
              <td><?= $row['best_score'] ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3">まだスコアがありません</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
<?php endforeach; ?>
</div>
<?php require 'includes/bgm.php';?>
<?php require 'includes/footer.php'; ?>
</body>
</html>
