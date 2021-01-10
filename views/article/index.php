<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

<div style="width:300px;" class="pull-right">
<?php  echo $this->render('_custom_search', ['model' => $custom_search]); ?>
</div>

    <p>
        <?= Html::a('Create Object', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
