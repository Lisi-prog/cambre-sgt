class CustomDropdown {
    constructor(container) {
        this.container = container;
        this.input = this.container.querySelector(".styled-input");
        this.dropdown = this.container.querySelector(".dropdown-list-auto");
        this.options = Array.from(this.dropdown.querySelectorAll("div"));
        this.currentIndex = -1; // Índice para navegación con teclado

        this.initEvents();
    }

    initEvents() {
        // Mostrar la lista al hacer clic en el input
        this.input.addEventListener("focus", () => {
            this.showDropdown();
        });

        // Ocultar lista si se hace clic fuera
        document.addEventListener("click", (event) => {
            if (!this.container.contains(event.target)) {
                this.hideDropdown();
            }
        });

        // Seleccionar opción al hacer clic
        this.options.forEach((option, index) => {
            option.addEventListener("click", () => {
                this.selectOption(option);
            });
        });

        // Filtrado dinámico mientras el usuario escribe
        this.input.addEventListener("input", () => {
            this.filterOptions();
        });

        // Manejo de teclado
        this.input.addEventListener("keydown", (event) => {
            if (event.key === "ArrowDown") {
                event.preventDefault();
                this.moveSelection(1);
            } else if (event.key === "ArrowUp") {
                event.preventDefault();
                this.moveSelection(-1);
            } else if (event.key === "Enter") {
                event.preventDefault();
                if (this.currentIndex >= 0 && this.options[this.currentIndex]) {
                    this.selectOption(this.options[this.currentIndex]);
                }
            } else if (event.key === "Tab") {
                const firstVisible = this.dropdown.querySelector("div:not([style*='display: none'])");
                if (firstVisible) {
                    this.selectOption(firstVisible);
                }
            }
        });
    }

    showDropdown() {
        this.dropdown.style.display = "block";
        this.filterOptions(); // Filtrar para mostrar solo las opciones válidas
    }

    hideDropdown() {
        this.dropdown.style.display = "none";
        this.currentIndex = -1; // Resetear índice al cerrar
    }

    selectOption(option) {
        this.input.value = option.getAttribute("data-value");
        this.hideDropdown();
    }

    filterOptions() {
        const filter = this.input.value.toLowerCase();
        this.currentIndex = -1; // Reiniciar selección
        let firstVisible = null;

        this.options.forEach((option, index) => {
            if (option.textContent.toLowerCase().includes(filter)) {
                option.style.display = "block";
                if (!firstVisible) {
                    firstVisible = option;
                    this.currentIndex = index; // Seleccionar el primero visible
                }
            } else {
                option.style.display = "none";
            }
        });

        this.highlightOption();
    }

    moveSelection(direction) {
        const visibleOptions = this.options.filter(option => option.style.display !== "none");
        
        if (visibleOptions.length === 0) return;
        
        this.currentIndex += direction;

        if (this.currentIndex < 0) {
            this.currentIndex = visibleOptions.length - 1;
        } else if (this.currentIndex >= visibleOptions.length) {
            this.currentIndex = 0;
        }

        this.highlightOption();
    }

    highlightOption() {
        this.options.forEach(option => option.classList.remove("selected"));

        const visibleOptions = this.options.filter(option => option.style.display !== "none");
        if (this.currentIndex >= 0 && visibleOptions[this.currentIndex]) {
            visibleOptions[this.currentIndex].classList.add("selected");
        }
    }
}
