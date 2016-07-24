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
        <div class="form-group">
            <label><?=t('Title');?></label>
            <input name="<?=$view->field('title'); ?>[]" type="text" value="<%=title%>" />
        </div>
        <input class="repeatable-element-entry-sort" name="<?=$view->field('sortOrder');?>[]" type="hidden" value="<%=sort_order%>"/>
    </div>
</script>

<!--FORM FUNCTIONALITY-->
<script>
 $(document).ready(function() {
     var entriesContainer = $('.repeatable-element-entries');
     var entriesTemplate = _.template($('#entryTemplate').html());

     $('.add-repeatable-element-entry').click(function() {
         entriesContainer.append(entriesTemplate({
             title: '',
             sort_order: ''
         }));
         doSortCount();
     });

     var doSortCount = function() {
         $('.repeatable-element-entry').each(function(index) {
             $(this).find('.repeatable-element-entry-sort').val(index);
         });
     };
 });

</script>
