<?php
require_once '../src/Repositories/ArticleRepository.php';
require_once 'nav.php';
require_once 'header.php';

use src\Repositories\ArticleRepository;

$articleRepository = new ArticleRepository();
$articles = $articleRepository->getAllArticles();

?>

<body>

<div class="mx-auto max-w-5xl  sm:px-6 lg:px-8">

    <h1 class="text-xl text-center font-semibold text-indigo-700 mt-10 mb-10">Articles</h1>

	<?= count($articles) === 0 ? "No articles yet :(" : ""; ?>

    <div class="overflow-hidden bg-white shadow sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">

			<?php foreach ($articles as $article): ?>
                <!--        Display all the articles        -->
                <li>
                    <div class="inline-block">
                        <a href="<?= $article->id; ?>" target="_blank" class="block hover:bg-gray-50 p-0.5 rounded inline-block">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class=" flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div class="truncate">
                                        <div class="flex text-sm">
                                            <p class="truncate font-medium text-indigo-600"><?= $article->title ?></p>
                                        </div>
                                        <div class="mt-2 flex">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor"
                                                     aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                                <p>
                                                    Created at
                                                    <time datetime="2020-01-07"><?= $article->created_at ?></time>
                                                </p>
                                                <?php if (($article->updated_at) != '') : ?>
                                                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor"
                                                            aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                                                clip-rule="evenodd"/>
                                                        </svg>
                                                        <p>                                                            
                                                            Updated at
                                                            <time date="2020-01-07"><?= $article->updated_at ?></time>
                                                        </p>
                                                <?php endif; ?>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $article->author_id):?>
                        <div class="inline-block float-right mt-8 mr-4">
                                
                                <a href="update_article.php?id=<?= $article->id ?>" class="inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="black" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                </a>

                                <a href="delete_article.php?id=<?= $article->id ?>" class="inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="red" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </a>

                        </div>
                    <?php endif; ?>
                </li>
			<?php endforeach; ?>

        </ul>
    </div>

</div>

</body>
