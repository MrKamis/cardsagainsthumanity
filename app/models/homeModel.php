<?php
    require_once 'model.php';
    class HomeModel extends Model {
        public function __construct() {
            parent::__construct();
        }

        /**
         * Getts all rooms where user is not banned
         * @return array<Any>
         */
        public function getRooms() {
            $query = $this->query('SELECT rooms.*, users.username AS "host_username"
            FROM rooms
            LEFT JOIN users
            ON (users.id = rooms.id)');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>