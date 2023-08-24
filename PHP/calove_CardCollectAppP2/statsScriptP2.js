const PokemonStatsApp = {
  // Function to create the "Add Cards" button and handle the click event
  createAddCardButton: function (pokemon) {
    
    const addCardButton = document.createElement("button");
    addCardButton.textContent = "Add to My Cards";
    addCardButton.classList.add("addCardButton");

    const typesString = pokemon.types ? pokemon.types.join(",") : "";

    addCardButton.setAttribute("data-card-name", pokemon.name);
    addCardButton.setAttribute("data-card-type", typesString);
    addCardButton.setAttribute("data-card-image-url", pokemon.images.small);

    addCardButton.setAttribute("data-card-rarity", pokemon.rarity);


    // Add click event listener to the "Add Cards" button
    addCardButton.addEventListener("click", (event) => {
      event.preventDefault();
      PokemonStatsApp.addCardToUserCards(event.currentTarget);
    });

    return addCardButton;
  },

  //Adds Content to displayCard.php
  createPokemonCardPage: function (pokemon) {
    const attacksString = pokemon.attacks
      ? pokemon.attacks
          .map(
            (attack) =>
              `${attack.name} (Cost: ${attack.cost.join(", ")}, Damage: ${
                attack.damage
              })`
          )
          .join(", ")
      : "None";

    const weaknessesString = pokemon.weaknesses
      ? pokemon.weaknesses
          .map((weakness) => `${weakness.type} (${weakness.value})`)
          .join(", ")
      : "None";

    const resistancesString = pokemon.resistances
      ? pokemon.resistances
          .map((resistance) => `${resistance.type} (${resistance.value})`)
          .join(", ")
      : "None";

    const abilitiesString = pokemon.abilities
      ? pokemon.abilities
          .map((ability) => `${ability.name} - ${ability.text}`)
          .join("\n")
      : "None";

    const rarityString = pokemon.rarity || "Unknown"; // If rarity is missing, display "Unknown"
    const levelString = pokemon.level || "Basic"; // If level is missing, display "Basic"
    const pokedexNum = pokemon.nationalPokedexNumbers || "Unknown"; // If pokedex number is missing, display "Unknown"

    const cardContentQuery = encodeURIComponent(`
              <h2><strong>Card:</strong> ${pokemon.name}</h2>
              <img src="${pokemon.images.small}" alt="${pokemon.name}">
              <h3><strong>Name:</strong> ${pokemon.name}</h3>
              <p><strong>Pokedex Number:</strong> ${pokedexNum}</p>
              <p><strong>Rarity:</strong> ${rarityString}</p>
              <p><strong>HP:</strong> ${pokemon.hp}</p>
              <p><strong>Attacks:</strong> ${attacksString}</p>
              <p><strong>Weaknesses:</strong> ${weaknessesString}</p>
              <p><strong>Resistances:</strong> ${resistancesString}</p>
              <p><strong>Type:</strong> ${pokemon.types.join(", ")}</p>
              <p><strong>Supertype:</strong> ${pokemon.supertype}</p>
              <p><strong>Subtypes:</strong> ${pokemon.subtypes.join(", ")}</p>
              <p><strong>Level:</strong> ${levelString}</p>
              <p><strong>Evolves From:</strong> ${pokemon.evolvesFrom}</p>
              <p><strong>Abilities:</strong> ${abilitiesString}</p>
          `);
    // Create the URL with the query parameter
    const cardPageUrl = `displayCard.php?cardContent=${cardContentQuery}`;

    // Open the displayCard.php page in a new tab with the URL
    window.open(cardPageUrl, "_blank");
  },

  addCardToUserCards: function (addCardButton) {
    console.log("addCardButton:", addCardButton);
    const cardName = addCardButton.name;
    console.log(cardName);
    const cardType = addCardButton.types;
    console.log(cardType);
    const cardImageUrl = addCardButton.images.small;
    console.log(cardImageUrl);
    const cardRarity = addCardButton.rarity;
    console.log(cardRarity);
  

    const formData = new FormData();
    formData.append("card_name", cardName);
    formData.append("card_type", cardType);
    formData.append("card_image_url", cardImageUrl);
    formData.append("card_rarity", cardRarity);

    console.log("FormData - card_name:", formData.get("card_name"));
    console.log("FormData - card_type:", formData.get("card_type"));
    console.log("FormData - card_image_url:", formData.get("card_image_url"));
    // Send the cardData to the server-side PHP script (addCard.php) using fetch or XMLHttpRequest.
    fetch("/phplogin/420710/PHP/addCard.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        console.log("Raw response data:", response);
        return response.text();
      })
      .then((data) => {
        console.log("Response data:", data);
        // Handle the response from the server, if needed.
        console.log("Card added successfully!", data);
        alert("Card added successfully!");
      })
      .catch((error) => {
        console.error("Error adding card:", error);
      });
  },
};

