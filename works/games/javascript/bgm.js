'use strict'

// BGMリストを配列で管理（ここに追加すれば自動で反映）
const bgmList = [
  { src: "music/playingCard.mp3", name: "Playing Card" },
  { src: "music/Drowsy_Afternoon.mp3", name: "Drowsy_Afternoon" },
  { src: "music/emakimono.mp3", name: "emakimono" },
  { src: "music/yasouradio.mp3", name: "夜想ラヂオ" },
  { src: "music/RAINY_GARDEN.mp3", name: "RAINY_GARDEN" },
  { src: "music/Morning.mp3", name: "Morning" },
  { src: "music/nandesyou.mp3", name: "なんでしょう?" },
  { src: "music/2_23_AM.mp3", name: "2_23_AM" }
];
// HTML要素を取得
const bgm = document.getElementById('bgm');
const bgmToggle = document.querySelector('.bgmToggle');
const bgmSelect = document.getElementById("bgmSelect");

// ボタンのクリックイベントリスナーを追加
bgmToggle.addEventListener('click', () => {
  if (bgm.paused) {
    bgm.play();
    setBgmButton(true); // ← 状態を明示
    console.log('BGMを再生しました。');
  } else {
    bgm.pause();
    setBgmButton(false); // ← 状態を明示
    console.log('BGMを停止しました。');
  }
});

// option を自動生成
bgmList.forEach(track => {
  const option = document.createElement("option");
  option.value = track.src;
  option.textContent = `♪${track.name}`;
  if (track.src === bgm.src) {
    option.selected = true;
  }
  bgmSelect.appendChild(option);
});

// BGM切り替え（必ず再生）
bgmSelect.addEventListener('change', () => {
  const newSrc = bgmSelect.value;
  bgm.src = newSrc;
  bgm.currentTime = 0;
  bgm.play();               // ← 必ず再生
  setBgmButton(true);       // ← ボタンもON表示に
  console.log(`BGMを切り替えて再生しました: ${newSrc}`);
});

// BGMボタン表示を更新する関数
function setBgmButton(isPlaying) {
  if (isPlaying) {
    bgmToggle.innerHTML = 'BGM<br>ON';
    bgmToggle.classList.add("bgmToggleOn");
  } else {
    bgmToggle.innerHTML = 'BGM<br>OFF';
    bgmToggle.classList.remove("bgmToggleOn");
  }
}