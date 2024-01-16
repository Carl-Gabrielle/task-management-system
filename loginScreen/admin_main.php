<?php
include('config.php');
session_start();
$firstName = '';
if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
    $nameArray = explode(' ', $name);
    $firstName = $nameArray[0];
} else {
    header('Location: login.php');
    exit(); 
}
?>


    
    <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
        <style>
                body {
        font-family: 'Poppins', sans-serif;
        transition: background-color 0.3s ease;
        color: black;
        background-color: #f1f1f1;
        overflow-y: scroll; 
    }

    body::-webkit-scrollbar {
        width: 6px; 
    }

    body::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }

    body::-webkit-scrollbar-thumb {
        background: #888; 
        border-radius: 3px; 
    }

    body::-webkit-scrollbar-thumb:hover {
        background: #555; 
    }

    /* Dark Mode */
    body.dark-mode {
        background-color: black;
        color: white;
        transition: background-color 1s ease;
    }

    body.dark-mode .sort,
    body.dark-mode .filter,
    body.dark-mode .overview,
    body.dark-mode .taskBanner,
    body.dark-mode .task_title,
    body.dark-mode .task_description,
    body.dark-mode .task_date,
    body.dark-mode .userEmails,
    body.dark-mode .userNames,
    body.dark-mode .adminstatus,
    body.dark-mode .userlabel,
    body.dark-mode .userroles,
    body.dark-mode .notasks,
    body.dark-mode .tasklabels,
    body.dark-mode .totaltasks

    {
        border-color: #555; 
        color: white; 
    }
    body.dark-mode .label{
        color: white; 
    }
    body.dark-mode .userName,
    body.dark-mode .role
    {
        border-color: #555;
        color: black; 
    }
    body.dark-mode table,
    body.dark-mode .divfilter,
    body.dark-mode .welcomedark

    {
    background-color: #2C2C2C;
    }
    body.dark-mode nav,
    body.dark-mode .sidebar{
        background-color:#3A3A3A
    }
    body.dark-mode .piedark,
    body.dark-mode .userprofile,
    body.dark-mode .taskcontainer
    {
        border:none;
        border-radius: 0.75rem; 
        background-color:#3A3A3A
    }
    body.dark-mode .dashhover:hover, 
    body.dark-mode .taskhover:hover, 
    body.dark-mode .listhover:hover,
    body.dark-mode .usershover:hover,
    body.dark-mode .completedhover:hover  
    {
        font-weight: 700;
        color: black; 
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

    .profile_dd ul li {
        list-style: none;
    }

    .profile_dd ul li a {
        display: block;
        padding: 0.5rem 1rem;
        color: #333;
        transition: background-color 0.3s ease;
    }

    .profile_dd ul li a:hover {
        background-color: #f0f0f0;
    }
    .divider{
                font-size: 14px;
                text-transform: uppercase;
                font-weight: 500;
                color:darkgrey;
                transition: all .3s ease;
            }
            .active{
        color: white;
        background-color: rgb(59 130 246);
        border-radius: 0.75rem; 
    }
        </style>
        </head>
        <!-- bg-gray-100 -->
        <!-- bg-gradient-to-r from-blue-100 via-blue-300 to-blue-200 -->
        <body class="">
        <nav class="flex justify-between items-center bg-white py-1 px-6 fixed top-0 w-full z-10 ">
        <div class="flex items-center">
            <div class="hidden sm:block mr-4">
                <span class="font-extrabold text-gray-800 md:text-2xl taskBanner">Task</span>
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

                <div id="dropdownContent" class="hidden absolute bg-white shadow-lg rounded-xl mt-2 w-80 sm:w-96 right-0 top-full  ">
        <div class="flex flex-col space-y-4 p-5 userprofile ">
            <h5 class="text-lg font-semibold text-gray-800 userlabel">User Profile</h5>
            <div class="flex items-center">
                <div class="w-16 h-16 overflow-hidden rounded-full">
                    <img src="profile.JPG" alt="profile-image" class="w-full h-full object-cover">
                </div>
            
                <div class="ml-4 flex flex-col ">
                    <p class="text-base font-semibold  mb-1 userlabel"><?php echo $firstName?></p>
                    <span class="mb-1  userroles">Administrator</span>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="far fa-envelope mr-1 userlabel"></i>
                        <span class="max-w-xs userlabel">orfinadacarlgabrielle@gmail.com</span>
                        <!-- <span class="max-w-xs "><?php echo $_SESSION['email']; ?></span> -->
                    </div>
                </div>
            </div>
            <hr class="my-4 border-t-1 border-gray-300">
            <a href="#" id="accountSettings" class="flex items-center text-gray-600 hover:text-gray-800">
                <i class="fas fa-cog text-xl mr-3 userlabel"></i>
                <span class="text-lg userlabel">Account Settings</span>
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
    </nav>
    <div class="flex">
        <aside id="sidebar" class="z-40 p-4 sidebar bg-white text-dark w-64 fixed flex flex-col transition duration-300 ease-in-out transform -translate-x-0 rounded-3xl" style="top: 6.5rem; bottom: 3.5rem; left: 1.3rem;">
            <div class="flex flex-col h-full">
                <ul id="sidebarMenu" class="py-4">
                    <li class="font-semibold text-gray-500 uppercase text-xs tracking-wide mb-3">Administrator</li>
                    <li class="mb-3 active">
                        <a href="#" id="dashboard" class=" dashhover  menu item p-4 flex hover:bg-gray-200 items-center text-lg rounded-lg transition duration-300 ease-in-out">
                            <i class='bx bx-home text-lg  mr-3'></i>
                            Dashboard
                            <svg width="86" class=" rightArrow" height="30"  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M8.752 17.648a1.2 1.2 0 0 1 0-1.696L12.703 12 8.752 8.048a1.2 1.2 0 0 1 1.696-1.696l4.8 4.8a1.2 1.2 0 0 1 0 1.696l-4.8 4.8a1.2 1.2 0 0 1-1.696 0Z" clip-rule="evenodd"></path>
    </svg>
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#" id="create_task" class="taskhover menu item p-4 flex hover:bg-gray-200 items-center text-lg rounded-lg transition duration-300 ease-in-out">
                            <i class='bx bx-plus text-lg text-yellow-500 mr-3'></i>
                            Create Task
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#" id="task_list" class="listhover flex text-lg items-center p-4 rounded-lg transition duration-300 hover:bg-gray-200 ease-in-out">
                            <i class='bx bx-list-ul text-lg text-green-500 mr-3'></i>
                            Task List
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#" id="user_list" class="usershover flex text-lg items-center p-4 rounded-lg transition duration-300 hover:bg-gray-200 ease-in-out">
                            <i class='bx bx-user text-lg text-gray-500 mr-3'></i>
                            Users
                        </a>
                    </li>
                    <div class="flex items-center border-b border-gray-300 w-full mb-3"></div>
                    <li class="mb-3">
                        <a href="#" class="dark-mode-toggle flex text-lg items-center p-4 rounded-lg transition duration-300 ease-in-out font-semibold text-gray-400">
                            <i class='bx dark:hidden bx-moon text-yellow-500 text-lg mr-3'></i>
                            Dark Mode
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="admin_logout.php" class="flex text-lg items-center p-4 rounded-lg  transition duration-300 ease-in-out font-semibold text-red-600">
                            <i class='bx bx-log-out text-red-600 text-lg mr-3'></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
    </div>


    <main id="content" class="flex-grow p-8 transition-all duration-300 "> 
    <div class="p-4  pt-11" >
        <div id="content">
        
    </div>
    </div>
        </main>
        <script>

    document.querySelector('.dark-mode-toggle').addEventListener('click', function(event) {
        event.preventDefault(); 
        document.body.classList.toggle('dark-mode'); 
        
        if (document.body.classList.contains('dark-mode')) {
            document.body.style.background = '#2C2C2C'; 
            document.body.style.color = 'white';
        } else {
            document.body.style.background = '#f1f1f1';
            document.body.style.color = '#2C2C2C'; 
        }
    });
    $(document).ready(function() {
        function loadAndInitializeChart(url) {
            $('#content').load(url, function() {
                initializeChart();
            });
        }

        loadAndInitializeChart('admin_dashboard.php');

        $('#dashboard').click(function(event) {
            event.preventDefault();
            loadAndInitializeChart('admin_dashboard.php');
        });
        $('#create_task').click(function(event) {
            event.preventDefault();
            loadAndInitializeChart('admin_createTask.php');
        });
        $('#task_list').click(function(event) {
            event.preventDefault();
            loadAndInitializeChart('admin_task_list.php');
        });
        $('#user_list').click(function(event) {
            event.preventDefault();
            loadAndInitializeChart('users_list.php');
        });

        // $('#create_task').click(function(event) {
        //     event.preventDefault();
        //     loadAndInitializeChart('admin_createTask.php');
        // });


        function initializeChart() {
                const ctx = document.getElementById("myDoughnutChart").getContext("2d");
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
                                    backgroundColor: ["#EF4444", "#F59E0B", "#10B981"],
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
                    
            }
    
        // $('#taskForm').submit(function(event) {
        //         event.preventDefault();
        //         $.ajax({
        //             type: 'POST',
        //             data: $(this).serialize(), 
        //             success: function(response) {
        //                 $('#successMessage').text("Task created successfully!");
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(error);
        //             }
        //         });
        //     });
        
    });



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
