<?php 
    require_once 'controller.php';
    class RoomController extends Controller {
        public function index() {
            
        }

        /**
         * @param int $id Id of room
         */
        public function join($id) {
            require_once __DIR__ . '/../helpers/user.php';
            if (User::isLogged()) {
                $this->loadModel();
                if ($this->model->isRoomExists($id)) {
                    if (User::isBanned($id)) {
                        header('Location: /home/rooms/banned');
                    } else {
                        $title = 'Pokój ' . $id;
                        require_once __DIR__ . '\..\views\RoomView.phtml';
                    }
                } else {
                    header('Location: /home');
                    return;
                }
            } else {
                header('Location: /home');
                return;
            }
        }
    }
?>
