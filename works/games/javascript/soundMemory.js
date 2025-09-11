'use strict'

const gameName = "soundMemory";
const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
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
const scoreMultiplier = {
  easy: 1,
  nomal: 2,
  hard: 3,
  veryHard: 4
};
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
const firstGameCount = 3;
let gameCount = firstGameCount;
let score = 0;
let currentFrequencies = difficulty.nomal;
let currentSoundNames = soundNames.nomal; // 現在の音名配列を保持する変数
let currentMultiplier = scoreMultiplier.nomal; // デフォルト

difficultySelect.addEventListener("change", (e) => {
  const selectedKey = e.target.value;
  currentFrequencies = difficulty[selectedKey];
  currentSoundNames = soundNames[selectedKey];
  currentMultiplier = scoreMultiplier[selectedKey];
  updateSoundButtons();
})

maxScoreMessage.textContent = localStorage.getItem("soundMemoryHS") || 0;
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

function playTone(frequency) {
  if (audioCtx.state === "suspended") {
    audioCtx.resume();
  }
  const selectedWave = document.getElementById('waveSelect').value;
  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();

  osc.type = selectedWave;
  osc.frequency.setValueAtTime(frequency, audioCtx.currentTime);

  osc.connect(gain);
  gain.connect(audioCtx.destination);

  gain.gain.setValueAtTime(1.0, audioCtx.currentTime);
  gain.gain.linearRampToValueAtTime(0.0, audioCtx.currentTime + 0.4);

  osc.start();
  osc.stop(audioCtx.currentTime + 0.4);
}


function playFailureSound() {
  if (audioCtx.state === "suspended") {
    audioCtx.resume();
  }
  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();

  // 低い周波数（失敗感のある音）
  osc.frequency.setValueAtTime(100, audioCtx.currentTime);
  osc.type = 'sawtooth';

  osc.connect(gain);
  gain.connect(audioCtx.destination);

  gain.gain.setValueAtTime(0.5, audioCtx.currentTime); // 少し音量を下げる
  gain.gain.linearRampToValueAtTime(0.0, audioCtx.currentTime + 0.3); // 短く減衰させる

  osc.start();
  osc.stop(audioCtx.currentTime + 0.3); // 短くする
}


function startGame() {
  sequence = [];
  userSequence = [];
  inputEnabled = false;
  startButton.classList.add("none");
  checkButton.classList.add("none");
  message.textContent = '再生中… ';
  currentScoreMessage.textContent = score;
  difficultySelect.disabled = true;

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
  difficultySelect.disabled = false;
  gameCount = firstGameCount;
  score = 0;
  currentScoreMessage.textContent = score;
  message.textContent = "音が鳴って光った順にボタンをおしてね！";
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

    // 不正解時 → ハイスコアを確定チェック
    if (updateHighScore(gameName, score)) {
      maxScoreMessage.textContent = getHighScore(gameName);
    }
    return;
  }

  // 全部正しく入力できた？（＝クリア）
  if (userSequence.length === sequence.length) {
    inputEnabled = false;
    gameCount++;
    score += currentMultiplier;
    currentScoreMessage.textContent = score;

    // ハイスコアを更新した場合
    if (updateHighScore(gameName, score)) {
      maxScoreMessage.textContent = getHighScore(gameName);
      message.textContent = '🎉 ハイスコア更新！';
    } else {
      message.textContent = '🎉 正解！！';
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