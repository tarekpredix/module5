<?php
session_start();

// Function to load users from a text file
function loadUsers() {
    $lines = file('users.txt');
    $users = [];

    foreach ($lines as $line) {
        $user = json_decode($line, true);
        $users[] = $user;
    }

    return $users;
}

// Function to save users to a text file
function saveUsers($users) {
    file_put_contents('users.txt', '');
    foreach ($users as $user) {
        file_put_contents('users.txt', json_encode($user) . "\n", FILE_APPEND);
    }
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $users = loadUsers();

    // Handle Create User
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['create_user'])) {
        $newUsername = $_POST['new_username'];
        $newEmail = $_POST['new_email'];
        $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $newRole = $_POST['new_role'];

        $newUser = [
            'username' => $newUsername,
            'email' => $newEmail,
            'password' => $newPassword,
            'role' => $newRole,
        ];

        $users[] = $newUser;
        saveUsers($users);
    }

    // Handle Edit User
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_user'])) {
        $editedUsername = $_POST['edited_username'];
        $editedRole = $_POST['edited_role'];

        foreach ($users as &$user) {
            if ($user['username'] === $editedUsername) {
                $user['role'] = $editedRole;
                break;
            }
        }

        saveUsers($users);
    }

    // Handle Delete User
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_user'])) {
        $deletedUsername = $_POST['deleted_username'];
        
        $users = array_filter($users, function ($user) use ($deletedUsername) {
            return $user['username'] !== $deletedUsername;
        });

        saveUsers($users);
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #ddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            .change-role-btn {
                padding: 5px 10px;
                background-color: #8B1EC4;
                color: #fff;
                border: none;
                cursor: pointer;
            }

            .delete-user-btn {
                padding: 5px 10px;
                background-color: #f44336;
                color: #fff;
                border: none;
                cursor: pointer;
            }

            .logout-btn {
                padding: 5px 10px;
                background-color: #4CAF50;
                color: #fff;
                border: none;
                cursor: pointer;
            }

            .create-user-btn{
                padding: 5px 10px;
                background-color: #00A1DE;
                color: #fff;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body class="bg-gray-200">
        <div class="p-8">
            <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['email']; ?></p>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn mt-8">Logout</button>
            </form>

            <h2 class="text-xl font-semibold mt-8">Create User</h2>
            <form action="admin_dashboard.php" method="post">
                <input type="text" name="new_username" placeholder="Username" required>
                <input type="email" name="new_email" placeholder="Email" required>
                <input type="password" name="new_password" placeholder="Password" required>
                <select name="new_role">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </select>
                <button type="submit" name="create_user" class="create-user-btn">Create User</button>
            </form>

            <h2 class="text-xl font-semibold mt-8">Edit/Delete Users</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['username'] . "</td>";
                    echo "<td>" . $user['role'] . "</td>";
                    echo "<td>";
                    echo "<form action='admin_dashboard.php' method='post'>";
                    echo "<input type='hidden' name='edited_username' value='" . $user['username'] . "'>";
                    echo "<select name='edited_role'>";
                    echo "<option value='admin' " . ($user['role'] === 'admin' ? 'selected' : '') . ">Admin</option>";
                    echo "<option value='manager' " . ($user['role'] === 'manager' ? 'selected' : '') . ">Manager</option>";
                    echo "<option value='user' " . ($user['role'] === 'user' ? 'selected' : '') . ">User</option>";
                    echo "</select>";
                    echo "<button type='submit' name='edit_user' class='change-role-btn'>Edit Role</button>";
                    echo "<button type='submit' name='delete_user' class='delete-user-btn'>Delete User</button>";
                    echo "<input type='hidden' name='deleted_username' value='" . $user['username'] . "'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </body>
    </html>
    <?php
} else {
    
    header("Location: login.php");
}
?>
