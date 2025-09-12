'use strict';

const gameName = "highLow";
const gameTable = document.getElementById("gameTable");
const startBtn = document.getElementById("startBtn");
const highBtn = document.getElementById("highBtn");
const lowBtn = document.getElementById("lowBtn");
const dropBtn = document.getElementById("dropBtn");
const resetBtn = document.getElementById("reset");
const numberOfCards = 52;
const highLowDisplay = document.getElementById("highLowDisplay");
const resultMessage = document.getElementById("resultMessage");
const startMessage = "次のカードの数が「たかい」か「ひくい」か選ぶゲームです！(2が一番ひくくてAが一番たかいです)";
const chipTotal = document.getElementById("chipTotal");
const betSelect = document.getElementById("betSelect");
const betIcon = document.querySelector(".betIcon");
const chipPotential = document.getElementById("chipPotential");

// ====== セリフ集（すべて配列化） ======
const messageTypes = {
  default: {
    success: [
      "おみごと！", "すごい！", "やるね！", "キレてる！", "絶好調！",
      "ノッてきた！", "天才かも！", "神がかってる！", "伝説の予感！", "もう誰にも止められない！！"
    ],
    prompt: ["次のカードが「たかい」か「ひくい」か選んでね！"],
    fail: ["ざんねん…"],
    drop: ["冷静な判断だね！"],
    tie: ["おっと、同じ数字！もういちど！"]
  },
  funny: {
    success: [
      "いいじゃん！", "ナイスー！", "やるやん！", "予知能力ある？",
      "誰か中に入ってる？", "さてはエスパー！", "超能力者、爆誕！",
      "完全に見えてるな？", "全カードに名前書いてるでしょ？！"
    ],
    prompt: ["笑ってもいいのよ〜？さあ選んで！"],
    fail: ["あれ〜？ギャグもスベったかも？"],
    drop: ["ビビった？いや、ナイス判断〜！"],
    tie: ["双子か！？どっちかわかんないってば！"]
  },
  english: {
    success: [
      "Nice one!", "Great job!", "You got it!", "Nailed it!", "You're on fire!",
      "Are you psychic?!", "Card master in the house!", "This is unreal!",
      "You read the matrix!", "We’re gonna need to nerf you!"
    ],
    prompt: ["High or Low? Make your move!"],
    fail: ["Oops... that didn’t go as planned."],
    drop: ["Smart move! Cash it out!"],
    tie: ["Whoa! Same number! Try again!"]
  },
  bodybuilding: {
    success: [
      "ナイスバルク！", "仕上がってるよ！", "いいカット出てる！", "デカすぎて見えない！",
      "肩にメロン乗ってるよ！", "腹筋バキバキだよ！", "広背筋が羽ばたいてる！",
      "バルクモンスター！", "パワーーーーーーー！！！！！！", "腹筋6LDK!!!"
    ],
    prompt: ["高いのかい！？低いのかい！？どっちなんだい！！"],
    fail: ["オーバーワークだったな!"],
    drop: ["休息こそもっとも筋肉に必要な時間だ…！"],
    tie: ["おいおい、同じサイズの筋肉か！？"]
  },
  yankee: {
    success: [
      "やるじゃねえか…ダチ公！", "シメるつもりがシビれたぜ…",
      "バチバチにキメたなァ！", "こいつは…伝説の一撃だ…！",
      "てめぇ…マジで最高だぜ！", "背中が語ってんだよ、勝利ってよ…！",
      "おいおい、誰にも止められねぇぞ！？", "ぶっちぎりの強さ…ついてくぜ兄貴！",
      "勝ち方、ワルすぎだろ！", "この流れ、もう番長コースだわ！"
    ],
    prompt: ["さあ来いよ、どっちに張るんだダチ公！？"],
    fail: ["チッ…まだ修行が足りねぇな。"],
    drop: ["…ふっ、ここで退くのもワルの嗜みよ。"],
    tie: ["まさかのシンクロかよ！もう一丁だッ！"]
  },
  sengoku: {
    success: [
      "見事な采配、まさに軍神よ…！", "これぞ戦上手、拙者脱帽に候！",
      "その一手、まさに勝ち戦である！", "おぬし…できるな…！",
      "誉れ高き一撃、我が軍も見習おうぞ！", "天晴れ！ 天下も近いぞ！",
      "敵将、討ち取ったりぃ！", "運も実力のうちと申すが、これは真の実力！",
      "武の極み、ここに見たり！", "将としての器…まさに天下布武！"
    ],
    prompt: ["いざ勝負！高う出すか、低う出すか…！？"],
    fail: ["くっ…これは無念の敗北に候…"],
    drop: ["ええい！引けっ！引けえええい！"],
    tie: ["兵力は拮抗…次の一手が勝敗を決めるであろう…！"]
  },
  announcer: {
    success: [
      "さあ決まりましたッ！見事な一手ッ！", "観客総立ちィィーー！！",
      "これはスーパープレーだァァァ！", "読み切ったァ！まさに天才的判断！",
      "どうする！？どうする！？…やったぁーッ！", "勝利への執念が実ったァ！",
      "まさに神がかった展開ッ！", "実況席も驚愕の展開！",
      "信じられない引き！伝説の再来か！？", "これは歴史に残る一戦ですッ！"
    ],
    prompt: ["さあ視聴者の皆さん、次の一手にご注目ください！"],
    fail: ["あぁーっと！ここで失敗かーッ！？"],
    drop: ["ここで決断ッ！勝利を持ち帰りますッ！"],
    tie: ["まさかの同点カード〜！仕切り直しです！"]
  },
  onee: {
    success: [
      "やだ…アンタ、できる子じゃない！", "あらやだ、ゾクゾクしちゃう展開ねぇ！",
      "その判断、100点満点よッ！あたしが保証する！", "惚れ直したわよ…罪な子ねぇ〜！",
      "その調子よ、もはや無敵！", "ちょっと待って、アンタ…今日イケすぎじゃない？",
      "強くて美しい、それがアンタの魅力！", "アタシの眼に狂いはなかったわ！",
      "やるじゃないのよ、あたしでもビビったわ…！", "アンタ、もう伝説入りね。殿堂よ、殿堂。"
    ],
    prompt: ["さぁ〜て、今日の運命、見せてもらおうかしら〜♡"],
    fail: ["いやぁん…残念だったわねぇ、でも次があるわよ♡"],
    drop: ["アナタの引く勇気、美しく咲いたわね"],
    tie: ["やだ〜♡どっちも同じ大きさだなんて〜"]
  },
  grandma: {
    success: [
      "ほっほっほ…その勝負、見えておったぞえ。", "ようやったのう、昔のワシを見ておるようじゃ。",
      "そりゃあもう、あっぱれじゃ！", "あんた…まさかワシの血を引いとるのか？",
      "昔はワシもよく勝負しとってな…それに勝るわ！", "見事じゃ…ワシの茶でも飲んでいきんさい。",
      "今の一手、ワシも震えたわい。", "おぬし…もはや“神の手”じゃ。",
      "それが勝負師の目じゃ！忘れるでないぞ。", "あんた、もうワシより強うなったかもな…。"
    ],
    prompt: ["さぁ次のカードを引くんじゃ、気張りんさいよ〜"],
    fail: ["あらまぁ…でも気を落とさんでな、まだまだいけるよって。"],
    drop: ["引き際も勝負じゃ、よう見とったぞえ。"],
    tie: ["ありゃりゃ、同じじゃな。もう一回じゃ。"]
  },
  chuuni: {
    success: [
      "フッ…選ばれし者よ、その一手、見事だ。", "我が右手が疼いたのは…貴様の力ゆえか。",
      "運命の扉は、いま貴様によって開かれた。", "漆黒の意思が、貴様を勝利へと導いたのだ。",
      "その力…封印しておくには惜しいな。", "見えたぞ…未来（ミライ）すら貴様の手中だ。",
      "我が瞳（オッドアイ）が震えた…！貴様、何者だ！？",
      "魔王ですら、貴様の前にはひれ伏すだろう。", "今、世界が貴様を中心に回っている…！",
      "この瞬間（とき）、伝説がまたひとつ刻まれた…貴様によってな。"
    ],
    prompt: ["さぁ…運命（さだめ）を選べ。同胞（我が魂を共鳴せし者）よ…"],
    fail: ["…フッ、まだ魂の輝きが足りぬようだな。"],
    drop: ["…運命は、いま封じられた。また次の刻を待つとしよう…"],
    tie: ["同等の力…貴様、鏡世界(ザンダクロス)の住人か…！？"]
  },
  hiromaru: {
    success: [
      "まぁ、そうなると思いましたけどね。", "普通に考えたら当たりますよね。",
      "ちゃんと情報を分析した結果ですよね。", "この程度の勝率で喜ぶのって、どうかと思うんですよ。",
      "あ、やっぱり当たりましたね。はい。", "予想通りすぎて、ちょっと眠くなってきました。",
      "統計的に考えれば当然の結果なんですよ。", "別にすごくないと思うんですけど、当たってますよね。",
      "これ、別に運じゃないですから。", "え？喜んでるんですか？まだ早いですよ、それ。"
    ],
    fail: [
      "うーん、それって運のせいにしてません？", "普通に考えて選び方が間違ってるんですよね。",
      "外れる確率もあるんだから、別に驚くことじゃないですよね。", "根拠ない選択って、だいたいこうなりますよね。",
      "当たると思った理由、説明できます？", "まぁ、感情で選んだ結果ですよね。",
      "ちゃんと考えて選んだなら、この結果でも納得できるはずですよ。", "こういうときって、経験がモノを言うんですよね。",
      "うーん、今の選び方は非論理的でしたね。"
    ],
    prompt: ["理屈で考えたら、どっちか明らかなんですよね。"],
    drop: [
      "まぁ、勝ち逃げっていうのも、賢い選択ですよね。", "リスク取らない人の方が、長期的には得するんですよ。",
      "え、そこでやめちゃうんですか？…でも合理的ですね。", "負けない戦い方って、実は一番強いんですよね。",
      "これ以上やる理由がないなら、やめた方がいいと思うんですよ。"
    ],
    tie: [
      "あ、同じ数字ですけど、これって運命とかじゃなくて確率なんですよね。", "はい、たまたま一緒だっただけです。確率論的には普通ですけど？",
      "これで驚いてる人って、数学苦手ですよね。", "同じ数字出たらどうなるかって、最初に説明されてませんでしたっけ？",
      "“偶然”って言葉で片付けるの、思考停止なんですよね。"
    ]
  }
};

