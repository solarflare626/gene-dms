<?php

class Indicator  extends BaseModel{
    protected  $_table = "indicators",$_className = "Indicator";

    public function forms($id =null){
        if($id){
            $this->find($id);
        }

        $id = $this->_data->id;

        return (new Form)->fetchAll(array('indicator_id','=', $id));
    }
}


