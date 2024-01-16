    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Task</title>
        <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <style>
                body{
                font-family: 'Montserrat', sans-serif;
            font-family: 'Roboto', sans-serif;
            background-color: #f1f1f1;
            }
    </style>
    <?php
    session_start();
    require_once('config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        $due_date = mysqli_real_escape_string($connection, $_POST['due_date']);
        $priority = mysqli_real_escape_string($connection, $_POST['priority']);
        $assigned_to = mysqli_real_escape_string($connection, $_POST['assigned_to']);
        
            $check_sql = "SELECT id FROM task_list WHERE title = '$title' AND description = '$description' AND due_date = '$due_date' AND priority = '$priority' AND assigned_to = '$assigned_to'";
            $check_result = mysqli_query($connection, $check_sql);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                echo "Task already exists for this user.";
            } else {
                $insert_sql = "INSERT INTO task_list (title, description, due_date, priority, assigned_to) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $insert_sql);
                mysqli_stmt_bind_param($stmt, "sssss", $title, $description, $due_date, $priority, $assigned_to);
                $success = mysqli_stmt_execute($stmt);
            }
        
    }

    ?>
    <body class="p-4">
    <form method="POST" id="taskForm" action="#" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-5">
    <div class="mb-4">
        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
        <input type="text" name="title" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea name="description" class="resize-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>
    <div class="mb-4">
        <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
        <input type="date" name="due_date" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Priority</label>
        <select id="priority" name="priority" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="Low">Low</option>
            <option value="Mid">Mid</option>
            <option value="High">High</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Assigned To</label>
        <select name="assigned_to" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <?php
            include('config.php'); 
            $sql = "SELECT id, name FROM user_list";
            $result = mysqli_query($connection, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="flex items-center justify-center">
        <input type="submit" value="Create Task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:shadow-outline">
    </div>
</form>

        <script>
            flatpickr('#dueDateCell', {
                dateFormat: "F j, Y",
                altInput: true,
                altFormat: "F j, Y",
                wrap: true
            });
        document.getElementById('taskForm').addEventListener('submit', function (event) {
            event.preventDefault(); 
            
            const title = document.getElementsByName('title')[0].value;
            const description = document.getElementsByName('description')[0].value;
            const dueDate = document.getElementsByName('due_date')[0].value;
            const priority = document.getElementsByName('priority')[0].value;
            const assignedTo = document.getElementsByName('assigned_to')[0].value;

            if (title === '' || description === '' || dueDate === '' || priority === '' || assignedTo === '') {
                Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please fill in all the fields!',
        customClass: {
            popup: 'rounded-md shadow-md',
            header: 'bg-red-500 text-white rounded-t-md px-4 py-2',
            title: 'text-lg font-bold',
            content: 'text-gray-700 py-4 px-4',
            confirmButton: 'text-white font-semibold focus:outline-none',
        },
        width: '22rem',
        showCancelButton: false,
        showConfirmButton: true,
        allowOutsideClick: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc2626',
    });
            } else {
            this.submit();
        }
        });
    </script>
    </body>
    </html>
