document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login");
    const chatForm = document.getElementById("chatForm");
    const loginResponse = document.getElementById("loginResponse");
    const chatResponse = document.getElementById("chatResponse");
    const chatOutput = document.getElementById("chatOutput");
    const currentUser = document.getElementById("currentUser");
    const chatInterface = document.getElementById("chatInterface");

    let messages = []; // Array to store chat messages

    // Handle login
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const username = document.getElementById("username").value.trim();

        if (username) {
            currentUser.textContent = username;
            loginForm.parentElement.style.display = "none";
            chatInterface.style.display = "block";
        } else {
            loginResponse.textContent = "Please enter a valid username.";
        }
    });

    // Handle chat message submission
    chatForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const username = currentUser.textContent;
        const message = document.getElementById("message").value.trim();
        const userImg = document.getElementById("userImg").value.trim();

        if (message) {
            // Add the message to the messages array
            messages.push({ username, message, userImg });

            // Clear the input fields
            document.getElementById("message").value = "";
            document.getElementById("userImg").value = "";

            // Update the chat output
            updateChatOutput();
        } else {
            chatResponse.textContent = "Message cannot be empty.";
        }
    });

    // Function to update the chat output
    function updateChatOutput() {
        chatOutput.innerHTML = ""; // Clear the chat output

        messages.forEach((msg) => {
            const messageElement = document.createElement("div");
            messageElement.classList.add("chatMessage");

            const userElement = document.createElement("strong");
            userElement.textContent = `${msg.username}: `;
            messageElement.appendChild(userElement);

            const textElement = document.createElement("span");
            textElement.textContent = msg.message;
            messageElement.appendChild(textElement);

            if (msg.userImg) {
                const imgElement = document.createElement("img");
                imgElement.src = msg.userImg;
                imgElement.alt = "User Image";
                imgElement.style.maxWidth = "50px";
                imgElement.style.maxHeight = "50px";
                imgElement.style.marginLeft = "10px";
                messageElement.appendChild(imgElement);
            }

            chatOutput.appendChild(messageElement);
        });
    }
});