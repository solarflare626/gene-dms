<?php

class Request  extends BaseModel{
    protected  $_table = "requests",$_className = "Request";

    public function create($fields = array(), $request_forms = array()){
        if(parent::create($fields)){
            $request_id = $this->_data->id;
            foreach ($request_forms as $key => $value) {
                $request_form = new RequestForm();

                if(!$request_form->create(array(
                    'form_id' => $value,
                    'request_id' => $request_id
                ))){
                    return false;
                }
            }

            $notification = new Notification();
            if (!$notification->create(array(
                'user_id' => $this->_data->user_id,
                'type' => "Request",
                'type_id' => $request_id

            ))) {
                return false;
            }

            return true;
        }

        return false;

        
    }

    public function recipient(){
        if($this->_data)
            return new User($this->_data->user_id);
        
        return null;
    }

    public function delete($id = null){
        
        if($id){
            $this->find($id);
        }
        if(!$this->deleteRequestForms()){
            return false;
        }

        if(!parent::delete()){
            return false;
        }

        return true;
    }

    public function update($fields = array(), $forms = array()){
        // die("hahaha");
        if(parent::update($fields)){
            $form_id = $this->_data->id;
           
            if(!$this->updateRequestForms($forms)){
                
                return false;
            }
            return true;
        }

        return false;

        
    }

    public function updateRequestForms($forms){
        if(count($forms) == 0){
            return $this->deleteRequestForms();
        }
        
        $request_id = $this->_data->id;
        $request_forms = $this->requestForms();

        foreach ($forms as $index => $value) {
            if($index >= count($request_forms)){
                
                $request_form = new RequestForm();
                
                if(!$request_form->create(array(
                    'form_id' => $value,
                    'request_id' => $request_id
                ))){
                    return false;
                }
            }else{
                if($request_forms[$index]->data()->form_id != $value ){
                    
                    $request_forms[$index]->delete();
                    $request_form = new RequestForm();
                    if(!$request_form->create(array(
                        'form_id' => $value,
                        'request_id' => $request_id
                    ))){
                        return false;
                    }

                    $request_forms[$index] =  $request_form;
                }
            }
        }

        if(count($request_forms) > count($forms)){

            $l = count($request_forms);
            for ($i=count($forms) ; $i < $l ; $i++) { 
                if(!$request_forms[$i]->delete()){
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

        $request_id = $this->_data->id;

        return (new RequestForm)->fetchAll(array('request_id','=', $request_id));
    }


    public function deleteRequestForms($id = null){
        if($id){
            $this->find($id);
        }
        $request_forms = $this->requestForms();

        foreach ($request_forms as $key => $value) {
            if(!$value->delete()){
                
                return false;
            }
        }
        return true;
    }
}
