//Pojawianie się okienka na stronie
const closeButton = document.getElementById("closeModal");
const modal = document.getElementById("cancelOrderModal");

document.querySelectorAll('.openModal').forEach(button => {
    button.addEventListener("click", () => {
        modal.classList.add("open");
    });
});

closeButton.addEventListener("click", () => {
    modal.classList.remove("open");
});