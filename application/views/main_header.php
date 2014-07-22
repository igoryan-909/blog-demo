<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title><?=$title?></title>
    <meta name="description" content="<?=$description?>" />
	<style type="text/css">
		h1 {font-size: 24px;}
		h3 {font-size: 20px;}
        .error {color: red;}
        .success {color: #006200;}
        .input_label {width: 100px;display: inline-block;vertical-align: top;}
	</style>
</head>
<body>
<div id="container" style="margin: 0 auto;max-width: 700px;">
    <div>
        <a href="<?=base_url()?>"><?=$this->lang->line('posts')?></a> | <a href="<?=base_url()?>add_post"><?=$this->lang->line('add_post')?></a> | <a href="<?=base_url()?>settings"><?=$this->lang->line('settings')?></a>
    </div>
    <div class="logo" style="margin: 15px 0;"><a href="<?=base_url()?>" style="text-decoration: none;font-size: 28px; color: #CEA822; font-weight: bold;"><?=$this->lang->line('blog')?></a></div>