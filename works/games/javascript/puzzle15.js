'use strict'

const sizeSelect = document.getElementById("sizeSelect");
const startBtn = document.getElementById("startBtn");
const boardEl = document.getElementById("board");
const moveCountEl = document.getElementById("moveCount");
const timerEl = document.getElementById("timer");
const rankingList = document.getElementById("rankingList");

let size = 4;
let board = [];
let moveCount = 0;
let timer = 0;
let timerInterval = null;

for (let i = 3; i <= 15; i++) {
  const option = document.createElement("option");
  option.value = i;
  option.textContent = `${i}×${i}`;
  if (i === 4) option.selected = true;
  sizeSelect.append(option);
}

startBtn.addEventListener("click", () => {
  size = parseInt(sizeSelect.value);
  resetGame();
});

function resetGame() {
  clearInterval(timerInterval);
  timer = 0;
  moveCount = 0;
  moveCountEl.textContent = "0";
  timerEl.textContent = "0";
  createSolvableBoard();
  renderBoard();
  timerInterval = setInterval(() => {
    timer++;
    timerEl.textContent = timer;
  }, 1000);
}

function createSolvableBoard() {
  do {
    board = [...Array(size * size - 1).keys()].map(n => n + 1);
    board.push(null); // 空白
    shuffle(board);
  } while (!isSolvable(board));
}

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
}

function isSolvable(arr) {
  let invCount = 0;
  const flat = arr.filter(n => n !== null);
  for (let i = 0; i < flat.length - 1; i++) {
    for (let j = i + 1; j < flat.length; j++) {
      if (flat[i] > flat[j]) invCount++;
    }
  }

  const blankIndex = arr.indexOf(null);
  const blankRowFromBottom = size - Math.floor(blankIndex / size);

  if (size % 2 === 1) {
    return invCount % 2 === 0;
  } else {
    return (invCount + blankRowFromBottom) % 2 === 0;
  }
}

function renderBoard() {
  boardEl.innerHTML = "";
  boardEl.style.gridTemplateColumns = `repeat(${size}, 1fr)`;
  board.forEach((val, i) => {
    const tile = document.createElement("div");
    tile.className = "tile";
    if (val === null) {
      tile.classList.add("blank");
    } else {
      tile.textContent = val;
      tile.addEventListener("click", () => tryMove(i));
      tile.addEventListener("touchstart", () => tryMove(i));
    }
    boardEl.appendChild(tile);
  });
}

function tryMove(index) {
  const blankIndex = board.indexOf(null);
  const [r1, c1] = [Math.floor(index / size), index % size];
  const [r2, c2] = [Math.floor(blankIndex / size), blankIndex % size];
  const isAdjacent = Math.abs(r1 - r2) + Math.abs(c1 - c2) === 1;

  if (isAdjacent) {
    [board[index], board[blankIndex]] = [board[blankIndex], board[index]];
    moveCount++;
    moveCountEl.textContent = moveCount;
    renderBoard();
    if (isSolved()) {
      clearInterval(timerInterval);
      alert("クリア！ 🎉");
      saveScore();
      showRanking();
    }
  }
}

function isSolved() {
  for (let i = 0; i < size * size - 1; i++) {
    if (board[i] !== i + 1) return false;
  }
  return true;
}

function saveScore() {
  const record = { size, moveCount, timer, date: new Date().toLocaleString() };
  const key = `ranking_${size}x${size}`;
  const ranking = JSON.parse(localStorage.getItem(key)) || [];
  ranking.push(record);
  ranking.sort((a, b) => a.moveCount - b.moveCount);
  localStorage.setItem(key, JSON.stringify(ranking.slice(0, 10)));
}

function showRanking() {
  const key = `ranking_${size}x${size}`;
  const ranking = JSON.parse(localStorage.getItem(key)) || [];
  rankingList.innerHTML = "";
  ranking.forEach(score => {
    const li = document.createElement("li");
    li.textContent = `${score.moveCount} 手 (${score.timer}s) - ${score.date}`;
    rankingList.appendChild(li);
  });
}
