<?php
namespace app\models;

use app\classes\Search;
use yii\data\ActiveDataProvider;
use app\models\Article;

class CustomSearch extends \yii\base\Model
{
    public $phrase;
    public $index;

    public function rules()
    {
        return [
            [['phrase'], 'required']
        ];

    }
    
    public function search($phrase, $index)
    {
        // This is so premitive and unprofessional that Im sad
        $search = new Search;
        if(strpos($index, ',') !== false){
            $indexes = explode(',', $index);
            $result = array();
            foreach ($indexes as $index) {
                $res = $search->search($phrase, $index);
                array_push($result, $res);
            }
            return $result;
        }else{
            $result = $search->search($phrase, $index);
            return json_decode($result);
        }

    }
}
