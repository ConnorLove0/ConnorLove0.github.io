var cardsArray = [];

// define the functions
function Card(name, email, address, phone, birthdate) {
  this.name = name;
  this.email = email;
  this.address = address;
  this.phone = phone;
  this.birthdate = birthdate;
  this.printCard = printCard;
}

function createCard() {
  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var address = document.getElementById("address").value;
  var phone = document.getElementById("phone").value;
  var birthdateInput = document.getElementById("birthdate").value;
  var birthdate = new Date(birthdateInput);

  var newCard = new Card(name, email, address, phone, birthdate);
  cardsArray.push(newCard);
  document.getElementById("form").reset();
}

function printCard() {
  var contentArea = document.getElementById("content_area");
  contentArea.innerHTML = ""; // Clears previous content

  for (var i = 0; i < cardsArray.length; i++) {
    tempPhone = cardsArray[i].phone;
    var formattedPhone = tempPhone.replace(/\D/g, "");
    formattedPhone = formattedPhone.replace(/^(\d{3})(\d{3})(\d{4})$/,"($1) $2-$3"); // formats the phone number

    const month = ("0" + (cardsArray[i].birthdate.getMonth() + 1)).slice(-2);
    const day = ("0" + cardsArray[i].birthdate.getDate()).slice(-2);
    const year = cardsArray[i].birthdate.getFullYear();

    var cardDiv = document.createElement("div");
    var cardDetails = document.createElement("div");
    var nameLine = "<strong>Name: </strong>" + cardsArray[i].name + "<br>";
    var emailLine = "<strong>Email: </strong>" + cardsArray[i].email + "<br>";
    var addressLine = "<strong>Address: </strong>" + cardsArray[i].address + "<br>";
    var phoneLine = "<strong>Phone: </strong>" + formattedPhone + "<br>";
    var birthdateLine = "<strong>Birth Date: </strong>" + `${month}/${day}/${year}` + "<hr>";
    cardDetails.innerHTML = nameLine + emailLine + addressLine + phoneLine + birthdateLine;

    cardDiv.appendChild(cardDetails);
    contentArea.appendChild(cardDiv);
  }
  const resetButton = document.createElement('button');
  resetButton.id = "reset-button";
  resetButton.textContent = "Reset";
  parentElement.appendChild(resetButton);
  resetButton.onclick = reset();
}

function reset() {
  document.getElementById("form").reset();
  cardsArray = [];
}
