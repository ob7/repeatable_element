<?php defined('C5_EXECUTE') or die("Access Denied.");

$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
$al = Core::make('helper/concrete/asset_library');

echo Core::make('helper/concrete/ui')->tabs(array(
    array('items', t('Items'), true),
    array('options', t('Options')),
    array('layouts', t('Layout'))
));

if(!$cropWidth) {
    $cropWidth = 200;
}
if(!$cropHeight) {
    $cropHeight = 200;
}
?>

<div class="ccm-tab-content" id="ccm-tab-content-items">
    <div class="repeatable-elements-container">
        <div class="repeatable-elements-controls">
            <button type="button" data-expand-text="Expand All" data-collapse-text="Collapse All" class="btn btn-default edit-all-items"><?=t('Expand All')?></button>
        </div>
        <div class="repeatable-element-entries">
            <!-- REPEATABLE DYNAMIC ELEMENT ITEMS WILL BE APPENDED INTO HERE -->
        </div>
        <div>
            <button type="button" class="btn btn-success add-repeatable-element-entry"> <?=t('Add Item')?> </button>
        </div>
    </div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-options">
    <label class="control-label"><?=t('Display Title?');?></label>
    <div class="option-box" data-option=".display-title">
        <select id="toggleTitle" class="form-control" name="displayTitle">
            <option <?=$displayTitle == 0 ? 'selected' : '';?> value="0"><?=t('No')?></option>
            <option <?=$displayTitle == 1 ? 'selected' : '';?> value="1"><?=t('Yes')?></option>
        </select>
    </div>
    <label class="control-label"><?=t('Static Image');?></label>
    <div class="option-box" data-option=".static-image">
        <div class="form-group">
            <?=$al->image('ccm-b-image', 'sfID', t('Choose Image'), $bf);?>
        </div>
    </div>
    <label class="control-label"><?=t('Enable Images?');?></label>
    <div class="option-box" data-option=".enable-image">
        <div class="option-box-row">
            <select class="form-control top-option" name="enableImage" id="toggleImage">
                <option <?=$enableImage == 0 ? 'selected' : ''?> value="0"><?=t('No')?></option>
                <option <?=$enableImage == 1 ? 'selected' : ''?> value="1"><?=t('Yes')?></option>
            </select>
            <button type="button" class="btn btn-default option-button <?=$enableImage == 0 ? 'disabled' : '';?>">Options</button>
        </div>
        <div class="option-box-options image-options <?=$enableImage == 0 || !$enableImage ? 'disabled' : 'disabled'; ?>">
            <hr/>
            <label class="control-label"><?=t('Resize Images?');?></label>
            <select class="form-control" name="cropImage" id="toggleCrop">
                <option <?=$cropImage == 0 ? 'selected' : ''?> value="0"><?=t('No')?></option>
                <option <?=$cropImage == 1 ? 'selected' : ''?> value="1"><?=t('Yes')?></option>
            </select>
            <div class="crop-options <?=$cropImage == 0 ? 'disabled' : ''?>">
                <label class="control-label"><?=t('Width');?></label>
                <input class="form-control" name="cropWidth" type="text" value="<?=$cropWidth?>"/>

                <label class="control-label"><?=t('Height');?></label>
                <input class="form-control" name="cropHeight" type="text" value="<?=$cropHeight?>"/>

                <label class="control-label"><?=t('Crop to dimensions?');?></label>
                <select class="form-control" name="crop">
                    <option <?=$crop ? '' : 'selected'?> value="0">No</option>
                    <option <?=$crop ? 'selected' : ''?> value="1">Yes</option>
                </select>
            </div>
        </div>
    </div>
    <label class="control-label"><?=t('Enable Slideshow?');?></label>
    <div class="option-box" data-option=".enable-image">
        <select class="form-control top-option" name="enableSlideshow" id="toggleSlideshow">
            <option <?=$enableSlideshow == 0 ? 'selected' : ''?> value="0"><?=t('No')?></option>
            <option <?=$enableSlideshow == 1 ? 'selected' : ''?> value="1"><?=t('Yes')?></option>
        </select>
    </div>
    <label class="control-label"><?=t('Enable Links?');?></label>
    <div class="option-box" data-option=".links-form">
        <select class="form-control top-option" name="enableLinks" id="toggleLinks">
            <option <?=$enableLinks == 0 ? 'selected' : ''?> value="0"><?=t('No')?></option>
            <option <?=$enableLinks == 1 ? 'selected' : ''?> value="1"><?=t('Yes')?></option>
        </select>
    </div>
    <div class="option-box" data-option=".location-item-form">
        <label class="control-label"><?=t('Enable Locations?');?></label>
        <select id="toggleLocations" class="form-control top-option" name="enableLocations">
            <option <?=$enableLocations == 0 ? 'selected' : '';?> value="0"><?=t('No')?></option>
            <option <?=$enableLocations == 1 ? 'selected' : '';?> value="1"><?=t('Yes')?></option>
        </select>
    </div>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-layouts">
	<div class="layout-item">
		<h4><?=t('Generic Options')?></h4>
		<hr>
		<label class="control-label"><?=t('Custom Container Class')?></label>
    <input class="form-control" name="customContainerClass" type="text" value="<?=$customContainerClass?>"/>
	</div>
	<div class="layout-item">
		<h4><?=t('Locations Layout')?></h4>
		<hr>
		<label class="control-label"><?=t('Location List Position')?></label>
		<select class="form-control" id="toggleLayoutLocations" name="layoutLocations">
			<option <?=$layoutLocations == 'none' ? 'selected' : ''?> value="none">None</option>
			<option <?=$layoutLocations == 'left' ? 'selected' : ''?> value="left">Left Layout</option>
		</select>
	</div>
	<div class="links-item">
		<h4><?=t('Links Layout')?></h4>
		<hr>
		<label class="control-label"><?=t('Enable Hamburger Menu?')?></label>
		<select class="form-control" id="toggleLayoutLinks" name="enableHamburger">
			<option <?=$enableHamburger == 'no' ? 'selected' : ''?> value="no">No</option>
			<option <?=$enableHamburger == 'yes' ? 'selected' : ''?> value="yes">Yes</option>
		</select>
	</div>
