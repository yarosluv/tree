<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property integer $parent_id
 *
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'link'], 'trim'],
            [['name', 'link'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['link'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    public static function getTree()
    {
        $tree = [];
        $categories = [];
        $rootCategories = [];
        foreach (self::find()->asArray()->all() as $cat) {
            if (is_null($cat['parent_id'])) {
                $rootCategories[] = $cat;
            } else {
                $categories[] = $cat;
            }
        }

        foreach ($rootCategories as $category) {
            $category['categories'] = self::setChildNode($category['id'], $categories);
            $tree[] = $category;
        }

        return $tree;
    }

    private static function setChildNode($parentId, array $categories): array
    {
        $children = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $category['categories'] = self::setChildNode($category['id'], $categories);
                $children[] = $category;
            }
        }

        return $children;
    }

}