// ====== キャラ画像マップ ======
const characterImages = {
  default: "img/characters/default.png",
  funny: "img/characters/funny.png",
  english: "img/characters/english.png",
  bodybuilding: "img/characters/bodybuilding.png",
  yankee: "img/characters/yankee.png",
  sengoku: "img/characters/sengoku.png",
  announcer: "img/characters/announcer.png",
  onee: "img/characters/onee.png",
  grandma: "img/characters/grandma.png",
  chuuni: "img/characters/chuuni.png",
  hiromaru: "img/characters/hiromaru.png"
};


// ====== 共通のメッセージ取得関数 ======
function getRandomMessage(type, category) {
  const msgs = messageTypes[type]?.[category] || messageTypes["default"][category];
  if (Array.isArray(msgs)) {
    return msgs[Math.floor(Math.random() * msgs.length)];
  }
  return msgs || "";
}

// ====== ゲーム制御変数 ======
let correctStreak = 0;
let totalChips = 100;
let currentBet = 0;
let potentialWin = 0;
let cardDeck = makeDeck();
let randomDeck = shuffleCards();
let prevCard = null;
let currentCard = null;

// 表示初期化
chipTotal.textContent = totalChips;
chipPotential.textContent = potentialWin;
resultMessage.textContent = startMessage;