</div>

<script>
 $('.option-box select.top-option').click(function() {
     value = $(this).find('option:selected').val();
     item = $(this).closest('.option-box').data('option');
     console.log("ITEM IS " + item);
     if (value == 1) {
         $(this).closest('.option-box').find('button').removeClass('disabled');
         $(item).show();
     } else if (value == 0) {
         $(this).parent().find('button').addClass("disabled");
         $(item).hide();
         $(this).closest('.option-box').find('.option-box-options').addClass('disabled');
     }
     console.log("VALUE IS " + value);
 });
 $(".option-button").click(function() {
     $(this).parent().parent().find('.option-box-options').toggleClass("disabled");
 });

</script>


<!-- THE TEMPLATE USED FOR EACH ITEM -->
<script type="text/template" id="entryTemplate">
    <div class="repeatable-element-entry item-closed">
        <div class="repeatable-element-entry-row">
            <!--Item # Title -->
            <div class="repeatable-element-entry-row-title">
                <h4>Item #<span class="item-number"><%=item_number%></span></h4> :: <p>(<%=title%>)</p>
            </div>
            <!-- Item Controls -->
            <div class="repeatable-element-entry-controls">
                <!-- Delete Button -->
                <button type="button" class="btn btn-danger remove-repeatable-element-entry"> <?=t('Delete')?> </button>
                <!-- Edit Button -->
                <button type="button" class="btn btn-default edit-repeatable-element-entry" data-item-close-text="<?=t('Collapse Details')?>" data-item-edit-text="<?=t('Edit Details')?>"><?=t('Edit Details');?></button>

                <!-- Edit Image-->
                <div class="form-group enable-image <%=enable_image > 0 ? '' : 'disabled' %>">
                    <label><?=t('Image');?></label>
                    <div class="repeatable-element-image">
                        <% if(image_url.length > 0) { %>
                        <img src="<%=image_url%>"/>
                        <% } else { %>
                        <i class="fa fa-picture-o"></i>
                        <% } %>
                    </div>
                    <input name="<?=$view->field('fID')?>[]" type="hidden" class="repeatable-element-fID" value="<%=fID%>"/>
                </div>
                <!-- Move item button-->
                <i class="fa fa-arrows"></i>
            </div>
        </div>

        <!-- Repeatable Content -->
        <div class="repeatable-element-entry-content">
            <hr/>
            <!-- Title -->
            <div style="<%=display_title > 0 ? '' : 'display:none;' %>" class="item-data-area title-item-form">
                <div class="form-group">
                    <label class="control-label"><?=t('Title');?></label>
                    <input class="form-control" name="<?=$view->field('title'); ?>[]" type="text" value="<%=title%>" />
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label><?=t('Content');?></label>
                <div class="redactor-edit-content">
                    <textarea style="display: none;" class="redactor-content" name="<?=$view->field('description');?>[]"><%=description%></textarea>
                </div>
            </div>

            <!-- Locations -->
            <div style="<%=enable_locations > 0 ? '' : 'display: none;'%>" data-option="location" class="item-data-area location-item-form">
                <label class="control-label"><?=t('Location')?></label>
                <hr/>
                <div class="form-group">
                    <label><?=t('Address Line #1')?></label>
                    <input class="form-control" name="<?=$view->field('addressLine1')?>[]" type="text" value="<%=address_line1%>"/>
                </div>
                <div class="form-group">
                    <label><?=t('Address Line #2')?></label>
                    <input class="form-control" name="<?=$view->field('addressLine2')?>[]" type="text" value="<%=address_line2%>"/>
                </div>
                <div class="form-group">
                    <label><?=t('City')?></label>
                    <input class="form-control" name="<?=$view->field('city')?>[]" type="text" value="<%=city%>"/>
                </div>
                <div class="form-group">
                    <label><?=t('State')?></label>
                    <input class="form-control" name="<?=$view->field('state')?>[]" type="text" value="<%=state%>"/>
                </div>
                <div class="form-group">
                    <label><?=t('Zip')?></label>
                    <input class="form-control" name="<?=$view->field('zip')?>[]" type="text" value="<%=zip%>"/>
                </div>
                <div class="form-group">
                    <label><?=t('Country')?></label>
                    <input class="form-control" name="<?=$view->field('country')?>[]" type="text" value="<%=country%>"/>

                    <input name="<?=$view->field('lat')?>[]" type="hidden" value="<%=lat%>"/>
                    <input name="<?=$view->field('lng')?>[]" type="hidden" value="<%=lat%>"/>
                </div>
                <div class="form-group">
                    <label><?=t('Marker Link')?></label>
                    <input class="form-control" name="<?=$view->field('locationLink')?>[]" type="text" value="<%=location_link%>"/>
                </div>
            </div>

            <!-- Link -->
            <div class="links-form" <%=enable_links < 1 ? 'style="display: none;"' : ''%>>
                <div class="form-group">
                    <label><?=t('Link');?></label>
                    <select name="linkType[]" class="form-control" data-field="entry-link-select">
                        <option <%if (!link_type) {%>selected<% }%> value="0"><?=t('None')?></option>
                        <option <%if (link_type == 1) {%>selected<% }%> value="1"><?=t('Another Page')?></option>
                        <option <%if (link_type == 2) {%>selected<% }%> value="2"><?=t('External Link')?></option>
                    </select>
                </div>
                <div data-field="entry-link-url" class="form-group hide-slide-link">
                    <label><?=t('URL:')?></label>
                    <textarea name="linkURL[]"><%=link_url%></textarea>
                </div>
                <div data-field="entry-link-page-selector" class="form-group hide-slide-link">
                    <label><?=t('Choose Page:')?></label>
                    <div data-field="entry-link-page-selector-select"></div>
                </div>
            </div>

            <!--Sort Order-->
            <input class="repeatable-element-entry-sort" name="<?=$view->field('sortOrder');?>[]" type="hidden" value="<%=sort_order%>"/>
        </div>

    </div>
