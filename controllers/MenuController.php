<?php

namespace app\controllers;

use app\models\Category;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use Yii;

class MenuController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRead()
    {
        $tree = Category::getTree();

        return $this->render('read', [
                    'categories' => $tree
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = new Category();
            if ($model->load($request->post()) && $model->validate() && $model->save()) {
                Yii::$app->session->setFlash('message', ['type' => 'create', 'text' => $model->name]);
                return $this->redirect(Url::to('/menu/read'));
            }
        } else {
            if (is_null($parent_id)) {
                return $this->render('create', [
                            'model' => new Category(),
                ]);
            }

            if (!($parentCategory = Category::findOne(['=', 'parent_id', $parent_id]))) {
                throw new NotFoundHttpException();
            }
            $model = new Category();
            $model->parent_id = $parentCategory->id;
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionUpdate($id = null)
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = ArrayHelper::getValue($data, 'Category.id');
            if (!($category = Category::findOne(['=', 'id', $id]))) {
                throw new NotFoundHttpException();
            }
            if ($category->load($data) && $category->validate() && $category->save()) {
                Yii::$app->session->setFlash('message', ['type' => 'update', 'text' => $category->name]);
                return $this->redirect(Url::to('/menu/read'));
            }
        } else {
            if (!($category = Category::findOne(['=', 'id', $id]))) {
                throw new NotFoundHttpException();
            }
        }

        return $this->render('update', [
                    'model' => $category,
        ]);
    }

    public function actionDelete($id)
    {
        if (!($category = Category::findOne(['=', 'id', $id]))) {
            throw new NotFoundHttpException();
        }
        $category->delete();
        Yii::$app->session->setFlash('message', ['type' => 'delete', 'text' => $category->name]);

        return $this->redirect(Url::to('/menu/read'));
    }

}
