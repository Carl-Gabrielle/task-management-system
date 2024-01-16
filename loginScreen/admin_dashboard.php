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
        .transition-delay {
    transition-delay: 0.3s;
}
.profile_dd ul {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.5rem 0;
}

/* Styling for list items */
.profile_dd ul li {
    list-style: none;
}

/* Styling for list item links */
.profile_dd ul li a {
    display: block;
    padding: 0.5rem 1rem;
    color: #333;
    transition: background-color 0.3s ease;
}

/* Hover effect for list item links */
.profile_dd ul li a:hover {
    background-color: #f0f0f0;
}
::webkit-scrollbar{
    width: 50px;
}
::-webkit-scrollbar-track{
    background-color: #f6f6f6;
}
::-webkit-scrollbar-thumb{
    background-color: #1F2937;
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
    header('Location:login.php');
}
?>



    </head>
    <!-- bg-gray-100 -->
    <body class="bg-gradient-to-r from-blue-100 via-blue-300 to-blue-200">
    <div class="pt-10" >
    <?php

date_default_timezone_set('Asia/Manila'); 


$current_hour = date('G');

if ($current_hour >= 5 && $current_hour < 12) {
    $greeting = "Good morning";
} elseif ($current_hour >= 12 && $current_hour < 18) {
    $greeting = "Good afternoon";
} else {
    $greeting = "Good evening";
}
$username = "Admin";
echo "<p class='text-lg font-normal mb-4 hidden sm:block'>$greeting, <span class='font-bold'>$username </span></p>";
echo "<hr class='my-4 hidden sm:block border-gray-400 dark:border-gray-600'>";
?>

        <div class="p-4  ">
        <?php
    $sql = "SELECT 
                SUM(CASE WHEN status = 'not started' THEN 1 ELSE 0 END) AS not_started_count,
                SUM(CASE WHEN status = 'in progress' THEN 1 ELSE 0 END) AS in_progress_count,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_count
            FROM task_list";
    
    $result = $connection->query($sql);

    $taskCounts = [
        'not_started' => 0,
        'in_progress' => 0,
        'completed' => 0
    ];

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $taskCounts['not_started'] = $row['not_started_count'];
        $taskCounts['in_progress'] = $row['in_progress_count'];
        $taskCounts['completed'] = $row['completed_count'];
    }

?>
<div class="grid grid-cols-2 gap-5 mb-4 ">
<div class=" piedark flex flex-col sm:flex-row lg:h-56  items-center bg-white  rounded-3xl p-6 sm:p-8">
    
<div class="flex flex-col sm:flex-grow ">
        <p class='text-1xl sm:text-lg font-normal mb-2 sm:mb-0 overview '>Hi, <span class='text-1xl font-semibold'><?php echo $firstName?></span>!</p>
        <span class="text-gray-500 dark:text-gray-400 text-1xl animate-bounce sm:pl-2">Welcome back!</span>
    </div>
    <img src="undraw_welcome_re_h3d9 (1).svg" alt="Welcome Illustration" class=" mt-4 sm:mt-0 ml-auto sm:mr-0 h-24 w-auto sm:h-32 transition-transform duration-500 ease-in-out transform hover:scale-110">
</div>
<div class="total-tasks piedark flex flex-col lg:h-56 sm:flex-row items-center bg-white rounded-3xl p-6 sm:p-8">
    <div class="flex flex-col sm:flex-grow">
        <p class='totaltasks text-2xl sm:text-3xl font-bold mb-3 text-center sm:text-left text-blue-900 leading-tight tracking-wide'>Total Tasks</p>
        <?php
include('config.php'); 

$sql = "SELECT 
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS notStarted,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS inProgress,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS completed
        FROM task_list";
$result = $connection->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notStarted = $row["notStarted"];
    $inProgress = $row["inProgress"];
    $completed = $row["completed"];
    
    $totalTasks = $notStarted + $inProgress + $completed;

    if ($totalTasks > 0) {
        if ($completed === $totalTasks) {
            $percentageCompleted = 100;
        } else {
            $progressFromCompleted = ($completed / ($completed + $inProgress)) * 100;
            $percentageCompleted = min($progressFromCompleted, 100); 
        }
    }
}
?>


        <div class=" task-counter glassmorphism h-16 w-16 flex items-center justify-center rounded-full border border-gray-300">
            <span class="totaltasks text-2xl font-semibold text-blue-600"><?php echo $totalTasks; ?></span>
        </div>

    


       
    </div>
    
    <img src="undraw_to_do_list_re_9nt7.svg" alt="Welcome Illustration" class="mt-4 sm:mt-0 ml-auto sm:mr-0 h-16 w-auto sm:h-24 transition-transform duration-500 ease-in-out transform hover:scale-110">

