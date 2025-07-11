'use strict'

const startButton = document.getElementById("startButton");
const nextButton = document.getElementById("nextButton");
const checkButton = document.getElementById("checkButton");
const frequencies = [261.63, 329.63, 392.00, 493.90]; // ドミソシ
const message = document.getElementById('message');
const currentScoreMessage = document.getElementById('currentScoreMessage');
const maxScoreMessage = document.getElementById("maxScoreMessage");
let sequence = [];     // 正解の音の順番
let userSequence = []; // ユーザーの入力
let inputEnabled = false;
const firstGameCount = 4;
let gameCount = firstGameCount;
let score = 0;

maxScoreMessage.textContent = localStorage.getItem("maxScore");



function playTone(frequency) {
  const selectedWave = document.querySelector('input[name="wave"]:checked').value;
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
    const randomIndex = Math.floor(Math.random() * frequencies.length);
    sequence.push(randomIndex);
  }
  // 音を順番に鳴らす（時間差をつける）
  sequence.forEach((index, i) => {
    setTimeout(() => {
      playTone(frequencies[index]);
      flashButton(index);
      if (i === sequence.length - 1) {
        // 最後の音のあと、入力受付開始
        setTimeout(() => {
          inputEnabled = true;
          message.textContent = '順番に押してね！';
        }, 500);
      }
    }, i * 500); // 0.7秒ずつずらして鳴らす
  });
}

function userInput(index) {
  if (!inputEnabled) return;

  playTone(frequencies[index]);
  flashButton(index);
  userSequence.push(index);

  // 今の入力が正しいかチェック
  const currentStep = userSequence.length - 1;
  if (userSequence[currentStep] !== sequence[currentStep]) {
    message.textContent = '❌ 残念！';
    inputEnabled = false;
    checkButton.classList.remove("none");
    startButton.classList.remove("none");
    startButton.textContent = "最初から";
    gameCount = firstGameCount;
    score = 0;
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
      playTone(frequencies[index]);
      flashButton(index);
    }, i * 500);
  });
}