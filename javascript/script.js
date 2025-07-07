'use strict';

// 作品データ
const workDetails = {
  poker: {
    title: "Poker",
    description: "役判定ロジックとUI制御に苦労しました。CPUの手札生成には確率調整を工夫。",
    link: "works/games/pokerGame.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  memory: {
    title: "神経衰弱",
    description: "カードのめくりアニメーションや、スマホ向けのレスポンシブ対応に工夫しました。",
    link: "works/games/memoryGame.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  highlow: {
    title: "High&Low",
    description: "プレイヤーの選択に応じたセリフや演出を工夫し、操作性にも配慮しました。",
    link: "works/games/highLow.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  puzzle15: {
    title: "15パズルゲーム",
    description: "解けるシャッフルの実装や、サイズ変更（3×3～15×15）の対応に苦労しました。",
    link: "works/games/puzzle15.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  lightsout: {
    title: "ライツアウト",
    description: "クリックによる周囲の切り替え判定や、初期配置・ヒント表示の制御が難しかったです。",
    link: "works/games/lightsOut.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  calculator: {
    title: "計算機",
    description: "小数点や除算のバグ処理、連続計算に対応するための入力状態管理に工夫しました。",
    link: "works/utilities/caluculator.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/utilities"
  },
  baseConverter: {
    title: "基数変換機",
    description: "2進数〜36進数まで対応するための柔軟な変換ロジックを作成しました。",
    link: "works/utilities/baseConverter.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/utilities"
  },
  prime: {
    title: "素数を求める",
    description: "エラトステネスの篩アルゴリズムを採用し、表示形式にも工夫しました。",
    link: "works/utilities/prime.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/utilities"
  },
  designHouse: {
    title: "企業HP（施工会社）",
    description: "実在する企業のように見えるよう、信頼感のあるデザインと構成を意識しました。",
    link: "works/others/designHouse/index.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/others"
  },
  taiwanTravel: {
    title: "台湾旅行紹介サイト",
    description: "グループ制作で役割分担やデザイン統一に注力。レスポンシブとマップ連携を工夫しました。",
    link: "works/others/taiwanTourism/index.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/others"
  }
};

// モーダル要素の生成
const modal = document.createElement('div');
modal.classList.add('modal');
modal.innerHTML = `
  <div class="modalContent">
    <button class="closeModal">×</button>
    <h2 class="modalTitle"></h2>
    <p class="modalDesc"></p>
    <p><a class="modalLink" href="" target="_blank">作品ページへ</a></p>
    <p>ソースコード：<a class="modalGitHub" href="" target="_blank">GitHub</a>より</p>
  </div>
`;
document.body.appendChild(modal);

// イベント設定
document.querySelectorAll('.viewDetailBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const detail = workDetails[id];
    if (detail) {
      modal.querySelector('.modalTitle').textContent = detail.title;
      modal.querySelector('.modalDesc').textContent = detail.description;
      modal.querySelector('.modalLink').href = detail.link;
      modal.querySelector('.modalGitHub').href = detail.github;
      modal.style.display = 'flex';
    }
  });
});

modal.querySelector('.closeModal').addEventListener('click', () => {
  modal.style.display = 'none';
});

const navToggle = document.querySelector('.navToggle');
const navWrapper = document.querySelector('.navWrapper');
const navLinks = document.querySelectorAll('.navList a');

navToggle.addEventListener('click', () => {
  navToggle.classList.toggle('active');
  navWrapper.classList.toggle('active');
});

// メニューリンクをクリックしたら閉じる
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    navToggle.classList.remove('active');
    navWrapper.classList.remove('active');
  });
});

