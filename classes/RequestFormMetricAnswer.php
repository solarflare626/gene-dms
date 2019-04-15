<?php

class RequestFormMetricAnswer  extends BaseModel{
    protected  $_table = "request_form_metric_answers",$_className = "RequestFormMetricAnswer";

    public function metric(){
        if($this->_data)
            return new Metric($this->_data->metric_id);
        return null;
    }

   
}
