document.addEventListener("DOMContentLoaded", () => {
    const toggles = document.querySelectorAll(".accordion-toggle");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", () => {
            const content = toggle.nextElementSibling;
            const icon = toggle.querySelector(".accordion-icon");

            content.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        });
    });
});