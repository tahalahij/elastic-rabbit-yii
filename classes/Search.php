<?php

namespace app\classes;

class Search {
    protected $base_url = "127.0.0.1:9200/thesis/_doc/";

    public function indexer($attributes, $new_record)
    {
        
        $id = $attributes['post_id'];
        $title = $attributes['title'];
        
        return $new_record ? $this->insert($id, $title) : $this->update($id, $title);
    }
    
    
    public function insert($id, $title){
        $url = $this->base_url . $id;
        $input_data = array (
            'title' => $title
        );
        
        return $this->sendReq($url, $input_data);
    }
    
    public function update($id, $title){
        $url = $this->base_url . $id . "/_update";
        $input_data = array (
            "doc" =>  array (
                'title' => $title
                )
            );
            
            return $this->sendReq($url, $input_data);
        }
        
        protected function sendReq($url, $input_data)
        {
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Connection: Keep-Alive'
                ));
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($input_data));
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            return curl_exec($handler);
        }

    public function search($param)
    {
        //request search in index, get data and return it
    }
}