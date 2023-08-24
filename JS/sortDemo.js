// initialize the counter and the array
var numbernames = 0;
var names = [];

function sortNames(event) {
    // Get the name from the text field
    var theName = document.getElementById("newname").value.toUpperCase();

    // Add the name to the array
    names[numbernames] = theName;
    // Increment the counter
    numbernames++;
    // Sort the array
    names.sort();

    // Populate the text area with the numbered list of sorted array values
    var sorted = "";
    for (var i = 0; i < numbernames; i++) {
        sorted += (i+1) + ". " + names[i] + "\n";
    }
    document.getElementById("sorted").value = sorted;
}

// Handle form submission on Enter key press
document.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        sortNames(event);
    }
});
