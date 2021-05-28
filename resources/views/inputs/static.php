<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
	<?php if($options['label_attr']== ['class'=>'control-label required']){
	    $options['label_attr']=['class' => 'control-label col-lg-3 required'];
	}elseif($options['label_attr']==['class'=>'control-label']){
	    $options['label_attr']=['class' => 'control-label col-lg-3'];
	} ?>
    <label <?= $options['labelAttrs'] ?>><?= $options['label'] ?></label>
<?php endif; ?>

<?php if ($showField): ?>
	<div class="col-lg-8">
		<<?= $options['tag'] ?> <?= $options['elemAttrs'] ?>><?= $options['value'] ?></<?= $options['tag'] ?>>
	</div>
    

    <?php include 'help_block.php' ?>

<?php endif; ?>


<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
