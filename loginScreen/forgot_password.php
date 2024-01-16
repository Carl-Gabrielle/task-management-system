                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-...." crossorigin="anonymous">
                        <!-- <link rel="icon" href="/login_image.png"> -->
                        <title>TaskWind - Forgot Password</title>
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
                    $email = isset ($_POST["email"]) ? $_POST["email"] : ""; 
                    if (isset($_POST['reset_btn'])){
                        $email = $_POST["email"];
                        $email = mysqli_real_escape_string($connection, $email);
                        $check_email_query = "SELECT * FROM user_list WHERE email = '$email'";
                        $email_result = mysqli_query($connection, $check_email_query);
                        $token = md5(rand());
                        if ($email_result){
                            $user = mysqli_fetch_assoc($email_result);
                            if (!$user){
                                $error[] = "Email address does not exist!";
                            }
                        }
                    }
                    ?>
                    <?php
                    require __DIR__ . '/../vendor/autoload.php';
                    require __DIR__ . "/mailer.php";

                    $token = bin2hex(random_bytes(16));
                    $token_hash = hash("sha256", $token);
                    $expiry = date('Y-m-d H:i:s', time() + 60 * 20);
                    require __DIR__ . "/config.php";

                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }

                    $sql = "UPDATE user_list SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
                    $stmt = $connection->prepare($sql);

                    if (!$stmt) {
                        die("Prepare failed: " . $connection->error);
                    }

                    $stmt->bind_param("sss", $token_hash, $expiry, $email);

                    if (!$stmt->execute()) {
                        die("Execute failed: " . $stmt->error);
                    }

                    if ($connection->affected_rows) {
                        $mail->Subject = "Password Reset";
                        $resetLink = "<a href='http://localhost/task-management-system/loginScreen/reset-password.php?token=$token'>Reset Password</a>";
                    $mail->setFrom(  "carlgab59@gmail.com", "TaskWind");
                    $mail->addAddress($email);
                    $mail->Subject = "Password Reset";
                    $mail->Body = <<<END
                    Hello $email,
                    <br>
                    Click $resetLink to reset your password.
                    END;
                        try {
                            $mail->send();
                            // echo "Message sent. Please check your inbox.";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
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
                                                        <h3 class="font-bold text-black " style="font-size: 1.5rem;">Password Reset</h3>
                                                        <h3 class=" mb-2 text-lg text-gray-700 dark:text-gray-300" style="font-family:'Roboto', sans-serif"> Please check your email and follow the link to create a new password.</h3>
                                                        <button id = "closeModalBtn" name="login_btn" type="submit" data-modal-hide="popup-modal" class="  bg-gray-800 text-white w-1/2 font-semibold hover:bg-gray-700 py-2 px-4 rounded-md transition duration-200">
                                                        Ok 
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                        <section class="section_bg bg-gray-100 min-h-screen flex items-center justify-center">
                            <div class=" flex flex-col sm:flex-row rounded-2xl shadow-lg max-w-4xl max-h-screen p-8"  style="background-color: rgb(248 250 252);">
                                <div class="w-full sm:w-1/2 mt-4 sm:mt-0">
                                    <img class="w-full h-full rounded-2xl hidden sm:block " src="login_image.png" alt="Login Image">
                                </div>
                                <div class="w-full sm:w-1/2 p-4">
                                    <h1 class="text-3xl font-bold text-gray-800">Forgot your password?</h1>
                                    <p class="text-gray-600 pt-3">Please enter the email address associated with your account and we will email you a link to reset your password. </p>
                                    <?php
                                                if (isset($error)) {
                                                    foreach ($error as $errorMsg) {
                                                ?>
                                                        <div class="flex items-center justify-center bg-red-100  text-red-700 px-4 py-3 rounded relative my-2 error-message" role="alert">
                                                            <strong class="font-bold mr-2">Error:</strong>
                                                            <span class="block "><?php echo $errorMsg; ?></span>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                    <form method="post"  action=""class="mt-4">
                                        <div class="mb-4">
                                            <label for="email" class="block text-sm font-medium text-gray-600">Email Address</label>
                                            <input required  type="email" id="email" name="email" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value ="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>"  placeholder="Enter Email">
                                        </div>
                                        <button name="reset_btn" type="submit" class="bg-gray-800 text-white w-full font-semibold hover:bg-gray-700 py-2 px-4 rounded-md transition duration-200 p-2 mb-5">
                                            Reset Password
                                        </button>
                                                <button  type="submit" class=" text-gray-800 w-full font-semibold hover:bg-gray-50 py-2 px-4 rounded-md transition duration-200 p-2">
                                                    <a href="login.php" class="text-current">Back to Login</a>
                                            </button>
                                        </form>
                                </div>
                            </div>
                        </section>
                        <script>
                            <?php
                                        if (isset($_POST['reset_btn']) && empty($error)) {
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
                                    hideModal();
                                }
                            });
                                showModal();
                                const closeModalButton = document.getElementById('closeModalBtn');
                                closeModalButton.addEventListener('click', hideModal);
                                        <?php
                                        }
                                        ?>
                        </script>
                    </body>
                    </html>