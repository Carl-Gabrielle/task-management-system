<?php
        @include('config.php');
        session_start();
        $error = [];
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        if (isset($_POST['login_btn'])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $check_email_query = "SELECT * FROM user_list WHERE email = '$email'";
            $email_result = mysqli_query($connection, $check_email_query);

            if ($email_result) {
                $user = mysqli_fetch_assoc($email_result);
                if ($user) {
                    $hashedPassword = $user['password'];
                    if (password_verify($password, $hashedPassword)) {
                        $_SESSION['user_id'] = $user['id']; 
                        $_SESSION['user_name'] = $user['name'];
                        if ($user['is_admin'] == 1) {
                        header("Location: admin_main.php"); 
                        exit(); 
                        } else {
                            header("Location: task_samp.php"); 
                            exit(); 
                        }
                    } else {
                        $error[] = "Incorrect password";
                    }
                } else {
                    $error[] = "Email not registered";
                }
            } else {
                $error[] = "Database query error: " . mysqli_error($connection);
            }
        }
        ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Login</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" integrity="sha384-...." crossorigin="anonymous">
    </head>
    <style>
                body{
                    font-family: 'Poppins', sans-serif;
            background-color: #f1f1f1;
                }
            #eye, #eye-confirm-password {
                cursor: pointer;
                top: 65%;
                transform: translateY(-50%);
                right: 10px;
            }
            .container{
                background-color: white;
            }
        </style>
    <body >
    <div class="flex flex-col lg:flex-row h-screen">
        <div class="w-full hidden sm:block lg:w-1/2 flex items-center justify-center">
            <img src="login_image.png" alt="Your Image" class="w-full h-full object-cover" />
        </div>
        <div class="flex flex-col lg:flex-row w-full sm:w-1/2  shadow-lg max-w-4xl mx-auto sm:mx-0 max-h-screen p-10 md:h-full justify-center" style="background-color: white">
            <div class="w-full p-4 flex flex-col justify-center ">
            <div class="mb-8">
                <span class="brand-text font-extrabold text-gray-800 sm:text-2xl">Task</span>
                <span class="brand-text font-extrabold text-blue-600 sm:text-2xl">Wind</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Hi, Welcome back</h1>
                <p class="text-gray-600 mb-8">New to TaskWind? <a href="signup.php" class="text-gray-800 font-semibold">Create an Account</a></p>
                <?php
                if (isset($error)) {
                    foreach ($error as $errorMsg) {
                ?>
                        <div class="flex  text-red-700  relative my-2 error-message" role="alert">
                            <span class="block"><?php echo $errorMsg; ?></span>
                        </div>
                <?php
                    }
                }
                ?>
                <form method="POST" action="" class="mt-4">
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input value="<?php echo "$email"?>" required type="email" id="email" name="email" class="mt-1 p-3 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" placeholder="Enter email">
                    </div>
                    <div class="relative mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input value="<?php echo "$password"?>" required type="password" id="password" name="password" class="mt-1 p-3 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 pr-10" placeholder="Enter password">
                        <i class="fas fa-eye-slash absolute transform -translate-y-1/2 right-3 text-gray-700" id="eye"></i>
                    </div>
                    <div class="mb-6">
                        <a href="forgot_password.php" class="text-gray-800 font-semibold">Forgot Password?</a>
                    </div>
                    <button name="login_btn" type="submit" class="bg-gray-800 text-white w-full font-semibold hover:bg-gray-700 py-3 px-4 rounded-md transition duration-200">
                        Log In <i class="fa-solid fa-right-to-bracket pl-2" style="color: #ffffff;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>



        <script>
            const passwordInput = document.querySelector("#password");
            const eyeIcon = document.querySelector("#eye");
            eyeIcon.addEventListener("click", function() {
                if (passwordInput.type === "password") {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove("fa-eye-slash");
                    eyeIcon.classList.add("fa-eye");
                } else {
                    passwordInput.type = "password";
                    eyeIcon.classList.remove("fa-eye");
                    eyeIcon.classList.add("fa-eye-slash");
                }
            });

            const confirmPasswordInput = document.querySelector("#confirm_password");
            const eyeConfirmPasswordIcon = document.querySelector("#eye-confirm-password");

            eyeConfirmPasswordIcon.addEventListener("click", function() {
                if (confirmPasswordInput.type === "password") {
                    confirmPasswordInput.type = 'text';
                    eyeConfirmPasswordIcon.classList.remove("fa-eye-slash");
                    eyeConfirmPasswordIcon.classList.add("fa-eye");
                } else {
                    confirmPasswordInput.type = "password";
                    eyeConfirmPasswordIcon.classList.remove("fa-eye");
                    eyeConfirmPasswordIcon.classList.add("fa-eye-slash");
                }
            });
        </script>
    </body>
    </html>
