<?php defined('C5_EXECUTE') or die("Access Denied.");?>

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
                <button type="button" class="btn btn-default edit-repeatable-element-entry" data-item-close-text="<?=t('Collapse Item')?>" data-item-edit-text="<?=t('Edit Item')?>"><?=t('Edit Item');?></button>

                <!-- Move item button-->
                <i class="fa fa-arrows"></i>
            </div>
        </div>

        <!-- Repeatable Content -->
        <div class="repeatable-element-entry-content">
            <hr/>
            <!-- Title -->
            <div class="form-group">
                <label><?=t('Title');?></label>
                <input class="form-control" name="<?=$view->field('title'); ?>[]" type="text" value="<%=title%>" />
            </div>
            <!--Sort Order-->
            <input class="repeatable-element-entry-sort" name="<?=$view->field('sortOrder');?>[]" type="hidden" value="<%=sort_order%>"/>
        </div>

    </div>
</script>



<!--FORM FUNCTIONALITY-->
<script>
 $(document).ready(function() {
     var entriesContainer = $('.repeatable-element-entries');
     var entriesTemplate = _.template($('#entryTemplate').html());

     // Add item button
     $('.add-repeatable-element-entry').click(function() {
         var currentEntries = document.getElementsByClassName('repeatable-element-entry').length + 1;
         entriesContainer.append(entriesTemplate({
             title: '',
             sort_order: '',
             item_number: currentEntries
         }));

         var newSlide = $('.repeatable-element-entry').last();
         attachDelete(newSlide.find('.remove-repeatable-element-entry'));
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

         doSortCount();
     });

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

     // Edit slide button
     $('.repeatable-element-entries').on('click','.edit-repeatable-element-entry', function() {
         $(this).closest('.repeatable-element-entry').toggleClass('item-closed');
         var thisEditButton = $(this).closest('.repeatable-element-entry').find('.edit-repeatable-element-entry');
         if (thisEditButton.data('itemEditText') === thisEditButton.text()) {
             thisEditButton.text(thisEditButton.data('itemCloseText'));
         } else if (thisEditButton.data('itemCloseText') === thisEditButton.text()) {
             thisEditButton.text(thisEditButton.data('itemEditText'));
         }
     });

     // Initial load up of already saved items
     <?php if($items) {
         $itemNumber = 1;
         foreach ($items as $item) { ?>
             entriesContainer.append(entriesTemplate({
                 title: '<?=$item['title']?>',
                 sort_order: '<?=$item['sortOrder']?>',
                 item_number: '<?=$itemNumber?>'
             }));
        <?php
            ++$itemNumber;
        }
     } ?>

     attachDelete($('.remove-repeatable-element-entry'));
     doSortCount();

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
</style>
