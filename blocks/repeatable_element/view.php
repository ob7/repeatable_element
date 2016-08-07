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
<?php } else if($enableLocations > 0) {
    $p = 0;
?>
	<div class="repeatable-element-container locations">
		<ul>
				<?php foreach($items as $item) {
				?>
				<li data-title="<?=$item['title']?>" data-location="<?=$p?>" data-address1="<?=$item['addressLine1']?>" data-address2="<?=$item['addressLine2']?>" data-city="<?=$item['city']?>" data-state="<?=$item['state']?>" data-zip="<?=$item['zip']?>" data-country="<?=$item['country']?>" data-lat="<?=$item['lat']?>" data-lng="<?=$item['lng']?>" data-link="<?=$item['locationLink']?>" data-address="<?=$item['fulladdress']?>" class="location-map-list">
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
            <div class="caption-content">
						<?php if ($item['title'] && $displayTitle > 0) {?>
						<h4>
							<?=$item['title']?>
						</h4>
						<?php } ?>
            <?php if ($displayLocationInfoInButton > 0) {?>
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
            <?php } ?>
            <?php if ($item['locationLink'] && $displayLinkInButton > 0) {?>
            <a href="<?=$item['locationLink']?>" target="_blank">
                Get Directions
            </a>
            <?php } ?>
            </div>
					</div>
			</li>
			<?php ++$p;
      } ?>
		</ul>
    <div class="map"></div>
    <script>
     function initMap() {
         var locations = document.getElementsByClassName('location-map-list');
         var startLat = locations[0].dataset.lat;
         var startLng = locations[0].dataset.lng;

         var map = new GMaps({
             div: '.map',
             lat: startLat,
             lng: startLng,
             scrollwheel: false,
             draggable: true,
             zoom: 12, //add zoom level to map settings instead...
             styles: [{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}]
         });

         for (i = 0; i < locations.length; i++) {
             var mapLat = locations[i].dataset.lat;
             var mapLng = locations[i].dataset.lng;
             var mapURL = locations[i].dataset.link;
             var title = locations[i].dataset.title;
             var address = locations[i].dataset.address;
             map.addMarker({
                 lat: mapLat,
                 lng: mapLng,
                 url: mapURL,
                 infoWindow: {
                     content: '<div class="map-info-window"><h3>' + title + '</h3>' + '<p>' + address + '<br>' + '<a href="' + mapURL + '" target="_blank">Open in Google Maps</a>' + '</div>'
			           }
             });

             /* google.maps.event.addListener(map.markers[i], 'click', function() {*/
             /* window.open(*/
             /* this.url,*/
             /* '_blank'*/
             /* );*/
             /* });*/

         }

         $('.location-map-list').on('click', function() {
             $(".location-map-list").removeClass("active");
             $(this).addClass("active");
             var thisLocation = $(this).data('location');
             var marker = map.markers[thisLocation];
             var markerPos = map.markers[thisLocation].getPosition();
             var markerLat = markerPos.lat();
             var markerLng = markerPos.lng();
             google.maps.event.trigger(marker, 'click');
             map.setCenter(markerLat, markerLng);
         });

     }
		</script>
	</div>
	<? } else { ?>
    <?php if($enableHamburger == 'yes'){?>
    <div class="hamburger-menu">
    <div class="hamburger-icons-container">
        <div class="hamburger-icons">
        <div class="hamburger-close-icon">
            <div class="icon-close">
            </div>
        </div>
        <div class="hamburger-menu-icon">
            <div class="icon-menu">
            </div>
            <div class="title">
            Menu
            </div>
        </div>
        </div>
    </div>
    <?}?>

    <?php if($enableHamburger == 'no'){?>
    <div class="repeatable-element-container <?=$enableHamburger > 0 ? 'hamburger-menu' : ''?> <?=$enableSlideshow > 0 ? 'cycle-slideshow-container' : ''?>">
    <?php } ?>
        <?php if(count($items) > 0) { ?>
            <ul
                <?php if ($enableHamburger == 'yes' && $enableLinks > 0){?>
                class="nav"
                <?php } else { ?>
                class="repeatable-list <?=$customContainerClass ? $customContainerClass : ''?> <?=$enableSlideshow > 0 ? 'cycle-slideshow' : 'menu-list'?>"
                <?php if($enableSlideshow > 0) {?>
                data-cycle-slides="li"
                data-cycle-pager=".pager"
                data-cycle-auto-height="container"
                <?php } ?>
                <?php if($image) {?>
                style="background-image: url('<?=$image->src?>');"
                <?php } ?>
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
                    <?php if ($item['linkURL'] && $enableLinks > 0) {?>
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

                    <?php if ($item['description']) {?>
                        <div class="description">
                            <?=$item['description']?>
                        </div>
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