// ====== イベント ======
startBtn.addEventListener("click", startGame);
highBtn.addEventListener("click", () => judge("high"));
lowBtn.addEventListener("click", () => judge("low"));
dropBtn.addEventListener("click", dropOut);
resetBtn.addEventListener("click", restartGame);

window.addEventListener("resize", () => {
  const originDeck = document.getElementById("originDeck");
  if (!originDeck) return;
  if (isMobile()) {
    if (!startBtn.classList.contains("none")) {
      originDeck.classList.remove("none");
    } else {
      originDeck.classList.add("none");
    }
  } else {
    originDeck.classList.remove("none");
  }
});

// ====== ゲーム処理 ======
function startGame() {
  // 選択されたベット
  currentBet = parseInt(betSelect.value) || 0;
  if ((totalChips - currentBet) < 0) {
    resultMessage.textContent = "チップが足りません！";
    setTimeout(() => resultMessage.textContent = startMessage, 1000);
    return;
  }
  // ベット反映
  totalChips -= currentBet;
  chipTotal.textContent = totalChips;
  potentialWin = 0;
  chipPotential.textContent = potentialWin;
  betSelect.disabled = true;

  // 最初のカードを1枚表示（プレイヤーが判断するための基準）
  drawNextCard();

  startBtn.classList.add("none");
  if (isMobile()) {
    const o = document.getElementById("originDeck");
    if (o) o.classList.add("none");
  }
  highBtn.classList.remove("none");
  lowBtn.classList.remove("none");
  dropBtn.classList.remove("none");

  const currentType = getSelectedMessageType();
  resultMessage.textContent = getRandomMessage(currentType, "prompt");
  updateCharacterImage(currentType); // ←追加
  betIcon.classList.remove("animate");
}

