import { api } from "./helper";
newList();
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

export async function createList(listName, listBoardId) {
    const data = await api(`boards/${listBoardId}/lists`, "POST", {
        name: listName,
    });
    try {
        const id = data.id;
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
