<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/Article.php';

use src\Models\Article;
use src\Models\User;

class ArticleRepository extends Repository {

	/**
	 * @return Article[]
	 */
	public function getAllArticles(): array {
		// TODO
		$sqlStatement = $this->mysqlConnection->prepare("SELECT * FROM articles;");
		$sqlStatement -> execute();
		$resultSet = $sqlStatement -> get_result();

		$allArticles = [];
		while ($row = $resultSet -> fetch_assoc()) {
			$allArticles[] = new Article($row);
		}
		return $allArticles;
	}

	/**
	 * @param int $id
	 * @return Article|false Post object if it was found, false otherwise
	 */
	public function getArticle(int $id): Article|false {
		// TODO
		$sqlStatement = $this->mysqlConnection->prepare("SELECT id, title, url, created_at, updated_at, author_id FROM articles WHERE id = ?");
		$sqlStatement -> bind_param('i', $id);
		$sqlStatement -> execute();
		$result = $sqlStatement -> get_result();
		
		if ($result -> num_rows === 1) {
			return (new Article($result -> fetch_assoc()));
		}
		return false;
	}

	/**
	 * @param string $title
	 * @param string $url
	 * @param int $authorId
	 * @return Article|false the newly created Article object, or false in the case of a failure to save or retrieve the new record
	 */
	public function saveArticle(string $title, string $url, int $authorId): Article|false {
		// TODO
		$createdAt = date('Y-m-d H:i:s');
		$sqlStatement = $this->mysqlConnection->prepare("INSERT INTO articles (id, title, url, created_at, updated_at, author_id) VALUES(NULL, ?, ?, ?, NULL, ?);");
		$sqlStatement->bind_param('sssi', $title, $url, $createdAt, $authorId);
		$savedArticle = $sqlStatement->execute();

		if ($savedArticle) {
			$articleId = $this->mysqlConnection->insert_id;
			return $this->getArticle($articleId);
		} else {
			return false;
		}
	}

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $url
	 * @return bool
	 */
	public function updateArticle(int $id, string $title, string $url): bool {
		// TODO
		$updatedAt = date('Y-m-d H:i:s');
		$sqlStatement = $this->mysqlConnection->prepare("UPDATE articles SET title = ?, url = ?, updated_at = ? WHERE id = ?");
		$sqlStatement->bind_param('sssi', $title, $url, $updatedAt, $id);
		return $sqlStatement->execute();
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function deleteArticle(int $id): bool {
		// TODO
		$sqlStatement = $this->mysqlConnection->prepare("DELETE FROM articles WHERE id = ?;");
		$sqlStatement->bind_param('i', $id);
		return $sqlStatement->execute();
	}

	/**
	 * Given the ID of an article, return the associated User
	 *
	 * @param int $articleId
	 * @return User|false
	 */
	public function getArticleAuthor(int $articleId): User|false {
		$sqlStatement = $this->mysqlConnection->prepare(
			"SELECT users.id, users.name, users.email, users.password_digest, users.profile_picture FROM users INNER JOIN articles a ON users.id = a.author_id WHERE a.id = ?;"
		);
		$sqlStatement->bind_param('i', $articleId);
		$success = $sqlStatement->execute();
		if ($success) {
			$resultSet = $sqlStatement->get_result();
			if ($resultSet->num_rows === 1) {
				return new User($resultSet->fetch_assoc());
			}
		}
		return false;
	}

}
