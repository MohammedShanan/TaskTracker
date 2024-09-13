import { api } from "./helper";
document.addEventListener("DOMContentLoaded", function () {
    window.changeName = function (element, type, id) {
        const prevName = element.getAttribute("data-name");
        const newName = element.textContent.trim();
        if (newName) {
            updateName(type, id, newName);
            if (type == "board") {
                document.querySelector("title").textContent = newName;
            } else if (type == "task") {
                document.querySelector(`#task-${id} .task-name`).textContent =
                    newName;
            }
            element.setAttribute(`data-name`, newName);
        } else {
            element.textContent = prevName;
        }
    };

    const updateName = async (type, id, newName) => {
        const route = `${type}s/${id}`;
        const body = { name: newName };
        api(route, "PUT", body);
    };

    document.getElementById("openPopup").addEventListener("click", function () {
        document.getElementById("popup").style.display = "flex";
    });

    document
        .getElementById("closePopup")
        .addEventListener("click", function () {
            document.querySelector(".popup").style.display = "none";
        });

    // Optional: Close popup when clicking outside of the content
    document
        .querySelector(".popup")
        .addEventListener("click", function (event) {
            if (event.target === this) {
                this.style.display = "none";
            }
        });
});
