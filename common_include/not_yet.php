
<div class="notYet_wrapper">
    <canvas></canvas>
    <p>
        죄송합니다. 현재 준비중인 페이지입니다.
    </p>
</div>
<script>
    const canvas = document.querySelector('canvas');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // Context
    const c = canvas.getContext('2d');

    let mouse = {
    x: undefined,
    y: undefined };


    let maxRadius = 40;

    const colorArray = [
    '#749bff',
    '#FFD362',
    '#FF4D4D'];


    window.addEventListener('mousemove', e => {
    mouse.x = e.x;
    mouse.y = e.y;
    });

    window.addEventListener('resize', e => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    });

    class Circle {
    constructor(x, y, dx, dy, radius) {
        this.x = x;
        this.y = y;
        this.dx = dx;
        this.dy = dy;
        this.radius = radius;
        this.minRadius = radius;
        this.color = colorArray[Math.floor(Math.random() * colorArray.length)];
    }

    draw() {
        c.beginPath();
        c.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
        c.fillStyle = this.color;
        c.fill();
        c.strokeStyle = 'transparent';
        c.stroke();
    }

    update() {
        if (this.x + this.radius > innerWidth || this.x - this.radius < 0) {
        this.dx = -this.dx;
        }

        if (this.y + this.radius > innerHeight || this.y - this.radius < 0) {
        this.dy = -this.dy;
        }

        this.x += this.dx;
        this.y += this.dy;

        if (mouse.x - this.x < 50 &&
        mouse.x - this.x > -50 &&
        mouse.y - this.y < 50 &&
        mouse.y - this.y > -50) {
        if (this.radius < maxRadius) {
            this.radius += 1;
        }
        } else if (this.radius > this.minRadius) {
        this.radius -= 1;
        }

        this.draw();
    }}


    let circleArray = [];

    for (let i = 0; i <= 600; i++) {
    let radius = Math.floor(Math.random() * 3 + 1);
    let x = Math.random() * (innerWidth - radius * 2) + radius;
    let y = Math.random() * (innerHeight - radius * 2) + radius;
    let dx = (Math.random() - 0.5) * 0.1;
    let dy = (Math.random() - 0.5) * 0.1;

    circleArray.push(new Circle(x, y, dx, dy, radius));
    }

    const animate = () => {
    requestAnimationFrame(animate);
    c.clearRect(0, 0, innerWidth, innerHeight);

    for (let i = 0; i < circleArray.length; i++) {
        circleArray[i].update();
    }
    };

    animate();
</script>