(function() {
   let autocompleteTimeout = null;

   // Elements in the HTML page
   const nameInput = document.getElementById('game-name');
   const autocompleteList = document.getElementById('game-autocompleter');

   // Timeout to prevent sending multiple requests when there are multiple keys being pressed rapidly.
   nameInput.addEventListener('keyup', function (event) {
      if (autocompleteTimeout !== null) { clearTimeout(autocompleteTimeout); autocompleteTimeout = null; }
      if (event.key === 'Escape') { // Remove autocomplete when pressing escape
         emptyAutocomplete();
      } else {
         autocompleteTimeout = setTimeout(requestAutocompletion, 200);
      }
   });

   nameInput.addEventListener('focusout', emptyAutocomplete);

   // Click event handler for autocomplete
   document.addEventListener("click", autocomplete);

   /**
    * API call to retrieve list of games matching autocomplete.
    * This function autonomously adds the results on the page.
    */
   function requestAutocompletion() {
      autocompleteTimeout = null;
      let gameName = nameInput.value;

      // Only request autocomplete with at least 2 characters
      if (gameName.length < 2) {
         emptyAutocomplete();
         return;
      }

      fetch(`/api/autocomplete.php?name=${gameName}`)
          .then(response => response.json())
          .then(data => {
             emptyAutocomplete();
            data.forEach(game => {
               addAutocompleteOption(game);
            });
          })
          .catch(console.error);
   }

   /**
    * Empties the autocomplete list.
    * Useful when adding new autocomplete results.
    */
   function emptyAutocomplete() {
      autocompleteList.innerHTML = '';
   }

   /**
    * Adds the necessary HTML to add a result to the autocomplete list.
    * @param game The name of the game to add.
    */
   function addAutocompleteOption(game) {
      if (nameInput === document.activeElement) {
         autocompleteList.innerHTML += `<li data-game="${game}">${game}</li>`;
      }
   }

   /**
    * Handles a click event on an autocompleting item.
    * @param event - The object representing the click event.
    */
   function autocomplete(event) {
      if (event.target.tagName === 'LI') {
         nameInput.value = event.target.textContent;
         emptyAutocomplete();
      }
   }
})()
