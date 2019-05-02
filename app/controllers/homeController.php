<?php 
    require_once 'controller.php';
    class homeController extends Controller {
        public function index() {
            require_once __DIR__ . '/../helpers/user.php';
            if (User::isLogged()) {
                header('Location: /home/rooms');
            } else {
                header('Location: /home/login');
            }
        }

        public function rooms($banned = false) {
            $title = 'Pokoje';
            $this->loadModel();
            $rooms = $this->model->getRooms();
            require_once __DIR__ . '/../views/home/rooms.phtml';
            
        }

        public function login($error = null) {
            $title = 'Logowanie';
            require_once __DIR__ . '/../views/home/login.phtml';
        }

        public function tryLogin() {
            require_once __DIR__ . '/../helpers/user.php';
            User::logout();
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                header('Location: /home');
                return;
            } else {
                $username = $_POST['username'];
                $password = $_POST['password'];
                if (User::login($username, $password)) {
                    header('Location: /home/rooms');
                    return;
                } else {
                    header('Location: /home/login/error');
                    return;
                }
            }
        }

        public function register($error = null) {
            $title = 'Rejestracja';
            require_once __DIR__ . '/../views/home/register.phtml';
        }

        public function tryRegister() {
            require_once __DIR__ . '/../helpers/user.php';
            User::logout();
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                header('Location: /home');
                return;
            } else {
                $username = $_POST['username'];
                $password = $_POST['password'];
                require_once __DIR__ . '/../helpers/user.php';
                if (User::register($username, $password)) {
                    header('Location: /home/rooms');
                    return;
                } else {
                    header('Location: /home/register/error');
                    return;
                }
            }
        }
    }
?>
