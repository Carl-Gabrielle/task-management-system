<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
                                <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css" integrity="sha384-...." crossorigin="anonymous">
                                <title>Signup - TaskWind</title>
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
            } */
                                    #password {
                                padding-right: 30px;
                                }
                                #eye , #eye-confirm-password{
                                cursor: pointer;
                                top: 65%;
                                transform: translateY(-50%);
                                right: 10px;
                                }
                                #popup-modal .bg-white {
                                    background-color: rgba(255, 255, 255);
                            backdrop-filter: blur(10px);
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            background: linear-gradient(to right, #fff 0%, #fff 50%, #eee 100%);
                            border:none;
                            }
                                #popup-modal, #btn_modal {
                            position: fixed;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            }
                    /* .dim-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0);
            z-index: 99;
            transition: background 0.3s;
            backdrop-filter: blur(3px); 
            pointer-events: none; 
            display: flex;
            align-items: center;
            justify-content: center;
            } */
            .dim-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(3px); 
        background: rgba(0, 0, 0, 0.3);
        z-index: 99;
        }
                    .highlight-modal {
                    position: relative;
                    z-index: 100;
                    }
                            </style>

                            <?php
                            @include 'config.php';

                            session_start();

                            $error = [];
                            $name = ""; 
                            $email = "";
                            $password = "";
                            $confirm_password = "";

                            if (isset($_POST['signup_btn'])) {
                                if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
                                    $error[] = 'All fields are required';
                                } else {
                                    $name = mysqli_real_escape_string($connection, $_POST['name']);
                                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                                    $password = mysqli_real_escape_string($connection, $_POST['password']);
                                    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

                                    $check_email_query = "SELECT * FROM user_list WHERE email = '$email'";
                                    $email_result = mysqli_query($connection, $check_email_query);

                                    if (mysqli_num_rows($email_result) > 0) {
                                        $error[] = 'Email already exists';
                                    } else {
                                        if (strlen($_POST['password']) < 8) {
                                            $error[] = "Password must be at least 8 characters";
                                        }
                                        if (!preg_match("/[a-z]/i", $_POST['password'])) {
                                            $error[] = "Password must contain at least one letter";
                                        }
                                        
                                        if (!preg_match("/[0-9]/", $_POST['password'])) {
                                            $error[] = "Password must contain at least one number";
                                        }
                                        if ($password != $confirm_password) {
                                            $error[] = 'Password not matched';
                                        } else {
                                            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                            $insert = "INSERT INTO user_list (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
                                            mysqli_query($connection, $insert);
                                            $_SESSION['success_message'] = 'Registration successful! You can now log in.';
                                            
                                        }
                                    }
                                }
                            }
                            ?>
                            <body>
                                <div id="popup-modal" tabindex="-1" class="fixed z-50 hidden p-4 overflow-x-hidden overflow-y-auto inset-0 max-h-full flex items-center justify-center">
                                <div class="bg-white text rounded-lg shadow dark:bg-gray-700 max-w-md w-full">
                                    <div class="p-6 text-center">
                                        <svg class="animate-bounce mx-auto mb-4 text-green-500 w-12 h-12 dark:text-green-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
                                            <path stroke="currentColor" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                        </svg>
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                    <svg class=" w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                        <h3 class="font-bold text-black " style="font-size: 1.5rem;">Awesome!</h3>
                                        <h3 class="mb-5 text-lg text-gray-700 dark:text-gray-300" style="font-family:'Roboto', sans-serif">You have successfully registered with TaskWind!</h3>
                                        <a href="login.php"><button name="login_btn" type="submit" data-modal-hide="popup-modal" class="  bg-gray-800 text-white w-full font-semibold hover:bg-gray-700 py-2 px-4 rounded-md transition duration-200">
                                            Proceed to Log In <i class="fa-solid fa-right-to-bracket pl-2" style="color: #ffffff;"></i>
                                        </button></a>
                                    </div>
                                </div>
                            </div>
                                <section class="section_bg bg-gray-100 min-h-screen flex items-center justify-center">
                                    <div class=" px-4  flex flex-col sm:flex-row rounded-2xl shadow-lg max-w-4xl max-h-screen p-8" style="background-color: rgb(248 250 252);">
                                        <div class="w-full  sm:w-1/2 mt-4 sm:mt-0">
                                            <img class="w-full rounded-2xl hidden sm:block  object-cover h-full" src="login_image.png" alt="Login Image">
                                        </div>
                                        <div class="w-full sm:w-1/2 p-4">
                                            <h1 class="text-3xl font-bold text-gray-800">Signup</h1>
                                            <p class="text-gray-600">Already have an account? <a href="login.php" class="text-gray-800 font-semibold">Login</a>
                                            <?php
                                                if (isset($error)) {
                                                    foreach ($error as $errorMsg) {
                                                ?>
                                                        <div class="flex  bg-red-100  text-red-700 px-4 py-3 rounded relative my-2 error-message" role="alert">
                                                            <strong class="font-bold mr-2">Error:</strong>
                                                            <span class="block font-normal"><?php echo $errorMsg; ?></span>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            <form id = "signup-form"method="POST"  action = "" class="mt-4">
                                                <div class="mb-4">
                                                    <label for="name" class="block text-sm font-medium text-gray-600">Name</label>
                                                    <input type="name" id="name" name="name" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"  value="<?php echo $name;?>" placeholder="Enter name" required >
                                                </div>
                                                <div class="mb-4">
                                                    <label for="email" class="block text-sm font-medium text-gray-600">Email Address</label>
                                                    <input type="email" id="email" name="email" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"  value="<?php echo $email;?>" placeholder="Enter email" required >
                                                </div>
                                                <div class="relative mb-4">
                                                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                                                <input type="password" id="password" name="password" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 pr-10"  value="<?php echo $password;?>" placeholder="Enter password" required >
                                                <i class="fas fa-eye-slash absolute transform -translate-y-1/2 right-3 text-gray-700" id="eye"></i>
                                                </div>
                                                <div class="relative mb-4">
                                                    <label for="confirm_password" class="block text-sm font-medium text-gray-600">Confirm password</label>
                                                    <input type="password" id="confirm_password" name="confirm_password" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 pr-10" value="<?php echo $confirm_password;?>" placeholder="Confirm password" required>
                                                    <i class="fas fa-eye-slash absolute transform -translate-y-1/2 right-3 top-1/2 cursor-pointer text-gray-700" id="eye-confirm-password"></i>
                                                </div>

                                                <button onkeydown="enter"  data-modal-target="popup-modal" data-modal-toggle="popup-modal"  name = "signup_btn" type="submit" class=" bg-gray-800 text-white w-full font-semibold hover:bg-gray-700 py-2 px-4 rounded-md transition duration-200 p-2">
                                                    Sign Up <i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i>  
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                
                                </section>
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

                                    <?php
                        if (isset($_POST['signup_btn']) && empty($error)) {
                        ?>
                        const modalClose =document.querySelector('[data-modal-hide="popup-modal"]');
                        const modal = document.getElementById('popup-modal');
                        const body = document.querySelector('body');
                        const dimBackground = document.createElement('div');
                        function showModal() {
                    modal.classList.remove('hidden');
                    dimBackground.classList.add('dim-background');
                    body.appendChild(dimBackground);
                    modal.classList.add('highlight-modal');
                }
                function hideModal() {
                    modal.classList.add('hidden');
                    body.removeChild(dimBackground);
                }
                modalClose.addEventListener('click', hideModal);
                document.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    showModal();
                }
            });
                showModal();
                        <?php
                        }
                        ?>
                                </script>
                            </body>
                            </html>
