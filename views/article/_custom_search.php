<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'custom-search-form',
    'action' => ['search']
]) ?>

    <?= $form->field($model, 'index') ?>
    <?= $form->field($model, 'phrase') ?>
    <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
