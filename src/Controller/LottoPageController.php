<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

final class LottoPageController
{
    public function index(): Response
    {
        $html = <<<'HTML'
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lotto Machine</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@500;700&family=Space+Grotesk:wght@400;600&display=swap');
    :root {
      --ink: #0e0b1f;
      --paper: #f6f1e9;
      --accent: #ff7a00;
      --accent-2: #0f8b8d;
      --glass: rgba(255, 255, 255, 0.22);
      --shadow: rgba(8, 6, 18, 0.2);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Space Grotesk", "Segoe UI", sans-serif;
      color: var(--ink);
      min-height: 100vh;
      background: radial-gradient(circle at 12% 12%, #ffe6c7 0, transparent 55%),
                  radial-gradient(circle at 88% 18%, #c6f6f4 0, transparent 52%),
                  linear-gradient(160deg, #f6f1e9 0, #f3e7db 42%, #efe0d4 100%);
    }
    .page {
      max-width: 1100px;
      margin: 0 auto;
      padding: 48px 20px 64px;
      display: grid;
      gap: 32px;
    }
    header {
      display: grid;
      gap: 12px;
    }
    h1 {
      font-family: "Fraunces", serif;
      font-size: clamp(32px, 4vw, 56px);
      margin: 0;
      letter-spacing: -0.02em;
    }
    .subtitle {
      font-size: 16px;
      max-width: 640px;
      line-height: 1.6;
    }
    .board {
      display: grid;
      gap: 24px;
      grid-template-columns: minmax(0, 1fr);
      align-items: start;
    }
    .controls {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      align-items: flex-end;
      padding: 20px;
      border-radius: 18px;
      background: rgba(255, 255, 255, 0.7);
      box-shadow: 0 18px 45px -35px var(--shadow);
    }
    label {
      display: grid;
      gap: 6px;
      font-size: 14px;
    }
    input[type="number"] {
      width: 150px;
      padding: 10px 12px;
      border-radius: 12px;
      border: 1px solid #cbbba8;
      background: #fffdf9;
      font-size: 16px;
      font-family: inherit;
    }
    button {
      padding: 12px 18px;
      border-radius: 999px;
      border: none;
      background: linear-gradient(135deg, var(--accent), #ffb347);
      color: #1d0e00;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      box-shadow: 0 12px 25px -18px rgba(255, 122, 0, 0.8);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    button:active {
      transform: translateY(2px) scale(0.98);
      box-shadow: 0 8px 16px -12px rgba(255, 122, 0, 0.8);
    }
    .machine-wrap {
      display: grid;
      gap: 22px;
      align-items: center;
      justify-items: center;
      padding: 28px 16px 12px;
      border-radius: 28px;
      background: rgba(255, 255, 255, 0.55);
      box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.6), 0 30px 60px -45px var(--shadow);
      position: relative;
      overflow: hidden;
    }
    .machine {
      width: min(420px, 92vw);
      aspect-ratio: 1;
      border-radius: 50%;
      border: 6px solid rgba(15, 139, 141, 0.4);
      background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.6), transparent 50%),
                  radial-gradient(circle at 70% 70%, rgba(15,139,141,0.2), transparent 45%),
                  var(--glass);
      position: relative;
      display: grid;
      place-items: center;
      box-shadow: 0 30px 50px -40px rgba(15, 139, 141, 0.9);
    }
    .machine::after {
      content: "";
      position: absolute;
      width: 75%;
      height: 75%;
      border-radius: 50%;
      border: 2px dashed rgba(15, 139, 141, 0.4);
    }
    .ball-cloud {
      position: absolute;
      inset: 12%;
    }
    .ball {
      position: absolute;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      font-weight: 600;
      color: #2b1a00;
      background: radial-gradient(circle at 30% 30%, #fff 0, #ffe29a 45%, #ffb347 100%);
      box-shadow: 0 12px 18px -12px rgba(0, 0, 0, 0.4);
      transition: transform 0.6s ease, opacity 0.3s ease;
    }
    .machine.shake {
      animation: shake 1s ease-in-out;
    }
    @keyframes shake {
      0% { transform: translateX(0) rotate(0deg); }
      20% { transform: translateX(-6px) rotate(-2deg); }
      40% { transform: translateX(6px) rotate(2deg); }
      60% { transform: translateX(-4px) rotate(-1deg); }
      80% { transform: translateX(4px) rotate(1deg); }
      100% { transform: translateX(0) rotate(0deg); }
    }
    .tray {
      width: min(520px, 95vw);
      min-height: 80px;
      padding: 16px 20px;
      border-radius: 20px;
      background: #fffdf9;
      border: 1px solid #d8c9b7;
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      justify-content: center;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.7);
    }
    .drawn {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      background: radial-gradient(circle at 35% 35%, #ffffff 0, #c6f6f4 48%, #7dd9d5 100%);
      color: #0e3f3f;
      display: grid;
      place-items: center;
      font-weight: 700;
      transform: translateY(8px);
      animation: pop 0.5s ease forwards;
    }
    @keyframes pop {
      to { transform: translateY(0); }
    }
    .note {
      font-size: 13px;
      opacity: 0.7;
    }
    @media (min-width: 860px) {
      .board {
        grid-template-columns: 320px minmax(0, 1fr);
        align-items: center;
      }
      .controls {
        flex-direction: column;
        align-items: stretch;
      }
      input[type="number"] {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <main class="page">
    <header>
      <h1>Maszyna Lotto</h1>
      <div class="subtitle">
        Wybierz ile kulek chcesz wylosowac, nacisnij przycisk i obserwuj jak maszyna losuje je z bębna.
      </div>
    </header>

    <section class="board">
      <div class="controls">
        <label>
          Liczba kulek do wylosowania
          <input id="ballCount" type="number" min="1" max="12" value="6" />
        </label>
        <button id="drawBtn" type="button">Losuj</button>
        <div class="note">Zakres liczb: 1-59. Maksymalnie 12 kulek.</div>
      </div>

      <div class="machine-wrap">
        <div class="machine" id="machine">
          <div class="ball-cloud" id="ballCloud"></div>
        </div>
        <div class="tray" id="tray"></div>
      </div>
    </section>
  </main>

  <script>
    const ballCloud = document.getElementById('ballCloud');
    const tray = document.getElementById('tray');
    const drawBtn = document.getElementById('drawBtn');
    const ballCountInput = document.getElementById('ballCount');
    const machine = document.getElementById('machine');
    const maxNumber = 59;
    const maxBalls = 12;

    const createFloatingBalls = () => {
      ballCloud.innerHTML = '';
      for (let i = 0; i < 12; i += 1) {
        const ball = document.createElement('div');
        ball.className = 'ball';
        ball.textContent = Math.floor(Math.random() * maxNumber) + 1;
        const angle = (Math.PI * 2 * i) / 12;
        const radius = 120 + Math.random() * 40;
        const x = Math.cos(angle) * radius;
        const y = Math.sin(angle) * radius;
        ball.style.transform = `translate(${x}px, ${y}px)`;
        ballCloud.appendChild(ball);
      }
    };

    const drawNumbers = (count) => {
      const pool = Array.from({ length: maxNumber }, (_, i) => i + 1);
      const result = [];
      for (let i = 0; i < count; i += 1) {
        const idx = Math.floor(Math.random() * pool.length);
        result.push(pool.splice(idx, 1)[0]);
      }
      return result;
    };

    const renderDraw = (numbers) => {
      tray.innerHTML = '';
      numbers.forEach((num, index) => {
        const ball = document.createElement('div');
        ball.className = 'drawn';
        ball.textContent = num;
        ball.style.animationDelay = `${index * 0.08}s`;
        tray.appendChild(ball);
      });
    };

    drawBtn.addEventListener('click', () => {
      const count = Math.min(Math.max(parseInt(ballCountInput.value, 10) || 1, 1), maxBalls);
      ballCountInput.value = String(count);

      machine.classList.remove('shake');
      void machine.offsetWidth;
      machine.classList.add('shake');

      createFloatingBalls();
      const numbers = drawNumbers(count);
      setTimeout(() => renderDraw(numbers), 450);
    });

    createFloatingBalls();
    renderDraw(drawNumbers(6));
  </script>
</body>
</html>
HTML;

        return new Response($html);
    }
}
