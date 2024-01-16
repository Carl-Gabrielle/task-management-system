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
    body{
        background-color: #f1f1f1;
        font-family: 'Poppins', sans-serif;
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
<body >
    
<nav class="flex justify-between items-center bg-white py-1 px-6 fixed top-0 w-full z-10 ">
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
    <?php
            include('config.php');


            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
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
    <button class="p-2 rounded-md focus:outline-none relative pt-1" id="notificationButton">
            <span class="absolute -top-1 ml-2 right-0 bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs"> <?php echo $taskCount; ?></span>
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
            <!-- Image -->
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
</nav>

<div class="flex ">
    <aside id="sidebar" class="p-4 bg-white text-dark w-64 fixed flex flex-col transition  duration-300 ease-in-out transform shadow-lg -translate-x-0 h-full  " style="top:3.5rem"   >
        <div class="flex flex-col h-full ">
            <ul id="sidebarMenu" class="py-4">
    <li class="mb-4">
        <a href="#" id="dashboard" class="active menu item active p-4 flex hover:bg-gray-100 font-semibold items-center py-2 px-4 text-lg rounded-lg transition duration-300 ease-in-out">
            <i class='bx bx-home text-lg mr-2'></i>
            Dashboard
        </a>
    </li>
    <li class="mb-4">
        <a href="#" id ="create_task" class="menu item p-4 flex text-lg items-center py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 ease-in-out">
            <i class='bx bx-plus text-lg mr-2'></i>
            Create Task
        </a>
    </li>
    <li class="mb-4">
        <a href="admin_task_list.php" class="flex text-lg items-center py-2 px-4 rounded-lg transition duration-300 hover:bg-gray-300 ease-in-out">
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
</div>


<main class="mt-8" id="content" class="flex-grow p-8 transition-all duration-300  ">
<div class="p-4 sm:ml-64 pt-10 " id="content-container">
                    <div class="flex items-center justify-center">
        <div class="mb-4">
            <label for="filter">Filter by Priority:</label>
            <select id="filter" class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="all">All</option>
                <option value="low">Low Priority</option>
                <option value="mid">Medium Priority</option>
                <option value="high">High Priority</option>
            </select>
        </div>
        <div class="mb-4 ml-4">
            <label for="sort">Sort by Due Date:</label>
            <select id="sort" class="border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
    </div>
</div>

<div class="flex items-center justify-center ">
        <div class="overflow-x-auto w-full ">
            <table id="taskTable" class="table-auto min-w-full divide-y divide-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-200 rounded-t-lg">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-800 uppercase">Priority</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-200" id="taskTableBody">
                    <?php
                 
                    require_once('config.php');

                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT title, description, due_date, priority FROM task_list WHERE assigned_to = $user_id";
                        $result = mysqli_query($connection, $sql);

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    
                                    echo "<tr>";
                                    echo "<td class='px-6 py-4 text-sm font-semibold text-gray-800'>" . $row['title'] . "</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $row['description'] . "</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>" . date("M. j, Y", strtotime($row['due_date'])) . "</td>";
                                    echo "<td class='px-6 py-4 text-sm ";

                                    $priority = ucwords(strtolower($row['priority']));
                                    $class = '';
                                    
                                    switch ($priority) {
                                        case 'High':
                                            echo "text-red-600 font-bold";
                                            break;
                                        case 'Mid':
                                            echo "text-yellow-600 font-medium";
                                            break;
                                        case 'Low':
                                            echo "text-green-600 font-normal";
                                            break;
                                        default:
                                            echo "text-gray-700";
                                            break;
                                    }
                                    
                                    echo " priority'>" . $row['priority'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='px-6 py-4 text-sm text-gray-500 text-center'>
                                <div class='flex flex-col items-center justify-center pt-3'>
                                <svg xmlns=\"http://www.w3.org/2000/svg\" data-name=\"Layer 1\" class=\"h-24 w-auto\" viewBox=\"0 0 747.32007 621.03435\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"100%\" height=\"100%\"><path d=\"M904.89,744.88717a50.79382,50.79382,0,0,1-13.58984,12.63c-1.12012.71-2.27,1.38-3.43994,2H860.33044c.32959-.66.64991-1.33.96-2a95.35446,95.35446,0,0,0-19.84034-109.34c16.64014,5.14,32.02,15.16,42.08008,29.37a64.46972,64.46972,0,0,1,10.23,23,96.27569,96.27569,0,0,0-7.66992-48.41c13.50977,10.99,24.03027,26.04,28.04,42.98C918.14,712.06716,915.23035,730.87716,904.89,744.88717Z\" transform=\"translate(-226.33997 -139.48282)\" fill=\"#f0f0f0\"/></svg>
                                    <p class='pt-3'>No tasks assigned to you.</p>
                                </div>";;
                            }
                        } else {
                            echo "<tr><td colspan='4' class='px-6 py-4 text-sm text-red-500 text-center'>Error executing query: " . mysqli_error($connection) . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='px-6 py-4 text-sm text-red-500 text-center'>User not logged in.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
    <script>
        function filterTasksByPriority(priority) {
            const rows = document.querySelectorAll('#taskTable tbody tr');
            rows.forEach(row => {
                const rowPriority = row.querySelector('.priority').textContent.trim().toLowerCase();
                if (priority === 'all' || rowPriority === priority) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
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
    </script>
</body>
</html>
