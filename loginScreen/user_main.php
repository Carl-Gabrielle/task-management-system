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

</head>
    <style>
body {
    font-family: 'Poppins', sans-serif;
    /* background: linear-gradient(to right, #a0c4ff, #a8ddff, #b6e6ff, #c3f0ff); */
    transition: background-color 0.3s ease;
    color: black; /* Adjust text color */
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
body.dark-mode .notdetails,
body.dark-mode .userlabel
{
    border-color: #555; 
    color: white; 
}
body.dark-mode .label,
body.dark-mode .userName,
body.dark-mode .role{
    color: white; 
}


body.dark-mode nav,
body.dark-mode .sidebar,
body.dark-mode table,
body.dark-mode .divfilter,
body.dark-mode .piedark,
body.dark-mode .dropdowndark
{
/* background-color: #2C2C2C; */
background-color:#3A3A3A
}
body.dark-mode .taskhover:hover, 
body.dark-mode .nothover:hover,
body.dark-mode .inhover:hover,
body.dark-mode .completedhover:hover  
 {
    color: black; 
}
.active{
    color: white;
    background-color: #2563eb;
    background-color: red;
    border-radius: 0.75rem; /* 12px */
}

        /* .bg{
            background-color:#999eff;
    background-image:
    radial-gradient(at 87% 40%, hsla(216,74%,74%,1) 0px, transparent 50%),
    radial-gradient(at 28% 48%, hsla(237,60%,78%,1) 0px, transparent 50%),
    radial-gradient(at 72% 95%, hsla(194,70%,68%,1) 0px, transparent 50%),
    radial-gradient(at 5% 78%, hsla(253,67%,70%,1) 0px, transparent 50%),
    radial-gradient(at 54% 67%, hsla(150,65%,61%,1) 0px, transparent 50%),
    radial-gradient(at 37% 70%, hsla(212,66%,76%,1) 0px, transparent 50%),
    radial-gradient(at 62% 70%, hsla(334,72%,63%,1) 0px, transparent 50%);
            }  */
            
            
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
    <?php
           

            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $sql = "SELECT COUNT(*) AS task_count FROM task_list WHERE assigned_to = '$userId'";
                $result = $connection->query($sql);

                $taskCount = 0;

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $taskCount = $row["task_count"];
                }
            }
            ?>
    <button class="p-2 rounded-md focus:outline-none relative pt-1" id="notificationButton" onclick="toggleNotification()">
            <span class="absolute -top-1 ml-2 right-0 bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs"><?php echo $taskCount?></span>
            <i class='bx bx-bell text-2xl'></i>
        </button>


        <div class="profile relative flex items-center ml-4">
            <img src="profile.JPG" alt="profile-picture" class="rounded-full w-7 h-7 md:h-10 md:w-10 object-cover">
            <!-- id="dropdownContent" -->
            <div class="ml-2 p-1 rounded-lg hidden sm:block hover:bg-gray-200 hover:bg-opacity-40 cursor-pointer "  >
                <span class="name ">Hi, <?php echo $firstName?></span>
                <i class="fas fa-chevron-down ml-1"></i>
            </div>
            <div id="dropdownContent" class="dropdowndark hidden absolute bg-white shadow-lg rounded-xl mt-2 w-80 sm:w-96 right-0 top-full ">
    <div class="flex flex-col space-y-4 p-5">
        <h5 class="text-lg font-semibold text-gray-800 userlabel">User Profile</h5>
        <div class="flex items-center">
            <div class="w-16 h-16 overflow-hidden rounded-full">
                <img src="profile.JPG" alt="profile-image" class="w-full h-full object-cover">
            </div>
        
            <div class="ml-4 flex flex-col ">
                <p class="text-base font-bold mb-1 userName "><?php echo $name?></p>
                <span class="mb-1 role">Member</span>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="far fa-envelope mr-1 userName"></i>
                    <span class="max-w-xs userName">orfinadacarlgabrielle@gmail.com</span>
                </div>
            </div>
        </div>
        <hr class="my-4 border-t-1 border-gray-300">
        <a href="#" class="flex items-center text-gray-600 hover:text-gray-800">
            <i class="fas fa-cog text-xl mr-3 userName"></i>
            <span class="text-lg userName">Account Settings</span>
        </a>
    </div>
