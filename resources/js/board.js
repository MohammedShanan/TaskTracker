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
            console.log(input.value);
        }
    });
}
function newTask() {
    const newTask = document.querySelector(".new-task-card");
    const addTask = document.querySelector("#new_task");
    const newTaskBtn = document.querySelector("#add_task_btn");
    newTask.addEventListener("click", function () {
        addTask.style.visibility = "visible";
    });

    document.addEventListener("click", function (event) {
        const target = event.target;
        const closeCard = document.querySelector("#new_task .close");
        if (
            (!addTask.contains(target) && target !== newTask) ||
            target === closeCard
        ) {
            addTask.style.visibility = "hidden";
        }
    });

    newTaskBtn.addEventListener("click", function () {
        const input = document.querySelector('input[name="task_name"]');
        if (input.value) {
            console.log(input.value);
        }
    });
}

newList();
newTask();
