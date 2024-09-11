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
            console.log("from api " + data.id);
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

export function toggleClass(element, class1, class2) {
    if (element.classList.contains(class1)) {
        element.classList.remove(class1);
        element.classList.add(class2);
    } else {
        element.classList.remove(class2);
        element.classList.add(class1);
    }
}

export function createElementWithClasses(element, classes) {
    const ele = document.createElement(element);
    ele.classList.add(...classes);
}
