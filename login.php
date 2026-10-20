<?php
require_once __DIR__ . '/db.php';
$stmt = $pdo->prepare("
    SELECT institution_name, logo
    FROM institution_settings
    WHERE id = 1
    LIMIT 1
");
$stmt->execute();

$settings = $stmt->fetch();

$company = [
    'name' => $settings['institution_name'] ?? 'Company Name',
    'logo' => !empty($settings['logo'])
        ? 'data:image/png;base64,' . base64_encode($settings['logo'])
        : ''
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="color-scheme" content="dark">
<?php if (!empty($settings['logo'])): ?>
<link rel="icon" href="logo.php?v=<?= md5($settings['logo']) ?>">
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
:root{
  --bg:#010014; --ink:#eef2ff; --muted:#9aa6c4;
  --accent:#5eead4; --accent2:#818cf8; --stroke:rgba(255,255,255,.14);
}
*,*::before,*::after{box-sizing:border-box}
html{font-size:clamp(15px,14px + .3vw,22px);-webkit-text-size-adjust:100%}
body{
  margin:0; min-height:100vh; min-height:100dvh; display:grid; place-items:center;
  padding:max(1rem,env(safe-area-inset-top)) max(1rem,env(safe-area-inset-right)) max(1rem,env(safe-area-inset-bottom)) max(1rem,env(safe-area-inset-left));
  font-family:'DM Sans',system-ui,-apple-system,'Segoe UI',Roboto,sans-serif; color:var(--ink);
  background:#010008;
  overflow-x:hidden;
}
#bg{position:fixed;inset:0;width:100%;height:100%;z-index:0;pointer-events:none}
.orb{position:fixed;z-index:0;border-radius:50%;filter:blur(80px);opacity:.35;pointer-events:none;animation:drift 20s ease-in-out infinite alternate}
.orb{display:none}
.o1{width:38vmax;height:38vmax;left:-12vmax;top:-12vmax;background:radial-gradient(circle,#6366f1,transparent 70%)}
.o2{width:34vmax;height:34vmax;right:-10vmax;bottom:-12vmax;background:radial-gradient(circle,#14b8a6,transparent 70%);animation-delay:-8s}
@keyframes drift{to{transform:translate(6vmax,4vmax) scale(1.15)}}

.card{
  position:relative;
  z-index:1;
  width:min(100%,26rem);
  padding:clamp(1.5rem,5vw,2.5rem);
  border-radius:1.75rem;
  background: rgba(1, 0, 20, 0.18);
  border:1px solid var(--stroke);
  -webkit-backdrop-filter: blur(3px) saturate(140%); 
  backdrop-filter: blur(3px) saturate(140%);   
  box-shadow:0 30px 80px -20px rgba(0,0,0,.65),inset 0 1px 0 rgba(255,255,255,.16);
  animation:rise .9s cubic-bezier(.2,.8,.2,1) both;
}
@supports not ((backdrop-filter: blur(1px)) or (-webkit-backdrop-filter: blur(1px))) {
  .card {
    background: rgba(1, 0, 20, 0.35);
  }
}
@keyframes rise{from{opacity:0;transform:translateY(24px) scale(.97)}}
.card>*{animation:rise .8s cubic-bezier(.2,.8,.2,1) both}
.brand{animation-delay:.15s}
form{animation-delay:.3s}

.brand{
  text-align:center;
  margin-bottom:1.75rem;
}
.logo{
  width:7rem;
  height:7rem;
  margin:0 auto 1rem;
  border-radius:1.25rem;
  display:grid;
  place-items:center;
  overflow:hidden;
  background:rgba(255,255,255,.07);
  border:1px solid var(--stroke);
  font-size:1.8rem;
  color:var(--accent);
}

.logo img{
  display:block;
  width:100%;
  height:100%;
  max-width:100%;
  max-height:100%;
  object-fit:fill;
  padding:0;
  margin:0;
}
h1{margin:0;font-family:"Cinzel Decorative",serif; color: white;;font-size:clamp(1.35rem,5vw,1.65rem);font-weight:900;font-style:normal;line-height:1.2;letter-spacing:-.01em;overflow-wrap:anywhere}

.field+.field{margin-top:1.1rem}
label{display:block;margin-bottom:.45rem;font-size:.85rem;font-weight:500;color:var(--muted)}
.control{
  display:flex;align-items:center;gap:.75rem;height:3.25rem;padding:0 .75rem 0 1rem;border-radius:1rem;
  background:rgba(8,12,28,.45);border:1px solid var(--stroke);
  transition:border-color .3s,box-shadow .3s,background .3s,transform .3s;
}
.control:hover{border-color:rgba(255,255,255,.26)}
.control:focus-within{border-color:var(--accent);background:rgba(8,12,28,.62);box-shadow:0 0 0 4px rgba(94,234,212,.15);transform:translateY(-1px)}
.lead{color:var(--muted);width:1.1rem;text-align:center;transition:color .3s}
.control:focus-within .lead{color:var(--accent)}
input{flex:1;min-width:0;height:100%;border:0;outline:0;background:none;color:var(--ink);font:inherit;font-size:max(16px,1rem)}
input::placeholder{color:rgba(154,166,196,.55)}
input:-webkit-autofill{-webkit-text-fill-color:var(--ink);box-shadow:0 0 0 40rem #0d1330 inset;caret-color:var(--ink)}
.count{font-size:.75rem;color:var(--muted);font-variant-numeric:tabular-nums}

.eye{
  position:relative;flex:none;width:2.50rem;height:2.50rem;border:0;border-radius:.65rem;background:none;color:var(--muted);cursor:pointer;
  display:grid;place-items:center;transition:background .25s,color .25s;
}
.eye:hover{background:rgba(255,255,255,.09);color:var(--ink)}
.eye i{grid-area:1/1;transition:opacity .25s,transform .35s}
.eye .slash{opacity:0;transform:rotate(-90deg) scale(.5)}
.eye[aria-pressed="true"] .open{opacity:0;transform:rotate(90deg) scale(.5)}
.eye[aria-pressed="true"] .slash{opacity:1;transform:none}
.eye[aria-pressed="true"]{color:var(--accent)}

.login{
  width:100%;height:3.25rem;margin-top:1.75rem;border:0;border-radius:1rem;cursor:pointer;
  display:flex;align-items:center;justify-content:center;gap:.65rem;
  font:600 1rem 'Sora',sans-serif;color:#04121a;
  background:linear-gradient(120deg,var(--accent),#7dd3fc 50%,var(--accent2)) 0 0/200% 100%;
  box-shadow:0 12px 30px -10px rgba(94,234,212,.55);
  transition:background-position .6s,transform .25s,box-shadow .3s;
}
.login i{transition:transform .3s}
.login:hover{background-position:100% 0;transform:translateY(-2px);box-shadow:0 16px 36px -10px rgba(129,140,248,.7)}
.login:hover i{transform:translateX(4px)}
.login:active{transform:scale(.98)}
:focus-visible{outline:3px solid var(--accent);outline-offset:3px}
.control input:focus-visible{outline:0}

@media (max-height:520px){.brand{margin-bottom:1rem}.logo{width:3.5rem;height:3.5rem;margin-bottom:.6rem}}
@media (prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition-duration:.01ms!important}}
</style>
</head>
<body>
<div class="orb o1"></div><div class="orb o2"></div>
<canvas id="bg" aria-hidden="true"></canvas>

<main class="card">
  <header class="brand">
    <div class="logo">
      <img id="logo" alt="" hidden>
    </div>
    <label><h1 id="companyName">Company Name</h1></label>
  </header>

  <form id="loginForm" novalidate>
    <div class="field">
      <label for="username">Username</label>
      <div class="control">
        <i class="fa-solid fa-user lead" aria-hidden="true"></i>
        <input id="username" name="username" type="text" maxlength="50" placeholder="Enter your username"
               autocomplete="username" autocapitalize="none" autocorrect="off" spellcheck="false" aria-describedby="count">
        <span class="count" id="count">0/50</span>
      </div>
    </div>

    <div class="field">
      <label for="password">Password</label>
      <div class="control">
        <i class="fa-solid fa-lock lead" aria-hidden="true"></i>
        <input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password">
        <button class="eye" id="eye" type="button" aria-label="Show password" aria-pressed="false">
          <i class="fa-solid fa-eye open" aria-hidden="true"></i>
          <i class="fa-solid fa-eye-slash slash" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <button class="login" type="submit"><span>Log in</span><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i></button>
  </form>
</main>

<script>
(() => {
  /* ===== Placeholders: fill these from your MySQL table values (e.g. with PHP) =====
     name: '<?= htmlspecialchars($company["name"]) ?>'
     logo: '<?= htmlspecialchars($company["logo_url"]) ?>'  (leave empty to show the icon) */
const COMPANY = {
    name: <?= json_encode($company['name'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>,
    logo: <?= json_encode($company['logo']) ?>
};

  const nameEl = document.getElementById('companyName');
const logo = document.getElementById('logo');
nameEl.textContent = COMPANY.name;
  document.title = COMPANY.name + ' - Login';
if (COMPANY.logo) {logo.alt = COMPANY.name + ' logo';
  logo.onload = () => { logo.hidden = false; };
  logo.onerror = () => { logo.hidden = true; };
  logo.src = COMPANY.logo;
}

  /* ===== Username: lowercase only, no whitespace of any kind, max 50 ===== */
  const u = document.getElementById('username'), count = document.getElementById('count');
  const clean = v => v.replace(/[\s\u00A0\u200B-\u200D\u2060\uFEFF]/g, '').toLowerCase().slice(0, 50);
  u.addEventListener('keydown', e => { if (e.key === ' ' || e.code === 'Space' || e.key === 'Spacebar') e.preventDefault(); });
  u.addEventListener('input', () => {
    const raw = u.value, pos = u.selectionStart, v = clean(raw);
    if (v !== raw) { const at = clean(raw.slice(0, pos)).length; u.value = v; u.setSelectionRange(at, at); }
    count.textContent = v.length + '/50';
  });

  /* ===== Show / hide password ===== */
  const p = document.getElementById('password'), eye = document.getElementById('eye');
  eye.addEventListener('click', () => {
    const s = p.selectionStart, e = p.selectionEnd, show = p.type === 'password';
    p.type = show ? 'text' : 'password';
    eye.setAttribute('aria-pressed', show);
    eye.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    p.focus({ preventScroll: true });
    try { p.setSelectionRange(s, e); } catch (_) {}
  });

  document.getElementById('loginForm').addEventListener('submit', e => e.preventDefault()); // login action comes later

  /* ===== Interactive particle network ===== */
  const cv = document.getElementById('bg'), ctx = cv.getContext('2d');
  const still = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const mouse = { x: null, y: null, r: 150 };
  let w, h, L, P = [], raf;

  const spawn = () => ({
  x: Math.random() * w,
  y: Math.random() * h,
  vx: (Math.random() - .5) * .5,
  vy: (Math.random() - .5) * .5,
  r: (Math.random() * 1.2 + 0.8)
});
  function resize() {
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    w = innerWidth; h = innerHeight;
    cv.width = w * dpr; cv.height = h * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    L = Math.min(160, Math.max(90, w / 9));
    const n = Math.min(500, Math.round(w * h / 11000) * 2);

P.length = 0;

const cols = Math.ceil(Math.sqrt(n * w / h));
const rows = Math.ceil(n / cols);

for (let i = 0; i < n; i++) {
  const col = i % cols;
  const row = Math.floor(i / cols);

  P.push({
    ...spawn(),
    x: (col + Math.random() * 0.8 + 0.1) * w / cols,
    y: (row + Math.random() * 0.8 + 0.1) * h / rows
  });
}
    if (still) frame();
  }

  function frame() {
    ctx.clearRect(0, 0, w, h);
    for (const q of P) {
      if (!still) {
        if (mouse.x !== null) {
          const dx = q.x - mouse.x, dy = q.y - mouse.y, d = Math.hypot(dx, dy);
          if (d < mouse.r && d > 0) { const f = (1 - d / mouse.r) * 1.6; q.x += dx / d * f; q.y += dy / d * f; }
        }
        q.x += q.vx; q.y += q.vy;
        if (q.x < 0 || q.x > w) q.vx *= -1;
        if (q.y < 0 || q.y > h) q.vy *= -1;
      }
      ctx.fillStyle = 'rgba(165,180,252,.75)';
      ctx.beginPath(); ctx.arc(q.x, q.y, q.r, 0, 6.283); ctx.fill();
    }
    ctx.lineWidth = 1;
    for (let i = 0; i < P.length; i++) {
      for (let j = i + 1; j < P.length; j++) {
        const dx = P[i].x - P[j].x, dy = P[i].y - P[j].y, d = Math.hypot(dx, dy);
        if (d < L) {
          ctx.strokeStyle = `rgba(129,140,248,${(1 - d / L) * .35})`;
          ctx.beginPath(); ctx.moveTo(P[i].x, P[i].y); ctx.lineTo(P[j].x, P[j].y); ctx.stroke();
        }
      }
      if (mouse.x !== null) {
        const d = Math.hypot(P[i].x - mouse.x, P[i].y - mouse.y);
        if (d < mouse.r) {
          ctx.strokeStyle = `rgba(94,234,212,${(1 - d / mouse.r) * .8})`;
          ctx.beginPath(); ctx.moveTo(P[i].x, P[i].y); ctx.lineTo(mouse.x, mouse.y); ctx.stroke();
        }
      }
    }
    if (!still) raf = requestAnimationFrame(frame);
  }

  const track = e => { mouse.x = e.clientX; mouse.y = e.clientY; };
  addEventListener('pointermove', track, { passive: true });
  addEventListener('pointerdown', track, { passive: true });
  addEventListener('pointerup', e => { if (e.pointerType !== 'mouse') mouse.x = mouse.y = null; });
  addEventListener('pointercancel', () => { mouse.x = mouse.y = null; });
  document.addEventListener('mouseleave', () => { mouse.x = mouse.y = null; });
  addEventListener('resize', resize);
  document.addEventListener('visibilitychange', () => {
    if (still) return;
    if (document.hidden) cancelAnimationFrame(raf); else raf = requestAnimationFrame(frame);
  });

  resize();
  if (!still) raf = requestAnimationFrame(frame);
})();
</script>
</body>
</html>