<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php
    $is_show_label = false ;
    if ($showLabel && $options['label'] !== false && $options['label_show']):
        $is_show_label=true;
        ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
        <?php  ?>
        <div class=<?php echo $is_show_label?"col-sm-10":"";?> >
             <?= Form::input($type, $name, $options['value'], $options['attr']) ?>
             <?php include 'help_block.php' ?>
        </div>

<?php endif; ?>

<?php include 'errors.php' ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
