<?php
/**
 * @автор Ivanoff
 * @описание файла: 
 * @изменен 20.7.2014
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ѕиблиотека дл€ загрузки вида
 */
class lib_view
{
    /**
     * ѕолучаем вид или массив видов
     * и выводим эти виды
     */
    public function output($views, $data = FALSE)
    {
        $CI = &get_instance();
        if(is_array($views))
        {
            foreach($views as $key => $view)
            {
                ($key == 0 && $data) ? $CI->load->view($view, $data) : $CI->load->view($view);
            }
        } else
        {
            ($data) ? $CI->load->view($view, $data) : $CI->load->view($view);
        }
    }
}