<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Получаем комментарии к указанной записи
 */
if( ! function_exists('blog_comments'))
{
    function blog_comments($post_id)
    {
        $CI = &get_instance();
        $where = array('post_comment_post_id' => $post_id);
        return $CI->Blog_model->get_comments($where);
    }
}
/**
 * Получаем количество комментариев к указанной записи
 */
if( ! function_exists('total_comments'))
{
    function total_comments($post_id)
    {
        $CI = &get_instance();
        $where = array('post_comment_post_id' => $post_id);
        return $CI->Blog_model->total_comments($where);
    }
}
/**
 * Выводим анонс, обрезаем текст в соответствии с настройками
 */
if( ! function_exists('excerpt'))
{
    function excerpt($post_content, $post_url)
    {
        $CI = &get_instance();
        $characters = $CI->Blog_model->get_setting('excerpt_characters'); // Получаем кол-во символов, после которых нужно обрезать
        if(mb_strlen($post_content, 'UTF-8') > $characters)
        {
            $post_content = mb_substr($post_content, 0, $characters, 'UTF-8');
            $post_content = mb_substr($post_content, 0, mb_strrpos($post_content, ' ', 0, 'UTF-8'), 'UTF-8'); //Находим пробел с конца обрезанного текста, после которого обрезаем остаток
            $post_content .= '... <a href="' . $post_url . '">' . $CI->lang->line('read_more') .'</a>';
            $post_content = nl2br($post_content);
        }
        return $post_content;
    }
}