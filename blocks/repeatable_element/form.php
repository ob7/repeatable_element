<?php defined('C5_EXECUTE') or die("Access Denied.");?>

<div class="repeatable-elements-container">
    <div class="repeatable-element-entries">
        <!-- REPEATABLE DYNAMIC ELEMENT ITEMS WILL BE LOADED INTO HERE -->
    </div>
    <div>
        <button type="button" class="btn btn-success add-repeatable-element-entry"> <?=t('Add Item')?> </button>
    </div>
</div>



<!-- THE TEMPLATE WE'LL USE FOR EACH ITEM -->
<script type="text/template" id="entryTemplate">
    <div class="repeatable-element-entry">
        <!-- Title -->
        <div class="form-group">
            <label><?=t('Title');?></label>
            <input class="form-control" name="<?=$view->field('title'); ?>[]" type="text" value="<%=title%>" />
        </div>
        <button type="button" class="btn btn-danger remove-repeatable-element-entry"> <?=t('Delete')?> </button>

        <!--Sort Order-->
        <input class="repeatable-element-entry-sort" name="<?=$view->field('sortOrder');?>[]" type="hidden" value="<%=sort_order%>"/>
    </div>
</script>



<!--FORM FUNCTIONALITY-->
<script>
 $(document).ready(function() {
     var entriesContainer = $('.repeatable-element-entries');
     var entriesTemplate = _.template($('#entryTemplate').html());

     // Add item
     $('.add-repeatable-element-entry').click(function() {
         entriesContainer.append(entriesTemplate({
             title: '',
             sort_order: ''
         }));

         var newSlide = $('.repeatable-element-entry').last();
         attachDelete(newSlide.find('.remove-repeatable-element-entry'));
         doSortCount();
     });

     // Remove item function
     var attachDelete = function($obj) {
         $obj.click(function() {
             $(this).closest('.repeatable-element-entry').remove();
             doSortCount();
         });
     };

     // Sort items
     var doSortCount = function() {
         $('.repeatable-element-entry').each(function(index) {
             $(this).find('.repeatable-element-entry-sort').val(index);
             console.log("SORTED");
         });
     };

     <?php if($items) {
         foreach ($items as $item) { ?>
             entriesContainer.append(entriesTemplate({
                 title: '<?=$item['title']?>',
                 sort_order: '<?=$item['sortOrder']?>'
             }));
         <?php }
     } ?>
     attachDelete($('.remove-repeatable-element-entry'));
     doSortCount();
 });

</script>

<style>
 .repeatable-element-entry {
     padding: 16px;
     border-radius: 4px;
     background: #F5F5F5;
     border: 1px solid #E3E3E3;
     margin-bottom: 10px;
 }
</style>
