const newBoard = document.querySelector(".new-board");
if (newBoard) {
    const card = newBoardCard();
    // Show the board creation card when the new board element is clicked
    newBoard.addEventListener("click", function () {
        card.style.display = "block";
    });
    // Hide the board creation card if clicking outside of it
    document.addEventListener("click", function (event) {
        if (!card.contains(event.target) && event.target !== newBoard) {
            card.style.display = "none";
        }
    });
}

/**
 * Creates and returns a new board card with a form for board creation.
 *
 * @returns {HTMLElement} The newly created board card element.
 */
function newBoardCard() {
    const card = document.querySelector(".new-board-card");
    const form = createForm("/boards/store", "POST", "mt-5");
    const label = document.createElement("label");
    const input = createInput("text", "", "board_name", "form-control");
    // used to not load to the DOM directly
    const fragment = document.createDocumentFragment();
    const button = createButton(
        "submit",
        "Create",
        true,
        "btn",
        "btn-primary",
        "mt-3",
        "w-100"
    );
    const div = document.createElement("div");
    div.textContent = "Create board";
    div.classList.add("fw-bold", "text-center");

    label.textContent = "Board title";
    label.classList.add("form-label", "fw-bold");
    input.addEventListener("input", () => {
        if (input.value) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    });
    fragment.appendChild(div);
    form.appendChild(label);
    form.appendChild(input);
    form.appendChild(button);
    fragment.appendChild(form);
    card.appendChild(fragment);
    return card;
}

/**
 * Creates an input element.
 *
 * @param {string} type - The type of the input (e.g., 'text').
 * @param {string} placeholder - The placeholder text for the input.
 * @param {string} name - The name attribute for the input.
 * @param {...string} classes - Additional CSS classes for the input.
 * @returns {HTMLInputElement} The newly created input element.
 */
function createInput(type, placeHolder, name, ...classes) {
    const input = document.createElement("input");
    input.classList.add(...classes);
    input.type = type;
    input.name = name;
    input.placeholder = placeHolder;
    return input;
}

/**
 * Creates a form element with a CSRF token included.
 *
 * @param {string} action - The URL to send the form data to.
 * @param {string} method - The HTTP method for the form (e.g., 'POST').
 * @param {...string} classes - Additional CSS classes for the form.
 * @returns {HTMLFormElement} The newly created form element.
 */
function createForm(action, method, ...classes) {
    const form = document.createElement("form");
    form.method = method;
    form.action = action;
    form.classList.add(...classes);
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const csrfInput = document.createElement("input");
    csrfInput.setAttribute("type", "hidden");
    csrfInput.setAttribute("name", "_token");
    csrfInput.setAttribute("value", csrfToken);
    form.appendChild(csrfInput);
    return form;
}

/**
 * Creates a button element.
 *
 * @param {string} type - The type of the button (e.g., 'submit').
 * @param {string} text - The text content of the button.
 * @param {boolean} [disabled=false] - Whether the button should be disabled.
 * @param {...string} classes - Additional CSS classes for the button.
 * @returns {HTMLButtonElement} The newly created button element.
 */

function createButton(type, text, disabled = false, ...classes) {
    const button = document.createElement("button");
    button.textContent = text;
    button.type = type;
    button.disabled = disabled;
    button.classList.add(...classes);
    return button;
}
