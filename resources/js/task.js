import flatpickr from "flatpickr";
import DOMPurify from "dompurify";
import { api, toggleClass } from "./helper.js";
// Show task details and handle various actions
window.showDetails = async function (element) {
    const taskId = element.id.split("-")[1];
    const task = await api(`tasks/${taskId}`, "GET", {});
    const route = `tasks/${taskId}`;
    if (task) {
        // Delete task functionality
        window.deleteTask = async () => {
            const data = api(route, "Delete", {});
            const details = document.querySelector(".details-container");
            if (data) {
                element.remove();
                details.remove();
            }
        };

        // Change task priority functionality
        window.changePriority = async (opt) => {
            const value = opt.value !== "null" ? opt.value : null;
            const data = api(route, "PUT", { priority: value });
            if (data) {
                element.setAttribute("data-priority", opt.value);
            }
        };

        // Update task completion status
        window.updateCompletion = async (element) => {
            const status = document.querySelector(`#task-${taskId} .status`);
            let body;
            if (element.checked) {
                body = { completed: true };
                status.textContent = "Completed";
            } else {
                body = { completed: false };
                status.textContent = "Not completed";
            }
            api(route, "PUT", body);
        };

        // Update task due date functionality
        window.updateDueDate = async (element) => {
            const input = document.querySelector("#datepicker");
            const dataSelection = document.querySelector(".date-selection");
            const button = document.querySelector("button.due-date");
            const taskProperties = document.querySelector(
                `#task-${taskId} ul.task-properties`
            );
            const dueDateLi = document.querySelector(
                `#task-${taskId} .has-due-date `
            );
            const date = new Date(input.value);
            const formattedDate = date.toLocaleDateString("en-US", {
                year: "numeric",
                month: "short",
                day: "numeric",
            });
            const unsafeHtml = `<li class="has-due-date"><i class="fa-solid fa-clock clock"></i>${formattedDate}</li>`;
            const safeHtml = DOMPurify.sanitize(unsafeHtml);
            let data;
            if (element.name === "remove_date") {
                data = await api(route, "PUT", { due_date: null });
                button.textContent = "Add due Date";
                if (data) {
                    dataSelection.style.visibility = "hidden";
                    if (dueDateLi) {
                        dueDateLi.remove();
                    }
                }
            } else {
                data = await api(route, "PUT", { due_date: input.value });
                if (data) {
                    dataSelection.style.visibility = "hidden";
                    button.textContent = input.value;
                    if (dueDateLi) {
                        dueDateLi.remove();
                    }
                    taskProperties.insertAdjacentHTML("beforeend", safeHtml);
                }
            }
        };

        // Update task description functionality
        window.updateDescription = async () => {
            const description = document.querySelector("#description");
            const edit = document.querySelector("#edit-description");
            const textarea = document.querySelector(
                "#edit-description textarea"
            );
            const body = { description: textarea.value };
            const data = api(route, "PUT", body);
            if (data) {
                if (textarea.value) {
                    description.textContent = textarea.value;
                } else {
                    description.textContent =
                        "Add more detailed description...";
                }

                description.style.display = "block";
                edit.style.display = "none";
            }
        };

        // Edit task description
        window.editDescription = function (element) {
            element.style.display = "none";
            const edit = document.querySelector("#edit-description");
            const textarea = document.querySelector(
                "#edit-description textarea"
            );
            if (task.description) {
                textarea.value = element.textContent;
            }
            edit.style.display = "flex";
        };

        // Close the edit description view
        window.closeEdit = function () {
            const description = document.querySelector("#description");
            const textarea = document.querySelector(
                "#edit-description textarea"
            );
            textarea.value = "";
            const edit = document.querySelector("#edit-description");
            edit.style.display = "none";
            description.style.display = "block";
        };

        // Show calendar for selecting due date
        window.showCalender = function (element) {
            const dataSelection = document.querySelector(".date-selection");
            dataSelection.style.visibility = "visible";
            document.addEventListener("click", function (event) {
                if (
                    !dataSelection.contains(event.target) &&
                    event.target !== element
                ) {
                    dataSelection.style.visibility = "hidden";
                }
            });

            const fp = flatpickr("#datepicker", {
                dateFormat: "Y-m-d",
                appendTo: document.querySelector("#calender"),
                allowInput: true, // Allow typing in the input field
                clickOpens: true, // Keep this true to allow the calendar to open on click
                onClose: function (selectedDates, dateStr, instance) {
                    // instance._input.blur(); // Keep the input from losing focus to allow typing
                    instance.open(); // Reopen the calendar
                },
                // Add more options if needed
            });
            fp.open();
        };

        // Create task details popup
        createTaskDetailsPopup(task);
    }
};

