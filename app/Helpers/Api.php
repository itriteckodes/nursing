<?php

namespace App\Helpers;


class Api
{
    private $data= [
        'error' => false
    ];

    public static function failed($validator){
        $obj = new Api();
        $obj->data['error'] = true;
        $obj->data['error_data'] = $validator->errors()->first();
        return response()->json($obj->data);
    }
    
    public static function setError($error,$index=null,$data=null){
        $obj = new Api();
        $obj->data['error'] = true;
        $obj->data['error_data'] = $error;
        if ($data)
        $obj->data[$index] = $data;
        return response()->json($obj->data);
    }
    
    // public static function setResponse($index,$object){
    //     $obj = new Api();
    //     $obj->data[$index] = $object;
    //     return response()->json($obj->data);
    // }

    public static function setResponse($index, $object, $extraIndex = null, $extra = null){
        $obj = new Api();
        $obj->data[$index] = $object;
        if($extra)  $obj->data[$extraIndex] = $extra;
        return response()->json($obj->data);
    }
    
    public static function setMessage($message,$index=null,$data=null){
        $obj = new Api();
        $obj->data['error_data'] = $message;
        if ($data)
        $obj->data[$index] = $data;
        return response()->json($obj->data);
    }

    public function add($index,$object){
        $this->data[$index] = $object;
    }
    
    public function json(){
        return response()->json($this->data);
    }


}