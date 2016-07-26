<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
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
                    $tag = Core::make('html/image', array($f, false))->getTag();
                    echo $tag;
                }
                ?>
            <?php } ?>
        <?php } else { ?>
        <div class="ccm-repeatable-item-placeholder">
            <p><?=t('No Repeatable Items Entered.'); ?></p>
        </div>
        <?php } ?>
    </div>
<?php } ?>
