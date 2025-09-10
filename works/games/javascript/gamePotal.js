'use strict';

const template = document.getElementById('gameCardTemplate');
const gameList = document.getElementById('gameList');

gameIds.forEach(game => {
  const clone = template.content.cloneNode(true);

  // 画像
  const gameImage = clone.querySelector('.gameImage');
  gameImage.src = `img/${game.name}.png`;
  gameImage.alt = game.name;

  // タイトル
  clone.querySelector('.gameTitle').textContent = game.title;

  // リンク
  const link = clone.querySelector('.link');
  link.href = game.name + '.php';
  link.textContent = 'GameStart';

  // スコア表示
  const score = getHighScore(game.name);
  clone.querySelector('.score').textContent = `HighScore：${score}`;

  // スコア初期化
  const clearBtn = clone.querySelector('.clearScore');
  clearBtn.addEventListener('click', () => clearScore(game.name, game.title));

  // スコア登録
  const registerBtn = clone.querySelector('.registerBtn');
  const registerResult = clone.querySelector('.registerResult');
  registerBtn.addEventListener('click', async () => {
  // 確認ダイアログ
    const confirmRegister = window.confirm(`ランキングに${game.title}のスコアを登録しますか？`);
    if (!confirmRegister) return; // キャンセルなら処理中止

    const playerName = localStorage.getItem("playerName") || "ゲスト";
    const browserId = localStorage.getItem("browserId4digits") || "0000";
    const userId = `${playerName}_${browserId}`;

    try {
      const res = await fetch("register_score.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          user_name: userId,
          game_id: game.id,
          best_score: score
        })
      });
      const data = await res.text();
      alert(data);
      registerResult.textContent = data;
    } catch (err) {
      registerResult.textContent = "通信エラー: " + err;
    }
  });

  gameList.appendChild(clone);
});
