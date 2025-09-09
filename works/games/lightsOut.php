<?php
  session_start();
  require_once __DIR__ . '/../../../../db.php';
  $title = "ライツアウト";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once __DIR__ . '/includes/headCommon.php';?>
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/lightsOut.css">
</head>

<body class="puzzleGameStyle">
  <?php require_once __DIR__ . '/includes/header.php';?>
  <h2><?=$title?></h2>
  <div class="innerWrap puzzleGameLayoutWrap">
    <div id="controls">
      <label for="gridSize">サイズ選択:</label>
      <select id="gridSize"></select>
      <button id="startBtn">スタート</button>
      <button id="toggleHintBtn">ヒント OFF</button>
    </div>
    <div id="board"></div>
    <p id="message"></p>
    <p id="minStep"></p>
    <p id="stepCounter"></p>
    <p id="scoreDisplay"></p>
    <?php require 'includes/pageNav.php';?>
  </div>
  <?php require 'includes/bgm.php';?>
  <?php require 'includes/footer.php';?>

  <script>
    'use strict';

    const gameName = 'lightsOut';
    let size = 3;
    let board = [];
    let hintOn = false;
    let hintUsed = false; // ←このゲームでヒントを一度でも使ったか
    let currentSolution = [];
    const boardElem = document.getElementById('board');
    const gridSizeSelect = document.getElementById('gridSize');
    const messageElem = document.getElementById('message');
    const minStepElem = document.getElementById('minStep');
    const stepCounterElem = document.getElementById('stepCounter');
    const scoreDisplay = document.getElementById('scoreDisplay');
    const toggleHintBtn = document.getElementById('toggleHintBtn');
    let stepCounter = 0;
    let cleared = false;

    // サイズ選択肢を追加（4,5,9はスキップ）
    const skipSizes = [1, 2, 4, 5, 9];
    for (let i = 1; i <= 10; i++) {
      if (skipSizes.includes(i)) continue;
      const option = document.createElement('option');
      option.value = i;
      option.textContent = `${i}×${i}`;
      gridSizeSelect.append(option);
    }

    // スタートボタン
    document.getElementById('startBtn').addEventListener('click', () => {
      size = Number(gridSizeSelect.value);
      createSolvableBoard(size);
      stepCounter = 0;
      stepCounterElem.textContent = `現在ステップ数${stepCounter}手`;
      cleared = false;
      boardElem.classList.remove('disabled');
      scoreDisplay.textContent = ''; // スコアリセット

      // スタート時にヒントOFF、hintUsedリセット
      hintOn = false;
      hintUsed = false;
      toggleHintBtn.textContent = 'ヒント:OFF';
      messageElem.textContent = '';
    });

    // ヒントボタン
    toggleHintBtn.addEventListener('click', () => {
      if (!hintUsed) { // まだ一度もONにしていない場合のみ確認
        const ok = confirm('ヒントを使うと得点が0になります。よろしいですか？');
        if (!ok) return; // キャンセルなら何もしない
        hintUsed = true; // 一度ヒントをONにしたら0点扱い
        messageElem.textContent = '※このゲームはヒント使用済みのため得点は0点になります';
      }
      hintOn = !hintOn;
      toggleHintBtn.textContent = hintOn ? 'ヒント:ON' : 'ヒント:OFF';
      updateHintDisplay();
    });

    // 初期盤面生成
    function createSolvableBoard(n) {
      const solution = Array(n * n).fill(0).map(() => Math.random() < 0.35 ? 1 : 0);
      const state = applyMoves(solution, n);
      currentSolution = solution;
      renderBoard(state, solution, n);
    }

    // 盤面描画
    function renderBoard(state, hintIndexes, n) {
      board = [];
      boardElem.innerHTML = '';
      boardElem.style.gridTemplateColumns = `repeat(${n}, 40px)`;

      for (let i = 0; i < n * n; i++) {
        const cell = document.createElement('div');
        cell.classList.add('cell');
        if (state[i]) cell.classList.add('on');
        cell.dataset.index = i;
        boardElem.appendChild(cell);
        board.push(cell);
      }

      board.forEach((cell, index) => {
        cell.addEventListener('click', () => {
          if (cleared) return;
          toggle(index, n);
          stepCounterElem.textContent = `現在ステップ数${++stepCounter}手`;
          checkClear();
          updateHintDisplay();
        });
      });

      messageElem.textContent = '';
      const stepCount = hintIndexes.filter(v => v === 1).length;
      minStepElem.textContent = `最小ステップ数: ${stepCount}手`;
      scoreDisplay.textContent = '';
      updateHintDisplay();
    }

    // セル反転
    function toggle(index, n) {
      const r = Math.floor(index / n);
      const c = index % n;
      [[0,0],[1,0],[-1,0],[0,1],[0,-1]].forEach(([dr, dc]) => {
        const nr = r + dr, nc = c + dc;
        if (nr >= 0 && nr < n && nc >= 0 && nc < n) {
          board[nr * n + nc].classList.toggle('on');
        }
      });
    }

    // クリア判定＋スコア計算
    function checkClear() {
      const isCleared = board.every(cell => !cell.classList.contains('on'));
      if (isCleared) {
        messageElem.textContent = 'クリア！✨';
        cleared = true;
        boardElem.classList.add('disabled');

        const minStep = currentSolution.filter(v => v === 1).length;
        const score = calculateScore(size, stepCounter, minStep);
        scoreDisplay.textContent = `スコア: ${score}点`;
        if(updateHighScore(gameName,score)) alert("ハイスコアを更新しました");
      }
    }

    // スコア計算
    function calculateScore(size, stepCounter, minStep) {
      if (hintUsed) return 0; // 一度でもヒントを使ったら0点

      let baseScore = (minStep / stepCounter) * 100;
      baseScore *= size;

      const minStepFactor = minStep / (size * size);
      baseScore *= minStepFactor;

      return Math.floor(baseScore);
    }

    // 初期状態に解を適用
    function applyMoves(moves, n) {
      const state = Array(n * n).fill(0);
      moves.forEach((val, idx) => {
        if (val === 1) {
          const r = Math.floor(idx / n), c = idx % n;
          [[0,0],[1,0],[-1,0],[0,1],[0,-1]].forEach(([dr, dc]) => {
            const nr = r + dr, nc = c + dc;
            if (nr >= 0 && nr < n && nc >= 0 && nc < n) {
              state[nr * n + nc] ^= 1;
            }
          });
        }
      });
      return state;
    }

    // 行列生成
    function generateMatrix(n) {
      const A = [];
      for (let i = 0; i < n * n; i++) {
        const row = Array(n * n).fill(0);
        const r = Math.floor(i / n), c = i % n;
        [[0,0],[1,0],[-1,0],[0,1],[0,-1]].forEach(([dr, dc]) => {
          const nr = r + dr, nc = c + dc;
          if (nr >= 0 && nr < n && nc >= 0 && nc < n) {
            row[nr * n + nc] = 1;
          }
        });
        A.push(row);
      }
      return A;
    }

    // GF(2) 解法
    function solveGF2(A, b) {
      const n = b.length;
      const mat = A.map(row => [...row]);
      const res = [...b];
      const x = Array(n).fill(0);

      for (let col = 0; col < n; col++) {
        let pivot = -1;
        for (let row = col; row < n; row++) {
          if (mat[row][col] === 1) {
            pivot = row;
            break;
          }
        }
        if (pivot === -1) return null;
        [mat[col], mat[pivot]] = [mat[pivot], mat[col]];
        [res[col], res[pivot]] = [res[pivot], res[col]];

        for (let row = 0; row < n; row++) {
          if (row !== col && mat[row][col] === 1) {
            for (let k = 0; k < n; k++) {
              mat[row][k] ^= mat[col][k];
            }
            res[row] ^= res[col];
          }
        }
      }

      for (let i = 0; i < n; i++) x[i] = res[i];
      return x;
    }

    // 現在盤面取得
    function getCurrentBoardState(n) {
      return board.map(cell => cell.classList.contains('on') ? 1 : 0);
    }

    // ヒント表示更新
    function updateHintDisplay() {
      board.forEach(cell => cell.classList.remove('hint'));
      if (!hintOn || cleared) return;

      const n = size;
      const A = generateMatrix(n);
      const b = getCurrentBoardState(n);
      const solution = solveGF2(A, b);
      if (!solution) return;

      board.forEach((cell, index) => {
        if (solution[index] === 1) cell.classList.add('hint');
      });
    }

    // 初期表示
    gridSizeSelect.value = 3;
    createSolvableBoard(3);
  </script>
</body>
</html>
