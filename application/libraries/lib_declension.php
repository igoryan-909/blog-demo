<?php
/**
 * @автор Ivanoff
 * @описание файла: 
 * @изменен 20.7.2014
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lib_declension {
    //Функция для правильного склонения слова в зависимости от цифр
    function regex_num($num, $lang_key, $reg = FALSE) {
        $CI = &get_instance();
        //1
        if(preg_match('/^[1]{1}$|^[0-9]*(0{1}|[2-9]{1})[1]{1}$/', $num))
        {
            $lang_set = $CI->lang->line($lang_key);
            return (!$reg) ? $lang_set[0] : $lang_set[3];
        }
        //5 - 9
        if(preg_match('/^[5-9]{1}$|^[0-9]*[0]{1}$|^[0-9]*[1]{1}[0-9]{1}$|^[0-9]*(0{1}|[2-9]{1})[5-9]{1}$/', $num))
        {
            $lang_set = $CI->lang->line($lang_key);
            return (!$reg) ? $lang_set[1] : $lang_set[4];
        }
        //2 - 4
        if(preg_match('/^[2-4]{1}$|^[0-9]*(0{1}|[2-9]{1})[2-4]{1}$/', $num))
        {
            $lang_set = $CI->lang->line($lang_key);
            return (!$reg) ? $lang_set[2] : $lang_set[5];
        }
    }
}
?>
