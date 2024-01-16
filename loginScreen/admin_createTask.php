    <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Task</title>
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
        </head>
        <?php
    @include('config.php');
    session_start();
    $error = [];
    if (isset($_SESSION['user_name'])) {
        $name = $_SESSION['user_name'];
    } else {
        echo "<p>You are not logged in.</p>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $description = $_POST['description'];
        $due_date = mysqli_real_escape_string($connection, $_POST['due_date']);
        $priority = mysqli_real_escape_string($connection, $_POST['priority']);
        $assigned_to = mysqli_real_escape_string($connection, $_POST['assigned_to']);
        
            $check_sql = "SELECT id FROM task_list WHERE title = '$title' AND description = '$description' AND due_date = '$due_date' AND priority = '$priority' AND assigned_to = '$assigned_to'";
            $check_result = mysqli_query($connection, $check_sql);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                $error[] = "Task already exists for this user.";
            } else {
                $insert_sql = "INSERT INTO task_list (title, description, due_date, priority, assigned_to) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $insert_sql);
                mysqli_stmt_bind_param($stmt, "sssss", $title, $description, $due_date, $priority, $assigned_to);
                $success = mysqli_stmt_execute($stmt);
                header('location:admin_task_list.php');
            }
    }
if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
    $nameArray = explode(' ', $name);
    $firstName = $nameArray[0];
} else {
    echo "<p>You are not logged in.</p>";
}
    ?>
        <!-- bg-gradient-to-r from-blue-100 via-blue-300 to-blue-200 -->
        <body class="bg  ">
        <!-- <nav class="flex justify-between items-center bg-white py-1 px-6 fixed top-0 w-full z-10 backdrop-filter backdrop-blur-lg bg-opacity-50">
    <div class="flex items-center">
        <div class="hidden sm:block mr-4">
            <span class="font-extrabold text-gray-800 md:text-2xl">Task</span>
            <span class="font-extrabold text-blue-600 md:text-2xl">Wind</span>
        </div>
        
        <div class="flex items-center md:ml-24">
            <button id="sidebar-toggle" class="p-2 rounded-md">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            
            <div class="relative ml-2">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class='bx bx-search-alt text-gray-400 text-2xl'></i>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center space-x-4 relative">
    <button class="p-2 rounded-md focus:outline-none relative pt-1" id="notificationButton">
            <span class="absolute -top-1 ml-2 right-0 bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs">5</span>
            <i class='bx bx-bell text-2xl'></i>
        </button>


        <div class="profile relative flex items-center ml-4">
            <img src="profile.JPG" alt="profile-picture" class="rounded-full w-7 h-7 md:h-10 md:w-10 object-cover">
            <div class="ml-2 p-1 rounded-lg hidden sm:block hover:bg-gray-200 hover:bg-opacity-40 cursor-pointer "  onclick="toggleDropdown()">
                <span class="name ">Hi, <?php echo $firstName?></span>
                <i class="fas fa-chevron-down ml-1"></i>
            </div>
            <div id="dropdownContent" class="hidden absolute bg-white shadow-lg rounded-xl mt-2 w-80 sm:w-96 right-0 top-full border border-gray-200">
    <div class="flex flex-col space-y-4 p-5">
        <h5 class="text-lg font-semibold text-gray-800">User Profile</h5>
        <div class="flex items-center">
           
            <div class="w-16 h-16 overflow-hidden rounded-full">
                <img src="profile.JPG" alt="profile-image" class="w-full h-full object-cover">
            </div>
        
            <div class="ml-4 flex flex-col ">
                <p class="text-base font-medium mb-1 "><?php echo $name?></p>
                <span class="mb-1">Administrator</span>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="far fa-envelope mr-1"></i>
                    <span class="max-w-xs ">orfinadacarlgabrielle@gmail.com</span>
                </div>
            </div>
        </div>
        <hr class="my-4 border-t-1 border-gray-300">
        <a href="#" class="flex items-center text-gray-600 hover:text-gray-800">
            <i class="fas fa-cog text-xl mr-3"></i>
            <span class="text-lg">Account Settings</span>
        </a>
    </div>
</div>



            <script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownContent");
        dropdown.classList.toggle("hidden");
    }
</script>
            
        </div>
    </div>
