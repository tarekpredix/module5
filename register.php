<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-200">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold text-center text-blue-500 mb-4">Register</h2>
            <form action="registerAction.php" method="post">
                <div class="mb-4">
                    <label for="username" class="block font-medium">Username:</label>
                    <input type="text" name="username" required
                        class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
                </div>

                <div class="mb-4">
                    <label for="email" class="block font-medium">Email:</label>
                    <input type="email" name="email" required
                        class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-medium">Password:</label>
                    <input type="password" name="password" required
                        class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-400 w-full">
                    Register
                </button>
            </form>

            <p class="text-center text-gray-600 mt-4">
                Existing user? <a href="login.php" class="text-blue-500">Login</a>
            </p>

        </div>
    </div>
</body>

</html>