</div>

  <div id="notificationContent" class="piedark hidden mr-36 absolute bg-white rounded-xl mt-2 w-80 sm:w-96 right-0 top-full ">
  <?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT title, due_date FROM task_list WHERE assigned_to = $user_id";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="flex flex-col space-y-4 p-5">';
            echo '<div class="flex items-center">';
            echo '<h5 class="text-lg font-semibold text-gray-800 inline-block mr-5 notdetails">Notifications</h5>';
            echo '<span class="bg-red-500 text-white inline-block w-15 pl-3 pr-3 pt-1 pb-1 text-center rounded-lg">' . mysqli_num_rows($result) . ' new</span>';
            echo '</div>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="flex items-center">';
                echo '<div class="w-10 h-10 overflow-hidden rounded-full">';
                echo '<img src="undraw_cabin_hkfr.png" alt="profile-image" class="w-full h-full object-cover">';
                echo '</div>';
                echo '<div class="ml-4">';
                echo '<p class="font-semibold">' . $row['title'] . '</p>';
                echo '<p class="text-sm text-gray-600 notdetails">Due date: ' . date("M. j, Y", strtotime($row['due_date'])) . '</p>';
                echo '<p class="text-sm text-gray-600 notdetails">Sent by: Carl Gabrielle</p>';
                echo '</div>';
                echo '</div>';
                echo '<hr class="my-4 border-t-1 border-gray-300">';
            }

            echo '<a href="task_samp.php" class="flex items-center justify-center p-3 piedark rounded-md text-white bg-gray-800">';
            echo '<span class="text-lg">See all notifications</span>';
            echo '</a>';            
            echo '</div>';
        }
    }
}
?>

        </div>
<!--  -->
<div id="dropdownContent"  class="hidden divcontent absolute bg-white shadow-lg rounded-xl mt-2 w-80 sm:w-96 right-0 top-full border border-gray-200">
    <div class="flex flex-col space-y-4 p-5">
        <h5 class="text-lg font-semibold text-gray-800">User Profile</h5>
        <div class="flex items-center">
            <!-- Image -->
            <div class="w-16 h-16 overflow-hidden rounded-full">
                <img src="profile.JPG" alt="profile-image" class="w-full h-full object-cover">
            </div>
        
            <div class="ml-4 flex flex-col ">
                <p class="text-base font-medium mb-1 userName"><?php echo $name?></p>
                <span class="mb-1 role">Member</span>
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

$(document).ready(function(){
    $(".ml-2").click(function(){
        $("#dropdownContent").toggle(500);
    });
});
function toggleNotification() {
    var notification = $("#notificationContent");
    notification.slideToggle();
}


</script>
            
        </div>
    </div>
</nav>
<div class="flex">
    <aside id="sidebar" class="p-4 sidebar bg-white  text-dark w-64 fixed flex flex-col transition  duration-300 ease-in-out transform -translate-x-0 h-full " style="top:3.5rem;"   >
        <div class="flex flex-col h-full">
            <ul id="sidebarMenu" class="py-4">
    <li class="mb-4 taskhover active ">
        <a href="#" id="dashboard" class=" active menu item p-4 flex font-semibold items-center py-2 px-4 text-lg rounded-lg transition duration-300 ease-in-out">
            <i class='bx bx-home text-lg mr-2'></i>
            Task
        </a>
    </li>
    <li class="mb-4 nothover">
        <a href="user_notstarted.php" id ="create_task" class="menu item p-4 flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray-300  transition duration-300 ease-in-out">
        <i class='bx bx-time-five text-lg text-red-600 mr-2'></i>
         Not Started
        </a>
    </li>
    <li class="mb-4 inhover">
        <a href="#" class="flex text-lg items-center py-2 px-4 rounded-lg transition duration-300 hover:bg-gray-300 ease-in-out">
      <i class='bx bx-loader-circle text-lg text-yellow-600 mr-2'></i>
            In Progress
        </a>
    </li>
    <li class="mb-4 completedhover">
        <a href="#" class="flex text-lg items-center py-2 px-4 rounded-lg transition hover:bg-gray-300 duration-300 ease-in-out">
        <i class='bx bx-check-circle text-lg text-green-500 mr-2'></i>
            Completed
        </a>
    </li>
    <div class="flex items-center border-b border-gray-300 w-full mb-2"></div>
    <li class="mb-4">
    <a href="#" class="dark-mode-toggle flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray transition duration-300 ease-in-out font-semibold text-gray-400">
    <i class='bx dark:hidden bx-moon text-yellow-500 text-lg mr-2'></i>
    Dark Mode
</a>
    </li>
    <li class="mb-4">
        <a href="admin_logout.php" class="flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray transition duration-300 ease-in-out font-semibold text-red-600">
            <i class='bx bx-log-out text-red-600 text-lg mr-2'></i>
            Logout
        </a>
    </li>
</ul>
        </div>
    </aside>
</div>
<!-- id content -->
<main class="mt-8" class="flex-grow p-8 transition-all duration-300 ">
            <div class="p-4 sm:ml-64 pt-16 " id="content-container">
                
                    <p class="flex items-center text-base ml-4">
    <span class="text-gray-500">Home</span>
    <span class="mx-2">></span>
    <span class="text-gray-800 overview">Task Overview</span>
</p>
                                            </div>               
        </main>
    <script>
document.querySelector('.dark-mode-toggle').addEventListener('click', function(event) {
    event.preventDefault(); 
    document.body.classList.toggle('dark-mode'); 
    
    if (document.body.classList.contains('dark-mode')) {
        document.body.style.background = '#2C2C2C'; 
        document.body.style.color = '#f1f1f1';
    } else {
        document.body.style.background = '#f1f1f1'; 
        document.body.style.color = '#2C2C2C'; 
    }
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
