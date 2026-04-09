/**
 * SITE-NAV  –  Self-contained, conflict-free header logic
 * Function names prefixed "sn" to avoid clashing with any
 * existing JS (main.js, modal.js, etc.)
 */

function snOpen() {
    var overlay = document.getElementById('sn-overlay');
    if (overlay) { overlay.style.display = 'flex'; }
}

function snClose() {
    var overlay = document.getElementById('sn-overlay');
    if (overlay) { overlay.style.display = 'none'; }
}
document.addEventListener("DOMContentLoaded", () => {
  const video = document.getElementById("bannerVideo");
  const btn = document.getElementById("unmuteBtn");
  if (!video || !btn) return;

  const STOP_AT = 7;

  function stopAt7s() {
    if (video.currentTime >= STOP_AT) {
      video.pause();
      video.currentTime = 0;
      video.removeEventListener("timeupdate", stopAt7s);
      btn.textContent = "🔊 Activer le son";
    }
  }

  btn.addEventListener("click", async () => {
    try {
      video.currentTime = 0;
      video.muted = false;
      video.volume = 1;
      video.addEventListener("timeupdate", stopAt7s);
      await video.play();
      btn.textContent = "⏸ Stop (7s)";
    } catch (e) {
      console.log("Play blocked:", e);
    }
  });
});