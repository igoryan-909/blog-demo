<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model
{
    //Указываем направление ORDER по умолчанию
    public $order_by = 'desc';
    
    //Указываем поля, которые будут сохраняться в таблицах БД
    public $post_fields = array(
                        'post_author',
                        'post_title',
                        'post_description',
                        'post_subject',
                        'post_content',
                        'post_url'
                        );
    public $comment_fields = array(
                        'post_comment_post_id',
                        'post_comment_author',
                        'post_comment_content'
                        );
    public $main_settings_fields = array(
                        'site_name',
                        'posts_per_page',
                        'excerpt_characters'
                        );
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Получаем значение определенного параметра ($settings) из таблицы установок в БД
     * @return string
     */
    public function get_setting($setting)
    {
        $where = array('setting_type' => 'blog', 'setting_parameter' => $setting);
        $query = $this->db->get_where(SETTINGS_TABLE, $where);
        return $query->row()->setting_value;
    }
    
    /**
     * Получаем все посты
     * @return object
     */
    public function get_posts($limit = 5, $limit_offset = 0)
    {
        $this->db->limit($limit, $limit_offset);
        $this->db->order_by('post_add_date', $this->order_by);
        $query = $this->db->get_where(POSTS_TABLE);
        return $query->result();
    }
    
    /**
     * Получаем общее количество записей
     * @return string
     */
    public function total_posts()
    {
        return $this->db->count_all_results(POSTS_TABLE);
    }
    
    /**
     * Получаем одну запись
     * @return object
     */
    public function get_post($where)
    {
        $query = $this->db->get_where(POSTS_TABLE, $where);
        return $query->row();
    }
    
    /**
     * Добавляем запись
     * @return integer
     */
    public function add_post($post_data)
    {
        if($this->form_validation->run())
        {
            $post_data['post_add_date'] = time();
            if($this->db->insert(POSTS_TABLE, $post_data))
                return $this->db->insert_id();
        }
    }
    
    /**
     * Получаем комментарии в зависимости от условий $where
     * @return object
     */
    public function get_comments($where = null)
    {
        $query = $this->db->get_where(POST_COMMENTS_TABLE, $where);
        return $query->result();
    }
    
    /**
     * Добавляем комментарий
     * @return integer
     */
    public function add_comment($post_data)
    {
        //Если валидация прошла успешно
        if($this->form_validation->run())
        {
            $post_data['post_comment_add_date'] = time(); // Текущее время
            if($this->db->insert(POST_COMMENTS_TABLE, $post_data))
                return $this->db->insert_id();
        }
    }
    
    /**
     * Получаем кол-во комментариев в зависимости от условий
     * @param mixed $where
     * @return string
     */
    public function total_comments($where)
    {
        $this->db->where($where);
        return $this->db->count_all_results(POST_COMMENTS_TABLE);
    }
    
    /**
     * Получаем и формируем в виде объекта настройки для блога из БД.
     * Настройки хранятся в БД в виде поле "ключ" -> поле "значение",
     * т.е. обращаясь к полю "ключ" мы получаем еще только ключ, а не сразу значение.
     * Чтобы не отходить от стандарта, формируем именно в виде объекта,
     * т.к. все остальные получаемые данные формируются тоже в виде объектов
     * @return object
     */
    public function get_settings()
    {
        $where = array('setting_type' => 'blog');
        $query = $this->db->get_where(SETTINGS_TABLE, $where);
        
        //Указываем, что settings - это объект
        $settings = new stdClass();
        foreach($query->result() as $col)
        {
            $settings->{$col->setting_parameter} = $col->setting_value;
        }
        return $settings;
    }
    
    /**
     * Сохраняем настройки
     * @return boolean
     */
    public function save_settings($post_data)
    {
        //Если валидация прошла успешно, сохраняем настройки
        if($this->form_validation->run())
        {
            $where = array('setting_type' => 'blog');
            $status = TRUE;
            foreach($this->main_settings_fields as $key)
            {
                $where['setting_parameter'] = $key;
                $data['setting_value'] = $post_data[$key];
                if(!$this->db->update(SETTINGS_TABLE, $data, $where))
                {
                    $status = FALSE;
                    break;
                }
            }
        } else
            $status = FALSE;
        return $status;
    }
}