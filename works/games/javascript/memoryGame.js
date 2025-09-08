'use strict';

const gameTable = document.getElementById("gameTable");
const resetBtn = document.getElementById("reset");
const numberOfCards = 52;
let openCards = [];
let moveCount = 0;
let timer = 0;
let timerInterval = null;

let cardDeck = makeDeck();
let randomDeck = shuffleCards();

// --- カード作成 ---
for (let i = 0; i < numberOfCards; i++) {
  const label = document.createElement("label");
  label.className = "cardLabel";

  const checkbox = document.createElement("input");
  checkbox.type = "checkbox";
  checkbox.className = "cardCheck";

  const img = document.createElement("img");
  img.className = "cardImage";

  label.appendChild(checkbox);
  label.appendChild(img);
  gameTable.appendChild(label);
}

const cardlabels = document.querySelectorAll('.cardLabel');
const cardImages = document.querySelectorAll('.cardImage');
const checkboxes = document.querySelectorAll('.cardCheck');


// --- スコア計算（手数＋時間重視） ---
function calculateScore(numberOfPairs, moveCount, time) {
  const base = numberOfPairs * 100;
  const penalty = moveCount * 5 + time; // 手数と時間で減点
  return Math.max(0, base - penalty);
}

// --- タイマー開始 ---
function startTimer() {
  clearInterval(timerInterval);
  timer = 0;
  timerInterval = setInterval(() => {
    timer++;
  }, 1000);
}

// --- ゲームのカード選択処理 ---
checkboxes.forEach((checkbox, index) => {
  checkbox.addEventListener('change', () => {
    const img = cardImages[index];
    const card = randomDeck[index];

    if (checkbox.checked) {
      img.src = `img/${card}.png`;
      checkbox.disabled = true;
      openCards.push({ index, card });

      if (openCards.length === 2) {
        moveCount++;
        checkboxes.forEach(cb => cb.disabled = true);

        const [first, second] = openCards;
        const num1 = first.card.slice(1);
        const num2 = second.card.slice(1);

        if (num1 === num2) {
          // 一致：非表示に
          setTimeout(() => {
            cardImages[first.index].style.visibility = "hidden";
            cardImages[second.index].style.visibility = "hidden";
            openCards = [];
            checkboxes.forEach(cb => cb.disabled = false);
            checkGameClear();
          }, 600);
        } else {
          // 不一致：裏返し
          setTimeout(() => {
            checkboxes[first.index].checked = false;
            checkboxes[second.index].checked = false;
            cardImages[first.index].src = "img/cardBack.png";
            cardImages[second.index].src = "img/cardBack.png";
            openCards = [];
            checkboxes.forEach(cb => cb.disabled = false);
          }, 800);
        }
      }
    }
  });
});

// --- ゲームクリア判定 ---
function checkGameClear() {
  const allHidden = Array.from(cardImages).every(img => img.style.visibility === "hidden");
  if (allHidden) {
    clearInterval(timerInterval);
    const numberOfPairs = numberOfCards / 2;
    const score = calculateScore(numberOfPairs, moveCount, timer);
    const updated = updateHighScore("memoryGame", score);
    const highScore = getHighScore("memoryGame");

    alert(
      `ゲームクリア！ 🎉\n手数: ${moveCount}\n時間: ${timer}秒\nスコア: ${score}` +
      (updated ? "\n✨ハイスコア更新！✨" : "") +
      `\n現在のハイスコア: ${highScore}`
    );
  }
}

// --- カード表示 ---
function displayCards(randomDeck) {
  const delayPerCard = 15;
  randomDeck.forEach((card, index) => {
    cardImages[index].classList.remove("slide-in");
    setTimeout(() => {
      cardImages[index].src = "img/cardBack.png";
      cardImages[index].style.visibility = "visible";
      cardImages[index].classList.add("slide-in");
    }, index * delayPerCard);
  });
}

// --- ゲームリスタート ---
function restartGame() {
  cardDeck = makeDeck();
  randomDeck = shuffleCards();
  openCards = [];
  moveCount = 0;
  startTimer();
  displayCards(randomDeck);
  checkboxes.forEach(cb => {
    cb.checked = false;
    cb.disabled = false;
  });
  cardImages.forEach(img => img.style.visibility = "visible");
}

resetBtn.addEventListener("click", restartGame);

// 初回ゲーム開始
displayCards(randomDeck);
startTimer();
