document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll(".section");
    const toggleCircles = document.querySelectorAll(".toggle-circle");
    const doneButton = document.getElementById("doneButton");

    let currentSection = 0;

    toggleCircles.forEach((circle, index) => {
        circle.addEventListener("click", () => {
            switchSection(index);
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "ArrowRight") {
            if (currentSection < sections.length - 1) {
                switchSection(currentSection + 1);
            }
        } else if (event.key === "ArrowLeft") {
            if (currentSection > 0) {
                switchSection(currentSection - 1);
            }
        }
    });

    doneButton.addEventListener("click", () => {
        window.location.href = "profile_setup.php"; 
    });

    function switchSection(index) {
        sections[currentSection].classList.remove("active");
        toggleCircles[currentSection].classList.remove("active");

        currentSection = index;

        sections[currentSection].classList.add("active");
        toggleCircles[currentSection].classList.add("active");

        if (currentSection === toggleCircles.length - 1) {
            doneButton.classList.remove("hidden");
        } else {
            doneButton.classList.add("hidden");
        }
    }

    // Initialize the first section as active
    switchSection(currentSection);
});

function toggleSelection(card) {
    card.classList.toggle("selected");
}
