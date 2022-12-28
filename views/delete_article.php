<?php
require_once '../src/Repositories/ArticleRepository.php';
require_once '../src/Repositories/UserRepository.php';

use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $articleRepository = new ArticleRepository();
        $articleRepository->deleteArticle($_GET['id']);
    }
    header('Location: index.php');
}

?>