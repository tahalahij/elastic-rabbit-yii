<?php
namespace app\models;

use app\classes\Search;
use yii\data\ActiveDataProvider;
use app\models\Article;

class CustomSearch extends \yii\base\Model
{
    public $phrase;

    public function rules()
    {
        return [
            [['phrase'], 'required']
        ];

    }
    
    public function search($phrase)
    {
        $search = new Search;
        $result = $search->search($phrase);
        
        $data = json_decode($result);
        $ids = array();
        foreach ($data->hits->hits as $hit)
        {
            array_push($ids, $hit['_id']);
        }
        $query = Article::find()->where(array('in', 'id', $ids))->orderBy('created_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return  $dataProvider;
    }
}