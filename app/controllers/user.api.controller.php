<?php

    require_once './app/models/user.model.php';
    require_once './app/views/json.view.php';
    require_once './libs/jwt.php';

    class UserApiController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new UserModel();
            $this->view = new JSONView();
        }

        public function getToken() {
            // obtengo el email y la contraseña desde el header
            $auth_header = $_SERVER['HTTP_AUTHORIZATION']; // "Basic dXN1YXJpbw=="
            $auth_header = explode(' ', $auth_header); // ["Basic", "dXN1YXJpbw=="]
            if(count($auth_header) != 2) {
                return $this->view->response("Error en los datos ingresados", 400);
            }
            if($auth_header[0] != 'Basic') {
                return $this->view->response("Error en los datos ingresados", 400);
            }
            $user_pass = base64_decode($auth_header[1]); // "usuario:password"
            $user_pass = explode(':', $user_pass); // ["usuario", "password"]
            // Buscamos El usuario en la base
            $user = $this->model->getUserByEmail($user_pass[0]);
            // Chequeamos la contraseña
            if($user == null || !password_verify($user_pass[1], $user->password)) {
                return $this->view->response("Error en los datos ingresados", 400);
            }
            // Generamos el token
            $token = createJWT(array(
                'sub' => $user->id,
                'email' => $user->email,
                'role' => 'admin',
                'iat' => time(),
                'exp' => time() + 60,
                'Saludo' => 'Hola',
            ));
            return $this->view->response($token);
        }
    }