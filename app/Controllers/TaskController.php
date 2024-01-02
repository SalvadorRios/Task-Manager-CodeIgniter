<?php namespace App\Controllers;

// use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\TaskModel;
use \Firebase\JWT\JWT;
use \Firebase\JWT\KEY;

class TaskController extends ResourceController
{
    protected $modelName = 'App\\Models\\TaskModel';
    protected $format    = 'json';

    public function __construct(){
        $this->model = new TaskModel();
    }

    // use ResponseTrait;
    public function getTask(){
        try{
            $this->validateToken();
        }catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], 401);
        }
        $task = $this->model->findAll();
        return $this->respond($task);
        
    }

    public function create()
    {
        try{
            $this->validateToken();
            $task = $this->request->getJSON();
            $task->created_at = date('Y-m-d H:i:s');
            $task->updated_at = date('Y-m-d H:i:s');

            if($this->model->insert($task)):
                return $this->respondCreated($task);
            else:
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
        }catch(\Exception $e){
            return $this->respond(['error' => $e->getMessage()], 401);
       }
    }

    public function show($id = null)
    {
        try{
            $this->validateToken();
        }catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], 401);
        }
        $data = $this->model->asObject()
        ->where('user_tasks',$id)
        ->findAll();
        if ($data) {
            return $this->respond([$data]);
        }
        return $this->failNotFound('Tarea no encontrada');
    }

    public function edit($id = null){
        try{
            $this->validateToken();
            if ($id == null) 
                return $this->failValidationError('necesitas un id valido');
            $task = $this->model->find($id);
            if ($task == null)
                return $this->failNotFound('no se encontro una tarea con el id'.$id);

            $task = $this->request->getJSON();

            if($this->model->update($id, $task)):
                $task->$id = $id;
                return $this->respondUpdated($task);
            else:
                return $this->failValidationError($this->model->validation->listErrors());
            endif;

        }catch(\Exception $e){
            return $this->respond(['error' => $e->getMessage()], 401);
        }

    }

    public function delete($id = null){
        try{
            $this->validateToken();
            if ($id == null) 
                return $this->failValidationError('necesitas un id valido');
            $task = $this->model->find($id);
            if ($task == null)
                return $this->failNotFound('no se encontro una tarea con el id'.$id);

            $task = $this->request->getJSON();

            if($this->model->delete($id)):
                return $this->respondCreated([
                    'status' => 200,
                    'message' => 'Tarea Eliminada'
                ]);
            else:
                return $this->failValidationError($this->model->validation->listErrors());
            endif;

        }catch(\Exception $e){
            return $this->respond(['error' => $e->getMessage()], 401);
        }

    }

    public function readUser($jwt = null){
        try{
            $key = "hilalahmadkhanformpakistan";
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
        }catch(\Exception $e){
            return $this->failServerError('error', $e);
        }
            
    }

    public function validateToken(){
        $request = service('request');
        $headers = $request->getHeader('Authorization');
        if (!$headers) {
            throw new \Exception("El token es necesario");
        }
        $jwt = $headers->getValue();
        $responseToken = $this->readUser($jwt);

        $jsonString = $responseToken->getBody();
        $jsonObject = json_decode($jsonString);
        $status = $jsonObject->status;

        if ($status!=200) {
            throw new \Exception("Token inválido");
        }
    }
    
}
