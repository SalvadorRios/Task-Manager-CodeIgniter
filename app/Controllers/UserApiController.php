<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;
use \Firebase\JWT\KEY;

class UserApiController extends BaseController
{
    public function __construct(){
        $this->model = new User();
    }
    use ResponseTrait;
    public function create()
    {
        $users = new User();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at'=> date("Y-m-d H:i:s")
        ];
        // for email existance
        $is_email = $users->where('email', $this->request->getVar('email'))->first();
        if ($is_email) {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Email already exist'
            ]);
        } else {
            $result = $users->save($data);
            if ($result) {
                return $this->respondCreated([
                    'status' => 200,
                    'message' => 'User Create Successfully'
                ]);
            } else {
                return $this->respondCreated([
                    'status' => 400,
                    'message' => 'User not create successfully',
                ]);
            }
        }
    }


    public function login()
    {
        $users = new User();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $is_email = $users->where('email', $email)->first();
        if ($is_email) {
            $verify_password = password_verify($password, $is_email['password']);
            if ($verify_password) {
                $key = "hilalahmadkhanformpakistan";
                $payload = [
                    "iss" => "localhost",
                    "aud" => "localhost",
                    // we can also use exprire time in seconds
                    "data" => [
                        'user_id' => $is_email['id'],
                        'name' => $is_email['name'],
                        'email' => $is_email['email']
                    ]
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                $_SESSION['token']=$jwt;
                return $this->respondCreated([
                    'status' => 200,
                    'jwt' => $jwt,
                    'message' => 'User Login Successfully',
                ]);
            } else {
                return $this->respondCreated([
                    'status' => 400,
                    'message' => 'Invalid Email and Password',
                ]);
            }
        } else {
            return $this->respondCreated([
                'status' => 400,
                'message' => 'Email is not found',
            ]);
        }
    }


    public function readUser()
    {
        $request = service('request');
        $key = "hilalahmadkhanformpakistan";
        $headers = $request->getHeader('Authorization');
        if (!$headers) {
            return $this->respondCreated([
                'status'=> 400,
                'message'=> 'token is requiered'
            ]);
        }
        $jwt = $headers->getValue();
        $userData = JWT::decode($jwt, new KEY($key, 'HS256'));
        $users = $userData->data;
        $response = $this->respondCreated([
            'status' => 200,
            'users' => $users
        ]);
        if ($response) {
            return $this->respondCreated([
                'status'=> 200,
                'message'=> 'login',
                'data'=> $users
            ]);
        }else {
            return $this->respondCreated([
                'status'=> 400,
                'message'=> 'error',
                ]);
        }
    }
    public function delete($id = null){
        try{
            $user = new User;
            if ($id == null) 
                return $this->failValidationError('necesitas un id valido');
            $task = $user->find($id);
            if ($task == null)
                return $this->failNotFound('no se encontro un usuario con el id'.$id);

            $task = $this->request->getJSON();

            if($user->delete($id)):
                 return $this->respondCreated([
                    'status' => 200,
                    'message' => 'User Eliminado'
                ]);
            else:
                return $this->failValidationError($user->validation->listErrors());
            endif;

        }catch(\Exception $e){
            return $this->failServerError('error', $e);
        }

    }
}
