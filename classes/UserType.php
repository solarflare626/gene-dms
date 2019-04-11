<?php
class UserType {
    private $_db,
            $_data,
            $_table = "user_types";

    public function __construct($userType = null) {
        $this->_db = DB::getInstance();
        if(is_object($userType)){
            $this->_data = $userType;
        }else if(is_string($userType) || is_numeric($userType)){
            $this->find($userType);
        }
    }

    public function create($fields = array()) {
        if(!$this->_db->insert($this->_table, $fields)) {
            throw new Exception('Sorry, there was a problem creating your account;');
        }
    }
    public function update($fields = array(), $id = null) {

        if(!$this->_db->update($this->_table, $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

    public function find($id = null) {
        if($id) {
            $field = (is_numeric($user)) ? 'id' : 'type';
            $data = $this->_db->get($this->_table, array($field, '=', $user));

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