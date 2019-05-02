<?php 
    require_once 'model.php';
    class RoomModel extends Model {
        public function isRoomExists($id) {
            $query = $this->query('SELECT * FROM rooms WHERE id = ?');
            $query->bindParam(1, $id);
            $query->execute();
            if (empty($query->fetchAll(PDO::FETCH_ASSOC))) {
                return false;
            } else {
                return true;
            }
        }
    }
?>
