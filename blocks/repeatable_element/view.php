<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if ($cropImage == 1) {
    $ih = Core::make('helper/image');
}
if ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Repeatable Element view disabled in edit mode.')?></div>
    </div>
<?php } else { ?>
    <div class="repeatable-element-container">
        <?php if(count($items) > 0) { ?>
            <?php foreach($items as $item) {?>
                <?php if($item['title']) { ?>
                    <p>
                        <?=$item['title']?>
                    </p>
                <?php } ?>
                <?php
                $f = File::getByID($item['fID']);
                if (is_object($f) && $enableImage == 1) {
                    if ($cropImage == 1) {
                        $width = $cropWidth;
                        $height = $cropHeight;
                        $crop = $crop;
                        $image = $ih->getThumbnail($f, $width, $height, $crop);
                        echo '<img src="' . $image->src . '">';
                    } else if ($cropImage == 0) {
                        $tag = Core::make('html/image', array($f, false))->getTag();
                        echo $tag;
                    }
                }
                ?>
            <?php } ?>
            <p> crop image is: <br> <?=$cropImage?> </p>
            <p> crop width is: <br> <?=$cropWidth?> </p>
            <p> crop height is: <br> <?=$cropHeight?> </p>
            <p> crop to size is: <br> <?=$crop?> </p>
        <?php } else { ?>
        <div class="ccm-repeatable-item-placeholder">
            <p><?=t('No Repeatable Items Entered.'); ?></p>
        </div>
        <?php } ?>
    </div>
<?php } ?>
