<h1><?=$this->lang->line('add_post')?></h1>
<form method="post">
    <label class="input_label"><?=$this->lang->line('author')?>:</label>
    <input type="text" name="post_author" value="<?=set_value('post_author')?>" /><br />
    <?php if(form_error('post_author')):?>
    <div class="error"><?=form_error('post_author')?></div>
    <?php endif;?>
    <label class="input_label"><?=$this->lang->line('title')?>:</label>
    <input type="text" name="post_title" value="<?=set_value('post_title')?>" /><br />
    <?php if(form_error('post_title')):?>
    <div class="error"><?=form_error('post_title')?></div>
    <?php endif;?>
    <label class="input_label"><?=$this->lang->line('description')?>:</label>
    <input type="text" name="post_description" value="<?=set_value('post_description')?>" /><br />
    <?php if(form_error('post_description')):?>
    <div class="error"><?=form_error('post_description')?></div>
    <?php endif;?>
    <label class="input_label"><?=$this->lang->line('subject')?>:</label>
    <input type="text" name="post_subject" value="<?=set_value('post_subject')?>" /><br />
    <?php if(form_error('post_subject')):?>
    <div class="error"><?=form_error('post_subject')?></div>
    <?php endif;?>
    <label class="input_label"><?=$this->lang->line('content')?>:</label>
    <textarea name="post_content" cols="70" rows="10"><?=set_value('post_content')?></textarea><br />
    <?php if(form_error('post_content')):?>
    <div class="error"><?=form_error('post_content')?></div>
    <?php endif;?>
    <label class="input_label"><?=$this->lang->line('url')?>:</label>
    <input type="text" name="post_url" value="<?=set_value('post_url')?>" /><br />
    <?php if(form_error('post_url')):?>
    <div class="error"><?=form_error('post_url')?></div>
    <?php endif;?>
    <input type="submit" name="submit" value="<?=$this->lang->line('save_post')?>" />
</form>