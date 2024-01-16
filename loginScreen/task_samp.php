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
    <title>User Dashboard</title>
</head>
    <style>
       /* Light Mode */
       body {
    font-family: 'Poppins', sans-serif;
    transition: background-color 0.3s ease, opacity 0.3s ease-in-out;
    color: black; /* Adjust text color */
    background-color: #f1f1f1;
    overflow-y: scroll; 
    opacity: 0;
}

body.loaded {
    opacity: 1;
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
body.dark-mode .userlabel,
body.dark-mode .contenttext
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
    border-radius: 0.75rem; /* 12px */
}
.status-button {
            padding: 8px 12px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        
        /* Dark mode styles */
        .dark-mode {
            background-color: #3A3A3A;
            color: #f1f1f1;
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
    header('Location: login.php');
    exit();
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
                <p class="contenttext text-base font-bold mb-1 userName "><?php echo $name?></p>
                <span class="contenttext mb-1 role">Member</span>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="contenttext far fa-envelope mr-1 userName"></i>
                    <span class="contenttext max-w-xs userName">orfinadacarlgabrielle@gmail.com</span>
                </div>
            </div>
        </div>
        <hr class="contenttext my-4 border-t-1 border-gray-300">
        <a href="#" class="flex items-center text-gray-600 hover:text-gray-800">
            <i class="contenttext fas fa-cog text-xl mr-3 userName"></i>
            <span class="contenttext text-lg userName">Account Settings</span>
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
    <aside id="sidebar" class="p-4 z-10 sidebar bg-white  text-dark w-64 fixed flex flex-col transition  duration-300 ease-in-out transform -translate-x-0 h-full " style="top:3.5rem;"   >
        <div class="flex flex-col h-full">
            <ul id="sidebarMenu" class="py-4">
    <li class="mb-4 taskhover ">
        <a href="task_samp.php" id="tasksLink" class=" menu item hover:bg-gray-300  p-4 flex font-semibold items-center py-2 px-4 text-lg rounded-lg transition duration-300 ease-in-out">
            <i class='bx bx-home text-lg mr-2'></i>
            Task
        </a>
    </li>
    <li class="mb-4 nothover">
        <a href="" id ="notStartedLink" class="menu item p-4 flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray-300  transition duration-300 ease-in-out">
        <i class='bx bx-time-five text-lg text-red-600 mr-2'></i>
         Not Started
        </a>
    </li>
    <li class="mb-4 inhover">
        <a href="#" id="inprogressLink" class="flex text-lg items-center py-2 px-4 rounded-lg transition duration-300 hover:bg-gray-300 ease-in-out">
      <i class='bx bx-loader-circle text-lg text-yellow-600 mr-2'></i>
            In Progress
        </a>
    </li>
    <li class="mb-4 completedhover">
        <a href="#" id ="completedLink" class="flex text-lg items-center py-2 px-4 rounded-lg transition hover:bg-gray-300 duration-300 ease-in-out">
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
<main class="mt-8" class="flex-grow p-8 transition-all duration-300 ">
            <div class="p-4 md:p-16 sm:ml-64 pt-16 " id="content-container">
                    <div class="flex ml-auto items-end justify-end">
                        <div class="mb-4 ">
                            <label for="filter" class=" filter text-gray-600">Filter by Priority:</label>
                            <select id="filter"
                                class="cursor-pointer border label divfilter rounded py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="all" class="cursor-pointer" >All</option>
                                <option value="low" >Low Priority</option>
                                <option value="mid">Medium Priority</option>
                                <option value="high" >High Priority</option>
                            </select>
                        </div>
                        <div class="mb-4 ml-4">
                            <label class=" text-gray-600 sort" for="sort">Sort by Due Date:</label>
                            <select id="sort"
                                class="cursor-pointer border  label divfilter rounded py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                    <p class="flex items-center text-base ml-4">
    <span class="text-gray-500">Home</span>
    <span class="mx-2">></span>
    <span class="text-gray-800 overview">Task Overview</span>
</p>
                    <div class="flex items-center justify-center pt-5">
        <div class="overflow-x-auto w-full rounded-t-lg">
            <table id="taskTable" class="table-auto min-w-full divide-y divide-gray-200 rounded-t-lg shadow-md  bg-white p-8">
                                <thead class="bg-gray-200  ">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Priority</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" id="taskTableBody">
                                    <?php
                                    if (isset($_SESSION['user_id'])) {
                                        $user_id = $_SESSION['user_id'];
                                        $sql = "SELECT title, description, due_date, priority, status  FROM task_list WHERE assigned_to = $user_id";
                                        $result = mysqli_query($connection, $sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td class='px-6 py-4 text-sm font-semibold text-gray-800 task_title'>" . $row['title'] . "</td>";
                                                    echo "<td class='px-6 py-4 text-sm text-gray-700 task_description'>" . $row['description'] . "</td>";
                                                    echo "<td class='px-6 py-4 text-sm text-gray-700 task_date'>" . date("M. j, Y", strtotime($row['due_date'])) . "</td>";
                                                    echo "<td class='px-6 py-4  text-xs ";
                                                    $priority = ucwords(strtolower($row['priority']));
                                                    $class = '';
                                                    
                                                    switch ($priority) {
                                                        case 'High':
                                                            echo "bg-red-200 font-bold text-red-600 rounded-2xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                        case 'Mid':
                                                            echo "bg-yellow-200 font-bold text-yellow-600 rounded-2xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                        case 'Low':
                                                            echo "bg-green-200 font-bold text-green-600 rounded-2xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                        default:
                                                            echo "bg-gray-400 text-white rounded-2xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                    }
                                                    
                                                    echo " priority '>" . strtoupper($row['priority']) . "</td>";
                                                    echo "<td class='px-6 py-4 text-xs ";
                                    
                                                    $status = strtolower($row['status']);
                                    switch ($status) {
                                        case 'not started':
                                            echo "text-red-600 font-bold text-white rounded-xl";
                                            break;
                                        case 'in progress':
                                            echo "text-yellow-600 font-bold text-white rounded-xl";
                                            break;
                                        case 'completed':
                                            echo "text-green-600 font-bold text-white rounded-xl";
                                            break;
                                        default:
                                            echo "text-gray-700 text-white rounded-xl";
                                            break;
                                    }

                                    echo "'>" . strtoupper($row['status']) . "</td>";

                                                    echo "</tr>";
                                                    ?>
                                                    <?php
                                                }
                                            } else {
                                                ?>

            <tr>
    <td colspan='4' class='px-6 py-4 text-sm text-gray-500 text-center'>
        <div class="flex flex-col items-center justify-center pt-3 ">
            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" class="h-24 w-auto" viewBox="0 0 747.32007 621.03435" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%"><path d="M904.89,744.88717a50.79382,50.79382,0,0,1-13.58984,12.63c-1.12012.71-2.27,1.38-3.43994,2H860.33044c.32959-.66.64991-1.33.96-2a95.35446,95.35446,0,0,0-19.84034-109.34c16.64014,5.14,32.02,15.16,42.08008,29.37a64.46972,64.46972,0,0,1,10.23,23,96.27569,96.27569,0,0,0-7.66992-48.41c13.50977,10.99,24.03027,26.04,28.04,42.98C918.14,712.06716,915.23035,730.87716,904.89,744.88717Z" transform="translate(-226.33997 -139.48282)" fill="#f0f0f0"/><path d="M339.016,155.95557a3.13178,3.13178,0,0,0,0,6.26355H567.6722a3.13178,3.13178,0,0,0,0-6.26355Z" transform="translate(-226.33997 -139.48282)" fill="#6c63ff"/><path d="M339.016,174.74619a3.13178,3.13178,0,1,0-.01321,6.26355H483.56161a3.13178,3.13178,0,1,0,0-6.26355Z" transform="translate(-226.33997 -139.48282)" fill="#6c63ff"/><path d="M339.016,268.95557a3.13178,3.13178,0,0,0,0,6.26355H567.6722a3.13178,3.13178,0,0,0,0-6.26355Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><path d="M339.016,287.74619a3.13178,3.13178,0,1,0-.01321,6.26355H483.56161a3.13178,3.13178,0,1,0,0-6.26355Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><path d="M339.016,381.95557a3.13178,3.13178,0,0,0,0,6.26355H567.6722a3.13178,3.13178,0,0,0,0-6.26355Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><path d="M339.016,400.74619a3.13178,3.13178,0,1,0-.01321,6.26355H483.56161a3.13178,3.13178,0,1,0,0-6.26355Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><path d="M255.11816,178.00023h-.01074a1.82018,1.82018,0,0,1-1.36255-.62549l-9.6997-11.1372a1.82107,1.82107,0,1,1,2.74646-2.39209l8.34253,9.5791,25.04455-28.09717a1.82054,1.82054,0,1,1,2.71838,2.42236l-26.4198,29.64112A1.821,1.821,0,0,1,255.11816,178.00023Z" transform="translate(-226.33997 -139.48282)" fill="#6c63ff"/><path d="M255.34,197.48282a29,29,0,0,1,0-58,1,1,0,0,1,0,2,27,27,0,1,0,27.00048,27,1,1,0,0,1,2,0A29.03316,29.03316,0,0,1,255.34,197.48282Z" transform="translate(-226.33997 -139.48282)" fill="#3f3d56"/><path d="M676.11816,542.51718h-.01074a1.82018,1.82018,0,0,1-1.36255-.62549l-9.6997-11.13721a1.82107,1.82107,0,1,1,2.74646-2.39209l8.34253,9.5791,25.04455-28.09717a1.82054,1.82054,0,1,1,2.71838,2.42237l-26.4198,29.64111A1.821,1.821,0,0,1,676.11816,542.51718Z" transform="translate(-226.33997 -139.48282)" fill="#6c63ff"/><path d="M676.34,561.99991a29,29,0,0,1,0-58,1,1,0,0,1,0,2,27,27,0,1,0,27,27,1,1,0,0,1,2,0A29.03338,29.03338,0,0,1,676.34,561.99991Z" transform="translate(-226.33997 -139.48282)" fill="#3f3d56"/><path d="M869.64205,517.58537a10.0558,10.0558,0,0,1,2.75353-15.17148L865.8717,467.2796l17.10819,7.22106,3.57231,32.257a10.11027,10.11027,0,0,1-16.91015,10.82766Z" transform="translate(-226.33997 -139.48282)" fill="#9e616a"/><path d="M711.03837,517.58537a10.0558,10.0558,0,0,0-2.75353-15.17148l6.52388-35.13429-17.10819,7.22106-3.57231,32.257a10.11027,10.11027,0,0,0,16.91015,10.82766Z" transform="translate(-226.33997 -139.48282)" fill="#9e616a"/><polygon points="548.355 607.831 536.095 607.831 530.263 560.543 548.357 560.543 548.355 607.831" fill="#9e616a"/><path d="M777.82176,759.19792l-39.53076-.00146v-.5a15.38728,15.38728,0,0,1,15.38647-15.38623h.001l24.144.001Z" transform="translate(-226.33997 -139.48282)" fill="#2f2e41"/><polygon points="599.355 607.831 587.095 607.831 581.263 560.543 599.357 560.543 599.355 607.831" fill="#9e616a"/><path d="M828.82176,759.19792l-39.53076-.00146v-.5a15.38728,15.38728,0,0,1,15.38647-15.38623h.001l24.144.001Z" transform="translate(-226.33997 -139.48282)" fill="#2f2e41"/><polygon points="526.418 322.034 510.5 339.568 517.5 470.856 529.5 596.534 551.362 596.534 571.5 372.109 580.465 596.534 603.898 596.534 631.396 332.755 526.418 322.034" fill="#2f2e41"/><path d="M853.84021,309.01718l-42.5-26.5-6-15H765.60793l-4.26772,14-44,27,17.5,76.5,2,94s68,41,121-5l-21.5-109.5Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><path d="M730.84021,310.01718l-13.5-1.5s-13.5,10.5-15.5,33.5,0,66.73622,0,66.73622l-8,85.26378,17,1,22-85,2-39.42126Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><path d="M839.84021,310.01718l13.5-1.5s13.5,10.5,15.5,33.5,10,66.73622,10,66.73622l8,85.26378-17,1-22-85-12-39.42126Z" transform="translate(-226.33997 -139.48282)" fill="#e4e4e4"/><circle cx="782.14336" cy="224.1156" r="32.80151" transform="translate(-16.01061 663.42875) rotate(-61.33681)" fill="#9e616a"/><path d="M819.61345,224.748a8.1802,8.1802,0,0,0-1.17452-5.8465,16.54056,16.54056,0,0,0,2.2031-5.61609c.89241-5.96643-3.67747-8.1522-6.62234-12.65813-1.27767-1.955-.699-2.72745-.77132-4.80494a15.06258,15.06258,0,0,0-2.60715-7.83986c-1.81934-3.01593-3.76174-6.16037-6.81342-8.12038-6.41314-4.11892-14.62842-1.38094-21.97727-3.13817-3.23919-.77461-6.263-2.42338-9.49281-3.24939s-7.03294-.61172-8.90461,1.75055c-.86408,1.0906-1.21075,2.51134-2.07735,3.60009-1.72262,2.16377-4.99238,2.525-7.65252,3.60929-5.88256,2.39766-8.91086,8.73973-8.78176,15.00109a24.26955,24.26955,0,0,0,.43287,3.90741,18.16486,18.16486,0,0,0-1.46146,7.55519c.129,6.26135,2.9183,12.44653,6.2533,18.15453a27.24489,27.24489,0,0,1,1.92539-5.17279,3.398,3.398,0,0,1,1.10863-1.45068c1.13286-.72556,2.75-.18237,4.18283-.12532,2.96759.11813,5.32758-1.974,6.72373-4.313s2.16459-5.03414,3.76533-7.24238a4.28194,4.28194,0,0,1,3.0901-2.029,6.45914,6.45914,0,0,1,3.14239.97183c4.83091,2.47559,9.821,5.16487,15.117,5.49842a24.70462,24.70462,0,0,1,5.40455.46126c4.01191,1.15748,6.39447,5.41127,6.91658,9.27825s-.27077,7.67771.04283,11.54617,2.17045,8.20048,6.00537,9.90819a1.767,1.767,0,0,0,1.332.17616,1.52948,1.52948,0,0,0,.66519-.718L816.77,231.4816A19.4283,19.4283,0,0,0,819.61345,224.748Z" transform="translate(-226.33997 -139.48282)" fill="#2f2e41"/><path d="M973.66,759.51718a1.00276,1.00276,0,0,1-1,1h-381a1,1,0,0,1,0-2h381A1.00275,1.00275,0,0,1,973.66,759.51718Z" transform="translate(-226.33997 -139.48282)" fill="#cacaca"/><rect x="1.16004" y="83.81665" width="345.00023" height="2" fill="#e4e4e4"/><rect x="1.16004" y="195.81665" width="345.00023" height="2" fill="#e4e4e4"/><rect x="1.16004" y="307.81665" width="345.00023" height="2" fill="#e4e4e4"/></svg>
            <p class="pt-3">No tasks assigned to you.</p>
        </div>
    </td>
</tr>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan='4' class='px-6 py-4 text-sm text-red-500 text-center'>Error
                                                    executing query:
                                                    <?= mysqli_error($connection) ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan='4' class='px-6 py-4 text-sm text-red-500 text-center'>User not
                                                logged in.</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
<!-- 
                        <div class="flex flex-col sm:flex-row gap-4" style="margin-top: 20px;">
        <button class="flex-1 bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded status-button"
                onclick="changeStatus('notStarted')">
            Not Started
        </button>
        <button class="flex-1 bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded status-button"
                onclick="changeStatus('inProgress')">
            In Progress
        </button>
        <button class="flex-1 bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded status-button"
                onclick="changeStatus('completed')">
            Completed
        </button>
    </div> -->
    </div>
                                            </div>               
        </main>
    <script>
         $(document).ready(function() {
        $("#notStartedLink").click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Load content from notstarted.php using AJAX
            $.ajax({
                url: "user_notstarted.php",
                type: "GET",
                success: function(response) {
                    $("#content-container").html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error); 
                }
            });
        });
        $("#inprogressLink").click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Load content from notstarted.php using AJAX
            $.ajax({
                url: "user_inprogress.php",
                type: "GET",
                success: function(response) {
                    $("#content-container").html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error); 
                }
            });
        });
        $("#completedLink").click(function(e) {
            e.preventDefault(); 
            $.ajax({
                url: "user_completed.php",
                type: "GET",
                success: function(response) {
                    $("#content-container").html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error); 
                }
            });
        });
    });

