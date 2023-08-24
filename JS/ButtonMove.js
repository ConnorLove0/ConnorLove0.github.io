var startButton = document.getElementById("makeButton");
var moveButton = document.getElementById("moveButton");
startButton.addEventListener("click", generateButton);
moveButton.addEventListener("click", moveButtons);
var numButton = 0;
var sum = 0;
var buttonList = [];

function generateButton() {
  var color = document.getElementById("colors");
  var ButtonArea = document.getElementById("ButtonArea");
  var button = document.createElement("button");
  var randNum = Math.floor(Math.random() * 99) + 1;

  button.innerHTML = randNum;
  button.style.position = "absolute";
  var x_pos = Math.floor(Math.random() * 700) + 150;
  var y_pos = Math.floor(Math.random() * 550) + 150;
  button.style.left = x_pos + 'px';
  button.style.top = y_pos + 'px';
  button.style.backgroundColor = color.value;
  button.style.color = "white";
  button.className = "button button-secondary";
  button.id = numButton++;
  alert("button created")
  document.body.appendChild(button);
  button.onclick = function() {
    this.style.backgroundColor = color.value;
    sum += randomNumber
    this.innerHTML = Math.floor(Math.random() * 99) + 1;
    document.getElementById("total").innerHTML = "Total:" + sum;
    console.log(this.id);
  }
}

function moveButtons() {
  if (moveButtons.innerHTML === "MOVE") {
    moveButtons.innerHTML = "Pause";
    for (var i = 0; i < buttonList.length; i++) {
      moveButtons.interval = setInterval(moveButtonList(i), 50);
    }
  }
  else {
    moveButtons.innerHTML = "MOVE";
    for (var i = 0; i < buttonList.length; i++) {
      clearInterval(buttonList[i].interval);
    }
  }
}

function moveButtonList(i) {
  return function() {
    var x_val = Math.floor(Math.random() * 10) - 5
    var y_val = Math.floor(Math.random() * 10) - 5;
    var button = buttonList[i];
    var ButtonArea = document.getElementById("ButtonArea");
    var x_pos = parseInt(button.style.left) + x_val; // Calculates new x position
    var y_pos = parseInt(button.style.top) + y_val; // Calculates new y position
    if (x_pos < 0 || x_pos > (ButtonArea.offsetWidth - button.offsetWidth)) { // If button reaches left or right edge of button area, reverse x direction
      x_val *= -1
    }
    if (y_pos < 0 || y_pos > (ButtonArea.offsetHeight - button.offsetHeight)) { // If button reaches top or bottom edge of button area, reverse y direction
      y_val *= -1
    }
    button.style.left = x_pos + "px"; // Updates x position
    button.style.top = y_pos + "px"; // Updates y position
  };
}

