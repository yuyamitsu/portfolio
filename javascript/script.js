'use strict';

// 作品データ
const workDetails = {
  poker: {
    title: "Poker",
    duration: "作業時間：30時間",
    description: "有名なゲームを参考に同じようにプレイできるように工夫しました。",
    link: "works/games/pokerGame.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  memory: {
    title: "神経衰弱",
    duration: "作業時間：10時間",
    description: "カードを選択した時のアニメーションや、スマホ向けのレスポンシブ対応を工夫しました。",
    link: "works/games/memoryGame.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  highlow: {
    title: "High&Low",
    duration: "作業時間：20時間",
    description: "プレイヤーの選択に応じたセリフや演出を工夫し、操作性にも配慮しました。",
    link: "works/games/highLow.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  puzzle15: {
    title: "15パズルゲーム",
    duration: "作業時間：5時間",
    description: "ChatGPTでの作成の練習で作ったゲーム。ユーザビリティに配慮して作ってもらうよう工夫しました。",
    link: "works/games/puzzle15.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  lightsout: {
    title: "ライツアウト",
    duration: "作業時間：2時間",
    description: "ChatGPTでの作成の練習で作ったゲーム。生成されたコードの意味を理解するのに時間がかかりました。",
    link: "works/games/lightsOut.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  soundGame: {
    title: "soundGame",
    duration: "作業時間：2時間",
    description: "soundGame",
    link: "works/games/soundGame.html",
    github: "https://github.com/yuyamitsu/portfolio/tree/main/works/games"
  },
  calculator: {
    title: "計算機",
    duration: "作業時間：10時間",
    description: "実際にある計算機アプリの実際の動作を確認し、入力状態管理を工夫しました。",
    link: "works/utilities/caluculator.html",
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
  }
};

// モーダル要素の生成
const modal = document.createElement('div');
modal.classList.add('modal');
modal.innerHTML = `
  <div class="modalContent">
    <button class="closeModal">×</button>
    <img class="modalImage" src="" alt=""></img>
    <h2 class="modalTitle"></h2>
    <p class="modalDuration"></p>
    <p class="modalDesc"></p>
    <p>ソースコード：<a class="modalGitHub" href="" target="_blank">GitHub</a>よりご覧ください</p>
    <p><a class="modalLink" href="" target="_blank">作品ページへ</a></p>
  </div>
`;
document.body.appendChild(modal);



// イベント設定
document.querySelectorAll('.viewDetailBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const detail = workDetails[id];
    if (detail) {
      // 画像を取得（button の親 .workCard の中の <img>）
      const workCard = btn.closest('.workCard');
      const img = workCard.querySelector('img');
      // モーダルに画像を設定
      const modalImg = modal.querySelector('.modalImage');
      modalImg.src = img.src;
      modalImg.alt = img.alt;

      modal.querySelector('.modalTitle').textContent = detail.title;
      modal.querySelector('.modalDuration').textContent = detail.duration;
      modal.querySelector('.modalDesc').textContent = detail.description;
      modal.querySelector('.modalLink').href = detail.link;
      modal.querySelector('.modalGitHub').href = detail.github;
      modal.style.display = 'flex';
      modal.classList.remove("modalHide");
      modal.classList.add("modalShow");
    }
  });
});

modal.querySelector('.closeModal').addEventListener('click', closing);

function closing() {
  modal.classList.replace("modalShow", "modalHide");
  setTimeout(() => {
    modal.classList.remove("modalHide");
    modal.style.display = "none";
  }, 500);
}


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