// Create the task details popup
function createTaskDetailsPopup(task) {
    const detailsContainer = document.createElement("div");
    detailsContainer.className = "details-container";
    detailsContainer.addEventListener("click", function (event) {
        if (event.target === this) {
            event.target.remove();
        }
    });
    const unsafeHtml = `
        <div class="task-details">
            <div class="details">
                <div class="date-selection">
                    <div class="date-selection-header"><h4>Dates</h4></div>
                    <div id="calender"></div>
                    <div class="date">
                        <input type="text" id="datepicker" autocomplete="off" />
                        <button name="save" class="btn btn-primary" onclick="updateDueDate(this)">
                            Save
                        </button>
                        <button name="remove_date" class="btn btn-secondary"  onclick="updateDueDate(this)">
                            Remove
                        </button>
                    </div>
                </div>
                <div contenteditable class="task-header" data-name="${
                    task.name
                }" onblur="changeName(this, 'task', '${task.id}')">${
        task.name
    }</div>
                <div class="task-due-date">
                    <input type="checkbox" name="status" id="" ${
                        task.completed ? "checked" : ""
                    } onclick="updateCompletion(this)"/>
                    <button class="btn btn-secondary due-date" onclick="showCalender(this)">
                        ${task.due_date ? task.due_date : "Add due date"}
                    </button>
                </div>
                <div class="task-description">
                    <h3>Description</h3>
                    <div id="description" onclick="editDescription(this)">${
                        task.description
                            ? task.description
                            : "Add more detailed description..."
                    }</div>
                    <div id="edit-description">
                        <textarea
                            name="description"
                            id=""
                            cols="30"
                            rows="6"
                        ></textarea>
                        <div>
                            <button class="btn btn-primary" onclick="updateDescription()">Save</button>
                            <button class="btn btn-secondary" onclick="closeEdit()" >Cancel</button>
                        </div>
                    </div>
                </div>
                <div class="task-priority">
                    <h3>priority</h3>
                    <select class="form-select" name="priority" onchange="changePriority(this)">
                        <option value="null">None</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div id="task-operations">
                    <button class="btn btn-danger" id="open-task-Popup">Delete Task</button>
                   <div id="delete-task-popup" class="popup">
                        <div class="popup-content">
                            <h2>Delete Task?</h2>
                            <p>Are you sure you want to delete this task? There is no undo.</p>
                            <button type="submit" class="btn btn-danger" onclick="deleteTask()" >Yes</button>
                            <button id="close-task-popup" class="btn btn-secondary" type="button">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    const safeHtml = DOMPurify.sanitize(unsafeHtml, {
        ALLOWED_ATTR: [
            "onclick",
            "onblur",
            "onchange",
            "contenteditable",
            "class",
            "id",
            "style",
            "value",
            "name",
            "cols",
            "rows",
            "type",
            "checked",
            "selected",
        ],
    });
    detailsContainer.innerHTML = safeHtml;
    document.body.prepend(detailsContainer);
    document
        .getElementById("close-task-popup")
        .addEventListener("click", function () {
            document.querySelector(".popup").style.display = "none";
        });
    document
        .getElementById("open-task-Popup")
        .addEventListener("click", function () {
            document.getElementById("delete-task-popup").style.display = "flex";
        });
}

async function createTask(taskName, taskListId) {
    const data = await api(`lists/${taskListId}/tasks`, "POST", {
        name: taskName,
    });
    try {
        const id = data.id;
        const task = document.createElement("li");
        const html = `<div class="task-name">${taskName}</div>                        
                        <ul class="task-properties">
                            <li class="status">Not completed</li>
                        </ul>`;
        task.classList.add("list-group-item", "task");
        task.innerHTML = html;
        task.setAttribute("id", `task-${id}`);
        task.setAttribute("onclick", `showDetails(this)`);
        return task;
    } catch (error) {
        console.error("Error handling API call:", error);
    }
}

/**
 * Initializes event listeners for showing and hiding the new task card.
 */
newTask();
function newTask() {
    document.addEventListener("click", function (event) {
        const target = event.target;
        const newTask = document.querySelector(".new-task-card.hide");
        const addTask = document.querySelector("li.show");
        const closeCard = document.querySelector("li.show .close");
        if (addTask && newTask) {
            if (
                (!addTask.contains(target) && target !== newTask) ||
                target === closeCard
            ) {
                toggleClass(addTask, "show", "hide");
                toggleClass(newTask, "hide", "show");
            }
        }
    });
}

/**
 * Shows the new task prompt for a specific list and focuses the input field.
 *
 * @param {HTMLElement} element - The element triggering the prompt.
 */
window.newTaskPrompt = function (element) {
    const listId = element.getAttribute("data-list-id");
    const addTask = document.querySelector(`#list-${listId} #new_task`);
    const input = document.querySelector(`#list-${listId} input`);
    input.focus();
    toggleClass(element, "show", "hide");
    toggleClass(addTask, "hide", "show");
};

/**
 * Adds a new task to a specific list if the input value is not empty.
 *
 * @param {HTMLElement} element - The element triggering the task addition.
 */
window.addTask = function (element) {
    const listId = element.getAttribute("data-list-id");
    const input = document.querySelector(`#list-${listId} input`);
    if (input.value) {
        const lastTask = document.querySelector(`#list-${listId} #new_task`);
        const task = createTask(input.value, listId);
        task.then((result) => {
            lastTask.before(result);
        });
        input.value = "";
    }
};
