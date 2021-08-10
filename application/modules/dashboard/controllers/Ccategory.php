<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ccategory extends MX_Controller
{
    public $menu;

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lcategory');
        $this->load->library('dashboard/session');
        $this->load->model('dashboard/Categories');
        $this->load->model('template/Template_model');
        $this->auth->check_user_auth();

    }

    public function index()
    {
        $this->permission->check_label('add_category')->create()->redirect();

        $content = $this->lcategory->category_add_form();
        $this->template_lib->full_admin_html_view($content);
    }
    //Product Add Form
    public function manage_category()
    {
        $this->permission->check_label('manage_category')->read()->redirect();

        $content =$this->lcategory->category_list();
        $this->template_lib->full_admin_html_view($content);;
    }



    //Insert Product and upload
    public function insert_category()
    {
        $this->permission->check_label('add_category')->create()->redirect();

        $category_id = generator(15);
        if ($_FILES['cat_image']['name']) {
            //Chapter chapter add start
            $config['upload_path'] = './my-assets/image/category/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('cat_image')) {
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect('dashboard/Ccategory');
            } else {
                $image = $this->upload->data();
                $image_url = "my-assets/image/category/" . $image['file_name'];
            }
        }

        if ($_FILES['cat_favicon']['name']) {
            //Chapter chapter add start
            $config['upload_path'] = './my-assets/image/category/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('cat_favicon')) {
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect('dashboard/Ccategory');
            } else {
                $image = $this->upload->data();
                $cat_icon = "my-assets/image/category/" . $image['file_name'];
            }
        }

        $parent_category = $this->input->post('parent_category',TRUE);
        //Category  basic information adding.
        $data = array(
            'category_id' => $category_id,
            'category_name' => $this->input->post('category_name',TRUE),
            'top_menu' => $this->input->post('top_menu',TRUE),
            'menu_pos' => $this->input->post('menu_position',TRUE),
            'cat_favicon' => (!empty($cat_icon) ? $cat_icon : 'my-assets/image/category.png'),
            'parent_category_id' => $parent_category,
            'cat_image' => (!empty($image_url) ? $image_url : 'my-assets/image/category.png'),
            'cat_type' => (!empty($parent_category) ? 2 : 1),
            'status' => 1
        );

        $result = $this->Categories->category_entry($data);
        if ($result == TRUE) {
            //Previous balance adding -> Sending to customer model to adjust the data.
            $this->session->set_userdata(array('message' => display('successfully_added')));
            if (isset($_POST['add-customer'])) {
                redirect(base_url('dashboard/Ccategory/manage_category'));
                exit;
            } elseif (isset($_POST['add-customer-another'])) {
                redirect(base_url('dashboard/Ccategory'));
                exit;
            }
        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('dashboard/Ccategory'));
        }
    }

    //customer Update Form
    public function category_update_form($category_id)
    {   
        $this->permission->check_label('manage_category')->update()->redirect();

        $content = $this->lcategory->category_edit_data($category_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // customer Update
    public function category_update()
    {
        $this->permission->check_label('manage_category')->update()->redirect();

        $category_id = $this->input->post('category_id',TRUE);

        if ($_FILES['cat_image']['name']) {
            //Chapter chapter add start
            $config['upload_path'] = './my-assets/image/category/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "1024";
            $config['max_height'] = "1024";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('cat_image')) {
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect('dashboard/Ccategory/manage_category');
            } else {
                $image = $this->upload->data();
                $image_url = "my-assets/image/category/" . $image['file_name'];
            }
        }


        if ($_FILES['cat_favicon']['name']) {
            //Chapter chapter add start
            $config['upload_path'] = './my-assets/image/category/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('cat_favicon')) {
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect('dashboard/Ccategory');
            } else {
                $image = $this->upload->data();
                $cat_icon = "my-assets/image/category/" . $image['file_name'];
            }
        }

        $old_image = $this->input->post('old_image',TRUE);
        $old_cat_icon = $this->input->post('old_cat_icon',TRUE);

        $parent_category = $this->input->post('parent_category',TRUE);
        //Category  basic information update.
        $data = array(
            'category_name' => $this->input->post('category_name',TRUE),
            'top_menu' => $this->input->post('top_menu',TRUE),
            'menu_pos' => $this->input->post('menu_position',TRUE),
            'cat_favicon' => (!empty($cat_icon) ? $cat_icon : $old_cat_icon),
            'parent_category_id' => $parent_category,
            'cat_image' => (!empty($image_url) ? $image_url : $old_image),
            'cat_type' => (!empty($parent_category) ? 2 : 1),
            'status' => $this->input->post('status',TRUE)
        );

        $this->Categories->update_category($data, $category_id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Ccategory/manage_category'));
    }

    // product_delete
    public function category_delete($category_id)
    {
        $this->permission->check_label('manage_category')->delete()->redirect();

        $this->load->model('Categories');
        $this->Categories->delete_category($category_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Ccategory/manage_category');
    }


    public function add_category_csv(){
        $this->permission->check_label('import_category_csv')->read()->redirect();

        $CI =& get_instance();
        $data = array(
            'title' => display('import_category_csv'),
        );
        $content = $CI->parser->parse('dashboard/category/add_category_csv',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }


    //CSV Upload File
    function uploadCsv()
    {
        $this->permission->check_label('import_category_csv')->create()->redirect();

        $count = 0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'], 'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE) {

            while ($csv_line = fgetcsv($fp, 1024)) {
                //keep this if condition if you want to remove the first row
                for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                    $insert_csv = array();
                    $insert_csv['parent_category_id'] = (!empty($csv_line[0]) ? $csv_line[0] : null);
                    $insert_csv['category_name'] = (!empty($csv_line[1]) ? $csv_line[1] : null);
                    $insert_csv['top_menu'] = (!empty($csv_line[2]) ? $csv_line[2] : 0);
                    $insert_csv['menu_position'] = (!empty($csv_line[3]) ? $csv_line[3] : 0);
                    $insert_csv['cat_image'] = (!empty($csv_line[4]) ? $csv_line[4] : null);
                    $insert_csv['cat_favicon'] = (!empty($csv_line[5]) ? $csv_line[5] : null);
                    $insert_csv['cat_type'] = (!empty($csv_line[6]) ? $csv_line[6] : 0);
                    $insert_csv['status'] = (!empty($csv_line[7]) ? $csv_line[7] : null);
                }
                //Data organizaation for insert to database
                $data = array(
                    'category_id' => $this->auth->generator(15),
                    'parent_category_id' => $insert_csv['parent_category_id'],
                    'category_name' => $insert_csv['category_name'],
                    'top_menu' => $insert_csv['top_menu'],
                    'menu_pos' => $insert_csv['menu_position'],
                    'cat_image' => $insert_csv['cat_image'],
                    'cat_favicon' => $insert_csv['cat_favicon'],
                    'cat_type' => $insert_csv['cat_type'],
                    'status' => $insert_csv['status'],
                );

                if ($count > 0) {
                    $result = $this->db->select('*')
                        ->from('product_category')
                        ->where('category_name', $data['category_name'])
                        ->get()
                        ->num_rows();
                    if ($result == 0 && !empty($data['category_name'])) {
                        $this->db->insert('product_category', $data);

                    } else {
                        $this->db->where('category_name', $data['category_name']);
                        $this->db->update('product_category', $data);
                    }
                }
                $count++;
            }
        }

        fclose($fp) or die("can't close file");
        $this->session->set_userdata(array('message' => display('successfully_added')));

        if (isset($_POST['add-product'])) {
            redirect(base_url('dashboard/Ccategory/manage_category'));
            exit;
        } elseif (isset($_POST['add-product-another'])) {
            redirect(base_url('dashboard/Ccategory'));
            exit;
        }

    }
}