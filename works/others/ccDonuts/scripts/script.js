'use strict';

  const ranks = document.querySelectorAll('.rank');

  ranks.forEach(rank => {
    const rankNumber = parseInt(rank.textContent.trim(), 10); // 数値に変換
    switch (rankNumber) {
      case 1:
        rank.style.backgroundColor = '#FFD233';
        break;
      case 2:
        rank.style.backgroundColor = '#CCCCCC';
        break;
      case 3:
        rank.style.backgroundColor = '#D27C2C';
        break;
      default:
        rank.style.backgroundColor = '#E8C2CA';
    }
  });



// ハンバーガーメニュー処理
const drawerOpenButton = document.querySelector('.drawerOpenButton');
const drawerCloseButton = document.querySelector('.drawerCloseButton');
const drawerMenu = document.querySelector('.drawerMenu');

drawerOpenButton.addEventListener('click', () => {
  drawerMenu.classList.toggle('drawerActive');
});
drawerCloseButton.addEventListener('click', () => {
  drawerMenu.classList.toggle('drawerActive');
});