</script>



<!--FORM FUNCTIONALITY-->
<script>
 $(document).ready(function() {
     var ccmReceivingEntry = '';
     var entriesContainer = $('.repeatable-element-entries');
     var entriesTemplate = _.template($('#entryTemplate').html());

     // Add item button
     $('.add-repeatable-element-entry').click(function() {
         var currentEntries = document.getElementsByClassName('repeatable-element-entry').length + 1;
         entriesContainer.append(entriesTemplate({
             title: '',
             fID: '',
             image_url: '',
             sort_order: '',
             item_number: currentEntries,
             enable_image: enable_image,
             enable_links: enable_links,
             address_line1: '',
             address_line2: '',
             city: '',
             state: '',
             zip: '',
             country: '',
             location_link: '',
             enable_locations: location_enable,
             display_title: title_display,
             lat: '',
             lng: '',
             link_url: '',
             cID: '',
             link_type: 0,
             description: '',
         }));

         var newSlide = $('.repeatable-element-entry').last();
         attachDelete(newSlide.find('.remove-repeatable-element-entry'));
         attachFileManagerLaunch(newSlide.find('.repeatable-element-image'));
         var closeText = newSlide.find('.edit-repeatable-element-entry').data('itemCloseText');
         $('.repeatable-element-entry').not('.item-closed').each(function() {
             $(this).addClass('item-closed');
             var thisEditButton = $(this).closest('.repeatable-element-entry').find('.edit-repeatable-element-entry');
             thisEditButton.text(thisEditButton.data('itemEditText'));
         });
         newSlide.removeClass('item-closed').find('.edit-repeatable-element-entry').text(closeText);

         //Move to newest added item
         var thisModal = $(this).closest('.ui-dialog-content');
         var modalHeight = thisModal.find('.ccm-ui').height();
         var scrollPosition = modalHeight;
         $(thisModal).animate({ scrollTop: scrollPosition }, "slow");

         // Ensure edit all button is toggled to original state
         var editAll = $('.edit-all-items');
         editAll.text(editAll.data('expandText'));

         // Initiate Link Page Selector
         newSlide.find('div[data-field=entry-link-page-selector-select]').concretePageSelector({
             'inputName': 'internalLinkCID[]'
         });

         // Initiate new items redactor
         newSlide.find('.redactor-content').redactor({
             minHeight: 200,
             'concrete5': {
                 filemanager: <?=$fp->canAccessFileManager();?>,
                 sitemap: <?=$tp->canAccessSitemap();?>,
                 lightbox: true
             }
         });

         doSortCount();
     });

     // Image selector
     var attachFileManagerLaunch = function($obj) {
         $obj.click(function() {
             var oldLauncher = $(this);
             ConcreteFileManager.launchDialog(function(data) {
                 ConcreteFileManager.getFileDetails(data.fID, function(r) {
                     jQuery.fn.dialog.hideLoader();
                     var file = r.files[0];
                     oldLauncher.html(file.resultsThumbnailImg);
                     oldLauncher.next('.repeatable-element-fID').val(file.fID);
                 });
             });
         });
     }

     // Remove item function
     var attachDelete = function($obj) {
         $obj.click(function() {
             $(this).closest('.repeatable-element-entry').remove();
             doSortCount();
         });
     };

     // Move item
     $('.repeatable-element-entries').sortable({
         placeholder: "ui-state-highlight",
         axis: "y",
         handle: "i.fa-arrows",
         cursor: "move",
         update: function() {
             doSortCount();
         }
     });

     // Sort items
     var doSortCount = function() {
         $('.repeatable-element-entry').each(function(index) {
             $(this).find('.repeatable-element-entry-sort').val(index);
             $(this).find('.item-number').html(index+1); // item_number simply gives each item a number in the form for user reference, it does not save to database
         });
     };

     // Edit item button
     $('.repeatable-element-entries').on('click','.edit-repeatable-element-entry', function() {
         $(this).closest('.repeatable-element-entry').toggleClass('item-closed');
         var thisEditButton = $(this).closest('.repeatable-element-entry').find('.edit-repeatable-element-entry');
         if (thisEditButton.data('itemEditText') === thisEditButton.text()) {
             thisEditButton.text(thisEditButton.data('itemCloseText'));
         } else if (thisEditButton.data('itemCloseText') === thisEditButton.text()) {
             thisEditButton.text(thisEditButton.data('itemEditText'));
         }
     });

     // Update link type
     entriesContainer.on('change', 'select[data-field=entry-link-select]', function() {
         var container = $(this).closest('.repeatable-element-entry');
         switch (parseInt($(this).val())) {
             case 2:
                 container.find('div[data-field=entry-link-page-selector]').addClass('hide-slide-link').removeClass('show-slide-link');
                 container.find('div[data-field=entry-link-url]').addClass('show-slide-link').removeClass('hide-slide-link');
                 break;
             case 1:
                 container.find('div[data-field=entry-link-url]').addClass('hide-slide-link').removeClass('show-slide-link');
                 container.find('div[data-field=entry-link-page-selector]').addClass('show-slide-link').removeClass('hide-slide-link');
                 break;
             default:
                 container.find('div[data-field=entry-link-page-selector]').addClass('hide-slide-link').removeClass('show-slide-link');
                 container.find('div[data-field=entry-link-url]').addClass('hide-slide-link').removeClass('show-slide-link');
                 break;
         }
     });

     // Initial load up of already saved items
     <?php if($items) {
         $itemNumber = 1;
         foreach ($items as $item) {
             $linkType = 0;
             if ($item['linkURL']) {
                 $linkType = 2;
             } else if ($item['internalLinkCID']) {
                 $linkType = 1;
             }
     ?>
             entriesContainer.append(entriesTemplate({
                 title: '<?=$item['title']?>',
                 fID: '<?=$item['fID']?>',
                 <?php if (File::getByID($item['fID'])) { ?>
                 image_url: '<?php echo File::getByID($item['fID'])->getThumbnailURL('file_manager_listing');?>',
                 <?php } else { ?>
                 image_url: '',
                 <?php } ?>
                 link_url: '<?=$item['linkURL']; ?>',
                 link_type: '<?=$linkType?>',
                 description: '<?php echo str_replace(array("\t", "\r", "\n"), "", addslashes(h($item['description']))); ?>',

                 sort_order: '<?=$item['sortOrder']?>',
                 item_number: '<?=$itemNumber?>',
                 enable_image: <?=$enableImage?>,
                 enable_links: <?=$enableLinks?>,
                 enable_locations: <?=$enableLocations?>,
                 address_line1: '<?=$item['addressLine1']?>',
                 address_line2: '<?=$item['addressLine2']?>',
                 city: '<?=$item['city']?>',
                 state: '<?=$item['state']?>',
                 zip: '<?=$item['zip']?>',
                 country: '<?=$item['country']?>',
                 location_link: '<?=$item['locationLink']?>',
                 display_title: <?=$displayTitle?>,
                 lat: '<?=$item['lat']?>',
                 lng: '<?=$item['lng']?>'
             }));
            // Append page selector
            entriesContainer.find('.repeatable-element-entry:last-child div[data-field=entry-link-page-selector]').concretePageSelector({
                'inputName': 'internalLinkCID[]', 'cID': <?php if ($linkType == 1) { ?><?php echo intval($item['internalLinkCID']); ?><?php } else { ?>false<?php } ?>
            });

        <?php
            ++$itemNumber;
        }
     } ?>

     attachDelete($('.remove-repeatable-element-entry'));
     attachFileManagerLaunch($('.repeatable-element-image'));
     entriesContainer.find('select[data-field=entry-link-select]').trigger('change');
     doSortCount();

     // Initialize redactors for descriptions
     $(function() {
         $('.redactor-content').redactor({
             minHeight: 200,
             'concrete5': {
                 filemanager: <?=$fp->canAccessFileManager();?>,
                 sitemap: <?=$tp->canAccessSitemap();?>,
                 lightbox: true
             }
         });
     });

 });

    //Extra functionalities
    //Expand or close all items
     $('.edit-all-items').on('click', function() {
         var thisButton = $('.edit-all-items');
         if (thisButton.data('expandText') === thisButton.text()) {
             $('.repeatable-element-entry').removeClass('item-closed');
             thisButton.text(thisButton.data('collapseText'));
             var closeText = $('.edit-repeatable-element-entry').data('itemCloseText');
             $('.edit-repeatable-element-entry').text(closeText);
         } else if (thisButton.data('collapseText') === thisButton.text()) {
             $('.repeatable-element-entry').addClass('item-closed');
             thisButton.text(thisButton.data('expandText'));
             var editText = $('.edit-repeatable-element-entry').data('itemEditText');
             $('.edit-repeatable-element-entry').text(editText);
         };
     });

 // Enable or disable elements
     <?php if ($enableImage) {  ?>
     var enable_image = <?=$enableImage?>;
     <? } else { ?>
     var enable_image = 0;
     <?php } ?>

     <?php if ($enableLinks) {  ?>
     var enable_links = <?=$enableLinks?>;
     <? } else { ?>
     var enable_links = 0;
     <?php } ?>

     <?php if ($displayTitle == 1) {  ?>
     var title_display = 1
     <? } else if ($displayTitle == 0) { ?>
     var title_display = 0;
     <?php } ?>
     console.log("TITLE DISPLAY IS " + title_display);
     console.log("DISPLAY TITLE IS <?=$displayTitle?>");


