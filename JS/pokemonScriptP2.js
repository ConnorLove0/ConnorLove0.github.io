// Variables for the filterTypeSelect and filterRaritySelect elements
let filterTypeSelect;
let filterRaritySelect;
let allPokemon = [];
let searchInput;

// Wait for the document to be fully loaded before running the JavaScript
document.addEventListener("DOMContentLoaded", function () {
  //Get references to the search input and results container
  const filterForm = document.getElementById("filter-form");
  const resultsContainer = document.querySelector(".results-container");
  searchInput = document.getElementById("search-input");
  const searchButton = document.getElementById("search-button");

  //Fetch the list of Pokemon names and populate the dataList
  const apiCode = "3aa720f6-d926-44cf-a910-6613c53deb4c";
  const allPokemonUrl = `https://api.pokemontcg.io/v2/cards?apiKey=${apiCode}`;
  console.log(allPokemonUrl);

  // Initialize filterTypeSelect and filterRaritySelect to their default value "All"
  filterTypeSelect = document.getElementById("filter-type");
  filterRaritySelect = document.getElementById("filter-rarity");

  filterTypeSelect.value = "All";
  filterRaritySelect.value = "All";

  // Function to fetch all Pokemon and populate the type and rarity filter dropdown
  fetch(allPokemonUrl)
    .then((response) => response.json())
    .then((data) => {
      allPokemon = data.data;
      console.log("Fetched data:", data);
      console.log("All Pokemon:", allPokemon);

      let pokemonTypes = data.data.flatMap((pokemon) => pokemon.types || []);
      pokemonTypes = [...new Set(pokemonTypes)];

      const filterTypeSelect = document.getElementById("filter-type");
      filterTypeSelect.innerHTML = "";

      let pokemonRarity = data.data.flatMap((pokemon) => pokemon.rarity || []);
      pokemonRarity = [...new Set(pokemonRarity)];

      const filterRaritySelect = document.getElementById("filter-rarity"); // Correct the element type to "select"
      filterRaritySelect.innerHTML = "";

      // Create the "All" option for type filter
      const allTypeOption = document.createElement("option");
      allTypeOption.value = "All";
      allTypeOption.textContent = "All";
      filterTypeSelect.appendChild(allTypeOption);

      // Create the "All" option for rarity filter
      const allRarityOption = document.createElement("option");
      allRarityOption.value = "All";
      allRarityOption.textContent = "All";
      filterRaritySelect.appendChild(allRarityOption);

      pokemonTypes.forEach((type) => {
        const option = document.createElement("option");
        option.value = type;
        option.textContent = type;
        filterTypeSelect.appendChild(option);
      });

      pokemonRarity.forEach((rarity) => {
        const option = document.createElement("option");
        option.value = rarity;
        option.textContent = rarity;
        filterRaritySelect.appendChild(option);
      });

      // Set filterTypeSelect to default "All" if it's undefined
      if (!filterTypeSelect.value) {
        filterTypeSelect.value = "All";
      }

      // Set filterRaritySelect to default "All" if it's undefined
      if (!filterRaritySelect.value) {
        filterRaritySelect.value = "All";
      }

      //DROPDOWN CODE FOR NEED HELP DON'T CHANGE
      const pokemonOptions = document.getElementById("pokemon-options");
      data.data.forEach((pokemon) => {
        const option = document.createElement("option");
        option.value = pokemon.name;
        pokemonOptions.appendChild(option);
      });
      console.log(pokemonOptions);

      // Add event listener to the type filter dropdown
      filterTypeSelect.addEventListener("change", function () {
        filterCards();
      });

      filterRaritySelect.addEventListener("change", function () {
        filterCards();
      });
    })
    .catch((error) => {
      console.error("Error fetching Pokemon type and rarity:", error);
    });
    console.log("All Pokemon: " + allPokemon);

    // Fetch and display all Pokemon at first
    fetchAndDisplayAllPokemonStats(allPokemon);

  //Function to fetch and display all cards
  function fetchAndDisplayAllPokemonStats() {
    //Clear previous results
    displaySearchResults(allPokemon);
  }

  // Add an event listener to the form submission
  filterForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission and page reload

    searchInput = searchInput.value.trim().toLowerCase();
    const selectedType = filterTypeSelect.value || "All";
    const selectedRarity = filterRaritySelect.value || "All";

    console.log("Search Term:", searchInput);
    console.log("Selected Type:", selectedType);
    console.log("Selected Rarity:", selectedRarity);

    // Check if any filter is applied
    applyFilters(allPokemon, searchTerm, selectedType, selectedRarity);
  });

  // Add an event listener to the search button
  //const searchButton = document.getElementById("search-button");
  searchButton.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent form submission and URL update

    const searchTerm = searchInput.value.trim();
    const selectedType = filterTypeSelect.value || "All";
    const selectedRarity = filterRaritySelect.value || "All";

    console.log("Search Term in SearchButton:", searchTerm);
    console.log("Selected Type:", selectedType);
    console.log("Selected Rarity:", selectedRarity);

    // Check if any filter is applied
    applyFilters(searchTerm, selectedType, selectedRarity);
  });

  filterTypeSelect.addEventListener("change", function () {
    filterCards(allPokemon);
  });
  filterRaritySelect.addEventListener("change", function () {
    filterCards(allPokemon);
  });
  searchInput.addEventListener("click", function () {
    filterCards(allPokemon);
  });
  // Automatically apply filters on page load
  filterCards();

  function filterCards() {
    const searchTerm = searchInput.value.trim().toLowerCase();
    const selectedType = filterTypeSelect.value;
    const selectedRarity = filterRaritySelect.value;

    resultsContainer.innerHTML = "";

    // Call the 'applyFilters()' function to apply the filters and display the filtered results
    applyFilters(searchTerm, selectedType, selectedRarity);
  }

  function applyFilters(searchTerm, selectedType, selectedRarity) {
    // Clear the previous results
    resultsContainer.innerHTML = "";

    filterContainer = document.getElementById("filters-container");

    // If searchTerm, selectedType, and selectedRarity are all "All",
    // display all the cards without filtering
    if (searchTerm === "All" && selectedType === "All" && selectedRarity === "All") {
      displaySearchResults(allPokemonUrl);
      return;
    }

    // Array to store the filtered cards
    let filteredCards = [];

    // Iterate through all the cards in allPokemonUrl and apply the filters
    allPokemon.forEach((card) => {
      const pokemonTypes = card.types || [];
      const rarity = card.rarity || "Common";

      const typeMatches = selectedType === "All" || pokemonTypes.includes(selectedType);
      const rarityMatches = selectedRarity === "All" || rarity === selectedRarity;

      // If searchTerm is not provided (default "All"), filter based on type and rarity only
      if (searchTerm === "All" && typeMatches && rarityMatches) {
        filteredCards.push(card);
    }

    // If searchTerm is provided, filter based on name, type, and rarity
    if (searchTerm !== "All") {
      const cardName = card.name.toLowerCase();
      const searchTermMatches = cardName.includes(searchTerm.toLowerCase());

      if (searchTermMatches && typeMatches && rarityMatches) {
        filteredCards.push(card);
      }
    }
  });
      // Log the elements of filtered cards to the console
      console.log("Filtered Cards:", filteredCards);
      
      // Process the API response and display the filtered results
      displaySearchResults(filteredCards);
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

        const cardImage = document.createElement("img");
        cardImage.src = card.images.small;
        cardImage.alt = card.name;
        cardItem.appendChild(cardImage);

        const cardText = document.createElement("div");
        cardText.classList.add("card-text");
        cardText.setAttribute("title", "Click Card to View Details");
        cardItem.appendChild(cardText);

        // Add the "Add to My Cards" button for each card
        const addCardButton = PokemonStatsApp.createAddCardButton(card);
        cardItem.appendChild(addCardButton);

        addCardButton.addEventListener("click", function (event) {
          event.preventDefault();
          PokemonStatsApp.addCardToUserCards(card);
        });

        cardImage.addEventListener("click", function () {
          PokemonStatsApp.createPokemonCardPage(card);
        });

        cardRow.appendChild(cardItem);
      });

      // Append any remaining cards to the last row
      cardTable.appendChild(cardRow);

      resultsContainer.appendChild(cardTable);
    }
  }

  const filterTypeButton = document.getElementById("filter-button-type");
  filterTypeButton.addEventListener("click", function () {
    const selectedType = document.getElementById("filter-type").value;
    // Call the function to fetch and display filtered results
    filterPokemonByType(selectedType);
  });

  const filterRarityButton = document.getElementById("filter-button-rarity");
  filterRarityButton.addEventListener("click", function () {
    const selectedRarity = document.getElementById("filter-rarity").value;
    // Call the function to fetch and display filtered results
    filterPokemonByRarity(selectedRarity);
  });

  // Function to fetch and display filtered results by type
  function filterPokemonByType(type) {
    // Clear the previous results
    resultsContainer.innerHTML = "";

    const apiUrl = `https://api.pokemontcg.io/v2/cards?q=types:${type}&apiKey=${apiCode}`;

    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        // Process the API response and display the filtered results
        displaySearchResults(data.data);
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
      });
  }

  // Function to fetch and display filtered results by type
  function filterPokemonByRarity(rarity) {
    // Clear the previous results
    resultsContainer.innerHTML = "";

    const apiUrl = `https://api.pokemontcg.io/v2/cards?q=rarity:${rarity}&apiKey=${apiCode}`;

    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        // Process the API response and display the filtered results
        displaySearchResults(data.data);
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
      });
  }
});
