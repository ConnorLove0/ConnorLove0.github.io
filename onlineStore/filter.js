// filter.js

// Function to toggle the visibility of the filter container
function toggleFilterContainer() {
  var filterContainer = document.getElementById("filter-container");
  if (filterContainer.style.display === "none") {
    filterContainer.style.display = "block";
  } else {
    filterContainer.style.display = "none";
  }
}

// Event listener for the "See Filter" button click
var seeFilterBtn = document.getElementById("see-filter-btn");
if (seeFilterBtn) {
  seeFilterBtn.addEventListener("click", function () {
    toggleFilterContainer();
  });
}

var gallery = document.getElementById("adv-filter-gallery");
if (gallery) {
  new Filter({
    element: gallery, // this is your gallery element
    priceRange: function (items) {
      // this is the price custom function
      var filteredArray = [],
        minVal = document.getElementById("priceMinValue").value,
        maxVal = document.getElementById("priceMaxValue").value;
      for (var i = 0; i < items.length; i++) {
        var price = parseInt(items[i].getAttribute("data-price"));
        filteredArray[i] = price >= minVal && price <= maxVal;
      }
      return filteredArray;
    },
    indexValue: function (items) {
      // this is the index custom function
      var filteredArray = [],
        value = document.getElementById("indexValue").value;
      for (var i = 0; i < items.length; i++) {
        var index = parseInt(items[i].getAttribute("data-sort-index"));
        filteredArray[i] = index >= value;
      }
      return filteredArray;
    },
    searchInput: function (items) {
      // this is the search custom function
      var filteredArray = [],
        value = document.getElementById("search-products").value; // search input
      for (var i = 0; i < items.length; i++) {
        // you can update the data-search attribute to include all search values (in the demo, only categories are included)
        var searchFilter = items[i].getAttribute("data-search");
        filteredArray[i] =
          searchFilter == "" ||
          searchFilter.toLowerCase().indexOf(value.toLowerCase()) > -1;
      }
      return filteredArray;
    },
  });
}

var customEvent = new CustomEvent("filter-selection-updated");
var galleryList = document.getElementsByClassName("js-adv-filter__gallery")[0];
galleryList.dispatchEvent(customEvent);