// Toggle images
 $('#toggleImage').click(function() {
     var enableImage = $('#toggleImage option:selected').val();
     console.log("Image toggled value is " + enableImage);
     if (enableImage == 0) {
         enable_image = 0;
     } else if (enableImage == 1) {
         enable_image = 1;
     }
 });
// Toggle links
 $('#toggleLinks').click(function() {
     var enableLinks = $('#toggleImage option:selected').val();
     var linksForm = $('.links-form');
     if (enableLinks == 0) {
         enable_links = 0;
     } else if (enableLinks == 1) {
         enable_links = 1;
     }
 });
// Toggle title
 $('#toggleTitle').click(function() {
     var displayTitle = $('#toggleTitle option:selected').val();
     var itemForm = $('.title-item-form');
     if (displayTitle == 0) {
         title_display = 0;
        $(itemForm).hide();
     } else if (displayTitle == 1) {
         title_display = 1;
        $(itemForm).show();
     }
 });
// Toggle locations
 <?php if ($enableLocations > 0) {?>
    var location_enable = <?=$enableLocations?>;
 <?php } else { ?>
  var location_enable = 0;
 <?php } ?>
 $('#toggleLocations').click(function() {
     var enableLocations = $('#toggleLocations option:selected').val();
     if (enableLocations == 0) {
        location_enable = 0;
     } else if (enableLocations == 1) {
        location_enable = 1;
     }
 });

