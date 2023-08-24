// Wait for the document to be fully loaded before running the JavaScript
document.addEventListener("DOMContentLoaded", function () {
  //Get references to the search input and results container
  const searchInput = document.getElementById("search-input");
  const resultsContainer = document.querySelector(".results-container");

  //Fetch the list of Pokemon names and populate the dataList
  const apiCode = "3aa720f6-d926-44cf-a910-6613c53deb4c";
  const allPokemonUrl = `https://api.pokemontcg.io/v2/cards?apiKey=${apiCode}`;

  fetch(allPokemonUrl)
    .then((response) => response.json())
    .then((data) => {
      const pokemonOptions = document.getElementById("pokemon-options");
      data.data.forEach((pokemon) => {
        const option = document.createElement("option");
        option.value = pokemon.name;
        pokemonOptions.appendChild(option);
      });
    })
    .catch((error) => {
      console.error("Error fetching Pokemon names:", error);
    });

  // Add an event listener to the search button
  const searchButton = document.getElementById("search-button");
  searchButton.addEventListener("click", function () {
    const searchTerm = searchInput.value.trim();
    if (searchTerm !== "") {
      // Call the function to fetch and display search results
      searchPokemon(searchTerm);
    }
  });

  // Function to fetch and display search results
  function searchPokemon(searchTerm) {
    //Clear the previous results
    resultsContainer.innerHTML = "";

    const apiUrl = `https://api.pokemontcg.io/v2/cards?q=name:${searchTerm}&apiKey=${apiCode}`;

    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        // Process the API response and display the search results
        displaySearchResults(data.data);
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
      });
  }

  function displaySearchResults(results) {
    if (results.length === 0) {
      //If no results found, display a message
      resultsContainer.innerHTML = "<p>No results found.</p>";
    } else {
      resultsContainer.innerHTML = "";

      const cardTable = document.createElement("div");
      cardTable.classList.add("card-table-wrapper");

      let cardRow = document.createElement("div");
      cardRow.classList.add("card-row");

      results.forEach((card, index) => {
        if (index % 4 === 0 && index !== 0) {
          // Starts a new row after every 4 cards
          resultsContainer.appendChild(cardRow);
          cardRow = document.createElement("div");
          cardRow.classList.add("card-row");
        }

        const cardItem = document.createElement("div");
        cardItem.classList.add("pokemon-card");
        cardItem.innerHTML = `<img src="${card.images.small}" alt="${card.name}">`;

        cardItem.addEventListener("click", function () {
          PokemonStatsApp.createPokemonCardPage(card);
        });

        cardRow.appendChild(cardItem);
      });

      // Append any remaining cards to the last row
      cardTable.appendChild(cardRow);

      resultsContainer.appendChild(cardTable);
    }
  }
});
