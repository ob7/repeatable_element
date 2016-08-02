<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if ($cropImage == 1) {
    $ih = Core::make('helper/image');
}
if ($sf > 0) {
    $ih = Core::make('helper/image');
    $image = $ih->getThumbnail($sf, 1920, 9999, false);
}
if ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Repeatable Element view disabled in edit mode.')?></div>
    </div>
<?php } else { ?>
    <div class="repeatable-element-container <?=$enableSlideshow > 0 ? 'cycle-slideshow-container' : ''?>">
        <?php if(count($items) > 0) { ?>
            <ul
                class="repeatable-list <?=$enableSlideshow > 0 ? 'cycle-slideshow' : 'menu-list'?>"
                data-cycle-slides="li"
                data-cycle-pager=".pager"
                data-cycle-auto-height="container"
                <?php if($image) {?>
                style="background-image: url('<?=$image->src?>');"
                <?php } ?>
            >
            <?php foreach($items as $item) {?>
                <?php if ($enableSlideshow > 0) {?>
                <li>
                    <div class="content">
                        <div class="container">

                            <div class="row">
                                <div class="col-xs-12 col-lg-6">
                            <?php if ($item['linkURL']) {?>
                                <a href="<?=$item['linkURL'] ?>" class="mega-link-overlay">
                            <?php } ?>
                                    <div class="image">
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
                                    </div>
                            <?php if ($item['linkURL']) {?>
                                </a>
                            <?php } ?>
                                </div>
                                <div class="col-xs-12 col-lg-6">
                                    <?php if($item['title'] && $displayTitle == 1) { ?>
                                        <h1>
                                            <?=$item['title']?>
                                        </h1>
                                    <?php } ?>
                                    <?php if ($item['description']) {?>
                                        <div class="description">
                                            <?=$item['description']?>
                                        </div>
                                    <?php } ?>
                                    <div class="pager">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php } else {?>
                <li>
                    <?php if ($item['linkURL']) {?>
                        <a href="<?=$item['linkURL'] ?>" class="mega-link-overlay">
                    <?php } ?>
                    <?php if ($item['fID']) {?>
                    <div class="image">
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
                    </div>
                    <?php } ?>
                    <?php if($item['title']) {?>
                        <h4>
                            <?=$item['title']?>
                        </h4>
                    <?php } ?>

                    <?php if ($item['linkURL']) {?>
                                </a>
                    <?php } ?>
                </li>
                <?php } ?>
            <?php } ?>
            </ul>
        <?php } else { ?>
        <div class="ccm-repeatable-item-placeholder">
            <p><?=t('No Repeatable Items Entered.'); ?></p>
        </div>
        <?php } ?>
    </div>
<?php } ?>
