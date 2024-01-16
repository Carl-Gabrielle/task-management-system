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
    /* .scrollbar-style::-webkit-scrollbar {
        width: 6px; 
    }


    .scrollbar-style::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }

 
    .scrollbar-style::-webkit-scrollbar-thumb {
        background: #888; 
        border-radius: 3px; 
    }

  
    .scrollbar-style::-webkit-scrollbar-thumb:hover {
        background: #555;
    } */
    body.dark-mode .statuscontainer{
    background-color: #2C2C2C;
}
body.dark-mode .textcolor{
    border-color: #555; 
    color: white; 
}
</style>
<?php
include('config.php');
session_start();

if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
    $nameArray = explode(' ', $name);
    $firstName = $nameArray[0];
} else {
    echo "<p>You are not logged in.</p>";
}?>
<body class="bg-gradient-to-r from-blue-100 via-blue-300 to-blue-200">
<main id="content" class="flex-grow p-8 transition-all duration-300 ">
<p class="flex items-center text-base ml-4 pt-10">
    <span class="text-gray-500">Home</span>
    <span class="mx-2">></span>
    <span class="text-gray-800 overview">Task Lists</span>
</p>
<div class="flex items-center justify-center pt-10 ">
    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <!-- PHP loop starts here -->
        <?php
require_once('config.php'); // Include your database connection

$sql = "SELECT id, title, description, due_date, priority, status FROM task_list";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $priority = ucwords(strtolower($row['priority']));
        $class = '';

        switch ($priority) {
            case 'High':
                $class = "bg-red-200 font-bold text-red-600 rounded-2xl w-16 h-8 flex items-center justify-center   mt-3 mb-3";
                break;
            case 'Mid':
                $class = "bg-yellow-200 font-bold text-yellow-600 rounded-2xl w-16 h-8 flex items-center justify-center mt-3 mb-3";
                break;
            case 'Low':
                $class = "bg-green-200 font-bold text-green-600 rounded-2xl w-16 h-8 flex items-center justify-center  mt-3 mb-3";
                break;
            default:
                $class = "bg-gray-700 text-white rounded-xl w-16 h-8 flex items-center justify-center mt-3 mb-3";
                break;
        }

        $status = strtolower($row['status']);
$statusClass = '';

switch ($status) {
    case 'not started':
        $statusClass = "text-red-600 font-bold";
        break;
    case 'in progress':
        $statusClass = "text-yellow-600 font-bold";
        break;
    case 'completed':
        $statusClass = "text-green-600 font-bold";
        break;
    default:
        $statusClass = "text-gray-700";
        break;
}
        ?>

                <!-- Displaying task cards -->
                <div class=" task-card rounded-lg piedark bg-white dark:bg-gray-900 transition duration-300 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg p-6">
             <h2 class="tasklabels text-l font-semibold mb-3 text-gray-900 h-12"><?= $row['title'] ?></h2>

    <p class=" tasklabels text-sm text-gray-600 mb-2">Due Date: <span class= "tasklabels text-gray-800"><?= date('M. d, Y', strtotime($row['due_date'])) ?></span></p>

    <div class="flex items-center mb-4">
        <p class="text-sm text-gray-600 mr-2 tasklabels">Priority:</p>
        <span class="<?= $class ?> font-semibold px-2 py-1 rounded-lg text-sm text-white"><?= $row['priority'] ?></span>
    </div>
    
    <div class="flex items-center mb-4">
    <p class="text-sm text-gray-600 mr-2 tasklabels">Status:</p>
    <span class="text-sm <?= $statusClass ?>"><?= strtoupper($row['status']) ?></span>
</div>


    <div class="flex items-center justify-between border-t border-gray-200 pt-4 mb-4">
    <p class="mb-7 text-sm text-gray-600 tasklabels">Assigned to: <span class="tasklabels text-gray-800">Mark John</span></p>
</div>

<div class="absolute bottom-0 right-0 mb-4 mr-4 flex">
    <button class="inline-flex items-center text-blue-500 hover:text-blue-700 font-bold   rounded focus:outline-none focus:shadow-outline">
        <i class="statuscontainer textcolor fas fa-edit bg-blue-300 p-2 rounded-lg text-blue-500 mr-2"></i> 
    </button>
    <a href='delete_task.php?id=<?= $row['id'] ?>' onclick='return confirmDelete(<?= $row['id'] ?>);' class='flex items-center justify-center text-red-500 hover:text-red-700 font-bold py-2 px-2 rounded focus:outline-none focus:shadow-outline'>
        <i class="statuscontainer textcolor fas fa-trash-alt bg-red-300 p-2 rounded-lg text-red-500"></i>
    </a>
</div>



</div>

            <?php
            }
        }  else {
            echo '
    <div class="flex items-center justify-center h-full ml-10">
        <div class="text-center">
            <h2 class="text-2xl font-semibold mb-3 text-gray-900 dark:text-white notasks">No tasks found</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 notasks">Looks like there are no tasks available at the moment.</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 notasks">Feel free to relax or add new tasks when needed.</p>
        </div>
    </div>';
        }
        ?>
        <!-- PHP loop ends here -->
    </div>
</div>
<main>
    <script>
         document.addEventListener("DOMContentLoaded", function () {
        const editBtn = document.querySelector('.edit-btn');
        const modal = document.querySelector('.modal');
        const closeBtn = document.querySelector('.close-btn');

        editBtn.addEventListener('click', function () {
            // Show modal when Edit button is clicked
            modal.classList.remove('hidden');
            // Fetch task details and populate the form for editing (using AJAX or PHP to fetch data)
            // Example: You can use AJAX to fetch task details from the server based on task ID
        });

        closeBtn.addEventListener('click', function () {
            // Close modal when Close button is clicked
            modal.classList.add('hidden');
        });

        // Optionally, you can handle form submission with AJAX to update the task details without page reload
        const editForm = document.getElementById('editForm');
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            // Submit the form using AJAX to update the task details on the server
            // Example: You can use fetch or XMLHttpRequest to send the updated data to the server
        });
    });
//  function confirmDelete(taskId) {
//     Swal.fire({
//         title: "Are you sure?",
//         text: "You won't be able to revert this!",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire({
//                 title: "Deleted!",
//                 text: "Task has been deleted.",
//                 icon: "success"
//             }).then(() => {
//                 window.location.href = "delete_task.php?id=" + taskId;
//             });
//         }
//     });
//     return false;
// }

function confirmDelete(taskId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "delete_task.php",
                type: "GET",
                data: { id: taskId },
                success: function(response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Task has been deleted.",
                        icon: "success"
                    }).then(() => {
                        
                        $('#taskRow_' + taskId).remove();
                    });
                },
                error: function(xhr, status, error) {
                    
                    console.error(xhr.responseText);
                }
            });
        }
    });
    return false; 
}
</script>
</body>
</html>


