const disclaimer = document.querySelector("#disclaimer");
const closeButton = document.querySelector(".disclaimer__close");

console.log(closeButton);

closeButton.addEventListener("click", () => {
    disclaimer.classList.toggle("visible");
});
