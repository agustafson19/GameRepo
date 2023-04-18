<!DOCTYPE html>
<html>
<body>
<h1>
    Score: <span id="leftscore">0</span> | <span id="rightscore">0</span>
</h1>
<canvas id="canvas"></canvas>
<script>

var keyboard = {
    lup: false,
    ldn: false,
    rup: false,
    rdn: false
}

// a is 65 | look up an ASCII chart
var keymap = {
    87: 'lup', // w
    83: 'ldn', // s
    73: 'rup', // i
    75: 'rdn'  // k
}

function keydown(event) {
    keyboard[keymap[event.keyCode]] = true
}

function keyup(event) {
    keyboard[keymap[event.keyCode]] = false
}

window.addEventListener("keydown", keydown, false)
window.addEventListener("keyup", keyup, false)

var width = 640
var height = 480

var leftscore = 0
var rightscore = 0
var leftscoretext = document.getElementById("leftscore")
var rightscoretext = document.getElementById("rightscore")

var l = {
    w: 10,
    h: 50,
    x: 15,
    y: height / 2 - 25,
    s: .4
}

var r = {
    w: 10,
    h: 50,
    x: width - 10 - 15,
    y: height / 2 - 25,
    s: .4
}

var b = {
    w: 10,
    h: 10,
    x: 50,
    y: height / 2 - 5,
    u: 1,
    v: -1,
    s: .3
}

function rectcol(a,b) {
    return a.x<=b.x+b.w&&b.x<=a.x+a.w&&b.y<=a.y+a.h&&a.y<=b.y+b.h
}

function update(delta) {
    if (keyboard.lup && 0 < l.y) {
        l.y -= delta*l.s
    }
    if (keyboard.ldn && l.y+l.h < height) {
        l.y += delta*l.s
    }
    if (keyboard.rup && 0 < r.y) {
        r.y -= delta*r.s
    }
    if (keyboard.rdn && r.y+r.h < height) {
        r.y += delta*r.s
    }
    if (b.y <= 0) {
        b.v = 1
    }
    if (height <= b.y + b.h) {
        b.v = -1
    }
    if (rectcol(l,b)) {
        b.u = 1
    }
    if (rectcol(r,b)) {
        b.u = -1
    }
    b.x += delta * b.u * b.s
    b.y += delta * b.v * b.s
    if (b.x <= 0) {
        b.x = 50
        b.y = height/2 - b.h/2
        b.u = 1
        b.v = 1
        rightscore++
        rightscoretext.innerHTML = rightscore
    }
    if (width <= b.x+b.w) {
        b.x = 50
        b.y = height/2 - b.h/2
        b.u = 1
        b.v = 1
        leftscore++
        leftscoretext.innerHTML = leftscore
    }
}

function drawobj(ctx,obj) {
    ctx.fillRect(obj.x,obj.y,obj.w,obj.h)
}

function draw() {
    ctx.clearRect(0, 0, width, height)
    drawobj(ctx,l)
    drawobj(ctx,r)
    drawobj(ctx,b)
    ctx.fillRect(0,0,10, 10)
    ctx.fillRect(0,height-10,10,10)
    ctx.fillRect(width-10,0,10,10)
    ctx.fillRect(width-10,height-10,10,10)
}

function loop(time) {
    var delta = time - lastRender
    update(delta)
    draw()
    lastRender = time
    window.requestAnimationFrame(loop)
}

var canvas = document.getElementById("canvas")
canvas.width = width
canvas.height = height
var ctx = canvas.getContext("2d")
ctx.fillStyle = "black"

var lastRender = 0
window.requestAnimationFrame(loop)

</script>
</body>
</html>
