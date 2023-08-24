const OnlineStoreApp = {
    addToCart: function (addItem) {
      const itemTitle = addItem.item_title;
      const itemPrice = addItem.item_price;
      const itemImage = addItem.item_image;
      const itemColor = addItem.item_color;
      const itemSize = addItem.item_size;
      
  
      const formData = new FormData();
      formData.append("item_title", itemTitle);
      formData.append("item_price", itemPrice);
      formData.append("item_image", itemImage);
      formData.append("item_color", itemColor);
      formData.append("item_size", itemSize);
  
      // Send the item data to the server-side PHP script (addItem.php) using fetch or XMLHttpRequest.
      fetch("/phplogin/420710/onlineStore/addItem.php", {
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
          console.log("Item added successfully!", data);
          alert("Item added successfully!");
        })
        .catch((error) => {
          console.error("Error adding item:", error);
        });
    },
  };