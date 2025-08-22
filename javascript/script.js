'use strict';

// 作品データ
const workDetails = {
  pokerGame: {
    title: "pokerGame",
    duration: "作業時間：30時間",
    description: "有名なゲームを参考に同じようにプレイできるように工夫しました。",
    link: "works/games/pokerGame.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  memoryGame: {
    title: "神経衰弱",
    duration: "作業時間：10時間",
    description: "カードを選択した時のアニメーションや、スマホ向けのレスポンシブ対応を工夫しました。",
    link: "works/games/memoryGame.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  highLowGame: {
    title: "High&Low",
    duration: "作業時間：20時間",
    description: "プレイヤーの選択に応じたセリフや演出を工夫し、操作性にも配慮しました。",
    link: "works/games/highLow.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  puzzle15: {
    title: "15パズルゲーム",
    duration: "作業時間：5時間",
    description: "ChatGPTでの作成の練習で作ったゲーム。ユーザビリティに配慮して作ってもらうよう工夫しました。",
    link: "works/games/puzzle15.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  lightsOut: {
    title: "ライツアウト",
    duration: "作業時間：2時間",
    description: "ChatGPTでの作成の練習で作ったゲーム。生成されたコードの意味を理解するのに時間がかかりました。",
    link: "works/games/lightsOut.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  soundMemory: {
    title: "soundMemory",
    duration: "作業時間：30時間",
    description: "気軽に遊べるサイモンゲーム。mp3ではなくWebAudioAPIを使っての制作に挑戦しました。難易度選択でのHzの調整等に苦労しました。",
    link: "works/games/soundMemory.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  calculator: {
    title: "計算機",
    duration: "作業時間：10時間",
    description: "実際にある計算機アプリの実際の動作を確認し、入力状態管理を工夫しました。",
    link: "works/utilities/calculator.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/utilities"
  },
  baseConverter: {
    title: "基数変換機",
    duration: "作業時間：4時間",
    description: "2進数〜36進数までの変換を一度に表示できるように工夫しました。",
    link: "works/utilities/baseConverter.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/utilities"
  },
  prime: {
    title: "素数を求める",
    duration: "作業時間：2時間",
    description: "ChatGPTにてアルゴリズムを生成し作成しました。",
    link: "works/utilities/prime.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/utilities"
  },
  designHouse: {
    title: "企業HP（施工会社）",
    duration: "作業時間：20時間",
    description: "実在する企業のように見えるよう、信頼感のあるデザインと構成を意識しました。",
    link: "works/others/designHouse/index.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/others/designHouse"
  },
  taiwanTravel: {
    title: "台湾旅行紹介サイト",
    duration: "作業時間：40時間×4人",
    description: "グループ制作で役割分担やデザイン統一に注力。モーダルウインドウに初挑戦しました。",
    link: "works/others/taiwanTourism/index.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/others/taiwanTourism"
  },
  ccDonuts: {
    title: "ドーナツのショッピングサイト",
    duration: "作業時間：60時間1人",
    description: "ログインの有無による画面遷移やセッション情報によるカート状態の更新などに注力しました。" +
      "また、PHPを使いデータベースを初導入しました。",
    link: "works/others/ccDonuts/index.php",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/others/ccDonuts"
  }
};

// カテゴリ分け
const categoryMap = {
  Games: ["pokerGame", "memoryGame", "highLowGame", "puzzle15", "lightsOut", "soundMemory"],
  Utilities: ["calculator", "baseConverter", "prime"],
  Others: ["designHouse", "taiwanTravel", "ccDonuts"]
};

// カードを生成して配置
Object.entries(categoryMap).forEach(([categoryName, ids]) => {
  const container = document.getElementById("category" + categoryName);
  if (!container) return;

  ids.forEach(id => {
    const detail = workDetails[id];
    if (!detail) return;

    const card = document.createElement("div");
    card.className = "workCard";
    const imagePath = `images/${id}.png`;

    card.innerHTML = `
      <img src="${imagePath}" alt="${detail.title}">
      <h4>${detail.title}</h4>
      <p>${detail.description}</p>
      <button class="viewDetailBtn" data-id="${id}">View Detail</button>
    `;

    container.appendChild(card);
  });
});

// モーダルを生成
const modal = document.createElement('div');
modal.classList.add('modal');
modal.innerHTML = `
  <div class="modalContent">
    <button class="closeModal">×</button>
    <img class="modalImage" src="" alt="">
    <h2 class="modalTitle"></h2>
    <p class="modalDuration"></p>
    <p class="modalDesc"></p>
    <p>ソースコード：<a class="modalGitHub" href="" target="_blank">GitHub</a>よりご覧ください</p>
    <p><a class="modalLink" href="" target="_blank">作品ページへ</a></p>
  </div>
`;
document.body.appendChild(modal);

// モーダル開閉
function openModal(detail, imgSrc, imgAlt) {
  modal.querySelector('.modalImage').src = imgSrc;
  modal.querySelector('.modalImage').alt = imgAlt;
  modal.querySelector('.modalTitle').textContent = detail.title;
  modal.querySelector('.modalDuration').textContent = detail.duration;
  modal.querySelector('.modalDesc').textContent = detail.description;
  modal.querySelector('.modalLink').href = detail.link;
  modal.querySelector('.modalGitHub').href = detail.github;
  modal.style.display = 'flex';
  modal.classList.remove("modalHide");
  modal.classList.add("modalShow");
}

modal.querySelector('.closeModal').addEventListener('click', () => {
  modal.classList.replace("modalShow", "modalHide");
  setTimeout(() => {
    modal.classList.remove("modalHide");
    modal.style.display = "none";
  }, 500);
});

// カード内ボタンまたはカード自体でモーダルを開く
document.addEventListener('click', e => {
  const btn = e.target.closest('.viewDetailBtn');
  const card = e.target.closest('.workCard');
  if (!card) return;

  const id = (btn || card.querySelector('.viewDetailBtn'))?.dataset?.id;
  const detail = workDetails[id];
  const img = card.querySelector('img');
  if (detail && img) {
    openModal(detail, img.src, img.alt);
  }
});


// HTML要素を取得
const bgm = document.getElementById('bgm');
const bgmToggle = document.querySelector('.bgmToggle');

// ボタンのクリックイベントリスナーを追加
bgmToggle.addEventListener('click', () => {
  if (bgm.paused) {
    // 音楽が停止している場合は再生
    bgm.play();
    bgmToggle.innerHTML='BGM<br>ON';
    bgmToggle.classList.toggle("bgmToggleOn");
    console.log('BGMを再生しました。');
  } else {
    // 音楽が再生中の場合は停止
    bgm.pause();
    console.log('BGMを停止しました。');
    bgmToggle.innerHTML='BGM<br>OFF';
    bgmToggle.classList.toggle("bgmToggleOn");
  }
});

// BGMの再生が終了したら次の曲イベントリスナー
bgm.addEventListener('ended', () => {

  bgm.currentTime = 0; // 再生位置を0秒に戻す
  bgm.play(); // 再生
});

// ハンバーガーメニュー処理
const navToggle = document.querySelector('.navToggle');
const navWrapper = document.querySelector('.navWrapper');
const navLinks = document.querySelectorAll('.navList a');

navToggle.addEventListener('click', () => {
  navToggle.classList.toggle('active');
  navWrapper.classList.toggle('active');
});
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    navToggle.classList.remove('active');
    navWrapper.classList.remove('active');
  });
});