//    function changeStatus(status) {
//     const isDarkMode = document.body.classList.contains('dark-mode');
//     const buttons = document.querySelectorAll('.status-button');

//     buttons.forEach(button => {
//         button.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500', 'text-white');
//         button.classList.add('bg-gray-200', 'text-gray-600');
//     });
    
//     if (isDarkMode) {
//         buttons.forEach(button => {
//             button.classList.remove('bg-white', 'text-black');
//             button.classList.add('bg-gray-200', 'text-gray-600');
//         });

//         const clickedButton = document.querySelector(`[onclick="changeStatus('${status}')"]`);
//         if (clickedButton) {
//             clickedButton.classList.remove('bg-gray-200', 'text-gray-600');
//             clickedButton.classList.add('bg-white', 'text-black');
//         }
//     }
//     switch (status) {
//         case 'notStarted':
//             buttons[0].classList.remove('bg-gray-200', 'text-gray-600');
//             buttons[0].classList.add('bg-red-500', 'text-white');
//             break;
//         case 'inProgress':
//             buttons[1].classList.remove('bg-gray-200', 'text-gray-600');
//             buttons[1].classList.add('bg-yellow-500', 'text-white');
//             break;
//         case 'completed':
//             buttons[2].classList.remove('bg-gray-200', 'text-gray-600');
//             buttons[2].classList.add('bg-green-500', 'text-white');
//             break;
//         default:
//             break;
//     }
// }

