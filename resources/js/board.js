document.addEventListener("DOMContentLoaded", function () {
    window.changeName = function (element) {
        const type = element.getAttribute("data-type");
        const prevName = element.getAttribute(`data-${type}-name`);
        const newName = element.textContent.trim();
        if (newName) {
            console.log(newName);
            element.setAttribute(`data-${type}-name`, newName);
        } else {
            element.textContent = prevName;
        }
    };

    window.newTaskPrompt = function (element) {
        const listId = element.getAttribute("data-list-id");
        const addTask = document.querySelector(`#${listId} #new_task`);
        const input = document.querySelector(`#${listId} input`);
        input.focus();
        toggleClass(element, "show", "hide");
        toggleClass(addTask, "hide", "show");
    };

    window.addTask = function (element) {
        const listId = element.getAttribute("data-list-id");
        const input = document.querySelector(`#${listId} input`);
        const addTask = document.querySelector(`#${listId} #new_task`);
        console.log(input.value);
        if (input.value) {
            const lastTask = document.querySelector(`#${listId} #new_task`);
            const task = document.createElement("li");
            task.classList.add("list-group-item", "task");
            task.textContent = input.value;
            lastTask.before(task);
            input.value = "";
            // addTask.style.display = "none";
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

    newListBtn.addEventListener("click", function () {
        const input = document.querySelector('input[name="list_name"]');
        if (input.value) {
            const list = createList(input.value);
            newListCard.before(list);
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

function createList(name) {
    const list = document.querySelector(".list-card").cloneNode();
    const listName = document.querySelector(".list-name").cloneNode();
    const tasks = document.createElement("ol");
    const newTask = document.querySelector("#new_task").cloneNode(true);
    const addTask = document.querySelector(".new-task-card").cloneNode(true);
    const fragment = document.createDocumentFragment();
    const button = newTask.querySelector("button");
    let id = 2;
    button.setAttribute("data-list-id", `list-${id}`);
    addTask.setAttribute("data-list-id", `list-${id}`);
    listName.textContent = name;
    tasks.classList.add("list-group", "border-0");
    tasks.appendChild(newTask);
    fragment.appendChild(listName);
    fragment.appendChild(tasks);
    fragment.appendChild(addTask);
    list.appendChild(fragment);
    list.setAttribute("id", `list-${id}`);
    return list;
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
