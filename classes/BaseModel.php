<?php
class BaseModel {
    protected $_db,
            $_data,
            $_table = "base";

    
    public function table(){
        return $this->_table;
    }

    public function __construct($data = null) {
        $this->_db = DB::getInstance();
        if(is_object($data)){
            $this->_data = $data;
        }else if(is_string($data) || is_numeric($data)){
            $this->find($data);
        }
    }

    public function fetchAll(){
        $db = DB::getInstance();
        $results = [];

        $table = $this->_table;
        
        // die("$table");
        if(!$db->query("SELECT * FROM $table")->error()){
            $r = $db->results();

            foreach ($r as $index => $value) {
                array_push($results, new self($value));
            }
        }

        return $results;
    }

    public function create($fields = array()) {
        if(!$this->_db->insert($this->_table, $fields)) {
            throw new Exception('Sorry, there was a problem creating your account;');
        }
    }

    public function delete($where = array()) {
        if(!$this->_db->delete($this->_table, $where)) {
            throw new Exception('Sorry, there was a problem creating your account;');
        }else{
            self::destroy($this);
            return true;
        }

        return false;
    }

    public static function destroy(&$data) {
        $data = null;
    }

    public function update($fields = array(), $id = null) {
        
        if(!$this->_db->update($this->_table, $id, $fields)) {
            throw new Exception('There was a problem updating');
        }else{
            foreach ($fields as $key => $value) {
                $this->_data[$key] = $value;
            }
        }
        return true;
    }

    public function find($id = null) {
        if($id) {
            $field = "id";
            $data = $this->_db->get($this->_table, array($field, '=', $id));
            
            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }
    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }
    
    public function data(){
        return $this->_data;
    }

}