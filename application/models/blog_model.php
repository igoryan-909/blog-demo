<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model
{
    //��������� ����������� ORDER �� ���������
    public $order_by = 'desc';
    //��������� ����, ������� ����� ����������� � �������� ��
    private $post_fields = array(
                        'post_author',
                        'post_title',
                        'post_description',
                        'post_subject',
                        'post_content',
                        'post_url'
                        );
    private $comment_fields = array(
                        'post_comment_post_id',
                        'post_comment_author',
                        'post_comment_content'
                        );
    private $main_settings_fields = array(
                        'site_name',
                        'posts_per_page',
                        'excerpt_characters'
                        );
    
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * �������� �������� ������������� ��������� ($settings) �� ������� ��������� � ��
     */
    public function get_setting($setting)
    {
        $where = array('setting_type' => 'blog', 'setting_parameter' => $setting);
        $query = $this->db->get_where(SETTINGS_TABLE, $where);
        return $query->row()->setting_value;
    }
    /**
     * �������� ��� �����
     */
    public function get_posts($limit = 5, $limit_offset = 0)
    {
        $this->db->limit($limit, $limit_offset);
        $this->db->order_by('post_add_date', $this->order_by);
        $query = $this->db->get_where(POSTS_TABLE);
        return $query->result();
    }
    /**
     * �������� ����� ���������� �������
     */
    public function total_posts()
    {
        return $this->db->count_all_results(POSTS_TABLE);
    }
    /**
     * �������� ���� ������
     */
    public function get_post($where)
    {
        $query = $this->db->get_where(POSTS_TABLE, $where);
        return $query->row();
    }
    /**
     * ��������� ������
     */
    public function add_post()
    {
        if($this->form_validation->run())
        {
            foreach($this->post_fields as $key)
            {
                $data[$key] = $this->input->post($key);
            }
            $data['post_add_date'] = time();
            if($this->db->insert(POSTS_TABLE, $data))
                return $this->db->insert_id();
        }
    }
    /**
     * �������� ����������� � ����������� �� ������� $where
     */
    public function get_comments($where = null)
    {
        $query = $this->db->get_where(POST_COMMENTS_TABLE, $where);
        return $query->result();
    }
    /**
     * ��������� �����������
     */
    public function add_comment()
    {
        if($this->form_validation->run()) //���� ��������� ������ �������
        {
            //������� ������ ��� ��������� � ��
            foreach($this->comment_fields as $key)
            {
                $data[$key] = $this->input->post($key);
            }
            $data['post_comment_add_date'] = time(); // ������� �����
            if($this->db->insert(POST_COMMENTS_TABLE, $data))
                return $this->db->insert_id();
        }
    }
    /**
     * �������� ���-�� ������������ � ����������� �� �������
     */
    public function total_comments($where)
    {
        $this->db->where($where);
        return $this->db->count_all_results(POST_COMMENTS_TABLE);
    }
    /**
     * �������� � ��������� � ���� ������� ��������� ��� ����� �� ��.
     * ��������� �������� � �� � ���� ���� "����" -> ���� "��������",
     * �.�. ��������� � ���� "����" �� �������� ��� ������ ����, � �� ����� ��������.
     * ����� �� �������� �� ���������, ��������� ������ � ���� �������,
     * �.�. ��� ��������� ���������� ������ ����������� ���� � ���� ��������
     */
    public function get_settings()
    {
        $where = array('setting_type' => 'blog');
        $query = $this->db->get_where(SETTINGS_TABLE, $where);
        foreach($query->result() as $col)
        {
            $settings->{$col->setting_parameter} = $col->setting_value;
        }
        return $settings;
    }
    /**
     * ��������� ���������
     */
    public function save_settings()
    {
        if($this->form_validation->run()) //���� ��������� ������ �������
        {
            $where = array('setting_type' => 'blog');
            $status = TRUE;
            foreach($this->main_settings_fields as $key)
            {
                $where['setting_parameter'] = $key;
                $data['setting_value'] = $this->input->post($key);
                if(!$this->db->update(SETTINGS_TABLE, $data, $where))
                {
                    $status = FALSE;
                    break;
                }
            }
            return $status;
        }
    }
}