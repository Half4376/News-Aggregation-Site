<?php

// An update article form should be shown here, similar to the lab.
require_once '../src/Repositories/ArticleRepository.php';
require_once 'header.php';
require_once 'nav.php';

use src\Repositories\ArticleRepository;
$articleRepository = new ArticleRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['article_title'];
    $url = $_POST['article_url'];
    $id = $_POST['article_id'];

	if (empty($title)) {
        header("Location: update_article.php?id=$id&title_error=Invalid title provided.");
		exit();
    }

	if (!filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: update_article.php?id=$id&url_error=Invalid url provided.");
		exit();
    }

	$articleRepository->updateArticle($id, $title, $url);

	header("Location: index.php");
	exit();
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET['id'])) {
		$article = $articleRepository->getArticle($_GET['id']);

		if (!$article) {
			header('Location: index.php');
			exit();
		}
	} else {
		header('Location: index.php');
		exit();
	}
} else {
	header('Location: index.php');
	exit();
}
?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<body class="h-full">

<?php if (isset($article)): ?>

	<div>
		<div class="mt-10">
			<div class="mx-auto max-w-2xl bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
				<form class="space-y-6" action="update_article.php" method="POST">
					<input type="hidden" name="article_id" value="<?= $article->id ?>">
					<div>
						<span class="error text-red-500"><?= isset($_GET['title_error']) ? htmlspecialchars($_GET['title_error']) : ''?></span>
						<label for="title" class="block text-sm font-medium text-gray-700"> Article Title </label>
						<div class="mt-1">
							<input placeholder="Title for article."
								   value="<?php echo !isset($_GET['title_error']) ? $article->title : ''; ?>"
								   id="article_title"
								   name="article_title"
								   type="text"
								   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						</div>
					</div>

					<div>
						<span class="error text-red-500"><?= isset($_GET['url_error']) ? htmlspecialchars($_GET['url_error']) : ''?></span>
						<label for="body" class="block text-sm font-medium text-gray-700"> URL </label>
						<div class="mt-1">
							<input placeholder="URL for article."
								   value="<?php echo !isset($_GET['url_error']) ? $article->url : ''; ?>"
								   id="article_url"
								   name="article_url"
								   type="url"
								   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						</div>
					</div>

					<div>
						<button type="submit"
						class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
					</div>
				</form>
		</div>
	</div>

<?php endif; ?>

</body>
</html>
