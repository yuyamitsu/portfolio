'use strict';

const games = [
  { id: 'pokerGame', name: 'ポーカー', link: 'pokerGame.html' },
  { id: 'memoryGame', name: '神経衰弱', link: 'memoryGame.html' },
  { id: 'highLowGame', name: 'ハイ&ロー', link: 'highlow.html' },
  { id: 'puzzle15', name: '15パズル', link: 'puzzle15.html' },
  { id: 'lightsOut', name: 'ライツアウト', link: 'lightsOut.html' },
  { id: 'soundMemory', name: 'soundMemory', link: 'soundMemory.html' }
];


const template = document.getElementById('gameCardTemplate');
const gameList = document.getElementById('gameList');

games.forEach(game => {
  const score = localStorage.getItem(`${game.id}`) || 0;
  const clone = template.content.cloneNode(true);
  const imagePath = `img/${game.id}.png`;
  const gameImage = clone.querySelector('.gameImage');
  gameImage.src = imagePath;
  gameImage.alt = game.name;
  clone.querySelector('.title').textContent = game.name;
  const link = clone.querySelector('.link');
  link.href = game.link;
  link.textContent = '▶ GameStart';

  clone.querySelector('.score').textContent = `HighScore：${score}`;

  // 表示用に挿入
  gameList.appendChild(clone);
});

function resetAllScore(){
  localStorage.clear();
}