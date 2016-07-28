<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
if ($cropImage == 1) {
    $ih = Core::make('helper/image');
}
if ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Repeatable Element view disabled in edit mode.')?></div>
    </div>
	<?php } else if($enableLocations > 0) { ?>
	<div class="repeatable-element-container locations">
		<ul>
				<?php foreach($items as $item) {
				?>
				<li data-location-address1="<?=$item['addressLine1']?>" data-location-address2="<?=$item['addressLine2']?>" data-location-city="<?=$item['city']?>" data-location-state="<?=$item['state']?>" data-location-zip="<?=$item['zip']?>" data-location-country="<?=$item['country']?>" data-location-lat="<?=$item['lat']?>" data-location-lng="<?=$item['lng']?>" class="location-map-list">
					<?php if ($enableImage < 1 ) {?>
					<img src="https://maps.googleapis.com/maps/api/streetview?size=600x300&location=<?=$item['lat']?>,<?=$item['lng']?>&heading=151.78&pitch=-0.76&key=AIzaSyC_eOliAR35peqAtdN6NquzIMQinPqwx5Q" alt="">
					<?php } else {
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
					}?>
					<div class="caption">
						<?php if ($item['title'] && $displayTitle > 0) {?>
						<h4>
							<?=$item['title']?>
						</h4>
						<?php } ?>
						<p>
						<?=$item['addressLine1'] ? $item['addressLine1'] . '<br>' : ''?>
						<?=$item['addressLine2'] ? $item['addressLine2'] . '<br>' : ''?>
						<?php if($item['city'] && $item['state'] && $item['zip'] ) {
							echo $item['city'] . ', ' . $item['state'] . '. ' . $item['zip'];
						} else { ?>
							<?=$item['city'] ? $item['city'] : ''?>
							<?=$item['state'] ? $item['state'] : ''?>
							<?=$item['zip'] ? $item['zip'] : ''?>
						<?php } ?>
						<?=$item['country'] ? '<br>' . $item['country'] : ''?>
						</p>
					</div>
			</li>
				<?php } ?>
		</ul>
	</div>
	<? } else { ?>
    <div class="repeatable-element-container">
        <?php if(count($items) > 0) { ?>
            <?php foreach($items as $item) {?>
                <?php if($item['title'] && $displayTitle == 1) { ?>
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
        <?php } else { ?>
        <div class="ccm-repeatable-item-placeholder">
            <p><?=t('No Repeatable Items Entered.'); ?></p>
        </div>
        <?php } ?>
    </div>
<?php } ?>
