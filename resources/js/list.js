import { api } from "./helper";
/**
 * Opens the delete list popup and sets up the delete action.
 *
 * @param {HTMLElement} element - The element that triggered the popup.
 */
window.openPopup = function (element) {
    const listPopup = document.querySelector("#deleteListPopup");
    listPopup.style.display = "flex";

    const listId = element.getAttribute("data-list-id");

    // Set up delete action
    window.deleteList = async () => {
        try {
            const data = await api(`lists/${listId}`, "DELETE"); // Fixed method to uppercase "DELETE"
            if (data) {
                const list = document.querySelector(`#list-${listId}`);
                if (list) {
                    list.remove();
                }
                listPopup.style.display = "none";
            }
        } catch (error) {
            console.error("Error deleting list:", error);
        }
    };
};

// Close popup when the close button is clicked
const closePopup = document.querySelector("#closeListPopup");
if (closePopup) {
    closePopup.addEventListener("click", () => {
        const listPopup = document.querySelector("#deleteListPopup");
        if (listPopup) {
            listPopup.style.display = "none";
        }
    });
}

// Initialize new list functionality
newList();

/**
 * Sets up functionality for creating and managing new lists.
 */
function newList() {
    const newListCard = document.querySelector(".new-list-card");
    const addList = document.querySelector("#new_list");
    const newListBtn = document.querySelector("#add_list_btn");

    if (newListCard && addList && newListBtn) {
        newListCard.addEventListener("click", () => {
            addList.style.visibility = "visible";
        });

        document.addEventListener("click", (event) => {
            const target = event.target;
            const closeCard = document.querySelector("#new_list .close");

            if (
                (!addList.contains(target) && target !== newListCard) ||
                target === closeCard
            ) {
                addList.style.visibility = "hidden";
            }
        });

        newListBtn.addEventListener("click", async (event) => {
            const input = document.querySelector('input[name="list_name"]');
            const boardId = event.target.getAttribute("data-board-id");

            if (input && input.value) {
                try {
                    const list = await createList(input.value, boardId);
                    newListCard.insertAdjacentHTML("beforebegin", list);
                    input.value = ""; // Clear input field after adding
                } catch (error) {
                    console.error("Error creating list:", error);
                }
            }
        });
    }
}

/**
 * Creates a new list and returns its HTML representation.
 *
 * @param {string} listName - The name of the new list.
 * @param {string} listBoardId - The ID of the board where the list will be added.
 * @returns {Promise<string>} The HTML of the newly created list.
 */
export async function createList(listName, listBoardId) {
    try {
        const data = await api(`boards/${listBoardId}/lists`, "POST", {
            name: listName,
        });
        const id = data.id;
        const list = `<div class="list-card card bg-body-tertiary" id="list-${id}">
                <div  id="list-${id}" class="list-header">
                    <div contenteditable="true" class="list-name card-header" data-list-name="${listName}" onblur="changeName(this, 'list', '${id}')">${listName}</div>
                    <button class="btn btn-danger" onclick="openPopup(this)" data-list-id="${id}">Delete</button>
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
