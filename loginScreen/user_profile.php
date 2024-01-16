<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    body{
        background-color: #f1f1f1;
    }
</style>
<body>


<div class="pt-5">
    <!-- Your HTML code for displaying user profile -->
    <div class="grid grid-cols-2 gap-5 mt-14">
    <!-- <div class="flex items-center justify-center mt-8">
    <div class="max-w-md rounded-lg overflow-hidden shadow-lg">
        <div class="relative">
            <img src="profile.JPG" alt="Profile Picture" class="w-full h-64 object-cover">
            <label for="profilePicture" class="absolute bottom-0 right-0 mr-4 mb-4 cursor-pointer text-blue-500 hover:text-blue-700">
                Change Picture
                <input type="file" id="profilePicture" class="hidden">
            </label>
        </div>
        <div class="bg-white p-6">
            <form method="post" action="update_profile.php" class="space-y-4">
                <div class="mb-4">
                    <label for="userName" class="block text-gray-700 font-semibold">Name</label>
                    <input type="text" id="userName" name="userName" placeholder="Enter your name" value="" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="userEmail" class="block text-gray-700 font-semibold">Email</label>
                    <input type="email" id="userEmail" name="userEmail" placeholder="Enter your email" value="" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">Update</button>
            </form>
        </div>
    </div>
</div> -->

<div class="flex justify-center items-center mt-8">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg">
        <div class="p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">User Profile</h2>
                    <p class="text-sm text-gray-600 flex items-center space-x-2 mt-2">
                        <i class="bx bxs-user-circle text-lg"></i>
                        <span>Role: Member</span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center space-x-2">
                        <i class="bx bxs-map text-lg"></i>
                        <span>Alaminos, City Pangasinan</span>
                    </p>
                </div>
                <div class="w-20 h-20 rounded-full overflow-hidden">
                    <img src="profile.JPG" alt="Profile Picture" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="space-y-6">
                <div>
                    <label for="userName" class="block text-gray-800 font-semibold text-lg mb-2">Name</label>
                    <span id="userName" name="userName" class="block bg-gray-100 rounded-lg py-3 px-4 text-gray-900 text-lg font-semibold flex items-center space-x-2">
                        <i class="bx bxs-user text-xl"></i>
                        <span>Carl Gabrielle</span>
                    </span>
                </div>
                <div>
                    <label for="userEmail" class="block text-gray-800 font-semibold text-lg mb-2">Email</label>
                    <span id="userEmail" name="userEmail" class="block bg-gray-100 rounded-lg py-3 px-4 text-gray-900 text-lg font-semibold flex items-center space-x-2">
                        <i class="bx bx-envelope text-xl"></i>
                        <span>carlgabrielle@gmail.com</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>



        <div class="piedark flex flex-col sm:flex-row lg:h-96 items-center bg-white rounded-3xl p-6 sm:p-8 w-full sm:w-auto">
            <div class="flex flex-col sm:flex-grow">
                
            </div>
        </div>
    </div>
</div>


</body>