</div>





    <!-- <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
    
    </div> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-4">
    <div class="piedark stat-card bg-white  dark:text-gray-200 flex flex-col items-center justify-center p-6 rounded-3xl">
        <div class="flex items-center justify-between w-full">
            <div class="text-right">
                <h2 class="adminstatus text-lg sm:text-xl lg:text-2xl font-semibold mb-1">Not started</h2>
            </div>
            <p class="adminstatus text-xl sm:text-2xl lg:text-3xl bg-red-200 font-bold text-red-600 rounded-md  px-5 py-1 shadow-md inline-block text-center"><?php echo $taskCounts['not_started']; ?></p>
        </div>
    </div>

    <div class="piedark stat-card bg-white  dark:text-gray-200 flex flex-col items-center justify-center p-6 rounded-3xl">
        <div class="flex items-center justify-between w-full">
            <div class="text-right">
                <h2 class="adminstatus  text-lg sm:text-xl lg:text-2xl font-semibold mb-1">In Progress</h2>
            </div>
            <p class="adminstatus text-xl sm:text-2xl lg:text-3xl bg-yellow-200 font-bold text-yellow-600 rounded-md  px-5 py-1 shadow-md inline-block text-center"><?php echo $taskCounts['in_progress']; ?></p>
        </div>
    </div>

    <div class=" lg:h-28 piedark stat-card bg-white  dark:text-gray-200 flex flex-col items-center justify-center p-6 rounded-3xl">
        <div class="flex items-center justify-between w-full">
            <div class="text-right">
                <h2 class="adminstatus  text-lg sm:text-xl lg:text-2xl font-semibold mb-1">Completed</h2>
            </div>
            <p class="adminstatus text-xl sm:text-2xl lg:text-3xl bg-green-200 font-bold text-green-600 rounded-md  px-5 py-1 shadow-md inline-block text-center"><?php echo $taskCounts['completed']; ?></p>
        </div>
    </div>
</div>






            
            
            
    <!-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
    <div class="task-card rounded-lg bg-white dark:bg-gray-900 shadow-md p-6">
        <h2 class="text-lg font-semibold mb-2">Task Title</h2>
        <p class="text-sm text-gray-600 mb-4">Due Date: <span class="text-gray-800">Jan 1, 2024</span></p>
        <p class="text-sm text-gray-600 mb-4">Status: <span class="text-green-600 font-semibold">In Progress</span></p>
        <p class="text-sm text-gray-600">Assigned to: <span class="text-gray-800">John Doe</span></p>
    </div>

    <div class="task-card rounded-lg bg-white dark:bg-gray-900 shadow-md p-6">
        <h2 class="text-lg font-semibold mb-2">Another Task Title</h2>
        <p class="text-sm text-gray-600 mb-4">Due Date: <span class="text-gray-800">Feb 15, 2024</span></p>
        <p class="text-sm text-gray-600 mb-4">Status: <span class="text-yellow-600 font-semibold">Pending</span></p>
        <p class="text-sm text-gray-600">Assigned to: <span class="text-gray-800">Jane Smith</span></p>
    </div>
    
    <div class="task-card rounded-lg bg-white dark:bg-gray-900 shadow-md p-6">
        <h2 class="text-lg font-semibold mb-2">Important Task</h2>
        <p class="text-sm text-gray-600 mb-4">Due Date: <span class="text-gray-800">Mar 5, 2024</span></p>
        <p class="text-sm text-gray-600 mb-4">Status: <span class="text-blue-600 font-semibold">Completed</span></p>
        <p class="text-sm text-gray-600">Assigned to: <span class="text-gray-800">Alex Johnson</span></p>
    </div>
</div> -->

         <div class="grid grid-cols-2 gap-4 mb-4">
         <div class="  lg:h-56  flex items-center justify-center z-index:0 piedark bg-white  h-29 rounded-3xl">
    <canvas id="myDoughnutChart" width="200" height="200" class="p-4"></canvas>
</div>
<?php
include('config.php');
$sql = "SELECT COUNT(*) as total_users FROM user_list";
$result = $connection->query($sql);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];
?>
        <div class=" lg:h-56 piedark flex items-center justify-center bg-white dark:bg-gray-800 rounded-3xl p-4 sm:p-6">
    <div class="flex items-center justify-center bg-gradient-to-br from-purple-400 to-indigo-500 text-white h-12 w-12 sm:h-16 sm:w-16 rounded-full">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 21h6v-1a6 6 0 0 0-9-5.197"></path>
            <path d="M15 21H3v-1a6 6 0 1 1 12 0v1Z"></path>
            <path d="M12 4.354a4 4 0 1 1 0 5.292"></path>
            <path d="M11.828 9.828a4 4 0 1 0-5.656-5.656 4 4 0 0 0 5.656 5.656Z"></path>
        </svg>
    </div>
    <div class="ml-4">
        <p class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-300">
            <span class="adminstatus text-gray-600 dark:text-gray-400"><?php echo $total_users; ?></span>
            <span class="adminstatus text-gray-500 dark:text-gray-400">Users</span>
        </p>
        <p class="adminstatus text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total users</p>
    </div>
