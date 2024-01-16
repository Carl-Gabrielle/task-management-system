<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
     body {
        font-family: 'Poppins', sans-serif;
        background-color: #f1f1f1;
        overflow-y: scroll;
    }
    
</style>
<?php
?>
<body class="bg-gradient-to-r from-blue-100 via-blue-300 to-blue-200">
<main id="content" class="flex-grow p-8 transition-all duration-300 ">
    <p class="flex items-center text-base ml-4 pt-10">
        <span class="text-gray-500">Home</span>
        <span class="mx-2">></span>
        <span class="text-gray-800 overview">User Lists</span>
</p>
    <div class="flex items-center justify-center pt-10">
        <div class="overflow-x-auto w-full rounded-t-lg">
        <table id="taskTable" class="table-auto min-w-full divide-y divide-gray-200 rounded-t-lg shadow-md bg-white p-8 backdrop-filter backdrop-blur-lg bg-opacity-80">
        <thead class="bg-gray-200">
    <tr>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Name</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Email</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Role</th>
    </tr>
</thead>

                    <tbody class="divide-y divide-gray-200 ">
                        <!-- PHP code to fetch and display users -->
                        <?php
                            require_once('config.php'); // Include your database connection

                            $sql = "SELECT id, name, email, is_admin FROM user_list";
                            $result = mysqli_query($connection, $sql);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                    <tr class="p-2">
                                    <td class='px-6 userNames py-4 text-sm font-semibold text-gray-800' style='display: flex; align-items: center;'>
    <!-- <svg width="30" height="30" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style='margin-right: 8px;'> 
        <path fill-rule="evenodd" d="M21.6 12a9.6 9.6 0 1 1-19.2 0 9.6 9.6 0 0 1 19.2 0Zm-7.2-3.6a2.4 2.4 0 1 1-4.8 0 2.4 2.4 0 0 1 4.8 0ZM12 13.2a6 6 0 0 0-5.455 3.5A7.184 7.184 0 0 0 12 19.2a7.182 7.182 0 0 0 5.455-2.5A6 6 0 0 0 12 13.2Z" clip-rule="evenodd"></path>
    </svg> -->
    <img src="profile.JPG" alt="profile-picture" class="rounded-full w-7 h-7 lg:h-10 lg:w-10 object-cover" style='margin-right: 8px;'>
    <?= $row['name'] ?>
</td>

                                        <td class='userEmails px-6 py-4 text-sm text-gray-700'><?= $row['email'] ?></td>
                                        <?php
$isAdmin = $row['is_admin'];
$bgColor = ''; 

switch ($isAdmin) {
    case 0:
        $bgColor = 'bg-blue-600'; 
        break;
    case 1:
        $bgColor = 'bg-green-600'; 
        break;
    default:
        $bgColor = 'bg-gray-500'; 
        break;
}
?>
                                        <td class='px-6 py-4 text-sm text-gray-700'>
    <select class="role-select <?= $bgColor ?> rounded-lg text-white font-semibold p-2" data-user-id="<?= $row['id'] ?>">
        <option value="0" <?= $isAdmin == 0 ? 'selected' : '' ?>>Member</option>
        <option value="1" <?= $isAdmin == 1 ? 'selected' : '' ?>>Admin</option>
    </select>
</td>
                                    </tr>
                        <?php
                                }
                            } else {
                                echo "<tr><td colspan='3' class='px-6 py-4 text-sm text-gray-500'>No users found.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</main>
</body>
<script>
        $(document).on('change', '.role-select', function() {
            const userId = $(this).data('user-id');
            const newRole = $(this).val();

            $.ajax({
                url: 'update_user_role.php', // Replace with your update script URL
                method: 'POST',
                data: { userId: userId, newRole: newRole },
                success: function(response) {
                    console.log(response); // Handle success if needed
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Handle errors if needed
                }
            });
        });
    </script>
</html>


