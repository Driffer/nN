<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Chat Application</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        #createAccountPopup {
            display: none; /* Initially hidden */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <h1>Web Chat Application</h1>

    <!-- Login Form -->
    <div id="loginForm">
        <h2>Login</h2>
        <form id="login">
            <label for="login_user_name">Username:</label>
            <input type="text" id="login_user_name" name="user_name" required>
            <br>
            <label for="login_user_password">Password:</label>
            <input type="password" id="login_user_password" name="user_password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <div id="loginResponse"></div>
        <button id="openCreateAccountPopup">Create Account</button>
    </div>

    <!-- Create Account Pop-Up -->
    <div id="createAccountPopup">
        <h2>Create Account</h2>
        <form id="createAccount">
            <label for="create_user_name">Username:</label>
            <input type="text" id="create_user_name" name="user_name" required>
            <br>
            <label for="create_user_password">Password:</label>
            <input type="password" id="create_user_password" name="user_password" required>
            <br>
            <button type="submit">Create Account</button>
        </form>
        <div id="createAccountResponse"></div>
        <button id="closeCreateAccountPopup">Close</button>
    </div>

    <!-- Chat Interface -->
    <div id="chatInterface">
        <h2>Welcome, <span id="currentUser"></span>!</h2>

        <!-- Delete Account Button -->
        <div id="deleteAccountSection">
            <button id="deleteAccountBtn">Delete My Account</button>
            <div id="deleteAccountResponse"></div>
        </div>

        <!-- Form to submit chat messages -->
        <form id="chatForm">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
            <br>
            <label for="user_img">Optional Image URL:</label>
            <input type="text" id="user_img" name="user_img">
            <br>
            <button type="submit">Send</button>
        </form>
        <div id="chatResponse"></div>

        <hr>

        <!-- Section to fetch and display chat messages -->
        <h2>Chat Messages:</h2>
        <button id="loadMessagesBtn">Load Messages</button>
        <div id="chatOutput"></div>
    </div>

    <script>
        // Toggle visibility of the Create Account pop-up
        document.getElementById('openCreateAccountPopup').onclick = function () {
            document.getElementById('createAccountPopup').style.display = 'block';
        };

        document.getElementById('closeCreateAccountPopup').onclick = function () {
            document.getElementById('createAccountPopup').style.display = 'none';
        };
    </script>
</body>
</html>
