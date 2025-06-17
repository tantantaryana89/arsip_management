<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<div class="login-box">
    <div class="login-logo">
        <b>Arsip</b>-Managemen
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <!-- Username -->
            <div class="input-group mb-3">
                <?= Html::activeTextInput($model, 'username', [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'autofocus' => true
                ]) ?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <?= Html::error($model, 'username', ['class' => 'text-danger']) ?>

            <!-- Password -->
            <div class="input-group mb-3">
                <?= Html::activePasswordInput($model, 'password', [
                    'class' => 'form-control',
                    'placeholder' => 'Password'
                ]) ?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <?= Html::error($model, 'password', ['class' => 'text-danger']) ?>

            <!-- Remember Me & Button -->
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <?= Html::activeCheckbox($model, 'rememberMe', [
                            'label' => 'Remember Me'
                        ]) ?>
                    </div>
                </div>
                <div class="col-4">
                    <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
            <p class="mb-0">
                <a href="#" class="text-center">Register a new membership</a>
            </p>
        </div>
    </div>
</div>
