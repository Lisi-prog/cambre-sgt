function fil_filtro(name, input){
     const searchTerm = input.value.toLowerCase();

     const labels = document.querySelectorAll(`label > input[name="${name}"]`);
 
     labels.forEach(inputElement => {
         const labelElement = inputElement.closest("label");
         const labelText = labelElement.textContent.toLowerCase();
 
         if (labelText.includes(searchTerm)) {
             labelElement.style.display = "";
         } else {
             labelElement.style.display = "none";
         }
     });
}