<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Task</title>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

        <style>
                    body{
                        font-family: 'Poppins', sans-serif;
            background-color: #f1f1f1;
            }
            aside ul > li > a.active,
            aside ul > li > a.active:hover{
                background: #1F2937;
                border-radius: 8px;
                color:white;
                font-weight: 700;
            }
            .sbmt_btn{
                cursor: pointer;
            }
            .bg{
                background-color:#999eff;
    background-image:
    radial-gradient(at 87% 40%, hsla(216,74%,74%,1) 0px, transparent 50%),
    radial-gradient(at 28% 48%, hsla(237,60%,78%,1) 0px, transparent 50%),
    radial-gradient(at 72% 95%, hsla(194,70%,68%,1) 0px, transparent 50%),
    radial-gradient(at 5% 78%, hsla(253,67%,70%,1) 0px, transparent 50%),
    radial-gradient(at 54% 67%, hsla(150,65%,61%,1) 0px, transparent 50%),
    radial-gradient(at 37% 70%, hsla(212,66%,76%,1) 0px, transparent 50%),
    radial-gradient(at 62% 70%, hsla(334,72%,63%,1) 0px, transparent 50%);
            }
        </style>
   <?php
@include('config.php');
session_start();
$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = $_POST['description'];
    $due_date = mysqli_real_escape_string($connection, $_POST['due_date']);
    $priority = mysqli_real_escape_string($connection, $_POST['priority']);
    $assigned_to = $_POST['assigned_to']; // Assuming assigned_to is an array of user IDs
    
    // Check if the task already exists based on its details (title, description, due_date, priority)
    $check_sql = "SELECT id FROM task_list WHERE title = '$title' AND description = '$description' AND due_date = '$due_date' AND priority = '$priority'";
    $check_result = mysqli_query($connection, $check_sql);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $error[] = "Task already exists.";
    } else {
        $insert_task_sql = "INSERT INTO task_list (title, description, due_date, priority) VALUES (?, ?, ?, ?)";
        $stmt_task = mysqli_prepare($connection, $insert_task_sql);
        mysqli_stmt_bind_param($stmt_task, "ssss", $title, $description, $due_date, $priority);
        $success_task = mysqli_stmt_execute($stmt_task);

        if ($success_task) {
            $task_id = mysqli_insert_id($connection);
            foreach ($assigned_to as $user_id) {
                $insert_assignment_sql = "INSERT INTO task_assignments (task_id, user_id) VALUES (?, ?)";
                $stmt_assignment = mysqli_prepare($connection, $insert_assignment_sql);
                mysqli_stmt_bind_param($stmt_assignment, "ii", $task_id, $user_id);
                mysqli_stmt_execute($stmt_assignment);
            }
        } else {
            $error[] = "Failed to add task.";
        }
    }
}
?>

        </head>
        <!-- bg-gradient-to-r from-blue-100 via-blue-300 to-blue-200 -->
        <body class="bg  ">

    <main id="content" class="flex-grow p-8 transition-all duration-300 ">
        <div class="p-4 pt-10">
        <div class="card shadow rounded-md bg-white p-8 backdrop-filter backdrop-blur-lg bg-opacity-80">
        <form method="POST" id="taskForm" class="w-full md:w-3/4 lg:w-5/6 xl:w-4/5 mx-auto">
    <div class="flex items-center mb-4 animate-bounce">
    <svg class="h-6 w-6 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
    </svg>
    <h2 class="text-xl font-bold text-gray-800 mb-0">Create New Task</h2>
    </div>
        <div class="mb-4">
        <label for="title" class="block text-gray-700 text-sm font-bold">Title</label>
        <input type="text" name="title" placeholder="Enter task title" class="border rounded w-full py-2 px-3  text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 "required>
        </div>

        <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold">Description</label>
        <textarea name="description" placeholder="Provide a brief description" class="border rounded resize-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 h-40 required" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
            <label for="due_date" class="block text-gray-700 text-sm font-bold">Due Date</label>
            <input type="date" name="due_date" class="flatpickr border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 " required>
        </div>

        <div class="mb-4">
            <label for="priority" class="block text-gray-700 text-sm font-bold">Priority</label>
            <select id="priority" name="priority" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 "required>
            <option value="Low">Low</option>
            <option value="Mid">Mid</option>
            <option value="High">High</option>
            </select>
        </div>
        </div>

        <div class="mb-4">
    <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Assigned To</label>
    <select name="assigned_to[]" multiple class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required" id="assigned_to">
        <?php
        include('config.php');
        $sql = "SELECT id, name FROM user_list WHERE is_admin = 0";
        $result = mysqli_query($connection, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
</div>


        <div class="flex justify-end">
        <input type="submit" value="Create Task" class="sbmt_btn bg-gray-800 text-white py-3 px-6 rounded">
        </div>
    </form>
    </div>

        </div>
    </main>

        <!-- <button id="sidebar-toggle" class="fixed top-3 left-4 z-50 p-2 rounded-md shadow-md shadow-gray-400">
            <i class='bx bx-menu text-2xl'></i>
        </button> -->

        <script>
            <?php
                            if (isset($_POST['submit_btn']) && empty($error)) {
                            ?>
                            const modalClose =document.querySelector('[data-modal-hide="popup-modal"]');
                            const modal = document.getElementById('popup-modal');
                            const body = document.querySelector('body');
                            const dimBackground = document.createElement('div');
                            function showModal() {
                        modal.classList.remove('hidden');
                        dimBackground.classList.add('dim-background');
                        body.appendChild(dimBackground);
                        modal.classList.add('highlight-modal');
                    }
                    function hideModal() {
                        modal.classList.add('hidden');
                        body.removeChild(dimBackground);
                    }
                    modalClose.addEventListener('click', hideModal);
                    document.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        showModal();
                    }
                });
                    showModal();
                            <?php
                            }
                            ?>
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const content = document.getElementById('content');
    const sidebar = document.getElementById('sidebar');


    sidebar.classList.add('-translate-x-full');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            if (window.innerWidth >= 640) {
                content.classList.remove('ml-64');
            } else {
                content.classList.remove('sm:ml-64');
            }
        } else {
            if (window.innerWidth >= 640) {
                content.classList.add('ml-64');
            } else {
                content.classList.add('sm:ml-64');
            }
        }
    });

    // Adjust content margin on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 640) {
            if (sidebar.classList.contains('-translate-x-full')) {
                content.classList.remove('ml-64');
            } else {
                content.classList.add('ml-64');
            }
        } else {
            if (sidebar.classList.contains('-translate-x-full')) {
                content.classList.add('sm:ml-64');
            } else {
                content.classList.toggle('sm:ml-64');
            }
        }
    });
        </script>
        <script>
            flatpickr('#dueDateCell', {
                    dateFormat: "F j, Y",
                    altInput: true,
                    altFormat: "F j, Y",
                    wrap: true
                });
        </script>
        </body>
        </html>
