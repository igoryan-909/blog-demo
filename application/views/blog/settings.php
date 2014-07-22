<h1><?=$this->lang->line('blog_settings')?></h1>
<form method="post">
    <label class="input_label"><?=$this->lang->line('site_name')?>:</label>
    <input type="text" name="site_name" value="<?=set_value('site_name', $settings->site_name)?>" /><br />
    <?if(form_error('site_name')):?>
    <div class="error"><?=form_error('site_name')?></div>
    <?endif;?>
    <label class="input_label"><?=$this->lang->line('posts_per_page')?>:</label>
    <input type="text" name="posts_per_page" value="<?=set_value('posts_per_page', $settings->posts_per_page)?>" /><br />
    <?if(form_error('posts_per_page')):?>
    <div class="error"><?=form_error('posts_per_page')?></div>
    <?endif;?>
    <label class="input_label"><?=$this->lang->line('excerpt_characters')?>:</label>
    <input type="text" name="excerpt_characters" value="<?=set_value('excerpt_characters', $settings->excerpt_characters)?>" /><br />
    <?if(form_error('excerpt_characters')):?>
    <div class="error"><?=form_error('excerpt_characters')?></div>
    <?endif;?>
    <input type="submit" name="submit" value="<?=$this->lang->line('save')?>" />
    <?if($message):?>
    <div class="success"><?=$message?></div>
    <?endif;?>
</form>