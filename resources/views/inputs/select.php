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
         
        <?php if ($options['label'] !== " "): ?>
          <?= Form::label($name, $options['label'], $options['label_attr']) ?>
        <?php endif; ?>
<?php endif; ?>

<?php if ($showField): ?>
    <?php $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null; ?>
    
    <?php if ($options['label'] !== " "&&
                $options['attr']!=["class" => "form-control nopadding","required" => "required"]&& 
                $options['attr']!=["class" => "form-control nopadding","required" => "required",'disabled'=>true]&& 
                $options['attr']!=["class" => "form-control nopadding"]&& 
                $options['attr']!=['class'=>"form-control nopadding selectpicker", 'data-live-search'=>"true","required" => "required"]&&
                $options['attr']!=['class'=>"form-control nopadding selectpicker", 'data-live-search'=>"true","required" => "required",'disabled'=>true]&&
                $options['attr']!=['class'=>"form-control nopadding selectpicker", 'data-live-search'=>"true"]): ?>
        <div class="col-lg-8">
            <?= Form::select($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) ?>     
        </div>
    <?php else: ?>
        <div class="col-lg-12">
            <?= Form::select($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) ?>     
        </div>
    <?php endif; ?>

    <div class="col-lg-8">
        
    </div>
    
    <?php include 'help_block.php' ?>
<?php endif; ?>

<?php //include 'errors.php' ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
