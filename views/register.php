<?php

// display a registration form and create new accounts here, with the help of the UserRepository class
require_once '../src/Repositories/UserRepository.php';
use src\Repositories\UserRepository;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = false;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

	if (empty($email)) {
		$_SESSION['email_error'] = 'An email is required.';
		$errors = true;
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_error'] = 'Invalid Email.';
        $errors = true;
    }
    
    $specialChars = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';
	if (empty($password)) {
		$_SESSION['password_error'] = 'A password is required.';
		$errors = true;
	} else if ((strlen($password) >= 8) && (preg_match($specialChars, $password))) {
        $bcryptPasswordDigest = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    } else {
        $_SESSION['password_error'] = 'Must be 8 characters long and have at least 1 special character.';
        $errors = true;
    }

	if (empty($name)) {
		$_SESSION['name_error'] = 'A name required.';
		$errors = true;
	}

	if ($errors) {
        $errors = false;
		$_SESSION['email'] = $email;
		$_SESSION['name'] = $name;
		header('Location: register.php');
	} else {
        $newUser = (new UserRepository())->saveUser($email, $name, $bcryptPasswordDigest);
		header('Location: index.php');
	}
	exit;
}

?>

<?php require_once 'header.php'; ?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">

<?php require_once 'nav.php' ?>

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600"
             alt="Workflow">
        <h2 class="mt-6 text-center text-3xl tracking-tight font-bold text-gray-900">NewCo. Registration</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="register.php" method="POST">
                <div>
                    <span class="text-red-500">
                    <?php
                    if (isset($_SESSION['name_error'])) {
                        echo $_SESSION['name_error'];
                        unset($_SESSION['name_error']);
                    }
                    ?>
                    </span>
                    <label for="name" class="block text-sm font-medium text-gray-700"> Name </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="name" autocomplete="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

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
                        Already have an account?
                        <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500"> Login </a>
                    </p>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Register
                    </button>
                </div>
            </form>            
        </div>
    </div>
</div>

</body>
</html>
