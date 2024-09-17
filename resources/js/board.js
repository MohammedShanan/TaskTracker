import { api } from "./helper";
document.addEventListener("DOMContentLoaded", function () {
    /**
     * Changes the name of an item and updates it on the server.
     *
     * @param {HTMLElement} element - The HTML element whose name is being changed.
     * @param {string} type - The type of the item ('board', 'list' or 'task').
     * @param {number|string} id - The ID of the item being updated.
     */

    window.changeName = function (element, type, id) {
        const prevName = element.getAttribute("data-name");
        const newName = element.textContent.trim();
        if (newName) {
            updateName(type, id, newName)
                .then((resolved, reject) => {
                    if (resolved) {
                        if (type === "board") {
                            document.querySelector("title").textContent =
                                newName;
                        } else if (type === "task") {
                            document.querySelector(
                                `#task-${id} .task-name`
                            ).textContent = newName;
                        }
                        element.setAttribute("data-name", newName);
                    }
                })
                .catch((error) =>
                    console.error("Failed to update name:", error)
                );
        } else {
            element.textContent = prevName;
        }
    };

    /**
     * Updates the name of an item via an API request.
     *
     * @param {string} type - The type of the item ('board' or 'task').
     * @param {number|string} id - The ID of the item being updated.
     * @param {string} newName - The new name for the item.
     * @returns {Promise<void>} - A promise that resolves when the API call completes.
     */
    const updateName = async (type, id, newName) => {
        const route = `${type}s/${id}`;
        const body = { name: newName };

        try {
            return await api(route, "PUT", body);
        } catch (error) {
            console.error("API request failed:", error);
        }
    };

    /**
     * Opens the popup by setting its display style to 'flex'.
     */
    document.getElementById("openPopup").addEventListener("click", function () {
        document.getElementById("popup").style.display = "flex";
    });

    /**
     * Closes the popup by setting its display style to 'none'.
     */
    document
        .getElementById("closePopup")
        .addEventListener("click", function () {
            document.querySelector("#popup").style.display = "none";
        });

    /**
     * Closes the popup if the user clicks outside the popup content area.
     *
     * @param {MouseEvent} event - The click event.
     */
    document
        .querySelector("#popup")
        .addEventListener("click", function (event) {
            if (event.target === this) {
                this.style.display = "none";
            }
        });
});
