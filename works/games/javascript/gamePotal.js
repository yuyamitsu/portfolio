'use strict';

const games = [
  { id: '1', name: 'pokerGame', link: 'pokerGame.php' },
  { id: '2', name: 'memoryGame', link: 'memoryGame.php' },
  { id: '3', name: 'highLowGame', link: 'highLow.php' },
  { id: '4', name: 'puzzle15', link: 'puzzle15.php' },
  { id: '5', name: 'lightsOut', link: 'lightsOut.php' },
  { id: '6', name: 'soundMemory', link: 'soundMemory.php' }
];


const template = document.getElementById('gameCardTemplate');
const gameList = document.getElementById('gameList');

games.forEach(game => {
  const score = 0;
  const clone = template.content.cloneNode(true);
  const imagePath = `img/${game.name}.png`;
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

