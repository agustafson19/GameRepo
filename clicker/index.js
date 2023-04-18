
var html = document.getElementById("html")
var counter = document.getElementById("counter")
var button_zone = document.getElementById("button_zone")
var button = counter

var count = 0
var phase = 0
var phaselength = 10
var phase1length = 10

function phase_function() {
    count++
    reveal(button,1.0/phaselength)
    if (count % phaselength == 0) {
        html.onclick = null
        button.onclick = null
        button = document.createElement("button")
        button.innerHTML = "BUTTON"
        button.onclick = phase_function
        button_zone.appendChild(button)
        button.style.opacity = 1.0/phaselength
        phase++
    }
    counter.innerHTML = count
}

function reveal(elt,inc) {
    let opacity = Number(elt.style.opacity)
    elt.style.opacity = opacity + inc
}

html.onclick=phase_function