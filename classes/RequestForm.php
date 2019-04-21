<?php

class RequestForm  extends BaseModel{
    protected  $_table = "request_forms",$_className = "RequestForm";

    public function create($fields = array()){
        if(parent::create($fields)){
            $form_id = $this->_data->form_id;
            $request_form_id = $this->_data->id;

            $metrics = (new Form($form_id))->metrics();

            foreach ($metrics as $key => $value) {
                $metric = $value->data(); 

                $request_form_metric_answer = new RequestFormMetricAnswer();

                if(!$request_form_metric_answer->create(array(
                    'request_form_id' => $request_form_id,
                    'metric_id' => $metric->id,
                    'answer' => null
                ))){
                    return false;
                }
            }

            return true;
        }

        return false;

        
    }

    public function form($id = null){
        if($id){
            $this->find($id);
        }
        return new Form($this->_data->form_id);
    }

    

    public function delete($id = null){
        if($id){
            $this->find($id);
        }
        if(!$this->deleteAnswers()){
            return false;
        }

        if(!parent::delete()){
            return false;
        }

        return true;
    }

    public function answers($id =null){
        if($id){
            $this->find($id);
        }

        $request_form_id = $this->_data->id;

        return (new RequestFormMetricAnswer)->fetchAll(array('request_form_id','=', $request_form_id));
    }
    

    public function deleteAnswers($id = null){
        if($id){
            $this->find($id);
        }

        $answers = $this->answers();

        foreach ($answers as $key => $value) {
            if(!$value->delete()){
                return false;
            }
        }

        return true;
    }
   
}
