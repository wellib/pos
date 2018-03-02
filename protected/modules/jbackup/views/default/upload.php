<?php
/**
 * @var $form CActiveForm
 */
?>

<h2>Загрузить резервную копию</h2>

<div class="form">
    <?php $form = $this->beginWidget($this->module->bootstrap ? 'bootstrap.widgets.TbActiveForm': 'CActiveForm', array(
        'id' => 'install-form',
        'enableAjaxValidation' => false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>

        <table class="table table-bordered table-striped table-hover" >
            <?php if($this->module->bootstrap)
                $form->type = 'horizontal';
            ?>

            <?php
                if($this->module->bootstrap) {
                    echo $form->fileFieldRow($model,'upload_file');
                } else{ ?>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model,'upload_file'); ?>
                        </td>
                        <td>
                            <?php echo $form->fileField($model,'upload_file'); ?>
                            <?php echo $form->error($model,'upload_file'); ?>
                        </td>
                    </tr>
            <?php } ?>
        </table>

        <?php echo CHtml::submitButton('Загрузить', array('class'=>'btn btn-primary btn-sm')); ?>

    <?php $this->endWidget(); ?>
</div>