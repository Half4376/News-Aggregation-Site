<?php

require_once '../src/Repositories/UserRepository.php';
require_once '../src/Models/User.php';

use src\Repositories\UserRepository;

$userRepository = new UserRepository();

// Reusable navigation bar. You will need to use the UserRepository to show the name
// and start a session in order to determine the user authentication status e.g. checking $_SESSION['user_id']
function active($page): bool {
    $pageFromUri = explode('/', $_SERVER['REQUEST_URI']);
	return $page === end($pageFromUri);
}

session_start();

?>

<header>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">

                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            
                            <p class="text-white px-3 py-2 rounded-md text-sm font-medium">
	                            NewCo.
                            </p>
                            
                            <a class="
                                <?php
                                    echo active('index.php') ?
                                    'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium' :
                                    'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
							    ?>"
                               href="index.php">All Article</a>
                            <?php if (!isset($_SESSION['access_granted']) || $_SESSION['access_granted'] == false) { ?>
                            
                                <a class="
                                    <?php
                                    echo active('login.php') ?
                                    'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium' :
                                    'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
                                    ?>"
                                    href="login.php">Login
                                </a>
                                
                                <a class="
                                    <?php
                                    echo active('register.php') ?
                                    'right-20 bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium' :
                                    'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
                                    ?>"
                                    href="register.php">Register
                                </a>
                            
                            <?php } else { ?>

                                <a class="
                                    <?php
                                    echo active('new_article.php') ?
                                    'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium' :
                                    'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
                                    ?>"
                                    href="new_article.php">New Article
                                </a>

                                <a class="
                                    <?php
                                    echo active('settings.php') ?
                                    'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium' :
                                    'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
                                    ?>"
                                    href="settings.php" alt="Avatar">
                                    <img src="images/defaultjpg" />
                                </a>

                                <p class="text-white px-3 py-2 text-sm font-medium">Welcome, <?=$_SESSION['user_name']?></p>

                                <a class="
                                    <?php
                                    echo active('logout.php') ?
                                    'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium' :
                                    'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
                                    ?>"
                                    href="logout.php">Logout
                                </a>

                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>
</header>