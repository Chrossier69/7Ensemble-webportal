/**
 * 7 Ensemble - Mission Community Canvas
 * Draws 7 people icons on canvas to replace empty SVG
 */

class CommunityCanvas {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) {
            console.error(`Canvas ${canvasId} not found`);
            return;
        }

        this.ctx = this.canvas.getContext('2d');
        this.colors = [
            '#ff6b6b',  // Red
            '#ffa94d',  // Orange
            '#ffd93b',  // Yellow
            '#51cf66',  // Green
            '#22b8cf',  // Cyan
            '#5c7cfa',  // Blue
            '#cc5de8'   // Purple
        ];

        this.init();
    }

    init() {
        this.resizeCanvas();
        window.addEventListener('resize', () => this.resizeCanvas());
        this.draw();
    }

    resizeCanvas() {
        // Make canvas responsive
        const container = this.canvas.parentElement;
        const width = Math.min(container.offsetWidth, 1000);
        const height = 180;

        this.canvas.width = width;
        this.canvas.height = height;

        // Redraw after resize
        this.draw();
    }

    drawPerson(x, y, color) {
        const ctx = this.ctx;

        // Head (circle)
        ctx.beginPath();
        ctx.arc(x, y, 18, 0, Math.PI * 2);
        ctx.fillStyle = color;
        ctx.fill();

        // Body (white dress/triangle shape)
        ctx.beginPath();
        ctx.moveTo(x, y + 16);
        ctx.quadraticCurveTo(x - 22, y + 50, x, y + 80);
        ctx.quadraticCurveTo(x + 22, y + 50, x, y + 16);
        ctx.closePath();
        ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
        ctx.fill();

        // Arms (white curved lines)
        ctx.beginPath();
        ctx.moveTo(x - 26, y + 35);
        ctx.quadraticCurveTo(x - 5, y + 20, x, y + 25);
        ctx.quadraticCurveTo(x + 5, y + 20, x + 26, y + 35);
        ctx.strokeStyle = 'white';
        ctx.lineWidth = 12;
        ctx.lineCap = 'round';
        ctx.stroke();
    }

    draw() {
        // Clear canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Calculate spacing based on canvas width
        const numPeople = 7;
        const totalWidth = this.canvas.width;
        const spacing = totalWidth / (numPeople + 1);
        const yPosition = 60;

        // Draw 7 people
        for (let i = 0; i < numPeople; i++) {
            const x = spacing * (i + 1);
            const color = this.colors[i];
            this.drawPerson(x, yPosition, color);
        }
    }
}

// Initialize when DOM is loaded (only on mission page)
document.addEventListener('DOMContentLoaded', () => {
    const communityCanvas = document.getElementById('community-canvas');
    if (communityCanvas) {
        new CommunityCanvas('community-canvas');
    }
});
