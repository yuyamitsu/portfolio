'use strict';

function getHighScore(gameName) {
  const score = localStorage.getItem(`${gameName}HS`);
  return score ? Number(score) : 0;
}

function updateHighScore(gameName, newScore) {
  const currentHigh = getHighScore(gameName);
  if (newScore > currentHigh) {
    localStorage.setItem(`${gameName}HS`, newScore);
    return true; // 更新された
  }
  return false; // 更新されなかった
}

function clearScore(gameName,gameTitle) {
  if (window.confirm(`本当に${gameTitle}のスコアを削除しますか?`)) {
    // OK を押したとき
    localStorage.removeItem(gameName + "HS");
    alert("削除しました");
    location.reload();
  }
}