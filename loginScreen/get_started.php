<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-...." crossorigin="anonymous">
    <title>Main</title>
</head>
<style>
    body {
        background-color: #f1f1f1;
    }
    .container{
        background-color: rgb(241 245 249);
    }
</style>
<body>
    <div class="flex justify-center items-center h-screen">
        <div class="container rounded-lg shadow-lg p-6 md:w-2/3">
            <div class="flex justify-center items-center space-x-8">
                <a href="login.php" class="transition duration-300 ease-in-out transform hover:scale-110">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <span class="text-gray-800 text-lg font-semibold">User</span>
                        <i class="fas fa-user-circle text-4xl text-gray-600 mt-2"></i>
                    </div>
                </a>
                <a href="admin_login.php" class="transition duration-300 ease-in-out transform hover:scale-110">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <span class="text-gray-800 text-lg font-semibold">Admin</span>
                        <i class="fas fa-user-secret text-4xl text-gray-600 mt-2"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
