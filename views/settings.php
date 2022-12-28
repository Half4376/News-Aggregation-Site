<?php
// Handle the user changing their username and profile picture uploads here

//one user table, teach provided profile pic column in database whcih will match the in image 
require_once '../src/Repositories/UserRepository.php';
use src\Repositories\UserRepository;

$userRepository = new UserRepository();

require_once 'nav.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profilePic = $_FILES['profile_picture'];
    $newName = $_POST['name'];

    $user = $userRepository->getUserByEmail($_POST['email']);

    updateUser($user->id, $newName, $profilePic);
}

?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<body class="h-full">

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md divide-y divide-slate-200">
    <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 text-center">Setting</h2>
    <div class="divide-y divide-slate-200">

    <form action="settings.php" method="POST" enctype="multipart/form-data" id="update_form">
        <label for="email" class="block text-sm font-medium text-gray-700"> Email address (cannot be changed)
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </label>

        <label for="name" class="block text-sm font-medium text-gray-700"> Name
            <div class="mt-1">
                <input id="name" name="name" type="name" autocomplete="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>"
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </label>

        <label for="name" class="block text-sm font-medium text-gray-700"> Profile Picture
            <input type="file" name="profile_picture">
                <div class="mt-10">
            </div>
        </label>

        <div>
			<button type="submit"
					class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
		</div>

    </form>
</div>

</body>
</html>