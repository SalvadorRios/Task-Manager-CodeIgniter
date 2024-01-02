<?php namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $returnType ='array';
    protected $allowedFields = ['title', 'description', 'status','created_at', 'updated_at', 'user_tasks'];

    protected $validationRules = [
        'title'=> 'required|alpha_space|min_length[3]|max_length[100]',
        'description'=> 'required|alpha_space|min_length[3]|max_length[100]',
        'status'=> 'required|alpha_space|min_length[3]|max_length[100]',
        'user_tasks'=> 'required',
    ];

    protected $validationMessages = [
        'title'=> 'el titulo de la tarea es requerido',
        'description'=> 'el titulo de la tarea es requerido',
        'status'=> 'el titulo de la tarea es requerido',
        ];

    protected $skipValidation = false;
    // Agregar aquí más funciones según sea necesario
}
