<?php

namespace app\controllers;

use app\models\CheckOut;
use app\models\Item;
use app\models\Order_items;
use app\models\Orders;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use app\models\Category;
use app\models\Cookie;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionHome()
    {
//        $category = new Category();
//         Category::deleteAll(['name' => 'Test']);
//        $category->name = 'Test2';
//        $category->save();


        $query = Category::find();

        $categories = $query

            ->all();

        return $this->render('index', [
        'categories' => $categories,
    ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionCase()
    {

        $query = Item::find()->where(['category_id' => 1]);

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);
        $cases = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        return $this->render('case', [
            'cases' => $cases,
        'pagination' => $pagination,]);
    }

    public function actionPowerbank()
    {
        $query = Item::find()->where(['category_id' => 2]);

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);
        $powerbanks = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        return $this->render('powerbank', [
            'powerbanks' => $powerbanks,
            'pagination' => $pagination,]);
    }

    public function actionPhoneholder()
    {
        $query = Item::find()->where(['category_id' => 3]);

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);
        $phoneholders = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        return $this->render('phoneholder', [
            'phoneholders' => $phoneholders,
            'pagination' => $pagination,]);
    }

    public function actionFigures()
    {
        $query = Item::find()->where(['category_id' => 4]);

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);
        $figures = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        return $this->render('figures', [
            'figures' => $figures,
            'pagination' => $pagination,]);
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    public function actionCart()
    {
       $a = Cookie::cartitem();

        $query = Item::find()->where(['id' => $a]);
        $items = $query -> all();
        return $this->render('cart', ['items' => $items]);
    }

    public function actionCheckout()
    {
        $date = new \DateTime();
        $method = $_GET["method"];
        $a = Cookie::cartitem();
        $query = Item::find()->where(['id' => $a])
            ->andWhere(['<>', 'quantity', 0]);
        $items = $query -> all();

        $order = CheckOut::orders($items);
        $model = new CheckOut();
        $values = $model -> amount($method, $items);
        $states = CheckOut::states();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'], $order)) {
            Yii::$app->session->setFlash('orderComplite');

        Item::checkoutdb($a);

            Cookie::checkoutcookie($items);

            $order = new Orders();
            $order -> date = $date -> format('Y-m-d');
            $order -> amount = $values[1];
            $order -> save();

            Order_items::add($order, $items);






            return $this->refresh();
        }

        return $this->render('checkout', ['items' => $items, 'model' => $model, 'states' => $states, 'a' => $a, 'values' => $values]);
    }
}