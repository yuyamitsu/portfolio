'use strict'

// ハンバーガーメニュー処理
const hamburgerBtn = document.querySelector('.hamburgerBtn');
const drawerMenu = document.querySelector('.drawerMenu');

hamburgerBtn.addEventListener('click', () => {
  drawerMenu.classList.toggle('drawerActive');
  hamburgerBtn.classList.toggle('open');
});

// localStorageから名前を取得
const playerName = localStorage.getItem("playerName");
const nameDisplayElements = document.querySelectorAll(".nameDisplay");

// 名前が登録されている場合
if (playerName) {
  const id = localStorage.getItem("browserId4digits") || "";
  const displayName = `${playerName}【${id}】`;

  nameDisplayElements.forEach(el => {
    el.textContent = displayName;
  });
}

//  else {
//   // 名前が未登録の場合（ゲスト扱い）
//   nameDisplayElements.forEach(el => {
//     el.textContent = "ゲスト";
//   });
// }

function addName() {
  const inputName = window.prompt("名前を10文字以内で入力してください\n入力した名前+idがユーザー名となります");
  if (inputName !== null) {
    if (inputName.trim().length > 10) {
      alert("名前は10文字以内で入力してください");
    } else {
      setBrowserId()
      localStorage.setItem("playerName", inputName)
      location.reload();
    }
  }
}

function setBrowserId() {
  let id = localStorage.getItem("browserId");
  if (!id) {
    // UUID（ランダムな一意ID）を生成
    id = crypto.randomUUID();
    localStorage.setItem("browserId", id);
    localStorage.setItem("browserId4digits", id.slice(0, 4));
  }
}
function clearScore() {
  if (window.confirm("本当にスコアを削除しますか？")) {
    // OK を押したとき
    // localStorage.removeItem("");
    // localStorage.removeItem("");
    alert("削除しました");
    location.reload();
  }
}
function deleteAll() {
  if (window.confirm("名前・id・スコアをすべて削除します。\n本当に削除しますか？")) {
    // OK を押したとき
    localStorage.clear();
    alert("削除しました");
    location.reload();
  }
}