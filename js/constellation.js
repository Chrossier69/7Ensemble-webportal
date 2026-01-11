/**
 * 7 Ensemble - Constellation Visualization
 * Canvas-based constellation rendering with rotating members
 */

class Constellation {
    constructor(canvasId, options = {}) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) {
            console.error(`Canvas ${canvasId} not found`);
            return;
        }

        this.ctx = this.canvas.getContext('2d');
        this.members = options.members || 7;
        this.centerText = options.centerText || 'Alcyone';
        this.gainText = options.gainText || '';
        this.title = options.title || '';
        this.subtitle = options.subtitle || '';
        this.colors = options.colors || ['#ff6b6b', '#4ecdc4', '#45b7d1', '#feca57', '#f093fb', '#5c7cfa', '#cc5de8'];

        this.rotation = 0;
        this.centerX = 0;
        this.centerY = 0;
        this.centerRadius = 40;
        this.orbitRadius = 100;
        this.memberRadius = 25;

        this.init();
    }

    init() {
        this.resizeCanvas();
        window.addEventListener('resize', () => this.resizeCanvas());
        this.animate();
    }

    resizeCanvas() {
        // Get container dimensions
        const container = this.canvas.parentElement;
        const size = Math.min(container.offsetWidth, 400);

        this.canvas.width = size;
        this.canvas.height = size;
        this.centerX = size / 2;
        this.centerY = size / 2;

        // Scale radius based on canvas size
        this.orbitRadius = size * 0.3;
        this.centerRadius = size * 0.12;
        this.memberRadius = size * 0.08;
    }

    drawCircle(x, y, radius, fillColor, text = '', textColor = '#ffffff') {
        // Draw circle with glow effect
        this.ctx.beginPath();
        this.ctx.arc(x, y, radius, 0, Math.PI * 2);

        // Gradient fill
        const gradient = this.ctx.createRadialGradient(x, y, 0, x, y, radius);
        gradient.addColorStop(0, this.lightenColor(fillColor, 20));
        gradient.addColorStop(1, fillColor);
        this.ctx.fillStyle = gradient;
        this.ctx.fill();

        // Outer glow
        this.ctx.shadowBlur = 15;
        this.ctx.shadowColor = fillColor;
        this.ctx.strokeStyle = this.lightenColor(fillColor, 40);
        this.ctx.lineWidth = 2;
        this.ctx.stroke();
        this.ctx.shadowBlur = 0;

        // Draw text
        if (text) {
            this.ctx.fillStyle = textColor;
            this.ctx.font = `bold ${radius * 0.5}px Arial`;
            this.ctx.textAlign = 'center';
            this.ctx.textBaseline = 'middle';
            this.ctx.fillText(text, x, y);
        }
    }

    drawOrbit() {
        // Draw orbit path
        this.ctx.beginPath();
        this.ctx.arc(this.centerX, this.centerY, this.orbitRadius, 0, Math.PI * 2);
        this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
        this.ctx.lineWidth = 1;
        this.ctx.setLineDash([5, 5]);
        this.ctx.stroke();
        this.ctx.setLineDash([]);
    }

    drawConnection(x1, y1, x2, y2, color) {
        // Draw connecting line
        this.ctx.beginPath();
        this.ctx.moveTo(x1, y1);
        this.ctx.lineTo(x2, y2);
        this.ctx.strokeStyle = `${color}40`;
        this.ctx.lineWidth = 2;
        this.ctx.stroke();
    }

    lightenColor(color, percent) {
        // Simple color lightener
        const num = parseInt(color.replace('#', ''), 16);
        const amt = Math.round(2.55 * percent);
        const R = Math.min(255, ((num >> 16) & 0xFF) + amt);
        const G = Math.min(255, ((num >> 8) & 0xFF) + amt);
        const B = Math.min(255, (num & 0xFF) + amt);
        return `rgb(${R},${G},${B})`;
    }

    render() {
        // Clear canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Draw orbit path
        this.drawOrbit();

        // Draw connecting lines from center to members
        for (let i = 0; i < this.members; i++) {
            const angle = (Math.PI * 2 * i / this.members) + this.rotation;
            const x = this.centerX + Math.cos(angle) * this.orbitRadius;
            const y = this.centerY + Math.sin(angle) * this.orbitRadius;
            const color = this.colors[i % this.colors.length];

            this.drawConnection(this.centerX, this.centerY, x, y, color);
        }

        // Draw orbiting members
        for (let i = 0; i < this.members; i++) {
            const angle = (Math.PI * 2 * i / this.members) + this.rotation;
            const x = this.centerX + Math.cos(angle) * this.orbitRadius;
            const y = this.centerY + Math.sin(angle) * this.orbitRadius;
            const color = this.colors[i % this.colors.length];

            this.drawCircle(x, y, this.memberRadius, color, (i + 1).toString());
        }

        // Draw center circle (Alcyone)
        this.drawCircle(
            this.centerX,
            this.centerY,
            this.centerRadius,
            '#ffd93b',
            this.centerText,
            '#333'
        );
    }

    animate() {
        this.rotation += 0.003; // Slow rotation speed
        this.render();
        requestAnimationFrame(() => this.animate());
    }
}

// Initialize constellations when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Triangulum Constellation (3 members)
    if (document.getElementById('triangulum-canvas')) {
        new Constellation('triangulum-canvas', {
            members: 3,
            centerText: 'Alcyone',
            title: 'Triangulum',
            subtitle: '3 personnes',
            gainText: '7\'789€',
            colors: ['#f093fb', '#f5576c', '#fa709a']
        });
    }

    // Pléiades Constellation (7 members)
    if (document.getElementById('pleiades-canvas')) {
        new Constellation('pleiades-canvas', {
            members: 7,
            centerText: 'Alcyone',
            title: 'Les Pléiades',
            subtitle: '7 personnes',
            gainText: '1\'575\'747€',
            colors: ['#ff6b6b', '#4ecdc4', '#45b7d1', '#feca57', '#f093fb', '#5c7cfa', '#cc5de8']
        });
    }
});
