                    <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
                            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" integrity="sha384-...." crossorigin="anonymous">
                        
                        </head>
                        <style>
                            body{
                font-family: 'Montserrat', sans-serif;
            font-family: 'Roboto', sans-serif;
            background-color: #f1f1f1;
            }
                        
                        /* .section_bg {
                background-image: url("bg-image.png");
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                background-color: rgba(255, 255, 255, 0.7);
                } */

                            #password {
                        padding-right: 30px;
                        }
                        @media (max-width: 300px) {
    img {
        max-height: 300px;
    }
    }
                        #eye {
                        cursor: pointer;
                        top: 65%;
                        transform: translateY(-50%);
                        right: 10px;
                        }

                    </style>
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
                        return  header("Location: admin_dashboard.php"); 
                     } else {
                         return  header("Location: user.php"); 
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

                        <body>
                            <section class="bg-gray-100 section_bg min-h-screen flex items-center justify-center  lg:h-full ">
                                <div class=" flex flex-col sm:flex-row rounded-2xl shadow-lg  max-w-4xl max-h-screen p-10 md:h-full" style="background-color: rgb(248 250 252);">
                                    <div class="w-full sm:w-1/2 p-4">
                                        <h1 class="text-3xl font-bold text-gray-800">Login</h1>
                                        <p class="text-gray-600">New to TaskWind? <a href="signup.php" class="text-gray-800 font-semibold">Create an Account</a></p>
                                            <?php
                                        if (isset($error)) {
                                            foreach ($error as $errorMsg) {
                                        ?>
                                                <div class="flex  bg-red-100  text-red-700 px-4 py-3 rounded relative my-2 error-message" role="alert">
                                                    <strong class="font-bold mr-2">Error:</strong>
                                                    <span class="block "><?php echo $errorMsg; ?></span>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <form method="POST" action= "" class="mt-4">
                                            <div class="mb-4">
                                                <label for="email" class="block text-sm  font-medium text-gray-600">Email</label>
                                                <input value="<?php echo "$email"?>" required type="email" id="email" name="email"  class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" placeholder="Enter email">
                                            </div>
                                            <div class="relative mb-4">
                                            <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                                        <input  value="<?php echo "$password"?>" required type="password" id="password" name="password" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 pr-10" placeholder="Enter password">
                                        <i class="fas fa-eye-slash absolute transform -translate-y-1/2 right-3 text-gray-700" id="eye"></i>
                                        </div>
                                            <div class="mb-4">
                                            <a href="forgot_password.php" class="text-gray-800 font-semibold"><h1>Forgot Password?</h1></a>
                                            </div>
                                            <button  name = "login_btn" type="submit" class="bg-gray-800  text-white w-full font-semibold hover:bg-gray-700 py-2 px-4 rounded-md transition duration-200 p-2">
                                                Log In  <i class="fa-solid fa-right-to-bracket pl-2" style="color: #ffffff;"></i> 
                                            </button>
                                        </form>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4 sm:mt-0 md:shrink-0 flex items-center justify-center ">
                                        <img class="w-11/12  rounded-3xl hidden sm:block  object-cover h-full" src="login_image.png" alt="Login Image">
                                    </div>
                                </div>
                            </section>
                        </body>
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
                        </script>
                        </html>
