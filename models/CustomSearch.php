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
        $search = new Search;
        $result = $search->search($phrase, $index);
        
        $data = json_decode($result);
        return  $data;
    }
}
