<?php

namespace MyApp;

use MyApp\Request;
use MyApp\Database;

class Model
{
	protected $table = '';
    protected $fields = '';
    protected $rules = '';
	public $request;
	
    public function select($closure = []) {

        $this->closure = $closure;

        $pdo = Database::getPDO();
		$query = 'select * from '. $this->table;
		foreach ($this->closure as $key => $value)
		if(!empty($value)) {
			$query .= ' '. $key .' '. $value;
		}
		
        $statement = $pdo->query($query);

        return $statement->fetchAll();
    }

    public function getAll() {
        $pdo = Database::getPDO();

        $statement = $pdo->query('select * from '. $this->table );

        return $statement->fetchAll();
    }
	
	public function getSpecial($request) {
        $pdo = Database::getPDO();

        $statement = $pdo->query($request);

        return $statement->fetchAll();
    }

    public function getOne($key, $id) {
        $pdo = Database::getPDO();
		
        $statement = $pdo->query('select * from '. $this->table .' where '. $key .' = "'. $id .'" limit 1');
        $result = $statement->fetchAll();

        return empty($result[0]) ? null : $result[0];
    }

    public function update($key, $id, $values) {
		unset($values['submit']);
		
		unset($values['user_id']);
		$values = array_diff($values, array(''));
		
        if(!$this->validate($values, $this->rules)) {
            return false;
        }
		$pdo = Database::getPDO();
		
		$query = 'UPDATE ' . $this->table . ' SET ';
		
		// После последнего значения запятая не нужна, считаем массив
		$numItems = count($values);
		$i = 0;
		foreach ($values as $keys => $value){
			if(!empty($value)){
				if($keys =='user_id') {
					continue;
				}
				if(++$i !== $numItems) {
					$query .= $keys .' = "'. $value .'", ';
				} else {
					$query .= $keys .' = "'. $value .'" ';
				}
			}
		}
		$query .= 'where '. $key .' = "'. $id . '"';
		
        $statement = $pdo->prepare($query);
		$result = $statement->execute();
		
		return true;
    }

    public function create($values) {

        if(!$this->validate($values, $this->rules)) {
            return false;
        }

        $pdo = Database::getPDO();
		
        $query = 'insert into ' . $this->table . ' (';
        $query .= implode(', ', array_keys($values)) . ') values ( :';
        $query .= implode(', :',array_keys($values)) . ')';

        $statement = $pdo->prepare($query);
        return $statement->execute($values);
    }

    public function delete($key, $id) {
        $pdo = Database::getPDO();
		
        $query = 'delete from ' . $this->table . ' ';
        $query .= 'where '. $key . ' = "'. $id .'"';
		$statement = $pdo->query($query);
		$statement->execute();
        
		return true;
    }


    public function validate($values, $rules) {

        if(!empty(array_diff_key($values, $rules))) {
            return false;
        }

        foreach ($rules as $key => $rule) {

            if(!isset($values[$key])) {
                continue;
            }

            switch($rule) {
                case 'string':
                    if(!is_string($values[$key])) {
                        return false;
                    }
                break;

                case 'int':
                    if(!is_numeric($values[$key])) {
                        return false;
                    }
                break;

                default:
                    throw new \Exception('Неизвестное правило валидации');

            }

        }
        return true;

    }

}