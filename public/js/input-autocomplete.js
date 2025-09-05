class CustomDropdown {
    constructor(container) {
        this.container = container;
        this.input = this.container.querySelector(".styled-input");
        this.dropdown = this.container.querySelector(".dropdown-list-auto");
        this.options = this.dropdown.querySelectorAll("div");

        this.initEvents();
    }

    initEvents() {
        // Mostrar la lista al hacer clic en el input
        this.input.addEventListener("focus", () => {
            this.dropdown.style.display = "block";
        });

        // Ocultar lista si se hace clic fuera
        document.addEventListener("click", (event) => {
            if (!this.container.contains(event.target)) {
                this.dropdown.style.display = "none";
            }
        });

        // Seleccionar opción al hacer clic
        this.options.forEach(option => {
            option.addEventListener("click", () => {
                this.input.value = option.getAttribute("data-value");
                this.dropdown.style.display = "none";
            });
        });

        // Filtrado dinámico mientras el usuario escribe
        this.input.addEventListener("input", () => {
            const filter = this.input.value.toLowerCase();
            let firstVisible = null;
            this.options.forEach(option => {
                if (option.textContent.toLowerCase().includes(filter)) {
                    option.style.display = "block";
                    if (!firstVisible) firstVisible = option;
                } else {
                    option.style.display = "none";
                }
            });

            // Resalta la primera opción visible
            this.options.forEach(option => option.classList.remove("selected"));
            if (firstVisible) firstVisible.classList.add("selected");

            this.dropdown.style.display = "block";
        });

        // Seleccionar primera opción con TAB
        this.input.addEventListener("keydown", (event) => {
            if (event.key === "Tab") {
                const firstOption = this.dropdown.querySelector("div.selected");
                if (firstOption) {
                    this.input.value = firstOption.getAttribute("data-value");
                    this.dropdown.style.display = "none";
                    // event.preventDefault(); // Evita que el foco pase al siguiente elemento
                }
            }
        });
    }
}
