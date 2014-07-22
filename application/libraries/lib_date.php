<?php
/**
 * @автор Ivanoff
 * @описание файла: 
 * @изменен 20.7.2014
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lib_date {
    private $month = array('');
    //Функция для формирования даты
    function format_date($timestamp) {
        $CI = &get_instance();
        $CI->lang->load('calendar');
        return date('d', $timestamp) . ' ' . $CI->lang->line('cal_' . strtolower(date('F', $timestamp))) . ' ' . date('Y', $timestamp) . ' ' . $CI->lang->line('cal_in') . ' ' . date('H : i', $timestamp);
    }
}
?>
