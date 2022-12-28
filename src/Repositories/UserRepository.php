<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';

use src\Models\User;

class UserRepository extends Repository {

	/**
	 * @param string $id
	 * @return array|false
	 */
	public function getUserById(string $id): User|false {
		$sqlStatement = $this->mysqlConnection->prepare("SELECT id, password_digest, email, name, profile_picture FROM users WHERE id = ?");
		$sqlStatement->bind_param('i', $id);
		$sqlStatement->execute();
		$resultSet = $sqlStatement->get_result();
		if ($resultSet->num_rows === 1) {
			return (new User($resultSet->fetch_assoc()));
		}
		return false;
	}

	/**
	 * @param string $email
	 * @return array|false
	 */
	public function getUserByEmail(string $email): User|false {
		// TODO
		$sqlStatement = $this->mysqlConnection->prepare("SELECT id, password_digest, email, name, profile_picture FROM users WHERE email = ?");
		$sqlStatement->bind_param('s', $email);
		$sqlStatement->execute();
		$resultSet = $sqlStatement->get_result();
		if ($resultSet->num_rows === 1) {
			return (new User($resultSet->fetch_assoc()));
		}
		return false;
	}

	/**
	 * @param string $email
	 * @param string $name
	 * @param string $bcryptPasswordDigest
	 * @return bool true on success, false on failure
	 */
	public function saveUser(string $email, string $name, string $bcryptPasswordDigest): bool {
		// TODO
		$sqlStatement = $this->mysqlConnection->prepare("INSERT INTO users (email, name, password_digest) 
															VALUES (?, ?, '$bcryptPasswordDigest')");
		$sqlStatement->bind_param('ss', $email, $name);
		$savedUser = $sqlStatement->execute();

		if ($savedUser) {
			$userId = $this->mysqlConnection->insert_id;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param int $id
	 * @param string $name
	 * @param string|null $profilePicture
	 * @return bool
	 */
	public function updateUser(int $id, string $name, string $profilePicture = null): bool {
		// TODO
		$updateAt = date('Y-m-d H:i:s');
		$sqlStatement = $this->mysqlConnection->prepare("UPDATE users SET name = ?, profile_picture = ? WHERE id = ?");
		$sqlStatement->bind_param('sssi', $updateAt, $name, $profilePicture, $id);
		return $sqlStatement->execute();
	}

}