</nav> -->
        <!-- <div class="flex">
    <aside id="sidebar" class="p-4 bg-white  text-dark w-64 fixed flex flex-col transition  duration-300 ease-in-out transform shadow-lg -translate-x-0 h-full backdrop-filter backdrop-blur-lg bg-opacity-20 " style="top:3.5rem"   >
        <div class="flex flex-col h-full">
            <ul id="sidebarMenu" class="py-4">
    <li class="mb-4">
        <a href="admin_main.php" id="dashboard" class=" menu item  p-4 flex hover:bg-gray-100  items-center py-2 px-4 text-lg rounded-lg transition duration-300 ease-in-out">
            <i class='bx bx-home text-lg mr-2'></i>
            Dashboard
        </a>
    </li>
    <li class="mb-4">
        <a href="admin_createTask.php" id ="create_task" class="menu active font-semibold item p-4 flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray-100 transition duration-300 ease-in-out">
            <i class='bx bx-plus text-lg mr-2'></i>
            Create Task
        </a>
    </li>
    <li class="mb-4">
        <a href="admin_task_list.php" class="flex text-lg items-center py-2 px-4 rounded-lg transition duration-300 hover:bg-gray-100 ease-in-out">
            <i class='bx bx-list-ul text-lg mr-2'></i>
            Task List
        </a>
    </li>
    <li class="mb-4">
        <a href="#" class="flex text-lg items-center py-2 px-4 rounded-lg transition hover:bg-gray-300 duration-300 ease-in-out">
            <i class='bx bx-user text-lg mr-2'></i>
            Users
        </a>
    </li>
    <div class="flex items-center border-b border-gray-300 w-full mb-2"></div>
    <li class="mb-4">
        <a href="admin_logout.php" class="flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray transition duration-300 ease-in-out font-semibold text-red-600">
            <i class='bx bx-log-out text-red-600 text-lg mr-2'></i>
            Logout
        </a>
    </li>
</ul>

        </div>
    </aside>
</div> -->
    <main id="content" class="flex-grow p-8 transition-all duration-300 ">
        <div class="p-4 pt-10">
        <div class="taskcontainer card shadow rounded-md darktask bg-white p-8 ">
        <form method="POST" id="taskForm" action ="admin_createTask.php"class="w-full md:w-3/4 lg:w-5/6 xl:w-4/5 mx-auto">
        <div class="flex items-center justify-start mb-4">
    <svg class="h-6 w-6 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
    </svg>
    <h2 class="tasklabels text-xl font-bold text-gray-800 mr-4">Create New Task</h2>
    <img src="undraw_add_files_re_v09g.svg" alt="Welcome Illustration" class="animate-bounce h-8 w-auto sm:h-12 transition-transform duration-500 ease-in-out transform hover:scale-110">
</div>


        <div class="mb-4">
        <label for="title" class="tasklabels block text-gray-700 text-sm font-bold">Title</label>
        <input type="text" name="title" placeholder="Enter task title" class="border rounded w-full py-2 px-3  text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 "required>
        </div>

        <div class="mb-4">
        <label for="description" class="tasklabels  block text-gray-700 text-sm font-bold">Description</label>
        <textarea name="description" placeholder="Provide a brief description" class="border rounded resize-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 h-40 required" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
            <label for="due_date" class="tasklabels  block text-gray-700 text-sm font-bold">Due Date</label>
            <input type="date" name="due_date" class="flatpickr border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 " required>
        </div>

        <div class="mb-4">
            <label for="priority" class="tasklabels  block text-gray-700 text-sm font-bold">Priority</label>
            <select id="priority" name="priority" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 "required>
            <option value="Low">Low</option>
            <option value="Mid">Mid</option>
            <option value="High">High</option>
            </select>
        </div>
        </div>

        <div class="mb-4">
        <label for="assigned_to" class="tasklabels  block text-gray-700 text-sm font-bold mb-2">Assigned To</label>
        <select name="assigned_to" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline required">
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
        <input onclick="showAlert(event)"  type="submit" value="Create Task" class="sbmt_btn bg-gray-800 text-white py-3 px-6 rounded">
        </div>
    </form>
    </div>

        </div>
    </main>

        <!-- <button id="sidebar-toggle" class="fixed top-3 left-4 z-50 p-2 rounded-md shadow-md shadow-gray-400">
            <i class='bx bx-menu text-2xl'></i>
        </button> -->

        <script>
              function showAlert(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        // Show an alert message
        alert('Task is sent!');

        // Optionally, perform any other actions or AJAX requests here

        // You can also hide the form or reset it after showing the alert
        document.getElementById('taskForm').reset();
    }
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
        //     document.getElementById('taskForm').addEventListener('submit', function (event) {
        //         event.preventDefault(); 
                
        //         const title = document.getElementsByName('title')[0].value;
        //         const description = document.getElementsByName('description')[0].value;
        //         const dueDate = document.getElementsByName('due_date')[0].value;
        //         const priority = document.getElementsByName('priority')[0].value;
        //         const assignedTo = document.getElementsByName('assigned_to')[0].value;

        //         if (title === '' || description === '' || dueDate === '' || priority === '' || assignedTo === '') {
        //             Swal.fire({
        //     icon: 'error',
        //     title: 'Oops...',
        //     text: 'Please fill in all the fields!',
        //     customClass: {
        //         popup: 'rounded-md shadow-md',
        //         header: 'bg-red-500 text-white rounded-t-md px-4 py-2',
        //         title: 'text-lg font-bold',
        //         content: 'text-gray-700 py-4 px-4',
        //         confirmButton: 'text-white font-semibold focus:outline-none',
        //     },
        //     width: '22rem',
        //     showCancelButton: false,
        //     showConfirmButton: true,
        //     allowOutsideClick: true,
        //     confirmButtonText: 'OK',
        //     confirmButtonColor: '#dc2626',
        // });
        //         } else {
        //         this.submit();
        //     }
        //     });
        </script>
        </body>
        </html>
