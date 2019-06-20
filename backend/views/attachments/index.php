<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AttachmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attachments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachments-index">
    <p>
        <?= Html::a('Reset filter', ['index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'checkbox',
                'format' => 'html',
                'value' => function ($data) {
                    return $data->checkbox == 1 ? Html::a('<i class="fa fa-toggle-on"></i>', ['status', 'id' => $data->id])
                        : Html::a('<i class="fa fa-toggle-off"></i>', ['status', 'id' => $data->id]);
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'checkbox',
                    'data' => [
                        'Not selected',
                        'Selected',
                    ],
                    'options' => [
                        'placeholder' => 'Status...',
                    ]
                ]),
            ],
            [
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => function ($data) {
                    if ($data->category_id === 0) {
                        return 'Relevés';
                    }
                    if ($data->category_id == 1) {
                        return 'Factures';
                    }
                    if ($data->category_id == 2) {
                        return 'Autres';
                    }

                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => [
                        0 => 'Relevés',
                        1 => 'Factures',
                        2 => 'Autres'
                    ],
                    'options' => [
                        'placeholder' => 'Category...',
                    ]
                ]),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    if ($data->category_id == 1) {
                        return $data->status == 0 ? "Compte pro" : "Autres";
                    }
                    return '-';
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => [
                        0 => 'Compte pro',
                        1 => 'Autres'
                    ],
                    'options' => [
                        'placeholder' => 'Paiements...',
                    ]
                ]),
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => \backend\models\User::GetAllUsersIndex(),
                    'options' => [
                        'placeholder' => 'Users...',
                    ]
                ]),
            ],
            'comment',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($data) {
                    $img = !empty($data->image) ? $data->image : 'no-user.png';
                    return Html::img('/attachments/' . $img,
                        ['width' => '50px']);
                },
            ],

            [
                'attribute' => 'realm_id',
            ],
            [
                'attribute' => 'date',
                'options' => [
                    'format' => 'YYYY-MM-DD',
                ],
                'filterType' => \kartik\grid\GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'only_date',
                    'presetDropdown' => true,
                    'convertFormat' => false,
                    'pluginOptions' => [
//                        'separator' => ' - ',
                        'format' => 'YYYY-MM-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('only_date') }",
                    ],
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
//                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>
</div>
