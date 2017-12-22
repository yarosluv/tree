<?php

use yii\helpers\Url;
use yii\helpers\Html;

function tree($categories)
{
    $node = '';
    foreach ($categories as $category) {
        $link = urlencode($category['link']);
        $node .= "<li><a href='$link'>{$category['name']}</a>";
        $node .= ' <a href="' . Url::to(['menu/update', 'id' => $category['id']]) . '"><span class="glyphicon glyphicon-pencil"></span></a>';
        $node .= ' <a href="' . Url::to(['menu/delete', 'id' => $category['id']]) . '"><span class="glyphicon glyphicon-remove"></span></a>';
        $node .= ' <a href="' . Url::to(['menu/create', 'parent_id' => $category['id']]) . '"><span class="glyphicon glyphicon-plus"></span></a>';
        if ($category['categories']) {
            $node .= '<ul>';
            $node .= tree($category['categories']);
            $node .= '</ul>';
        }
        $node .= '</li>';
    }

    return $node;
}
?>
<h1 class="info">Menu</h1>
<?php if (Yii::$app->session->hasFlash('message') && ($message = Yii::$app->session->getFlash('message'))): ?>
    <div class="alert alert-success fade in">
        <strong>Success!</strong> Category "<?= $message['text'] ?>" is <?= $message['type'] ?>.
    </div>
<?php endif; ?>

<?php if ($categories): ?>
    <ul>
        <?= tree($categories) ?>
    </ul>
<?php else: ?>
    <p>Menu have not any category!</p>
<?php endif; ?>

<?= Html::a('Create', Url::to(['menu/create']), ['class' => 'btn btn-primary']) ?>

