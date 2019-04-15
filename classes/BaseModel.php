<?php
class BaseModel {
    protected $_db,
            $_data,
            $_table = "base",
            $_className = "BaseModel";

    
    
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

    public function fetchAll($where = null){
        // $db = DB::getInstance();
        $results = [];

        $table = $this->_table;
        
        if(!$this->_db->get($table,$where)->error()){
            $r = $this->_db->results();

            foreach ($r as $index => $value) {
                array_push($results, new $this->_className($value));
            }
        }

        return $results;
    }

    public function create($fields = array()) {
        
        if(!$this->_db->insert($this->_table, $fields)) {
            echo("error");
            throw new Exception("Sorry, there was a problem inserting into $this->_table");
        }else{
            $id = $this->_db->lastInsertId();
            $this->find($id);
            return true;
        }
        return false;
    }

    public function delete($where = null) {
        if($where == null && $this->_data->id){
            $where = array( "id","=",$this->_data->id );
        }else if(!is_array($where)){
            throw new Exception("Sorry, there was a problem deleting from $this->_table ");
            return false;
        }
        if(!$this->_db->delete($this->_table, $where)) {
            throw new Exception("Sorry, there was a problem deleting from $this->_table ");
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
        $id = $id == null ? $this->_data->id : $id;
        if(!$this->_db->update($this->_table, $id, $fields)) {
            throw new Exception("Sorry, there was a problem updating from $this->_table ");
            return false;
        }else{
            $this->find($id);
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