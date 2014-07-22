<?php
/**
 * @автор Ivanoff
 * @описание файла: 
 * @изменен 27.12.2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->lang->load('validation_new');
    }
    /**
	 * Вырезаем теги
	 */ 
    function no_tags($str) {
        return htmlspecialchars($str);
    }
    /**
	 * Проверяем, существует ли запись
	 */ 
    function post_exists($str) {
        $CI = &get_instance();
        $where = array(
                        'post_id' => $CI->input->post('post_comment_post_id'),
                        );
        $CI->db->where($where);
        return $CI->db->count_all_results(POSTS_TABLE) == 0 ? FALSE : TRUE;
    }
}
?>