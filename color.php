<div class="color-wrap js-color-wrap">

<?php if (!empty($color['label'])): ?>
    
    <span class="color-label badge badge-secondary float-right"><?php echo $color['label'] ?></span>

<?php endif ?>

    <div class="color" style="background-color: #<?php echo $color['hex'] ?>;">
        <div class="color-mix-count js-color-mix-count"></div>
        <span class="color-hex js-color-hex" title="Copy to clipboard"><?php echo $color['hex'] ?></span>

<?php if (!empty($color['h'])): ?>
    
    <span class="color-hsl"><?php echo $color['h'] ?>/<?php echo $color['s'] ?>/<?php echo $color['l'] ?></span>

<?php endif ?>

    </div>
    <p class="color-name js-color-name"><?php echo $color['name'] ?></p>
</div>
