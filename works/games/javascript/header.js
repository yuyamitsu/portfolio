'use strict'

// ハンバーガーメニュー処理
const hamburgerBtn = document.querySelector('.hamburgerBtn');
const drawerMenu = document.querySelector('.drawerMenu');

hamburgerBtn.addEventListener('click', () => {
  drawerMenu.classList.toggle('drawerActive');
  hamburgerBtn.classList.toggle('open');
});

// ドロワー以外クリックで閉じる
document.addEventListener('click', (event) => {
  const isClickInsideDrawer = drawerMenu.contains(event.target);
  const isClickOnButton = hamburgerBtn.contains(event.target);

  if (!isClickInsideDrawer && !isClickOnButton && drawerMenu.classList.contains('drawerActive')) {
    drawerMenu.classList.remove('drawerActive');
    hamburgerBtn.classList.remove('open');
  }
});


// localStorageから名前とブラウザIDを取得
const playerName = localStorage.getItem("playerName") || "";
const browserId = localStorage.getItem("browserId4digits") || "";
const nameDisplayElements = document.querySelectorAll(".nameDisplay");

// 表示名を作成
if (playerName || browserId) {
  // playerNameが空でもIDは表示
  const displayName = playerName ? `${playerName}_${browserId}` : `_${browserId}`;
  nameDisplayElements.forEach(el => {
    el.textContent = displayName;
  });
}

function addName() {
  const inputName = window.prompt(
    "名前を10文字以内で入力してください\n入力した名前+idがユーザー名となります"
  );
  if (inputName !== null) {
    if (inputName.trim().length > 10) {
      alert("名前は10文字以内で入力してください");
    } else {
      setBrowserId();
      localStorage.setItem("playerName", inputName);
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

function deleteAll() {
  if (window.confirm(
    "名前・id・スコアをすべて削除します。(ランキングは削除されません)\n本当に削除しますか？"
  )) {
    localStorage.clear();
    alert("削除しました");
    location.reload();
  }
}
