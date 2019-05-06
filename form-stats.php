<?php
 require_once 'core/init.php';
 include 'guards/authenticated.php';

 $form = new Form(Input::get('form'));
 $metrics =  $form->metrics();
 $request_forms = $form->requestForms();

 $labels = [];
 $datasets = [];
 
 function randomHex() {
    $chars = 'ABCDEF0123456789';
    $color = '#';
    for ( $i = 0; $i < 6; $i++ ) {
       $color .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $color;
 }

 foreach ($metrics as $key => $metric) {
     array_push($labels,$metric->data()->metric);
 }

 foreach ($request_forms as $key => $request_form) {
     if($request_form->data()->is_submitted){
        $user = $request_form->user();
        $data = [];
        $answers = $request_form->answers();

        foreach ($answers as $index => $answer) {
            array_push($data,(double) $answer->data()->answer);
        }

        $dataset = array(
            'label' => $user->data()->name,
            'backgroundColor' => randomHex(),
            'data' => $data
        );

        array_push($datasets,$dataset);

     }
 }

 $data = array(
     'labels' => $labels,
     'datasets' => $datasets
 );

 header("Content-Type: application/json");
 $json = json_encode($data);
    if ($json === false) {
        // Avoid echo of empty string (which is invalid JSON), and
        // JSONify the error message instead:
        $json = json_encode(array("jsonError", json_last_error_msg()));
        if ($json === false) {
            // This should not happen, but we go all the way now:
            $json = '{"jsonError": "unknown"}';
        }
        // Set HTTP response status code to: 500 - Internal Server Error
        http_response_code(500);
    }
echo $json;
