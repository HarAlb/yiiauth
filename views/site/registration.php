<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\RegistrationForm */
/* @var $days array */
/* @var $months array */
/* @var $years array */
/* @var $phoneCodes array */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-12 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-8 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>
    <?php
    if($errors = $model->getErrors()){
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error){
            echo '<h6 class="row">' . $error[0] . '</h6>';
        }
        echo '</div>';
    }
    ?>
    <h4>Full name</h4>
    <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'lastname')->textInput() ?>
    <?= $form->field($model, 'gender')->radioList( \app\models\RegistrationForm::GENDERS ); ?>
    <h4>Birthdate</h4>
    <?= $form->field($model, 'day')->dropDownList($days) ?>
    <?= $form->field($model, 'month')->dropDownList($months) ?>
    <?php
    $yearOptions = [];
    foreach ($years as $year){
        $yearOptions[$year] = $year;
    }
    ?>
    <?= $form->field($model, 'year')->dropDownList($yearOptions) ?>
    <div class="row">
        <div class="col-lg-12" style="display: flex">
            <?php
            $options = [];
            foreach ($phoneCodes as $phoneCode){
                $options[$phoneCode] = '+' . $phoneCode;
            }
            ?>
            <?= $form->field($model, 'phoneCode')->dropDownList($options) ?>
            <?= $form->field($model, 'phone')->textInput() ?>
        </div>
    </div>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->textInput(['type' => 'password']) ?>
    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
