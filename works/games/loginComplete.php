<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>最新スコア保存</title>
</head>
<body>
  <h1>ゲームスコア</h1>

  <div>
    <label>ユーザー名:
      <input type="text" id="username">
    </label>
    <br>
    <label>スコア:
      <input type="number" id="score">
    </label>
    <br>
    <button id="saveBtn">保存</button>
  </div>

  <h2>保存されたスコア</h2>
  <pre id="output"></pre>

  <script>
    const usernameInput = document.getElementById("username");
    const scoreInput = document.getElementById("score");
    const output = document.getElementById("output");
    const saveBtn = document.getElementById("saveBtn");

    // 保存処理
    saveBtn.addEventListener("click", () => {
      const username = usernameInput.value.trim();
      const score = Number(scoreInput.value);

      if (!username || isNaN(score)) {
        alert("名前とスコアを入力してください");
        return;
      }

      // 1人の最新スコアだけを保存
      const data = { username, score };
      localStorage.setItem("latestScore", JSON.stringify(data));

      showData();
    });

    // 表示処理
    function showData() {
      const raw = localStorage.getItem("latestScore");
      if (raw) {
        const data = JSON.parse(raw);
        output.textContent = `名前: ${data.username}\nスコア: ${data.score}`;
      } else {
        output.textContent = "スコアはまだ保存されていません";
      }
      localStorage.clear("latestScore");
    }

    // ページ読み込み時に表示
    showData();
  </script>
</body>
</html>