</div>





            <!-- <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div> -->
        </div>
        <!-- <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </p>
        </div> -->
        <!-- <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
        </div> -->
        </div>
    </div>
    <!-- </main> -->
    <!-- <button id="sidebar-toggle" class="fixed top-3 left-4 z-50 p-2 rounded-md shadow-md shadow-gray-400">
        <i class='bx bx-menu text-2xl'></i>
    </button> -->

    <script>

document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("myDoughnutChart").getContext("2d");

    // AJAX request to fetch task counts from the PHP file
    fetch('getTaskCounts.php')
        .then(response => response.json())
        .then(taskCounts => {
            // Data for the chart
            const data = {
                labels: ["Not Started", "In Progress", "Completed"],
                datasets: [
                    {
                        label: "Tasks",
                        data: [
                            taskCounts.not_started,
                            taskCounts.in_progress,
                            taskCounts.completed
                        ],
                        backgroundColor: ["#FF6384", "#D97706", "#4CAF50"],
                    },
                ],
            };

            const options = {
                responsive: true,
                maintainAspectRatio: false,
            };

            const myDoughnutChart = new Chart(ctx, {
                type: "doughnut",
                data: data,
                options: options,
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});



// const sidebarMenu = document.getElementById('sidebarMenu');
// const dashboardLink = document.getElementById('dashboardLink');
// const createTaskLink = document.getElementById('createTaskLink');

// // Add click event to sidebar items
// sidebarMenu.addEventListener('click', (event) => {
//     const clickedItem = event.target.closest('li');
//     if (!clickedItem) return;

//     // Remove active class from Dashboard and Create Task links
//     dashboardLink.classList.remove('active');
//     createTaskLink.classList.remove('active');

//     // Remove active and hover effects from all list items
//     const listItems = sidebarMenu.querySelectorAll('li');
//     listItems.forEach(item => {
//         item.classList.remove('bg-gray-800', 'text-white');
//     });
//     clickedItem.classList.add('bg-gray-800', 'text-white', 'rounded-lg');
// });

// const listItems = sidebarMenu.querySelectorAll('li');
// listItems.forEach(item => {
//     item.addEventListener('mouseenter', () => {
//         if (!item.classList.contains('bg-gray-800')) {
//             item.classList.add('bg-gray-100', 'text-dark');
//         }
//     });

//     item.addEventListener('mouseleave', () => {
//         if (!item.classList.contains('bg-gray-800')) {
//             item.classList.remove('bg-gray-100', 'text-dark');
//         }
//     });
// });

const sidebarToggle = document.getElementById('sidebar-toggle');
const content = document.getElementById('content');
const sidebar = document.getElementById('sidebar');
const menuIcon = document.getElementById('menuIcon');

sidebar.classList.add('-translate-x-full');
let isSidebarOpen = false;

function toggleSidebar() {
    sidebar.classList.toggle('-translate-x-full');
    isSidebarOpen = !isSidebarOpen;

    if (isSidebarOpen) {
        if (window.innerWidth >= 640) {
            content.classList.add('ml-64');
        } else {
            content.classList.add('sm:ml-64');
        }
        menuIcon.classList.remove('fa-arrow-right');
        menuIcon.style.marginLeft = 'auto';

        menuIcon.classList.add('fa-arrow-left');
        sidebar.style.left = '0';
    } else {
        if (window.innerWidth >= 640) {
            content.classList.remove('ml-64');
        } else {
            
            content.classList.remove('sm:ml-64');
        }
        menuIcon.classList.remove('fa-arrow-left');
        menuIcon.style.marginLeft = 'initial';

        menuIcon.classList.add('fa-arrow-right');
        sidebar.style.left = '1.3rem';
    }
}

sidebarToggle.addEventListener('click', toggleSidebar);

window.addEventListener('resize', () => {
    if (window.innerWidth >= 640) {
        if (!isSidebarOpen) {
            content.classList.remove('ml-64');
        }
    } else {
        if (!isSidebarOpen) {
            content.classList.remove('sm:ml-64');
        }
    }
});

window.addEventListener('DOMContentLoaded', () => {
    if (window.innerWidth >= 640) {
        menuIcon.classList.add('fa-arrow-right');
    } else {
        menuIcon.classList.add('fa-arrow-left');
    }
});
    </script>
    </body>
    </html>
