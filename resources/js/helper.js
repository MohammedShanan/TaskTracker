/**
 * Performs an API request to the specified route with the given method and body.
 *
 * @param {string} route - The API route (e.g., 'boards/1').
 * @param {string} method - The HTTP method (e.g., 'GET', 'POST').
 * @param {object} [body=null] - The body to send with the request, or null for GET requests.
 * @returns {Promise<object|null>} The response data as a JavaScript object, or null if an error occurs.
 */
export async function api(route, method, body) {
    try {
        let response;
        if (method === "GET") {
            response = await fetch(`/api/v1/${route}`, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                credentials: "include", // Include cookies with the request
            });
        } else {
            response = await fetch(`/api/v1/${route}`, {
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
        }
        if (response.ok) {
            const data = await response.json();
            return data;
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

/**
 * Toggles a class on an HTML element between two specified classes.
 *
 * @param {HTMLElement} element - The element to modify.
 * @param {string} class1 - The first class name.
 * @param {string} class2 - The second class name.
 */
export function toggleClass(element, class1, class2) {
    if (element.classList.contains(class1)) {
        element.classList.remove(class1);
        element.classList.add(class2);
    } else {
        element.classList.remove(class2);
        element.classList.add(class1);
    }
}

/**
 * Creates an HTML element with specified classes.
 *
 * @param {string} tagName - The type of the element (e.g., 'div', 'span').
 * @param {string[]} classes - An array of CSS class names to add to the element.
 * @returns {HTMLElement} The newly created element with the specified classes.
 */
export function createElementWithClasses(element, classes) {
    const ele = document.createElement(element);
    ele.classList.add(...classes);
}
