<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    <?php $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null; ?>
        <div class="col-sm-10">
            <?php
                 function myselect($name, $options = [], $selected = null, $attributes = null, $disabled = null)
            {
                if(!is_array($selected)){
                    $selected[]=$selected;
                }
                if(!is_array($attributes)){
                    $attribute[]=$attributes;
                }
                if(!is_array($disabled)){
                    $disabled[]=$disabled;
                }
                $html = '<select name="' . $name . '"';
                foreach ($attributes as $attribute => $value)
                {
                    $html .= ' ' . $attribute . '="' . $value . '"';
                }
                $html .= '>';

                foreach ($options as $value => $text)
                {
                    $html .= '<option value="' . $value . '"' .
                        (in_array($value ,$selected) ? ' selected="selected"' : '') .
                        (in_array($value, $disabled) ? ' disabled="disabled"' : '') . '>' .
                        $text . '</option>';
                }

                $html .= '</select>';

                return $html;
            }
            echo  myselect($name,(array)$emptyVal + $options['choices'],$options['selected'],$options['attr'],isset($options['disabled'])?$options['disabled']:[]);

            ?>
        </div>
    <?php include 'help_block.php' ?>
<?php endif; ?>

<?php include 'errors.php' ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
