<?php

require_once '../src/Repositories/ArticleRepository.php';
require_once 'nav.php';
require_once 'header.php';

use src\Repositories\ArticleRepository;
$articleRepository = new ArticleRepository();

// Handle creating a new article here.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['article_title'];
	$url = $_POST['article_url'];
    $authorId = $_SESSION['user_id'];
	$savedArticle = $articleRepository->saveArticle($title, $url, $authorId);
	if ($savedArticle) {
		header("Location: index.php?id=$savedArticle->id");
	} else {
		header("Location: new_article.php"); 
    }
}
?>

<!doctype html>
<html lang="en">
<body>
<div class="flex min-h-full items-center justify-center px-4 mt-16 sm:px-6 lg:px-8">
	<div class="w-full max-w-xl space-y-8">
		<div>
			<h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 text-center">Submit a New Article</h2>
		</div>

		<form class="space-y-6" action="new_article.php" method="POST">
			<div class="rounded-md">
				<div>
					<span class="error text-red-500"><?= isset($_GET['title_error']) ? htmlspecialchars($_GET['title_error']) : '' ?></span>
					<label for="article_title" class="sr-only">Article Title</label>
					<input id="article_title" name="article_title" type="text"
						   class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
						   placeholder="Article Title">
				</div>
				<div class="mt-2">
					<span class="error text-red-500"><?= isset($_GET['url_error']) ? htmlspecialchars($_GET['url_error']) : '' ?></span>
					<label for="article_url" class="sr-only">Article URL</label>
					<input id="article_url" name="article_url" type="text"
						   class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
						   placeholder="Article URL">
				</div>
			</div>

			<div>
				<button type="submit"
						class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
					Submit
				</button>
			</div>
		</form>
	</div>
</div>
</body>
</html>

