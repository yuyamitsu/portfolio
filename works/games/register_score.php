<?php
session_start();
require_once __DIR__ . '/../../../../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $json = file_get_contents("php://input");
  $data = json_decode($json, true);

  $user_name  = $data['user_name'] ?? null;
  $game_id    = $data['game_id'] ?? null;  // ← game_name → game_id
  $best_score = $data['best_score'] ?? null;

  if ($user_name && $game_id !== null && $best_score !== null) {
    try {
      $sql = "INSERT INTO best_scores (user_name, game_id, best_score, updated_at)
              VALUES (:user_name, :game_id, :best_score, NOW())
              ON DUPLICATE KEY UPDATE
                best_score = GREATEST(best_score, VALUES(best_score)),
                updated_at = NOW()";

      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':user_name'  => $user_name,
        ':game_id'    => $game_id,
        ':best_score' => $best_score
      ]);

      echo "ランキング登録しました！";

    } catch (PDOException $e) {
      echo "登録失敗: " . $e->getMessage();
    }
  } else {
    echo "必要なデータが不足しています。";
  }
}
