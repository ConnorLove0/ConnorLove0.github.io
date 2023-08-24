// Connor Love
// 6/19/2023
// CPSC 3750
// program exam #1
// Senior

// helper function to check if number is prime
function isPrime(num) {
  if (num <= 1) {
    return false;
  }

  for (let i = 2; i <= Math.sqrt(num); i++) {
    if (num % i === 0) {
      return false;
    }
  }
  return true;
}

// Function to find prime and non-prime numbers
function findPrimes() {
  const numberInput = document.getElementById("number-input");
  const limit = parseInt(numberInput.value);

  if (limit < 1 || limit > 55) {
    alert("Please enter a number between 1 and 55.");
    return;
  }

  const primeList = document.getElementById('prime-numbers');
  const nonPrimeList = document.getElementById('non-prime-numbers');

  primeList.innerHTML = '';
  nonPrimeList.innerHTML = '';

  for (let i = 1; i <= limit; i++) {
    if (isPrime(i)) {
      primeList.innerHTML += '<li>' + i + '</li>';
    } else {
      nonPrimeList.innerHTML += '<li>' + i + '</li>';
    }
  }
}

function sumPrimes() {
  let primeSum = 0;
  const primeList = document.getElementById('prime-numbers');
  const primeNums = primeList.getElementsByTagName('li');


  for (let i = 0; i < primeNums.length; i++) {
    primeSum += parseInt(primeNums[i].textContent);
  }
    document.getElementById("output").style.visibility = "visible";
    document.getElementById("primeSum").textContent = primeSum.toString();
}


// Function to calculate the sum of non-prime numbers
function sumNonPrimes() {
  let nonPrimeSum = 0;
  const nonPrimeList = document.getElementById('non-prime-numbers');
  const nonPrimeNums = nonPrimeList.getElementsByTagName('li');

  for (let i = 0; i < nonPrimeNums.length; i++) {
    nonPrimeSum += parseInt(nonPrimeNums[i].textContent);
  }

  document.getElementById("output2").style.visibility = "visible";
  document.getElementById("nonPrimeSum").textContent = nonPrimeSum.toString();
}

