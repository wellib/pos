<?php /** @var DefaultController $this */?>
<?php
Yii::app()->clientScript->registerScript(
   'HideAlert',
   '$(".alert-success, .alert-error").animate({opacity: 1.0}, 10000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>

<h2>Управление резервными копиями</h2>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert-success" style="text-align: center; margin: 10px 0 10px 0; padding: 10px;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('error')):?>
    <div class="alert-error" style="text-align: center; margin: 10px 0 10px 0; padding: 10px;">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php
    $cs = Yii::app()->clientscript;
    $afterAjax = '';
    if($this->module->bootstrap){
        $cs->registerScript('backup','
            $(function (){
                $(".bdownload").html("<i class=\'icon-arrow-down\'></i>");
                $(".brestore").html("<i class=\'icon-repeat\'></i>");
            });
        ',CClientScript::POS_HEAD);
        $afterAjax = '$(".bdownload").html("<i class=\'icon-arrow-down\'></i>"); $(".brestore").html("<i class=\'icon-repeat\'></i>");';
    } else{
        $cs->registerScript('backup','
            $(function (){
                $(".download").text("");
                $(".restore").html("");
            });
        ',CClientScript::POS_HEAD);
        $cs->registerCss('backup','
            .delete{
                margin: 1px;
                float:left;
            }
        ');
        $afterAjax = '$(".download").text(""); $(".restore").html("");';
    }
	$moduleId = $this->module->id;
    $this->widget($this->gridViewClass, array(
            'id' => 'backup-grid',
            'afterAjaxUpdate' => 'function(id, data){'.$afterAjax.'}',
            'dataProvider' => $dataProvider,
            'columns' => array(
                    array(
                        'name'=>'name',
                        'header'=>'Название',
                        'headerHtmlOptions'=>array('class'=>'active'),
                    ),
                    array(
                        'name'=>'size',
                        'header'=>'Размер',
                        'htmlOptions'=>array('class'=>'m-column'),
                        'headerHtmlOptions'=>array('class'=>'m-column active'),
                    ),
                    array(
                        'name'=>'create_time',
                        'header'=>'Время создания',
                        'htmlOptions'=>array('class'=>'l-column'),
                        'headerHtmlOptions'=>array('class'=>'l-column active'),
                    ),
                    array(
                        'class' => $this->CButtonColumnClass,
                        'deleteButtonUrl' =>'Yii::app()->createUrl("/'.$moduleId.'/default/delete", array("file"=>$data["name"]))',
                        'template' => '{download}{restore}{delete}',
                        'htmlOptions'=>array('class'=>'s-column'),
                        'headerHtmlOptions'=>array('class'=>'s-column active'),
                        'buttons'=>array(
                            'download' => array(
                                'label'=>'Скачать',
                                'url'=>'Yii::app()->createUrl("/'.$moduleId.'/default/download", array("file"=>$data["name"]))',
                                'visible'=>'Yii::app()->getModule("'.$moduleId.'")->download'
                            ),
                            'restore' => array(
                                'label'=>'Восстановить',
                                'url'=>'Yii::app()->createUrl("/'.$moduleId.'/default/restore", array("file"=>$data["name"]))',
                                'visible'=>'Yii::app()->getModule("'.$moduleId.'")->restore'
                            ),
                            'delete' => array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/themes/front/images/delete.png',
                            ),
                        ),
                    ),
            ),
    )); 
?>
