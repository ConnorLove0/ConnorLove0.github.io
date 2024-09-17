const PokemonStatsApp = {
  //Adds Content to displayCard.html
  createPokemonCardPage: function (pokemon) {
    const cardPage = window.open("/HTML/displayCard.html", "_blank");

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

    const cardContentHTML = `
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
        `;

    // Update the card-content area of displayCard.html with the Pokémon card info
    cardPage.addEventListener("DOMContentLoaded", function () {
      cardPage.document.querySelector(".card-content").innerHTML =
        cardContentHTML;
    });
  },
}

// Wait for the document to be fully loaded before running the JavaScript
document.addEventListener("DOMContentLoaded", function () {
  const cardContainerList = document.querySelector(".card-container-list");
  const selectDropdown = document.getElementById("pokemon-type-dropdown");
  const cardLimitDropdown = document.getElementById("card-limit-dropdown");

  let cardsPerPage = 20;

  // After the cards are loaded, remove the card-container-loading class to show the border
  function showCardContainerBorder() {
    const cardContainers = document.querySelectorAll(".card-container");
    cardContainers.forEach((container) => {
      container.classList.remove("card-container-loading");
    });
  }

  function handleCardLimitChange() {
    const selectedLimit = parseInt(this.value, 10);
    selectedType = selectDropdown.value;

    if (!isNaN(selectedLimit) && selectedLimit > 0) {
      cardsPerPage = selectedLimit;
      fetchAndDisplayAllPokemonStats();
    }
  }

  // Add event listener to the card limit dropdown
  cardLimitDropdown.addEventListener("change", handleCardLimitChange);

  // Fetches the statistics for all Pokémon
  const apiCode = "3aa720f6-d926-44cf-a910-6613c53deb4c";
  const allPokemonUrl = `https://api.pokemontcg.io/v2/cards?apiKey=${apiCode}`;

  // Pagination variables
  let currentPage = 1;
  let totalPages;

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

  // Function to sort Pokémon data by name
  function sortedPokemonByName(pokemonData) {
    return pokemonData.sort((a, b) => a.name.localeCompare(b.name));
  }

  //Function to fetch and display all cards
  function fetchAndDisplayAllPokemonStats() {
    //Clear previous results
    cardContainerList.innerHTML = "";

    // Constructs the API URL with the current card limit
    const urlWithLimitAndPage = `${allPokemonUrl}&pageSize=${cardsPerPage}&page=${currentPage}`;

    fetchPokemonStats(urlWithLimitAndPage)
      .then((pokemonData) => {
        //Sort the Pokemon data by name
        totalPages = Math.ceil(pokemonData.totalCount / cardsPerPage);
        const sortedPokemonData = sortedPokemonByName(pokemonData.data);
        if (selectDropdown.value === "all") {
          displayPokemonStats(sortedPokemonData, null);
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
  }

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

  //Function That Displays All Pokemon by Rarity ** TODO

  //Function to display stats
  function displayPokemonStats(pokemonData, selectedType) {
    //selectedCardAmount = cardsPerPage;
    // Clear previous results
    cardContainerList.innerHTML = "";

    console.log("Displaying Pokemon Stats", pokemonData); // Add this line to check the filtered data

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
      const cardContainer = document.createElement("div");
      cardContainer.classList.add("card-container");

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
      cardContainerList.appendChild(cardContainer);

      // Add click event listener to the Pokémon container
      cardContainer.addEventListener("click", () => {
        PokemonStatsApp.createPokemonCardPage(pokemon);
      });
    });
  }

  // Add the event listener to show the border when the page is loaded
  window.addEventListener("load", showCardContainerBorder);

  // Update the page number and fetch/display Pokémon stats for the selected page
  function updatePage(pageNumber) {
    currentPage = pageNumber;
    document.getElementById("currentPage").textContent = currentPage;
    fetchAndDisplayAllPokemonStats();
  }

  // Event listener for the Previous Page button
  document.getElementById("prevPageBtn").addEventListener("click", function () {
    if (currentPage > 1) {
      updatePage(currentPage - 1);
    }
  });

  // Event listener for the Next Page button
  document.getElementById("nextPageBtn").addEventListener("click", function () {
    if (currentPage < totalPages) {
      updatePage(currentPage + 1);
    }
  });

  // Adds event listener to the dropdown to filter Pokémon by type when selected
  selectDropdown.addEventListener("change", function () {
    const selectedType = selectDropdown.value;
    if (selectedType === "all") {
      // Show all Pokémon
      fetchAndDisplayAllPokemonStats();
    } else {
      // Fetch and display Pokémon by type
      fetchPokemonStatsByType(selectedType);
    }
  });
});
