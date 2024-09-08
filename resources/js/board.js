document.addEventListener("DOMContentLoaded", function () {
    window.testClick = function (e) {
        console.log(e);
    };

    window.changeName = function (element) {
        const type = element.getAttribute("data-type");
        const prevName = element.getAttribute("data-name");
        const newName = element.textContent.trim();
        const id = element.id.split("-")[1];
        if (newName) {
            updateName(type, id, newName);
            if (type == "board") {
                document.querySelector("title").textContent = newName;
            }
            element.setAttribute(`data-${type}-name`, newName);
        } else {
            element.textContent = prevName;
        }
    };

    window.newTaskPrompt = function (element) {
        const listId = element.getAttribute("data-list-id");
        const addTask = document.querySelector(`#list-${listId} #new_task`);
        const input = document.querySelector(`#list-${listId} input`);
        input.focus();
        toggleClass(element, "show", "hide");
        toggleClass(addTask, "hide", "show");
    };

    window.addTask = function (element) {
        const listId = element.getAttribute("data-list-id");
        const input = document.querySelector(`#list-${listId} input`);
        console.log(input.value);
        if (input.value) {
            const lastTask = document.querySelector(
                `#list-${listId} #new_task`
            );
            const task = createTask(input.value, listId);
            task.then((result) => {
                lastTask.before(result);
            });
            input.value = "";
        }
    };
    newList();
    newTask();
});

function newList() {
    const newListCard = document.querySelector(".new-list-card");
    const addList = document.querySelector("#new_list");
    const newListBtn = document.querySelector("#add_list_btn");
    newListCard.addEventListener("click", function () {
        addList.style.visibility = "visible";
    });

    document.addEventListener("click", function (event) {
        const target = event.target;
        const closeCard = document.querySelector("#new_list .close");
        if (
            (!addList.contains(target) && target !== newListCard) ||
            target === closeCard
        ) {
            addList.style.visibility = "hidden";
        }
    });

    newListBtn.addEventListener("click", function (event) {
        const input = document.querySelector('input[name="list_name"]');
        const boardId = event.target.getAttribute("data-board-id");
        if (input.value) {
            const list = createList(input.value, boardId);
            list.then((result) => {
                newListCard.insertAdjacentHTML("beforebegin", result);
            });
            input.value = "";
        }
    });
}

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
async function createTask(taskName, taskListId) {
    const data = api(`lists/${taskListId}/tasks`, "POST", {
        name: taskName,
    });
    try {
        const task = document.createElement("li");
        const id = await data;
        task.classList.add("list-group-item", "task");
        task.textContent = taskName;
        task.setAttribute("id", `task-${id}`);
        return task;
    } catch (error) {
        console.error("Error handling API call:", error);
    }
}

async function createList(listName, listBoardId) {
    const data = api(`boards/${listBoardId}/lists`, "POST", {
        name: listName,
    });
    try {
        const id = await data;
        console.log("from create list" + id);
        const list = `<div class="list-card card bg-body-tertiary" id="list-${id}">
                <div contenteditable="true" id="list-${id}" class="card-header list-name" data-list-name="${listName}" data-type="list" onblur="changeName(this)">
                            ${listName}
                </div> 
                <ol class="list-group border-0" >
                    <li class="hide list-group-item" id='new_task'>
                            <div class="add-card"> 
                                <input class="form-control" type="text" name="task_name" placeholder="Enter list name...">
                                <button class="btn btn-primary mt-3" data-list-id="${id}" onclick="addTask(this)">Add task</button>
                                <i class="fa-solid fa-xmark close"></i>
                            </div>
                    </li>
                </ol>
                <div class="new-task-card show" data-list-id="${id}" onclick="newTaskPrompt(this)">Add a task</div>
            </div>`;
        return list;
    } catch (error) {
        console.error("Error handling API call:", error);
    }
}

const updateName = async (type, id, newName) => {
    const route = `${type}s/${id}`;
    const body = { name: newName };
    api(route, "PUT", body);
};

async function api(route, method, body) {
    try {
        const response = await fetch(`/api/v1/${route}`, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(body),
            credentials: "include", // Include cookies with the request
        });

        if (response.ok) {
            const data = await response.json();
            console.log("from api" + data.id);
            return data.id;
            // Handle the data (e.g., display it on the page)
        } else {
            const errorData = await response.json();
            console.log("down here");
            console.error("Error:", errorData.message);
        }
    } catch (error) {
        console.error("Request failed", error);
    }
}

function toggleClass(element, class1, class2) {
    if (element.classList.contains(class1)) {
        element.classList.remove(class1);
        element.classList.add(class2);
    } else {
        element.classList.remove(class2);
        element.classList.add(class1);
    }
}

document.getElementById("openPopup").addEventListener("click", function () {
    document.getElementById("popup").style.display = "flex";
});

document.getElementById("closePopup").addEventListener("click", function () {
    document.getElementById("popup").style.display = "none";
});

// Optional: Close popup when clicking outside of the content
document.getElementById("popup").addEventListener("click", function (event) {
    if (event.target === this) {
        this.style.display = "none";
    }
});
