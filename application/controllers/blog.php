<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller
{
    // Массив данных, который передается в вид
    private $data = array(
                    'message' => ''
                        );
    
    public function __construct()
    {
        parent::__construct();
        
        //Подгружаем языковой файл для блога
        $this->lang->load('blog');
        
        //Подгружаем модель для блога
        $this->load->model('Blog_model');
        
        // Получаем заголовок для блога по умолчанию
        $this->data['title']       = $this->Blog_model->get_setting('site_name');
        
        //Описание по умолчанию
        $this->data['description'] = '';
    }
    
    /**
     * Главная страница - лента записей
     * @param string $page
     */
    public function index($page = null)
    {
        // Библиотека пагинации CI
        $this->load->library('pagination');
        
        //Формируем пагинацию
        $config['base_url']    = base_url() . __FUNCTION__;
        $config['total_rows']  = $this->Blog_model->total_posts();
        $config['per_page']    = $this->Blog_model->get_setting('posts_per_page');
        $config['uri_segment'] = 2;
        
        $this->pagination->initialize($config);
        
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['posts']      = $this->Blog_model->get_posts($config['per_page'], $page); //Формируем вывод записей в соответствии с параметрами пагинации
        $this->lib_view->output(array('main_header', 'blog/blog', 'main_footer'), $this->data); //Выводим вид
    }
    
    /**
     * Страница записи
     * @param string $post_url
     */
    public function post($post_url = null)
    {
        if($this->data['post'] = $this->Blog_model->get_post(array('post_url' => $post_url)))
        {
            $this->data['title']       = $this->data['post']->post_title . ' | ' . $this->data['title'];
            $this->data['description'] = $this->data['post']->post_description;
            if($this->input->post('submit'))
            {
                //Подгружаем библиотеку валидации
                $this->load->library('form_validation');
                
                //Правила для валидации
                $this->form_validation->set_rules('post_comment_author', $this->lang->line('author'), 'required|no_tags|min_length[3]|max_length[30]');
        		$this->form_validation->set_rules('post_comment_content', $this->lang->line('comment'), 'required');
                $this->form_validation->set_rules('post_comment_post_id', $this->lang->line('post_id'), 'required|post_exists');
                
                //Обрабатываем полученные post данные для отправки в модель
                foreach($this->Blog_model->comment_fields as $key)
                {
                    $post_data[$key] = $this->input->post($key, TRUE);
                }
                
                //Добавляем комментарий
                if($this->Blog_model->add_comment($post_data))
                    $this->data['message'] = $this->lang->line('successfully_saved');
            }
            $this->data['comments'] = $this->Blog_model->get_comments(array('post_comment_post_id' => $this->data['post']->post_id));
            $this->lib_view->output(array('main_header', 'blog/post', 'main_footer'), $this->data);
        }
        else
            show_404();
    }
    
    /**
     * Добавление записи
     */
    public function add_post()
    {
        $this->data['title'] = $this->lang->line('add_post') . ' | ' . $this->data['title'];
        
        //Если форма отправлена
        if($this->input->post('submit'))
        {
            //Подгружаем библиотеку валидации
            $this->load->library('form_validation');
            
            //Правила для валидации
            $this->form_validation->set_rules('post_author', $this->lang->line('author'), 'required|no_tags|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('post_title', $this->lang->line('title'), 'required|no_tags|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('post_description', $this->lang->line('description'), 'required|no_tags|min_length[6]|max_length[300]');
            $this->form_validation->set_rules('post_subject', $this->lang->line('subject'), 'required|no_tags|min_length[6]|max_length[150]');
    		$this->form_validation->set_rules('post_content', $this->lang->line('content'), 'required');
            $this->form_validation->set_rules('post_url', $this->lang->line('url'), 'required|no_tags|min_length[3]|max_length[30]');
            
            foreach($this->Blog_model->post_fields as $key)
            {
                $post_data[$key] = $this->input->post($key, TRUE);
            }
            
            //Если запись добавлена
            if($this->Blog_model->add_post($post_data))
            
                //Если данные сохранены успешно, выводим соответствующий вид
                $this->lib_view->output(array('main_header', 'blog/send', 'main_footer'), $this->data);
            else
                $this->lib_view->output(array('main_header', 'blog/add_post', 'main_footer'), $this->data);
                
        //Иначе загружаем вид с формой
        } else
            $this->lib_view->output(array('main_header', 'blog/add_post', 'main_footer'), $this->data);
    }
    
    /**
     * Страница настроек блога
     */
    public function settings()
    {
        if($this->input->post('submit'))
        {
            //Подгружаем библиотеку валидации
            $this->load->library('form_validation');
            
            //Правила для валидации
            $this->form_validation->set_rules('site_name', $this->lang->line('site_name'), 'no_tags');
            $this->form_validation->set_rules('posts_per_page', $this->lang->line('posts_per_page'), 'required|no_tags|integer');
            $this->form_validation->set_rules('excerpt_characters', $this->lang->line('excerpt_characters'), 'required|integer');
            
            //Обрабатываем полученные post данные для отправки в модель
            foreach($this->Blog_model->main_settings_fields as $key)
            {
                $post_data[$key] = $this->input->post($key, TRUE);
            }
            
            if($this->Blog_model->save_settings($post_data))
                $this->data['message'] = $this->lang->line('successfully_saved');
        }
        $this->data['settings'] = $this->Blog_model->get_settings();
        $this->lib_view->output(array('main_header', 'blog/settings', 'main_footer'), $this->data);
    }
}