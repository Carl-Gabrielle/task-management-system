<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    $userRole = $user['role'];
}


if (isset($_POST['new-task'])) {
    $mysqli = require __DIR__ . "/database.php";
    
    $task_name = mysqli_real_escape_string($mysqli, $_POST['task_name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $due_date = date('Y-m-d', strtotime($_POST['due_date']));
    $date_created = date('Y-m-d');
    $assigned_to = intval($_POST['assigned_user']);
    $team_members = $_POST['team_members'];
    $priority = mysqli_real_escape_string($mysqli, $_POST['priority']);
    $status = mysqli_real_escape_string($mysqli, $_POST['status']);

    $query = "INSERT INTO task (task_name, description, due_date, date_created, assigned_to, priority, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssiss", $task_name, $description, $due_date, $date_created, $assigned_to, $priority, $status);

    if ($stmt->execute()) {
        $task_id = $mysqli->insert_id;
    
        $team_query = "INSERT INTO task_team_members (task_id, user_id) VALUES (?, ?)";
        $team_stmt = $mysqli->prepare($team_query);
    
        foreach ($team_members as $member) {
            $member_id = intval($member);
            $team_stmt->bind_param("ii", $task_id, $member_id);
            $team_stmt->execute();
        }
    
        $_SESSION['message'] = "Record created successfully";
        header("Location: new-task.php");
        exit();
    } else {
        $_SESSION['message'] = "Record not created";
        header("Location: new-task.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <!--Nav-->
    <nav class="navbar navbar-expand fixed-top scrolled">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-2" href="">Home</a>
                    </li>
                </ul>
            </div>
            <a class="navbar-brand ms-auto" href="#"><img src="contents/Logo.png" style="width: 80px;"></a>
        </div>
    </nav>
	<div id="app">
		<div class="main-container mt-5" id="wrapper">
		  <div class="d-flex vh-100">
	  
	<!-- Sidebar -->
    <aside id="sidebar" class="side-panel d-flex flex-column h-100 scrolled">
        <a id="navTrigger" class="d-lg-none nav-trigger pt-4 mt-5" role="button" title="sweet hamburger">
        <span class="hamburger">
          <span class="hamburger-icon"></span>
        </span>
        </a>
          <?php if (isset($user)): ?>
              <h6 class="sidebar-heading mt-5 pt-4 ml-3 user_name"><?= htmlspecialchars($user["name"]) ?></h6>
          <?php endif; ?>
        <ul class="navbar-nav bd-navbar-nav py-4">
        <li class="nav-item"><a class="navbar-link" href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <!-- Dropdown-->
          <li class="panel panel-default" id="dropdown">
            <a data-toggle="collapse" href="#dropdown-lvl1">
              <i class="fa fa-diamond"></i> Workplace
              <span class="caret"></span>
            </a>
            <!-- Dropdown level 1 -->
            <div id="dropdown-lvl1" class="panel-collapse collapse">
              <div class="panel-body">
                <ul class="nav navbar-nav">
                  <?php if ($userRole == 1): ?>
                    <li><a href="new-task.php"><i class="fa fa-tasks"></i>New Task</a></li>
                  <?php endif; ?>
                  <li><a href="my-task.php"><i class="fa fa-list"></i>Task List</a></li>
                </ul>
              </div>
            </div>
          </li>
        <?php if ($userRole == 1): ?>
          <li class="nav-item"><a class="navbar-link" href="members.php">
            <i class="fa fa-users"></i>Members</a></li>
          </li>
        <?php endif; ?>
        </ul>
        <div id="footer" class="mt-auto">
        <div class="text-center">
          <div class="footer_copyright">
            <p>© 2023, ARXX, Inc. All right reserved.</p>
          </div>  
        </div>
        </div>
    </aside>

    <!-- Content -->
    <div class="container-fluid mt-5" id="content" >
        
        <?php
            if(isset($_SESSION['message'])) :
            ?>
            <div class="alert alert-warning alert-dismissible fade-show" role="alert">
                <strong> <?=$_SESSION['message'];?> </strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION['message']);
                endif;
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Task</h4>
                            <a href="new-task.php" class="btn btn-danger float-end">BACK</a>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3 col-4">
                                <label for="task_name">Task Name:</label><br>
                                <input type="text" id="task_name" name="task_name" class="form-control"><br>
                            </div>
                            <div class="mb-3 col-4">
                                <label for="description">Description:</label><br>
                                <textarea id="description" name="description" class="form-control" rows="4" cols="50"></textarea> <br>
                            </div>
                            <div class="mb-3 col-6 float-end">
                                <label for="due_date">Due Date:</label><br>
                                <input type="date" id="due_date" name="due_date" class="form-control"><br>
                            </div>
                            <div class="mb-3">
                                <!-- <label for="date_created">Date Created:</label><br> -->
                                <input type="hidden" id="date_created" name="date_created" class="form-control">
                            </div>
                            <div class="mb-3 col-6">
                                <label for="priority">Priority:</label><br>
                                <select id="priority" name="priority" class="form-control">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>

                            <div class="mb-3 col-6">
                                <label for="status">Status:</label><br>
                                <select id="status" name="status" class="form-control">
                                    <option value="pending" selected>Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="in progress">In Progress</option>
                                </select>
                            </div>
                                                <div class="mb-3 col-6">
                                <label for="assigned_user">Team Leader:</label><br>
                                <select id="assigned_user" name="assigned_user" class="form-control">
                                    <?php
                                    // Fetch users from the database
                                    $userQuery = "SELECT id, name FROM user WHERE role = 2";
                                    $userResult = $mysqli->query($userQuery);

                                    // Populate the dropdown with user options
                                    while ($row = $userResult->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="team_members">Team Members:</label><br>
                                <select id="team_members" name="team_members[]" class="form-control js-example-basic-multiple" multiple="multiple">
                                    <?php
                                    // Fetch users from the database where role = 3 (assuming role 3 represents team members)
                                    $userQuery = "SELECT id, name FROM user WHERE role = 3";
                                    $userResult = $mysqli->query($userQuery);

                                    // Populate the dropdown with user options
                                    while ($row = $userResult->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="new-task" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var sidebar = $("#sidebar");
        var hamburger = $('#navTrigger');

    hamburger.click(function(e) {
        e.preventDefault();
        $(this).toggleClass('is-active');
        $('#wrapper').toggleClass("sidebar-opened");
        sidebar.toggleClass('ml-0');
    });

    
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
    s});
  </script>
</body>
</html>  