// Wait for the document to be fully loaded before running the JavaScript
document.addEventListener("DOMContentLoaded", function () {
  const cardContainerList = document.querySelector(".card-container-list");
  const selectDropdown = document.getElementById("pokemon-type-dropdown");
  const cardLimitDropdown = document.getElementById("card-limit-dropdown"); // Get the card limit dropdown element
  let selectedType = "all";
  let pokemonData;

  let cardsPerPage = 20;
  let currentPage = 1;
  cardLimitDropdown.value = cardsPerPage;

  // After the cards are loaded, remove the card-container-loading class to show the border
  function showCardContainerBorder() {
    const cardContainers = document.querySelectorAll(".card-container");
    cardContainers.forEach((container) => {
      container.classList.remove("card-container-loading");
    });
  }

  // Adds event listener to the dropdown to filter Pokémon by type when selected
  selectDropdown.addEventListener("change", function () {
    console.log(selectDropdown.value);
    selectDropdown.value = selectDropdown.value;
    if (selectDropdown.value === "all") {
      // Show all Pokémon
      fetchAndDisplayAllPokemonStats();
    } else {
      // Fetch and display Pokémon by type
      fetchPokemonStatsByType(selectDropdown.value);
    }
  });

  function handleCardLimitChange() {
    const selectedLimit = parseInt(this.value, 10);

    if (!isNaN(selectedLimit) && selectedLimit > 0) {
      cardsPerPage = selectedLimit;
      if(selectedType === "all") {
        fetchAndDisplayAllPokemonStats();
      }
      else {
        fetchPokemonStatsByType(selectedType);
      }
    }
  }
  // Set the default value of the card limit dropdown to 20
  cardLimitDropdown.value = cardsPerPage;

  // Add event listener to the card limit dropdown
  cardLimitDropdown.addEventListener("change", handleCardLimitChange);

  // Fetches the statistics for all Pokémon
  const apiCode = "3aa720f6-d926-44cf-a910-6613c53deb4c";
  const allPokemonUrl = `https://api.pokemontcg.io/v2/cards?apiKey=${apiCode}`;

  fetch(allPokemonUrl)
    .then((response) => response.json())
    .then((data) => {
      //Processes the API response and populate the dropdown with Pokemon types
      const pokemonData = data.data;
      const allTypes = [
        ...new Set(pokemonData.flatMap((pokemon) => pokemon.types)),
      ];
      allTypes.forEach((type) => {
        const option = document.createElement("option");
        option.value = type;
        option.textContent = type;
        selectDropdown.appendChild(option);
      });

      // Fetch and display all Pokemon at first
      fetchAndDisplayAllPokemonStats();
    })
    .catch((error) => {
      console.error("Error fetching Pokemon types:", error);
    });

     //Function to fetch and display all cards
  function fetchAndDisplayAllPokemonStats() {
    //Clear previous results
    cardContainerList.innerHTML = "";

    const urlWithLimitAndPage = `${allPokemonUrl}&pageSize=${cardsPerPage}&page=${currentPage}`;


    if (!pokemonData) {
      // If pokemonData is not available, fetch it and then display all Pokémon
      fetch(urlWithLimitAndPage)
        .then((response) => response.json())
        .then((data) => {
          pokemonData = data.data;
          displayPokemonStats(pokemonData, "all");
        })
        .catch((error) => {
          console.error("Error fetching Pokemon data:", error);
        });
    } else {
      // If pokemonData is already available, directly display all Pokémon
      displayPokemonStats(pokemonData, "all");
    }
  }

    /*// Constructs the API URL with the current card limit
    const urlWithLimitAndPage = `${allPokemonUrl}&pageSize=${cardsPerPage}&page=${currentPage}`;

    displayPokemonStats(pokemonData, "All");
    fetchPokemonStats(urlWithLimitAndPage)
      .then((pokemonData) => {
        //Sort the Pokemon data by name
        totalPages = Math.ceil(pokemonData.totalCount / cardsPerPage);
        if (selectDropdown.value === "All") {
          displayPokemonStats(pokemonData, "All");
        } else {
          fetchPokemonStatsByType(selectDropdown.value);
        }
      })
      .catch((error) => {
        console.error(
          "Error fetching and displaying all Pokémon statistics:",
          error
        );
      });
  }*/

  // Function to sort Pokémon data by name
  //function sortedPokemonByName(pokemonData) {
    //return pokemonData.sort((a, b) => a.name.localeCompare(b.name));
  //}


  //Function That Displays All Pokemon
  function fetchPokemonStats(url) {
    return fetch(url)
      .then((response) => response.json())
      .then((pokemonData) => {
        //Process the API response and display Pokemon of the selected type
        return pokemonData;
      })
      .catch((error) => {
        console.error("Error fetching Pokémon Statistics:", error);
      });
  }

  //Function That Displays All Pokemon by Type
  function fetchPokemonStatsByType(type) {
    const typeUrl = `https://api.pokemontcg.io/v2/cards?q=types:${type}&pageSize=${cardsPerPage}&apiKey=${apiCode}`;

    fetch(typeUrl)
      .then((response) => response.json())
      .then((data) => {
        console.log("Filtered data:", data); // Add this line to check the filtered data
        cardContainerList.innerHTML = "";
        //Process the API response and display Pokemon of the selected type
        if (data.data.length === 0) {
          cardContainerList.innerHTML = "<p>No Pokemon of this type found.</p>";
        } else {
          // If Pokemon found, display the stats
          displayPokemonStats(data.data, type);
        }
      })
      .catch((error) => {
        console.error(`Error fetching Pokémon by type "${type}":`, error);
      });
  }

  //Function to display stats
  function displayPokemonStats(pokemonData, selectedType) {
    //selectedCardAmount = cardsPerPage;
    // Clear previous results
    cardContainerList.innerHTML = "";

    console.log("Displaying Pokemon Stats", pokemonData);
    console.log("Selected Type:", selectedType);

    // Add a title indicating the selected Pokémon type
    const titleElement = document.createElement("h2");

    if (selectedType && selectedType !== "all") {
      titleElement.textContent = `Pokémon of Type: ${selectedType}`;
    } else {
      titleElement.textContent = "All Pokémon"; // Show a different title when "All" is selected
    }

    cardContainerList.appendChild(titleElement);

    //Process the API response and display Pokemon of the selected type
    pokemonData.forEach((pokemon) => {
      const addCardButton = PokemonStatsApp.createAddCardButton(pokemon);
      document.body.appendChild(addCardButton);
      addCardButton.classList.add("addCardButton");

      const viewCardDetails = document.createElement("button");
      viewCardDetails.textContent = "View Card Details";
      viewCardDetails.classList.add("viewCardDetails");
      const cardContainer = document.createElement("div");
      cardContainer.classList.add("card-container");

      console.log("addCardButton", addCardButton);
      console.log("viewCardDetails", viewCardDetails);

      const imageLeftElement = document.createElement("div");
      imageLeftElement.classList.add("image-left");
      const imgElement = document.createElement("img");
      imgElement.classList.add("pokemon-img");
      imgElement.src = pokemon.images.small;
      imgElement.alt = pokemon.name;
      imageLeftElement.appendChild(imgElement);

      // Add these declarations
      const attack = pokemon.attacks
        ? pokemon.attacks.map((attack) => `${attack.name}`).join(", ")
        : "None";
      const abilities = pokemon.abilities
        ? pokemon.abilities.map((abilities) => `${abilities.name}`).join(", ")
        : "None";
      const rarityString = pokemon.rarity || "Unknown"; // If rarity is missing, display "Unknown"
      const weaknessesString = pokemon.weaknesses
        ? pokemon.weaknesses
            .map((weakness) => `${weakness.type} (${weakness.value})`)
            .join(", ")
        : "None";
      const infoRightElement = document.createElement("div");
      infoRightElement.classList.add("info-right");

      infoRightElement.innerHTML = `
                              <p><strong>Name:</strong> ${pokemon.name}</p>
                              <p><strong>HP:</strong> ${pokemon.hp}</p>
                              <p><strong>Abilities:</strong> ${abilities}</p>
                              <p><strong>Attacks:</strong> ${attack}</p>
                              <p><strong>Weaknesses:</strong> ${weaknessesString}</p>
                              <p><strong>Type:</strong> ${pokemon.types.join(
                                ", "
                              )}</p>
                              <p><strong>Evolves From:</strong> ${
                                pokemon.evolvesFrom
                              }</p>
                              <p><strong>Rarity:</strong> ${rarityString}</p>
                      `;
      cardContainer.appendChild(imageLeftElement);
      cardContainer.appendChild(infoRightElement);
      infoRightElement.appendChild(viewCardDetails);
      infoRightElement.appendChild(addCardButton);
      cardContainerList.appendChild(cardContainer);

      // Add click event listener to the "View Card Details" button
      viewCardDetails.addEventListener("click", () => {
        // Call a function to display the card details page
        PokemonStatsApp.createPokemonCardPage(pokemon);
      });

      // Add click event listener to the "Add Card" button (assuming it adds the card to some collection)
      addCardButton.addEventListener("click", () => {
        PokemonStatsApp.addCardToUserCards(pokemon);
      });
    });
}

  // Add the event listener to show the border when the page is loaded
  window.addEventListener("load", showCardContainerBorder);
});
