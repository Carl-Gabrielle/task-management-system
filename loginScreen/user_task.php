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
       /* Light Mode */
body {
    font-family: 'Poppins', sans-serif;
    /* background: linear-gradient(to right, #a0c4ff, #a8ddff, #b6e6ff, #c3f0ff); */
    transition: background-color 0.3s ease;
    color: black; /* Adjust text color */
    background-color: #f1f1f1;
    overflow-y: scroll; 
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


<!-- id content -->
<main class="mt-8" class="flex-grow p-8 transition-all duration-300 ">
            <div class="p-4 sm:ml-64 pt-16 " id="content-container">
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
                                                            echo "bg-red-600 font-bold text-white rounded-xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                        case 'Mid':
                                                            echo "bg-yellow-600 font-bold text-white rounded-xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                        case 'Low':
                                                            echo "bg-green-600 font-bold text-white rounded-xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
                                                            break;
                                                        default:
                                                            echo "bg-gray-700 text-white rounded-xl w-16 h-8 flex items-center justify-center ml-5  mt-3 mb-3";
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
                                            </div>               
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
