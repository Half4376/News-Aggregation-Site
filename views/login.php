<?php

require_once '../src/Repositories/UserRepository.php';

require_once 'nav.php';

use src\Repositories\UserRepository;

$userRepository = new UserRepository();

// Display a login form and handle login attempts

// $_SERVER['REQUEST_METHOD'] === 'POST'
// get the post and put them in cariale
//hash the password using bcrypt -> thats for registration
//what you actually do is use passowrd_verify
//use get user by email or id to help verify passowrd

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $attemptedPassword = $_POST['password'];
    $errorFlag = false;

    $user = $userRepository->getUserByEmail($email);
    if (empty($email)) {
        $_SESSION['email_error'] = 'An email is required.';
        $errorFlag = true;
    } else if (!$user) {
        $_SESSION['email_error'] = 'Invalid Email.';
        $errorFlag = true;
    }
    
    $checkPassword = password_verify($attemptedPassword, $user->password_digest);
    if (empty($attemptedPassword)) {
        $_SESSION['password_error'] = 'A password is required.';
        $errorFlag = true;
    } else if (!$checkPassword) {
        $_SESSION['password_error'] = 'Invalid Password.';
        $errorFlag = true;
    }

    $_SESSION['email'] = $email;
    if ($errorFlag) {
        header('Location: login.php');
        exit;
    } else {
        $_SESSION['access_granted'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_pic'] = $user->profile_picture;
        header('Location: index.php');
        exit;
    }
}

?>

<!-- build form with post -->

<?php require_once 'header.php'; ?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600"
             alt="Workflow">
        <h2 class="mt-6 text-center text-3xl tracking-tight font-bold text-gray-900">NewCo. Login</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="login.php" method="POST">
                <div>
                    <span class="text-red-500">
                    <?php
                    if (isset($_SESSION['email_error'])) {
                        echo $_SESSION['email_error'];
                        unset($_SESSION['email_error']);
                    }
                    ?>
                    </span>
                    <label for="email" class="block text-sm font-medium text-gray-700"> Email address </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <span class="text-red-500">
                    <?php
                    if (isset($_SESSION['password_error'])) {
	                    echo $_SESSION['password_error'];
	                    unset($_SESSION['password_error']);
                    }
                    ?>
                    </span>
                    <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Don't have an account?
                        <a href="register.php" class="font-medium text-indigo-600 hover:text-indigo-500"> Register </a>
                    </p>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>            
        </div>
    </div>
</div>

</body>
</html>
