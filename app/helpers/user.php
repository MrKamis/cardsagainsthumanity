<?php
    class User {
        /**
         * Checks is user login
         * @return bool
         */
        public static function isLogged() {
            session_start();
            if (isset($_SESSION['username'])) {
                session_write_close();
                return true;
            }
            session_write_close();
            return false;
        }

        /**
         * Logged user
         * @param string $username
         * @param string $password Raw
         * @return bool
         */
        public static function login($username, $password) {
            require_once __DIR__ . '/../database/config.php';
            $pdo = DatabaseConfig::getPDO();
            $query = $pdo->prepare('SELECT id FROM users WHERE username LIKE ? AND password LIKE ?');
            $query->bindParam(1, $username);
            $passwordHashed = crypt($password, $username);
            $query->bindParam(2, $passwordHashed);
            $query->execute();
            if (!empty($query->fetchAll(PDO::FETCH_ASSOC))) {
                session_start();
                $_SESSION['username'] = $username;
                session_write_close();
                return true;
            }
            return false;
        }

        /**
         * Register user
         * @param string $username
         * @param string $password Raw
         * @return bool
         */
        public static function register($username, $password) {
            require_once __DIR__ . '/../database/config.php';
            $pdo = DatabaseConfig::getPDO();
            $query = $pdo->prepare('INSERT INTO users(username, password) VALUES(?, ?)');
            $query->bindParam(1, $username);
            $passwordHashed = crypt($password, $username);
            $query->bindParam(2, $passwordHashed);
            if ($query->execute()) {
                self::login($username, $password);
                return true;
            } else {
                return false;
            }
        }

        /**
         * Logout user
         * @return bool
         */
        public static function logout() {
            session_start();
            session_destroy();
            session_write_close();
            return true;
        }

        /**
         * Returns current logged user in session
         * @return string|bool
         */
        public static function getUsername() {
            session_start();
            $username = $_SESSION['username'];
            session_write_close();
            return $username;
        }

        /**
         * Checks is user banned on room id
         * @param int $id Id of room
         * @return bool
         */
        public static function isBanned($id) {
            require_once __DIR__ . '\..\database/config.php';
            $pdo = DatabaseConfig::getPDO();
            $query = $pdo->prepare('SELECT banned.*
                FROM banned
                LEFT JOIN rooms
                ON (banned.room_id = rooms.id)
                WHERE rooms.id = ?');
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $userId = self::getId();
            foreach ($result as $row) {
                if ($row['user_id'] == $userId) {
                    return true;
                }
            }
            return false;
        }

        /**
         * Gets user id
         * @return int
         */
        public static function getId() {
            require_once __DIR__ . '\..\database/config.php';
            $pdo = DatabaseConfig::getPDO();
            $query = $pdo->prepare('SELECT id
                FROM users
                WHERE username LIKE ?');
            $username = self::getUsername();
            $query->bindParam(1, $username);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['id'];
        }

        /**
         * Joins to room
         * @param string $id Id of room
         * @return bool
         */
        public static function joinRoom($id) {
            require_once __DIR__ . '\..\database/config.php';
            $pdo = DatabaseConfig::getPDO();
            $query = $pdo->prepare('UPDATE users SET room = ?, isBoss = 0 WHERE id = ?');
            $userId = self::getId();
            $query->bindParam(1, $id);
            $query->bindParam(2, $userId);
            return $query->execute();
        }
    }
?>