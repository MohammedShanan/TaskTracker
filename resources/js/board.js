const newList = document.querySelector(".new-list-card");
newList.addEventListener("click", function () {
    const addList = document.querySelector(".add-list");
    addList.style.visibility = "visible";
});

document.addEventListener("click", function (event) {
    const addList = document.querySelector(".add-list");
    const target = event.target;
    const closeCard = document.querySelector(".close");
    if (
        (!addList.contains(target) && target !== newList) ||
        target === closeCard
    ) {
        addList.style.visibility = "hidden";
    }
});