function drawNextCard() {
  // デッキが空ならリシャッフル
  if (!randomDeck || randomDeck.length === 0) {
    cardDeck = makeDeck();
    randomDeck = shuffleCards();
  }
  const cardCode = randomDeck.splice(0, 1)[0];
  prevCard = currentCard;
  currentCard = cardCode;

  const newImg = document.createElement("img");
  newImg.src = `img/${cardCode}.png`;
  newImg.classList.add("cardImage");
  newImg.style.position = "relative";
  newImg.style.left = "70px";
  highLowDisplay.appendChild(newImg);

  // 画像が増えすぎたらスクロールさせる
  if (highLowDisplay.scrollWidth > highLowDisplay.clientWidth) {
    highLowDisplay.scrollLeft = highLowDisplay.scrollWidth;
  }
}

function judge(choice) {
  // 次のカードを引く（これで prevCard がある状態になる）
  drawNextCard();

  // prevCard/currCard の値取り出し
  if (!prevCard || !currentCard) return;
  let prevValue = parseInt(prevCard.slice(1), 10);
  let currValue = parseInt(currentCard.slice(1), 10);
  if (prevValue === 1) prevValue = 14; // A を最大に
  if (currValue === 1) currValue = 14;

  const currentType = getSelectedMessageType();

  // 同値なら tie
  if (currValue === prevValue) {
    resultMessage.textContent = getRandomMessage(currentType, "tie");
    resultMessage.className = "tie";
    return;
  }

  // ボタン一時無効
  highBtn.disabled = true;
  lowBtn.disabled = true;
  dropBtn.disabled = true;

  const isCorrect = debugMode ? true :
    (choice === "high" && currValue > prevValue) ||
    (choice === "low" && currValue < prevValue);

  if (isCorrect) {
    // 正解
    const successMsg = getRandomMessage(currentType, "success");
    resultMessage.textContent = successMsg;
    resultMessage.className = "correct";
    correctStreak++;
    potentialWin = potentialWin <= 0 ? currentBet : potentialWin * 2;
    chipPotential.textContent = potentialWin;
    if(potentialWin >= 10000){
      playFanfare10000();
    }else if(potentialWin >= 1000){
      playFanfare1000();
    }else{
      playSuccessSound100();
    }
  } else {
    // 不正解（敗北処理）
    playFailureSound()
    const failMsg = getRandomMessage(currentType, "fail");
    resultMessage.textContent = failMsg;
    resultMessage.className = "wrong";
    correctStreak = 0;
    potentialWin = 0;
    chipPotential.textContent = potentialWin;

    // ボタンと表示切替
    highBtn.classList.add("none");
    lowBtn.classList.add("none");
    dropBtn.classList.add("none");
    resetBtn.classList.remove("none");

    return;
  }

  // 次の選択待ち（少し間を置いてプロンプト表示、ボタン復帰）
  setTimeout(() => {
    const prompt = getRandomMessage(currentType, "prompt");
    resultMessage.textContent = prompt;
    highBtn.disabled = false;
    lowBtn.disabled = false;
    dropBtn.disabled = false;
  }, 1200);
}

function dropOut() {
  const currentType = getSelectedMessageType();
  const dropMsg = getRandomMessage(currentType, "drop") || "冷静な判断です。";
  resultMessage.textContent = `${dropMsg}（${potentialWin}チップ獲得）`;
  resultMessage.className = "drop";
  totalChips += potentialWin;
  chipTotal.textContent = totalChips;

  // ハイスコア更新（ローカルstorageベース）
  if (updateHighScore(gameName, totalChips)) {
    alert("ハイスコアを更新しました");
  }

  potentialWin = 0;
  chipPotential.textContent = potentialWin;

  highBtn.classList.add("none");
  lowBtn.classList.add("none");
  dropBtn.classList.add("none");
  resetBtn.classList.remove("none");
}

