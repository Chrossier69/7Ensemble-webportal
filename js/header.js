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
