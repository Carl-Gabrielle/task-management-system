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
body.dark-mode .selecttext,
body.dark-mode .contenttext,
body.dark-mode .textcolor,
body.dark-mode .iconstatus,
body.dark-mode .notask
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
body.dark-mode nav,
body.dark-mode .sidebar,
body.dark-mode table,
body.dark-mode .divfilter,
body.dark-mode .piedark,
body.dark-mode .status,
body.dark-mode .statushead
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
body.dark-mode .statuscontainer{
    background-color: #2C2C2C;
}

body.dark-mode .countstatus{
        background-color: #2C2C2C;
        color:white;
        font-weight: bold;
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
// session_start();

// if (isset($_SESSION['user_name'])) {
//     $name = $_SESSION['user_name'];
//     $nameArray = explode(' ', $name);
//     $firstName = $nameArray[0];
// } else {
//     echo "<p>You are not logged in.</p>";
// }?>
<body class="">

<!-- <main class="mt-8" class="flex-grow p-8 transition-all duration-300 ">
            <div class="p-4 sm:ml-64 pt-16 " id="content-container"> -->
                    <p class="flex items-center text-base ml-4">
    <span class="text-gray-500">Task</span>
    <span class="mx-2">></span>
    <span class="text-gray-800 overview">In progress</span>
</p>

                        
                        <div class="flex flex-col sm:flex-row items-center justify-between pt-5">
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
<div class="task-sections"></div>

<div class="w-full sm:w-full lg:w-/3 mb-4 sm:mb-0">
    <div class="statushead bg-yellow-500 rounded-t-lg shadow-md p-2">
        <h2 class="textcolor text-lg font-semibold text-white flex items-center">
        <i class='iconstatus bx bx-loader-circle text-lg text-white mr-2'></i> In progress
            <span class="countstatus bg-white text-gray-700 rounded-full ml-2 px-2.5 py-1.5 text-xs"><?php echo $taskCounts['in_progress']; ?></span>
        </h2>
    </div>
    <div class="statuscontainer bg-yellow-100 p-2 pt-5">
        <?php
        require('config.php');

        $query = "SELECT id, title, due_date, status FROM task_list WHERE status = 'In progress'";
        $result = $connection->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                if ($result->num_rows > 0) {
                    echo "<div class='grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-4'>";
                    while ($row = $result->fetch_assoc()) {
                        $taskId = $row['id'];
                        $commentKey = 'task_comment_' . $taskId;
                        $existingComment = isset($_SESSION[$commentKey]) ? $_SESSION[$commentKey] : '';
                
                        echo "<div class='col-span-1 sm:col-span-1'>";
                        echo "<div class='status bg-white rounded-3xl p-4 mx-2 mb-2 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl transform transition-transform duration-300 hover:scale-105'>";
                        echo "<div class='flex justify-between items-center mb-2'>";
                        echo "<div>";
                        echo "<h2 class='text-xl font-semibold mb-0'>" . $row['title'] . "</h2>";
                        echo "</div>";
                        echo "<p class='contenttext text-sm text-gray-500 mb-0'>2 hours ago</p>";
                        echo "</div>";
                        echo "<p class='contenttext text-sm text-gray-500 mb-2'>Due Date: " . date("M. j, Y", strtotime($row['due_date'])) . "</p>";
                        echo "<div class='progress-bar' style='height: 10px; background-color: #f2f2f2; border-radius: 5px;'>";
                        echo "<div class='progress bg-yellow-400' style='height: 100%; width: 50%;  border-radius: 5px;'></div>";
                        echo "<p class='contenttext text-xs text-gray-500 mt-1'>50%</p>"; 
                        echo "</div>";
                        echo "<div class='relative mt-7'>";
                        echo "<select name='status' class='statuscontainer selecttext rounded-md px-3 py-2 bg-white appearance-none bg-gray-200   text-gray-700 task-status' data-task-id='" . $taskId . "'>";
                        echo "<option value='not started' class='selecttext text-gray-700'>Not Started</option>";
                        echo "<option value='in progress' class='selecttext text-gray-700'>In Progress</option>";
                        echo "<option value='completed' class='selecttext text-gray-700'>Completed</option>";
                        echo "</select>";
                        echo "<div class='absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none'>";
                        echo "<i class='fas fa-circle text-yellow-500'></i>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='mt-4'>";
                        echo "<textarea id='comment_$taskId' class=' statuscontainer  rounded-md px-3 py-2 w-full resize-none bg-gray-200 ' placeholder='Add notes or comments...'>" . htmlspecialchars($existingComment) . "</textarea>";
                        // echo "<div class='flex justify-end mt-2'>";
                        // echo "<button class='textcolor text-blue-500 font-bold px-3 py-1 rounded-md mr-2' onclick='saveComment($taskId)'><i class='fas fa-save mr-1'></i>Save</button>";
                        // echo "<button class='textcolor text-red-500 font-bold px-3 py-1 rounded-md' onclick='deleteComment($taskId)'><i class='fas fa-trash-alt mr-1'></i>Delete</button>";
                        // echo "</div>";                        
                        echo "</div>";
                
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                }echo "<script>";
                echo "function saveComment(taskId) {
                    const comment = document.getElementById('comment_' + taskId).value;
                    if (comment.trim() !== '') {
                        localStorage.setItem('task_comment_' + taskId, comment);
                        alert('Comment saved successfully.');
                    } else {
                        alert('Please enter a comment before saving.');
                    }
                }
                
                function deleteComment(taskId) {
                    localStorage.removeItem('task_comment_' + taskId);
                    const commentTextArea = document.getElementById('comment_' + taskId);
                    if (commentTextArea) {
                        commentTextArea.value = '';
                    }
                    alert('Comment deleted successfully.');
                }";
                echo "</script>";
                
            } else {
                echo '
                <div class="flex flex-col items-center justify-center text-center">
                    <img src="undraw_Not_found_re_bh2e-removebg-preview.png" alt="No tasks found" class="h-24 w-32 text-indigo-500 ">
                    <p class="notask text-gray-700 mt-4 font-bold text-lg">Oops! Looks like there are no tasks at the moment.</p>
                </div>';
                
            }
        } else {
            echo "<p class='text-red-500'>Error executing the query: " . $connection->error . "</p>";
        }
        ?>
    </div>
</div>



<script>
$(document).ready(function() {
    $('.task-status').change(function() {
        var taskId = $(this).data('task-id');
        var status = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: 'updatestatus.php', 
            data: { task_id: taskId, status: status },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(error); 
            }
        });
    });
});
</script>







</div>



                                            </div>               
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


    </script>
</body>
</html>
