<?php
    use yii\helpers\Url;
    use app\models\Candy;
    use yii\data\Pagination;

/**
 * @var Candy [] $models
 * @var Pagination $pages
 */
?>


<h1>Candies</h1>



<?php
    foreach($models as $model):
?>
    <h2><?= $model->name ?></h2>
    <!--<p>
        <img src="/images/<?= $model->image ?>" />
    </p>-->
    <p>
        <?= $model->description ?>
    </p>

    <?php


        endforeach;



echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]);
    ?>