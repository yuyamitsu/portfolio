'use strict';

// --- 要素取得 ---
const sizeSelect = document.getElementById("sizeSelect");
const startBtn = document.getElementById("startBtn");
const boardEl = document.getElementById("board");
const moveCountEl = document.getElementById("moveCount");
const timerEl = document.getElementById("timer");
const imageInput = document.getElementById("imageInput");
const showHint = document.getElementById("showHint");
const hintColor = document.getElementById("hintColor");

let size = 4;
let board = [];
let moveCount = 0;
let timer = 0;
let timerInterval = null;
let selectedImageURL = "img/sky.png";
let hasJustCleared = false;
let gameCleared = false;

// --- サイズ選択 ---
for (let i = 3; i <= 15; i++) {
  const option = document.createElement("option");
  option.value = i;
  option.textContent = `${i}×${i}`;
  if (i === 4) option.selected = true;
  sizeSelect.append(option);
}

// --- 画像選択 ---
document.querySelectorAll("input[name='imageOption']").forEach(radio => {
  radio.addEventListener("change", () => {
    if (radio.value === "custom") {
      imageInput.style.display = "inline";
    } else {
      imageInput.style.display = "none";
      selectedImageURL = radio.value;
    }
  });
});

imageInput.addEventListener("change", function () {
  const file = this.files[0];
  if (!file) return;
  if (!file.type.startsWith("image/")) {
    alert("画像ファイルを選択してください（JPG/PNGなど）！");
    this.value = "";
    return;
  }
  const reader = new FileReader();
  reader.onload = function (e) {
    selectedImageURL = e.target.result;
  };
  reader.readAsDataURL(file);
});

// --- ゲームスタート ---
startBtn.addEventListener("click", () => {
  size = parseInt(sizeSelect.value);
  resetGame();
});

// --- ヒント表示 ---
showHint.addEventListener("change", () => {
  renderBoardWithImage(selectedImageURL);
});

hintColor.addEventListener("change", () => {
  renderBoardWithImage(selectedImageURL);
});


// --- スコア計算（速さ重視） ---
function calculateScore(size, moveCount, time) {
  if (time === 0) return 0;
  const base = size * size * 100;
  return Math.floor(base / time);
}

// --- ゲームリセット ---
function resetGame() {
  clearInterval(timerInterval);
  timer = 0;
  moveCount = 0;
  moveCountEl.textContent = "0";
  timerEl.textContent = "0";
  createSolvableBoard();
  hasJustCleared = false;
  gameCleared = false;
  renderBoardWithImage(selectedImageURL);
  timerInterval = setInterval(() => {
    timer++;
    timerEl.textContent = timer;
  }, 1000);
}

// --- 盤面生成 ---
function createSolvableBoard() {
  do {
    board = [...Array(size * size - 1).keys()].map(n => n + 1);
    board.push(null);
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
  const rowFromTop = Math.floor(blankIndex / size);
  const blankRowFromBottom = size - rowFromTop;
  if (size % 2 === 1) {
    return invCount % 2 === 0;
  } else {
    return (invCount + blankRowFromBottom) % 2 === 1;
  }
}

// --- 盤面描画 ---
function renderBoardWithImage(imgURL) {
  boardEl.innerHTML = "";
  boardEl.style.gridTemplateColumns = `repeat(${size}, 1fr)`;

  board.forEach((val, i) => {
    const tile = document.createElement("div");
    tile.className = "tile";

    const row = val !== null ? Math.floor((val - 1) / size) : size - 1;
    const col = val !== null ? (val - 1) % size : size - 1;

    if (val !== null || gameCleared) {
      tile.style.backgroundImage = `url(${imgURL})`;
      tile.style.backgroundSize = `${size * 100}% ${size * 100}%`;
      tile.style.backgroundPosition = `${(col / (size - 1)) * 100}% ${(row / (size - 1)) * 100}%`;
    }

    if (val === null) {
      tile.classList.add("blank");
    } else {
      tile.addEventListener("click", () => tryMove(i));
      tile.addEventListener("touchstart", () => tryMove(i));
      if (showHint.checked) {
        tile.textContent = val;
        tile.style.color = hintColor.value;
      }
    }

    boardEl.appendChild(tile);
  });
}

// --- タイル移動 ---
function tryMove(index) {
  const blankIndex = board.indexOf(null);
  const [r1, c1] = [Math.floor(index / size), index % size];
  const [r2, c2] = [Math.floor(blankIndex / size), blankIndex % size];
  if (Math.abs(r1 - r2) + Math.abs(c1 - c2) === 1) {
    [board[index], board[blankIndex]] = [board[blankIndex], board[index]];
    moveCount++;
    moveCountEl.textContent = moveCount;

    if (isSolved() && !hasJustCleared) {
      hasJustCleared = true;
      gameCleared = true;
      clearInterval(timerInterval);
      renderBoardWithImage(selectedImageURL);

      const score = calculateScore(size, moveCount, timer);
      const updated = updateHighScore("puzzle15", score);
      const highScore = getHighScore("puzzle15");

      setTimeout(() => {
        let msg = `クリア！ 🎉\n時間: ${timer}秒\n手数: ${moveCount}\nスコア: ${score}`;
        if (updated) msg += `\n✨ハイスコア更新！✨`;
        msg += `\n現在のハイスコア: ${highScore}`;
        alert(msg);
      }, 100);
    } else {
      renderBoardWithImage(selectedImageURL);
    }
  }
}

// --- 完成判定 ---
function isSolved() {
  for (let i = 0; i < size * size - 1; i++) {
    if (board[i] !== i + 1) return false;
  }
  return true;
}
