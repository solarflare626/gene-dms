<?php

class Form  extends BaseModel{
    protected  $_table = "forms", $_className = "Form";


    public function indicator(){
        if($this->_data->indicator_id)
            return new Indicator($this->_data->indicator_id);

            return null;
    }

    public function create($fields = array(), $metrics = array()){
        if(parent::create($fields)){
            $form_id = $this->_data->id;
            foreach ($metrics as $key => $value) {
                $metric = new Metric();

                if(!$metric->create(array(
                    'form_id' => $form_id,
                    'metric' => $value
                ))){
                    return false;
                }
            }

            return true;
        }

        return false;

        
    }

    public function delete($id = null){
        if($id){
            $this->find($id);
        }
        if(!$this->deleteMetrics()){
            return false;
        }

        if(!parent::delete()){
            return false;
        }

        return true;

    }

    public function update($fields = array(), $metrics = array()){
        // die("hahaha");
        if(parent::update($fields)){
            $form_id = $this->_data->id;
            if(!$this->updateMetrics($metrics)){
                return false;
            }
            return true;
        }

        return false;

        
    }

    public function metrics($id =null){
        if($id){
            $this->find($id);
        }

        $id = $this->_data->id;

        return (new Metric)->fetchAll(array('form_id','=', $id));
    }

    public function deleteMetrics($id = null){
        $id = $id == null ? $this->_data->id : $id;

        $results = [];
        if($this->_db->delete("metrics",array(
            'form_id' ,'=', $id
        ))){
            return true;
        }

        return false;
    }


    public function updateMetrics($metrics){
        if(count($metrics) == 0){
            return $this->deleteMetrics();
        }
        $form_id = $this->_data->id;
        $db_metrics = $this->metrics();

        foreach ($metrics as $index => $value) {
            if($index >= count($db_metrics)){
                $metric = new Metric();
                if(!$metric->create(array(
                    'form_id' => $form_id,
                    'metric' => $value
                ))){
                    return false;
                }
            }else{
                if(!$db_metrics[$index]->update(array(
                    "metric" => $value
                ))){
                    return false;
                };
            }
        }

        if(count($db_metrics) > count($metrics)){
            $l = count($db_metrics);
            for ($i=count($metrics) ; $i < $l ; $i++) { 
                if(!$db_metrics[$i]->delete()){
                    return false;
                }
            }
        }

        

        return true;

    }

    public function requestForms($id =null){
        if($id){
            $this->find($id);
        }

        $form_id = $this->_data->id;

        return (new RequestForm)->fetchAll(array('form_id','=', $form_id));
    }
   
}
