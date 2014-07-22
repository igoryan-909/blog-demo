
<?foreach ($posts as $post):?>
<h2><a href="<?=base_url()?>post/<?=$post->post_url?>"><?=$post->post_subject?></a></h2>
<p><?=excerpt($post->post_content, base_url(). 'post/' . $post->post_url);?></p>
<p style="margin: 0;"><?=$this->lib_date->format_date($post->post_add_date);?></p>
<h5><?=total_comments($post->post_id)?> <?=$this->lib_declension->regex_num(total_comments($post->post_id), 'comments_num')?></h5>
    <?foreach(blog_comments($post->post_id) as $comment):?>
    <div class="comment_block" style="margin-left: 40px;">
        <p style="font-weight: bold;margin-bottom: 10px;"><?=$comment->post_comment_author;?></p>
        <p style="margin: 5px 0 0 30px;"><?=$comment->post_comment_content;?></p>
        <p style="margin: 0;text-align: right;"><?=$this->lib_date->format_date($comment->post_comment_add_date);?></p>
        <hr />
    </div>
    <?endforeach;?>
<?endforeach;?>
<?if($pagination):?>
<p><?=$pagination?></p>
<?endif?>