// You can also add a call to setDarkModeState function if needed
function setDarkModeState() {
    const isDarkMode = localStorage.getItem('darkMode');

    if (isDarkMode === 'true') {
        document.body.classList.add('dark-mode');
        document.body.style.background = '#2C2C2C';
        document.body.style.color = '#f1f1f1';

        const buttons = document.querySelectorAll('.status-button');
        buttons.forEach(button => {
            button.classList.add('dark-mode');
        });
    }
}

// Call setDarkModeState function on page load
setDarkModeState();

        document.querySelector('.dark-mode-toggle').addEventListener('click', function(event) {
            event.preventDefault(); 
            document.body.classList.toggle('dark-mode'); 

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'true');
                document.body.style.background = '#2C2C2C'; 
                document.body.style.color = '#f1f1f1';
                
                const buttons = document.querySelectorAll('.status-button');
                buttons.forEach(button => {
                    button.classList.add('dark-mode');
                });
            } else {
                localStorage.setItem('darkMode', 'false');
                document.body.style.background = '#f1f1f1'; 
                document.body.style.color = '#2C2C2C';
                const buttons = document.querySelectorAll('.status-button');
                buttons.forEach(button => {
                    button.classList.remove('dark-mode');
                });
            }
        });

        setDarkModeState();
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });

            function filterTasksByPriority(priority) {
    const rows = document.querySelectorAll('#taskTable tbody tr');
    rows.forEach(row => {
        const rowPriority = row.querySelector('.priority').textContent.trim().toLowerCase();
        if (priority === 'all' || rowPriority === priority) {
            row.classList.remove('hidden'); 
        } else {
            row.classList.add('hidden');
        }
    });
}

function sortTable(order) {
    const tableBody = document.getElementById('taskTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    rows.sort((rowA, rowB) => {
        const cellA = rowA.children[2].textContent.trim(); 
        const cellB = rowB.children[2].textContent.trim();

        if (order === 'asc') {
            return new Date(cellA) - new Date(cellB);
        } else {
            return new Date(cellB) - new Date(cellA);
        }
    });

    tableBody.innerHTML = ''; 
    rows.forEach(row => tableBody.appendChild(row)); 
}

document.getElementById('filter').addEventListener('change', function () {
    const selectedPriority = this.value;
    filterTasksByPriority(selectedPriority);
});

document.getElementById('sort').addEventListener('change', function () {
    const selectedOrder = this.value;
    sortTable(selectedOrder);
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
