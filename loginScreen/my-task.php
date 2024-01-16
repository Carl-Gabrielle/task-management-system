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

// Fetching tasks based on user role
if ($userRole == 1) {
    // Admin has full access to all tasks
    $query = "SELECT * FROM task";
} elseif ($userRole == 2) {
    // Project Leader can't edit tasks assigned to them
    $query = "SELECT * FROM task WHERE assigned_to = {$_SESSION["user_id"]}";
} else {
    // Regular User can only edit status
    $query = "
            SELECT task.task_id, task.task_name, task.description, task.due_date, task.date_created, task.priority, task.status
            FROM task
            INNER JOIN task_team_members ON task.task_id = task_team_members.task_id
            WHERE task_team_members.user_id = {$_SESSION["user_id"]}";
}

$result = $mysqli->query($query);


?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <!--Nav-->
    <nav class="navbar navbar-expand fixed-top scrolled">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-2" href="arxx.html">Home</a>
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
    <div class="container-fluid mt-5 p-4" id="content" >
        
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
            <?php
            if ($result->num_rows > 0) {
                while ($task = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-4 col-12 mb-4">
                        <div class="card border-0">
                            <div class="header pt-3 text-center">
                                <h5 class="card-title"><?= $task['task_name']; ?></h5>
                            </div>
                            <hr>
                            <div class="card-body">
                                <p class="card-text"><strong>Description:</strong> <?= $task['description']; ?></p>
                                <p class="card-text"><strong>Due Date:</strong> <?= $task['due_date']; ?></p>
                                <p class="card-text"><strong>Date Created:</strong> <?= $task['date_created']; ?></p>
                                <p class="card-text"><strong>Priority:</strong> <?= $task['priority']; ?></p>
                                <p class="card-text"><strong>Status:</strong> <?= $task['status']; ?></p>
                                <div class="text-center">
                                    <?php if ($userRole == 1 || $userRole == 2) { ?>
                                        <!-- Admin and Project Leader can view/update/delete tasks -->
                                        <a href="read.php?task_id=<?= $task['task_id']; ?>" class="btn btn-info btn-sm">View</a>
                                        <a href="update.php?task_id=<?= $task['task_id']; ?>" class="btn btn-success btn-sm">Update</a>
                                        <form action="delete.php" method="POST" class="d-inline">
                                            <input type="hidden" name="task_id" value="<?= $task['task_id']; ?>">
                                            <button type="submit" name="delete_task" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    <?php } elseif ($userRole == 3) { ?>
                                        <!-- Regular User can edit status -->
                                        <form action="edit-status.php" method="POST" class="d-inline">
                                            <input type="hidden" name="task_id" value="<?= $task['task_id']; ?>">
                                            <select name="status">
                                                <option value="pending">Pending</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">Edit Status</button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='col'><h5>No record found</h5></div>";
            }
            ?>
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
  </script>
</body>
</html>