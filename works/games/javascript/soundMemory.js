'use strict'

const startButton = document.getElementById("startButton");
const resetButton = document.getElementById("resetButton");
const checkButton = document.getElementById("checkButton");
const difficultySelect = document.getElementById("difficultySelect");
const difficulty = {
  easy: [261.63, 523.25],
  nomal: [261.63, 329.63, 392.00, 493.90],
  hard: [261.63, 293.66, 349.23, 392.00, 493.90, 523.25],
  veryHard: [261.63, 293.66, 329.63, 349.23, 392.00, 440, 493.90, 523.25]
}
const soundNames = {
  easy: ['ド（C）', '高いド（C）'],
  nomal: ['ド（C）', 'ミ（E）', 'ソ（G）', '高いド（C）'],
  hard: ['ド（C）', 'レ（D）', 'ファ（F）', 'ソ（G）', 'シ（B）', '高いド（C）'],
  veryHard: ['ド（C）', 'レ（D）', 'ミ（E）', 'ファ（F）', 'ソ（G）', 'ラ（A）', 'シ（B）', '高いド（C）']
};
const message = document.getElementById('message');
const currentScoreMessage = document.getElementById('currentScoreMessage');
const maxScoreMessage = document.getElementById("maxScoreMessage");
let sequence = [];     // 正解の音の順番
let userSequence = []; // ユーザーの入力
let inputEnabled = false;
const firstGameCount = 4;
let gameCount = firstGameCount;
let score = 0;
let currentFrequencies = difficulty.nomal;
let currentSoundNames = soundNames.nomal; // 現在の音名配列を保持する変数

difficultySelect.addEventListener("change", (e) => {
  const selectedKey = e.target.value;
  currentFrequencies = difficulty[selectedKey];
  currentSoundNames = soundNames[selectedKey];
  updateSoundButtons();
})

maxScoreMessage.textContent = localStorage.getItem("maxScore");
currentScoreMessage.textContent = score;
message.textContent = "音が鳴って光った順にボタンをおしてね！";

const soudsButtonsArea = document.getElementById("soudsButtonsArea");
updateSoundButtons();


function updateSoundButtons() {
  // ボタンエリアを一旦空にする
  soudsButtonsArea.innerHTML = '';

  // 現在の難易度に応じた frequencies を使ってボタンを生成
  currentFrequencies.forEach((_, index) => {
    const btn = document.createElement('button');
    btn.className = 'soundButton';
    btn.textContent = currentSoundNames[index];
    btn.onclick = () => userInput(index);
    soudsButtonsArea.appendChild(btn);
  });
}

// 難易度が変わったときの処理
difficultySelect.addEventListener("change", (e) => {
  const selectedKey = e.target.value;
  currentFrequencies = difficulty[selectedKey];
  updateSoundButtons();
});

function playTone(frequency) {
  const selectedWave = document.getElementById('waveSelect').value;
  const ctx = new (window.AudioContext || window.webkitAudioContext)();
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();

  osc.type = selectedWave;
  osc.frequency.setValueAtTime(frequency, ctx.currentTime);

  osc.connect(gain);
  gain.connect(ctx.destination);

  gain.gain.setValueAtTime(1.0, ctx.currentTime);
  gain.gain.linearRampToValueAtTime(0.0, ctx.currentTime + 0.4);

  osc.start();
  osc.stop(ctx.currentTime + 0.4);
}
function playFailureSound() {
  const ctx = new (window.AudioContext || window.webkitAudioContext)();
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();

  // 低い周波数（失敗感のある音）
  osc.frequency.setValueAtTime(100, ctx.currentTime);
  osc.type = 'sawtooth';

  osc.connect(gain);
  gain.connect(ctx.destination);

  gain.gain.setValueAtTime(0.5, ctx.currentTime); // 少し音量を下げる
  gain.gain.linearRampToValueAtTime(0.0, ctx.currentTime + 0.3); // 短く減衰させる

  osc.start();
  osc.stop(ctx.currentTime + 0.3); // 短くする
}


function startGame() {
  sequence = [];
  userSequence = [];
  inputEnabled = false;
  startButton.classList.add("none");
  checkButton.classList.add("none");
  message.textContent = '再生中… ';
  currentScoreMessage.textContent = score;

  // ランダムに音を選ぶ（重複あり）
  for (let i = 0; i < gameCount; i++) {
    const randomIndex = Math.floor(Math.random() * currentFrequencies.length);
    sequence.push(randomIndex);
  }
  // 音を順番に鳴らす（時間差をつける）
  sequence.forEach((index, i) => {
    setTimeout(() => {
      playTone(currentFrequencies[index]);
      flashButton(index);
      if (i === sequence.length - 1) {
        // 最後の音のあと、入力受付開始
        setTimeout(() => {
          inputEnabled = true;
          message.textContent = '順番におしてね！';
        }, 500);
      }
    }, i * 500); // 0.5秒ずつずらして鳴らす
  });
}

function resetGame() {
  startButton.classList.remove("none");
  resetButton.classList.add("none");
  checkButton.classList.add("none");
  gameCount = firstGameCount;
  score = 0;
  currentScoreMessage.textContent = score;
}

function userInput(index) {
  if (!inputEnabled) return;

  playTone(currentFrequencies[index]);
  flashButton(index);
  userSequence.push(index);

  // 今の入力が正しいかチェック
  const currentStep = userSequence.length - 1;
  if (userSequence[currentStep] !== sequence[currentStep]) {
    playFailureSound();
    message.textContent = '❌ 残念！';
    inputEnabled = false;
    checkButton.classList.remove("none");
    resetButton.classList.remove("none");

    return;
  }

  // 全部正しく入力できた？
  if (userSequence.length === sequence.length) {
    message.textContent = '🎉 正解！！';
    inputEnabled = false;
    gameCount++;
    score++;
    currentScoreMessage.textContent = score;
    // 最大スコアを更新（score が maxScore を超えたら）
    const maxScore = Number(localStorage.getItem("maxScore")) || 0;
    if (score > maxScore) {
      localStorage.setItem("maxScore", score);
      maxScoreMessage.textContent = localStorage.getItem("maxScore");
    }
    startButton.classList.remove("none");
    startButton.textContent = "次のゲームへ";
  }
}

function flashButton(index) {
  const buttons = document.querySelectorAll(".soundButton");
  const btn = buttons[index];
  btn.classList.add("flash");
  setTimeout(() => {
    btn.classList.remove("flash");
  }, 300);
}


function check() {
  sequence.forEach((index, i) => {
    setTimeout(() => {
      playTone(currentFrequencies[index]);
      flashButton(index);
    }, i * 500);
  });
}