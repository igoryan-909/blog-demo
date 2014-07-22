<p style="margin: 0;"><?=$this->lib_date->format_date($post->post_add_date);?></p>
<h2><?=$post->post_subject?></h2>
<p><?=$post->post_content;?></p>
<hr />
<div class="comments">
    <h5><?=total_comments($post->post_id)?> <?=$this->lib_declension->regex_num(total_comments($post->post_id), 'comments_num')?></h5>
    <?php foreach($comments as $comment):?>
    <div class="comment_block">
        <p style="font-weight: bold;margin-bottom: 10px;"><?=$comment->post_comment_author;?></p>
        <p style="margin: 5px 0 0 30px;"><?=$comment->post_comment_content;?></p>
        <p style="margin: 0;text-align: right;"><?=$this->lib_date->format_date($comment->post_comment_add_date);?></p>
        <hr />
    </div>
    <?php endforeach;?>
    <form method="post">
        <fieldset>
            <legend><?=$this->lang->line('add_comment')?></legend>
            <label class="input_label"><?=$this->lang->line('author')?></label>
            <input type="text" name="post_comment_author" value="<?=set_value('post_comment_author')?>" /><br />
            <?php if(form_error('post_comment_author')):?>
            <div class="error"><?=form_error('post_comment_author')?></div>
            <?php endif;?>
            <label class="input_label"><?=$this->lang->line('comment')?></label>
            <textarea name="post_comment_content" cols="40" rows="5"><?=set_value('post_comment_content')?></textarea><br />
            <?php if(form_error('post_comment_content')):?>
            <div class="error"><?=form_error('post_comment_content')?></div>
            <?php endif;?>
            <input type="hidden" name="post_comment_post_id" value="<?=$post->post_id;?>" />
            <input type="submit" name="submit" value="<?=$this->lang->line('send')?>" />
            <?php if($message):?>
            <div class="success"><?=$message?></div>
            <?php endif;?>
        </fieldset>
    </form>
</div>