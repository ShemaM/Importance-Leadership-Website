document.addEventListener("DOMContentLoaded", function () {
    // Path to the header HTML file
    const headerFilePath = "header.html";

    // Fetch the header content
    fetch(headerFilePath)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Failed to load header: ${response.statusText}`);
            }
            return response.text();
        })
        .then((headerHTML) => {
            // Insert the header content into the placeholder
            const headerContainer = document.getElementById("header-container");
            if (headerContainer) {
                headerContainer.innerHTML = headerHTML;

                // Reinitialize Bootstrap components (e.g., dropdowns) after loading the header
                const dropdowns = document.querySelectorAll(".dropdown-toggle");
                dropdowns.forEach((dropdown) => {
                    new bootstrap.Dropdown(dropdown);
                });
            } else {
                console.error("Header container not found!");
            }
        })
        .catch((error) => {
            console.error("Error loading header:", error);
        });
});