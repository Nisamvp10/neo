

    <!-- Load Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Great+Vibes&family=Orbitron&display=swap" rel="stylesheet">

    <style>
       

        input, select {
            padding: 10px;
            margin: 10px;
            width: 250px;
        }

        canvas {
            margin-top: 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }
    </style>



<h2>Neon Custom Preview</h2>

<!-- Text Input -->
<input type="text" id="text" placeholder="Type your text">

<br>

<!-- Font Select -->
<select id="font">
    <option value="Arial">Arial</option>
    <option value="Pacifico">Stylish</option>
    <option value="Great Vibes">Sassy</option>
    <option value="Prosto One">Prosto One</option>
</select>

<br>

<!-- Color -->
<input type="color" id="color" value="#00ffff">

<br>

<!-- Canvas -->
<canvas id="canvas" width="800" height="300"></canvas>

<script>

const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

// Draw Function
function drawText() {

    let text = document.getElementById("text").value || "Your Text";
    let font = document.getElementById("font").value;
    let color = document.getElementById("color").value;

    let brightColor = brightenColor(color, 80); // 🔥 brighter

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.font = "80px '" + font + "'";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";

    let x = canvas.width / 2;
    let y = canvas.height / 2;

    // 🔥 OUTER GLOW
    ctx.shadowColor = brightColor;
    ctx.shadowBlur = 50;
    ctx.fillStyle = brightColor;
    ctx.fillText(text, x, y);

    // 🔥 MID GLOW
    ctx.shadowBlur = 30;
    ctx.fillText(text, x, y);

    // 🔥 INNER GLOW
    ctx.shadowBlur = 15;
    ctx.fillText(text, x, y);

    // 🔥 CORE TEXT (sharp white)
    ctx.shadowBlur = 0;
    ctx.fillStyle = "#ffffff";
    ctx.fillText(text, x, y);
}

function brightenColor(hex, percent = 40) {
    let num = parseInt(hex.replace("#", ""), 16);

    let r = (num >> 16) + percent;
    let g = ((num >> 8) & 0x00FF) + percent;
    let b = (num & 0x0000FF) + percent;

    r = r > 255 ? 255 : r;
    g = g > 255 ? 255 : g;
    b = b > 255 ? 255 : b;

    return `rgb(${r},${g},${b})`;
}
// Wait for fonts to load (VERY IMPORTANT)
document.fonts.ready.then(() => {
    drawText();
});

// Events
document.getElementById("text").addEventListener("keyup", drawText);
document.getElementById("font").addEventListener("change", async () => {

    let font = document.getElementById("font").value;

    await document.fonts.load("80px '" + font + "'");

    drawText();
});
document.getElementById("color").addEventListener("change", drawText);

</script>