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

function resetHighScore(gameName) {
  localStorage.removeItem(`${gameName}HS`);
}