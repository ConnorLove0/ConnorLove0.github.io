// create the array
var cards = [];
var i = 0;
var nameCount = 0;

// define the functions
function Card(name, email, address, phone, birthdate ) {
    this.name = name;
    this.email = email;
    this.address = address;
    this.phone = phone;
    this.birthdate = birthdate;
}

function createCard() {
  // loop and prompt for names
  do {
    var name = prompt("Enter the Next Name", "");
    if (name.trim() === "") {
        return;
    }
    cards[i] = Object.assign(cards[i] || {}, { name: name });
    nameCount++;
  } while (name.trim() === "");

  // loop and prompt for email
  do {
    var email = prompt("Enter the Next Email", "");
    if (email > "") {
      cards[i] = Object.assign(cards[i] || {}, { email: email });
    }
  } while (email === "");

  // loop and prompt for address
  do {
    var address = prompt("Enter the Next Address", "");
    if (address > "") {
      cards[i] = Object.assign(cards[i] || {}, { address: address });
    }
  } while (address === "");

  // loop and prompt for Phone Number
  do {
    var phone = prompt("Enter the Next Phone Number", "");
    if (phone > "") {
        phone = formatPhone(phone);
      cards[i] = Object.assign(cards[i] || {}, { phone: phone });
    }
  } while (phone === "");

  // loop and prompt for birthdate
  do {
    var birthdateString = prompt("Enter the Next Birthdate (YYYY-MM-DD)", "");
    if (birthdateString > "") {
        var birthdate = new Date(birthdateString);
      cards[i] = Object.assign(cards[i] || {}, { birthdate: birthdate});
    }
  } while (birthdateString === "");


  var newCard = new Card(name, email, address, phone, birthdate);
  cards.push(newCard);

  i++;
}

function displayAllCards() {
    var cardContainer = document.getElementById("cardContainer");
    var nameCountLine = "<h2>" + nameCount + " names entered</h2>";
    var cardList = "";
  for (var j = 0; j < cards.length; j++) {
    var nameLine = "<li>Name: " + cards[j].name + "</li>";
    var emailLine = cards[j].email ? "<li>Email: " + cards[j].email + "</li>": "";
    var addressLine = cards[j].address ? "<li>Address: " + cards[j].address + "</li>": "";
    var phoneLine = cards[j].phone ? "<li>Phone: " + cards[j].phone + "</li>" : "";
    var birthdateLine = cards[j].birthdate ? "<li>Birthdate: " + formatBirthdate(cards[j].birthdate) + "</li><hr>" : "";

    cardList = nameLine + emailLine + addressLine + phoneLine + birthdateLine;
  }
  cardContainer.innerHTML = nameCountLine + "<hr><ol>" + cardList + "</ol>";
}

function formatBirthdate(birthdate) {
    const month = ("0" + (birthdate.getMonth() + 1)).slice(-2);
    const day = ("0" + birthdate.getDate()).slice(-2);
    const year = birthdate.getFullYear();

    return `${month}/${day}/${year}`;
}
function formatPhone(phone) {
    tempPhone = phone;
    var formattedPhone = tempPhone.replace(/\D/g, "");
    formattedPhone = formattedPhone.replace(/^(\d{3})(\d{3})(\d{4})$/,"($1) $2-$3");

    return formattedPhone;
}

