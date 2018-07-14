<?php

namespace Models;

use MyApp\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fields = [
        'user_id',
        'user',
        'password',
        'user_name' ,
        'email',
    ];

    public $rules = [
        'user_id'   => 'int',
        'user'  	=> 'string',
        'password'  => 'string',
        'user_name' => 'string',
        'email'  	=> 'string',
    ];

    public function getUsers() {
        return $this->getAll();
    }
}