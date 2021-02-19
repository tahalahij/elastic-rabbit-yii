<?php

namespace app\controllers;

// need a class --> http://stuff.cebe.cc/yii2docs/yii-web-forbiddenhttpexception.html
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use app\models\CustomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\classes\Search;


/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['update', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $custom_search = new CustomSearch;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'custom_search' => $custom_search
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($slug),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /**
             * init a new search
             * use indexer method to start indexing this model instance
             * we need the article object, boolean for if this is a new record
             * and the model instance name (here is article)
             */
            $search = new Search;
            $search->indexer($model->attributes, 1, 'article');

            return $this->redirect(['view', 'slug' => $model->slug]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = $this->findModel($slug);

        //logic of protection for article owner
        if($model->created_by !== Yii::$app->user->id)
        {
            throw new ForbiddenHttpException("Insuficient Privileges");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /**
             * init a new search
             * use indexer method to start indexing this model instance
             * we need the article object, boolean for if this is a new record
             */
             $search = new Search;
             $search->indexer($model->attributes, 0, 'article');

            return $this->redirect(['view', 'slug' => $model->slug]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = $this->findModel($slug);

         //logic of protection for article owner
        if($model->created_by !== Yii::$app->user->id)
        {
            throw new ForbiddenHttpException("Insuficient Privileges");
        }

        $search = new Search;
        $search->indexer($model->attributes, 2, 'article');
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Article::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearch()
    {
        $model = new CustomSearch;
        $phrase = Yii::$app->request->post()['CustomSearch']['phrase'];

        $searchModel = new ArticleSearch();
        $dataProvider = $model->search($phrase);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'custom_search' => $model
        ]);
    }
}
