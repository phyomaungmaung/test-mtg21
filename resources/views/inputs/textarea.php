<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
	   <?php 
        if($options['label_attr']== ['class'=>'control-label required']){
            $options['label_attr']=['class' => 'control-label col-lg-3 required'];
        }elseif($options['label_attr']==['class'=>'control-label']){
            $options['label_attr']=['class' => 'control-label col-lg-3'];
        }
    ?>
		<?= Form::label($name, $options['label'], $options['label_attr']) ?>	
<?php endif; ?>

<?php if ($showField): ?>
    <?php if ($options['label'] !== " " && $options['attr']!=["class" => "form-control nopadding"]): ?>
	<div class="col-lg-8">
		<?= Form::textarea($name, $options['value'], $options['attr']) ?>	
	</div>
    <?php else: ?>
        <div class="col-lg-12">
            <?= Form::textarea($name, $options['value'], $options['attr']) ?> 
        </div>
    <?php endif; ?>

    <?php include 'help_block.php' ?>
<?php endif; ?>

<?php //include 'errors.php' ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