// Toggle crop
 $('#toggleCrop').click(function() {
     var enableCrop = $('#toggleCrop option:selected').val();
     if (enableCrop == 0) {
         $('.crop-options').addClass("disabled");
     } else if (enableCrop == 1) {
         $('.crop-options').removeClass("disabled");
     }
 });
 </script>


<!-- FORM STYLES -->
<style>
 .repeatable-element-entry {
     padding: 16px;
     border-radius: 4px;
     background: #F5F5F5;
     border: 1px solid #E3E3E3;
     margin-bottom: 10px;
 }
 .repeatable-element-entry-row {
     display: flex;
     flex-direction: row;
     justify-content: space-between;
     align-items: center;
 }
 .repeatable-element-entry-row h4 {
     margin: 0;
}
 .repeatable-element-entry.item-closed {
     /* opacity: .5; */
 }
 .repeatable-element-entry.item-closed .repeatable-element-entry-content {
     display: none;
 }
 .repeatable-elements-controls {
     border-bottom: 1px solid #E3E3E3;
     padding-bottom: 10px;
     margin-bottom: 16px;
 }
 .repeatable-element-entry-row-title h4 {
     display: inline-block;
 }
 .repeatable-element-entry-row-title p {
     display: inline-block;
 }
 .repeatable-element-entries i {
     transition: all .5s ease-in-out;
 }
 .repeatable-element-entries i:hover {
     color: #428bca;
 }
 .repeatable-element-entries i.fa-arrows {
     padding: 5px;
     font-size: 20px;
     cursor: move;
 }
 .repeatable-element-entries .ui-state-highlight {
     height: 94px;
     margin-bottom: 15px;
 }
 .repeatable-element-entries .ui-sortable-helper {
     -webkit-box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
     -moz-box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
     box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
 }
 .repeatable-element-image {
        padding: 5px;
        cursor: pointer;
        background: #dedede;
        border: 1px solid #cdcdcd;
        text-align: center;
        vertical-align: middle;
        width: 72px;
        height: 72px;
        display: table-cell;
 }
 .repeatable-element-image:hover i.fa  {
     color: #428bca;
 }
 .repeatable-element-entry-controls {
     display: flex;
     flex-direction: row;
     align-items: center;
 }
 .repeatable-element-entry-controls .form-group {
     margin-left: 10px;
 }
 .form-group.disabled {
     display: none;
 }
 .image-options.disabled {
     display: none;
 }
 .crop-options.disabled {
     display: none;
 }
 @media only screen and (min-width: 992px) {
     .repeatable-element-entry-controls {
         width: 30%;
         min-width: 320px;
         justify-content: space-between;
     }
     .repeatable-element-entry-controls .form-group {
         margin-left: 0;
     }
 }

 .option-box {
     padding: 16px;
     border-radius: 4px;
     background: #F5F5F5;
     border: 1px solid #E3E3E3;
     margin-bottom: 10px;
 }
 .option-box-row {
     display: flex;
     flex-row;
 }
 .option-button {
     margin-left: 10px !important;
 }
 .redactor_editor {
     padding: 20px;
 }
 .repeatable-element-entry .show-slide-link {
     display: block;
 }
 .repeatable-element-entry .hide-slide-link {
     display: none;
 }

 .repeatable-element-entry input[type="text"],
 .repeatable-element-entry textarea {
     display: block;
     width: 100%;
 }
 .layout-item {
     padding: 16px;
     border-radius: 4px;
     background: #F5F5F5;
     border: 1px solid #E3E3E3;
     margin-bottom: 10px;
 }
 .item-data-area {
     background-color: #110B14;
     background-color: #202020;
     color: #CCC;
     padding: 10px;
     margin-bottom: 10px;
     border-radius: 10px;
     border: 1px solid #ABCEFD;
 }
 .item-data-area label.control-label{
     color: #B8E9CB;
     color: #ABCEFD;
     font-size: 20px;
 }
 .item-data-area hr {
     border-color: #ADCEFD;
     margin-top: 10px;
     margin-bottom: 10px;
 }
</style>
