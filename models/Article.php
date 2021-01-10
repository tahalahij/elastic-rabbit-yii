<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
//use yii\elasticsearch\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Html;   
/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Article extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'created_by'], 'integer'],
            [['title'], 'string', 'max' => 1024],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Model',
            'slug' => 'Slug',
            'body' => 'Object',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getEncodedBody()
    {
        return Html::encode($this->body);
    }
    
    // Other class attributes and methods go here
    // ...
    //public static function index()
    //{
        //return "article";//index name
    //}

    //public static function type()
    //{
        //return "article";//index type
    //}

    //public function attributes()
    //{
        //return [
            //'id',
            //'title',
            //'slug',
            //'body'
            //'created_at',
            //'updated_at',
            //'created_by'
        //];
    //}

    /**
     * @return array This model's mapping
     */
    //public static function mapping()
    //{
        //return [
            //static::type() => [
                //'properties' => [
                    //'title' => ['type' => 'string',"index" => "analyzed","store" => "yes"],
                    //'slug' => ['type' => 'string'],
                    //'body' => ['type' => 'text'],
                    //'created_at' => ['type' => 'date'],
                    //'updated_at' => ['type' => 'date'],
                    //'created_by' => ['type' => 'string'],
                //]
            //],
        //];
    //}

    //public static function setUpMapping()
    //{
        //$db = static::getDb();

        ////in case you are not using elasticsearch ActiveRecord so current class extends database ActiveRecord yii/db/activeRecord
        //// $db = yii\elasticsearch\ActiveRecord::getDb();

        //$command = $db->createCommand();

        /*
         * you can delete the current mapping for fresh mapping but this not recommended and can be dangrous.
         */

        //// $command->deleteMapping(static::index(), static::type());

        //$command->setMapping(static::index(), static::type(), [
            //static::type() => [
                ////"_id" => ["path" => "id", "store" => "yes"],
                //"properties" => [
                    //'title' => ["type" => "string","index" => "analyzed","store" => "yes"],
                    //'slug' => ["type" => "string"],
                    //'body' => ["type" => "string"],
                    //'created_at' => ["type" => "date"],
                    //'updated_at' => ["type" => "date"],
                    //'created_by' => ["type" => "string"],
                //],
            //],
        //]);
    ////echo "<pre>";print_r($command);die;
    //}

    /**
     * Create this model's index
     */
    //public static function createIndex()
    //{
        //$db = static::getDb();
        //$command = $db->createCommand();


        //$command->createIndex(static::index(), [
            ////'settings' => [ [> ... <]],
            //'mappings' => static::mapping(),
            ////'warmers' => [ [> ... <] ],
            ////'aliases' => [ [> ... <] ],
            ////'creation_date' => '...'
        //]);
    //}

    /**
     * Delete this model's index
     */
    //public static function deleteIndex()
    //{
        //$db = static::getDb();
        //$command = $db->createCommand();
        //$command->deleteIndex(static::index(), static::type());
    //}
}
