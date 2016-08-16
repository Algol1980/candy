<?php
/**
 * @var \yii\data\ActiveDataProvider $provider
 */
?>


<?= \yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'image',
            //'header' => 'ИЗОБРАЖЕНИЕ!',
            'content' => function(\app\models\Candy $model){
                return \yii\helpers\Html::img('/favicon.ico');
            }
        ],
        [
            'class' => \yii\grid\ActionColumn::className(),
            // you may configure additional properties here
        ],
//        [
//            'header' => 'Actions',
//            'content' => function(\app\models\Candy $model) {
//                return \yii\helpers\Html::a('Delete', [
//                    '/candy/delete', 'id' => $model->id
//                ], [
//                    'onclick' => 'return confirm("Are you sure ?")'
//                ]);
//            }
//        ],

    ],
]) ?>