function restartGame() {
  // デッキと表示のリセット
  cardDeck = makeDeck();
  randomDeck = shuffleCards();
  highLowDisplay.innerHTML = "";
  // UI リセット
  startBtn.classList.remove("none");
  highBtn.classList.add("none");
  lowBtn.classList.add("none");
  resetBtn.classList.add("none");
  betIcon.classList.add("animate");
  resultMessage.textContent = startMessage;
  highBtn.disabled = false;
  lowBtn.disabled = false;
  betSelect.disabled = false;
  const o = document.getElementById("originDeck");
  if (o) o.classList.remove("none");
  // 状態リセット（チップはそのまま）
  correctStreak = 0;
  currentBet = 0;
  potentialWin = 0;
  chipPotential.textContent = potentialWin;
}

// ====== ユーティリティ ======
function getSelectedMessageType() {
  const selected = document.querySelector('input[name="messageType"]:checked');
  return selected ? selected.value : "default";
}
function isMobile() {
  return window.innerWidth < 768;
}

// デッキ作成（コードは Suit + number の形式： S1 .. S13, H1 .. H13 ...）
function makeDeck() {
  const suits = ['S', 'H', 'D', 'C'];
  const deck = [];
  suits.forEach(s => {
    for (let i = 1; i <= 13; i++) {
      deck.push(`${s}${i}`); // 画像ファイル名に合わせる (例: S1.png)
    }
  });
  return deck;
}

// Fisher-Yates シャッフル
function shuffleCards() {
  const arr = makeDeck().slice();
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
  return arr;
}

// ハイスコア更新（ローカルストレージベース）
// 返り値: 更新があったら true を返す
function updateHighScore(gameNameKey, score) {
  try {
    const key = `highscore_${gameNameKey}`;
    const prev = parseInt(localStorage.getItem(key), 10) || 0;
    if (score > prev) {
      localStorage.setItem(key, String(score));
      return true;
    }
  } catch (e) {
    // localStorage が使えないときは何もしない
    console.warn("updateHighScore error:", e);
  }
  return false;
}


// ラジオボタンが変わったら画像を更新
const messageTypeRadios = document.querySelectorAll("input[name='messageType']");
messageTypeRadios.forEach(radio => {
  radio.addEventListener("change", () => {
    const currentType = getSelectedMessageType();
    updateCharacterImage(currentType);
  });
});

// ページ読み込み時に初期表示
document.addEventListener("DOMContentLoaded", () => {
  const currentType = getSelectedMessageType();
  updateCharacterImage(currentType);
});



function updateCharacterImage(type) {
  const imageArea = document.getElementById("characterImageArea");
  imageArea.innerHTML = ""; // 前の画像を消す

  const imgSrc = characterImages[type] || characterImages["default"];
  const img = document.createElement("img");
  img.src = imgSrc;
  img.alt = type + "風キャラ";
  img.className = "characterImage";
  imageArea.appendChild(img);
}


const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

function playFailureSound() {
  if (audioCtx.state === "suspended") audioCtx.resume();

  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();

  osc.type = "sawtooth";
  osc.connect(gain);
  gain.connect(audioCtx.destination);

  const now = audioCtx.currentTime;

  // 3段階で低くなる音（失敗感）
  const freqs = [200, 150, 100];
  freqs.forEach((f, i) => {
    osc.frequency.setValueAtTime(f, now + i * 0.1);
  });

  gain.gain.setValueAtTime(0.5, now);
  gain.gain.linearRampToValueAtTime(0.0, now + 0.3);

  osc.start();
  osc.stop(now + 0.3);
}

function playSuccessSound100() {
  if (audioCtx.state === "suspended") audioCtx.resume();

  const osc = audioCtx.createOscillator();
  const gain = audioCtx.createGain();

  osc.type = "triangle";
  osc.connect(gain);
  gain.connect(audioCtx.destination);

  const now = audioCtx.currentTime;

  // 上昇メロディ＋跳ねる感じ
  const freqs = [500, 650, 800, 950, 1100];
  freqs.forEach((f, i) => {
    const vibrato = Math.random() * 20 - 10; // 少し揺らす
    osc.frequency.setValueAtTime(f + vibrato, now + i * 0.08);

    // 音量をポンポン跳ねさせる
    gain.gain.setValueAtTime(0.6 - i * 0.1, now + i * 0.08);
    gain.gain.linearRampToValueAtTime(0.3 - i * 0.05, now + i * 0.08 + 0.05);
  });

  osc.start();
  osc.stop(now + 0.5);
}

function playFanfare1000() {
  const audio = new Audio("music/fanfare1000.mp3");
  audio.currentTime = 0;
  audio.play();
}
function playFanfare10000() {
  const audio = new Audio("music/fanfare10000.mp3");
  audio.currentTime = 0;
  audio.play();
}

