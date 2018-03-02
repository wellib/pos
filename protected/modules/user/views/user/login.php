<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/front/css/bootstrap.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/front/css/bootstrap-cerulean.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/front/css/main.css" media="all" />

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/front/js/jquery.js" ></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/front/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/front/js/scripts.js" ></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <?php
    $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
    $this->breadcrumbs=array(
        UserModule::t("Login"),
    );
    ?>

    <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>

    <?php endif; ?>

    <div id="login-form1">
        <?php echo CHtml::beginForm(); ?>

        <div class="panel panel-primary">

            <div class="panel-heading">
                <h3 class="panel-title">Авторизация</h3>
            </div>

            <div class="panel-body">
                <?php echo CHtml::errorSummary($model); ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo CHtml::activeLabelEx($model,'username'); ?><br />
                        <?php echo CHtml::activeTextField($model,'username', array('class'=>'form-control')) ?>
                    </div>
                </div><br />

                <div class="row">
                    <div class="col-md-12">
                        <?php echo CHtml::activeLabelEx($model,'password'); ?><br />
                        <?php echo CHtml::activePasswordField($model,'password', array('class'=>'form-control')) ?>
                    </div>
                </div><br />

                <!--<div class="row">
                    <div class="col-md-12">
                        <p class="hint">
                        <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
                        </p>
                    </div>
                </div><br />-->

                <!--<div class="row rememberMe">
                    <div class="col-md-12">
                        <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                        <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
                    </div>
                </div><br />-->

                <div class="row submit">
                    <div class="col-md-12">
                        <?php echo CHtml::submitButton(UserModule::t("Войти"), array('class'=>'btn btn-primary btn-sm col-md-12')); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>


    <?php
    $form = new CForm(array(
        'elements'=>array(
            'username'=>array(
                'type'=>'text',
                'maxlength'=>32,
            ),
            'password'=>array(
                'type'=>'password',
                'maxlength'=>32,
            ),
            'rememberMe'=>array(
                'type'=>'checkbox',
            )
        ),

        'buttons'=>array(
            'login'=>array(
                'type'=>'submit',
                'label'=>'Login',
            ),
        ),
    ), $model);
    ?>

</body>
</html>