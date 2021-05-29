<?php

namespace app\classes;

use app\classes\Rabbit;
use app\models\User;
use Yii;

class Search
{
    public $base_url ;
    public $index ;
    
    public function __construct()
    {
        $env = require __DIR__ . '/../config/enviornment.php';
        $this->base_url = $env['es_base_url'];
        $this->index = $env['es_default_index'];
    }
    public function indexer($attributes, $type, $object_entity)
    {
        switch ($type) {
            case '0':
                return $this->adaptor($attributes, 'update',  $object_entity) ;
                break;
            case '1':
                return $this->adaptor($attributes, 'insert',  $object_entity) ;
                break;
            case '2':
                return $this->adaptor($attributes, 'delete',  $object_entity) ;
                break;
        }
    }

    public function adaptor($attributes, $type, $object_entity)
    {
        $input_data = array (
            'type' => $type, //type of entry [insert, update, delete]
            'model' => $object_entity, //model of entity [user, article,...]
            'document' => $attributes, //entity object
            'time' => date('Y-D-M H:i') // create_at date
        );

        return $this->sendToRabbit($input_data);
    }

    protected function sendToRabbit($input_data)
    {
        $rabbit = new Rabbit(); //init Rabbit class
        return $rabbit->send($input_data);
    }

    /**
     *  search_phrase is the phrase that you are searching for
     *  index is what is declared at the top
     * Sends a http request to elastic server
     * returns objects that contain the search_phrase
     * returned objects id are object_entity's record in our db
     * TODO : use a connector for elastic instead of http request
     */
    public function search($search_phrase)
    {
        $input_data = array(
            'query' => array(
                "match_phrase" => array(
                    $this->index => $search_phrase
                )
            )
        );

        $handler = curl_init($this->base_url);
        curl_setopt($handler, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
            ));
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($input_data));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
}
