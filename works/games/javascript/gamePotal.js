'use strict';

const gameIds = {
  1: { name: 'poker', title: 'ポーカー', link: 'pokerGame.php' },
  2: { name: 'memoryGame', title: '神経衰弱', link: 'memoryGame.php' },
  3: { name: 'highLow', title: 'ハイ＆ロー', link: 'highLow.php' },
  4: { name: 'puzzle15', title: '15パズル', link: 'puzzle15.php' },
  5: { name: 'lightsOut', title: 'ライツアウト', link: 'lightsOut.php' },
  6: { name: 'soundMemory', title: 'サウンド記憶ゲーム', link: 'soundMemory.php' }
};

const template = document.getElementById('gameCardTemplate');
const gameList = document.getElementById('gameList');

for (const id in gameIds) {
  const game = gameIds[id];
  const score = getHighScore(game.name);
  const clone = template.content.cloneNode(true);
  const imagePath = `img/${game.name}.png`;
  const gameImage = clone.querySelector('.gameImage');
  gameImage.src = imagePath;
  gameImage.alt = game.name;
  clone.querySelector('.gameTitle').textContent = game.title;
  const link = clone.querySelector('.link');
  link.href = game.link;
  link.textContent = 'GameStart';
  clone.querySelector('.score').textContent = `HighScore：${score}`;

  gameList.appendChild(clone);
}

