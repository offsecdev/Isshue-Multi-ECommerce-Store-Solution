<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cproduct extends MX_Controller
{

    public $product_id;

    function __construct()
    {

        parent::__construct();
        $this->auth->check_user_auth();
        $this->load->model(array(
            'dashboard/Products',
            'dashboard/Galleries',
            'dashboard/Variants',
            'dashboard/Suppliers',
            'dashboard/Categories',
            'dashboard/Brands',
            'dashboard/Units',
            'dashboard/Soft_settings',
            'template/Template_model',
        ));
        $this->load->library('dashboard/lproduct');
        $this->load->library('dashboard/occational');

    }

    //Index page load
    public function index()
    {
        $this->permission->check_label('add_product')->create()->redirect();

        $content = $this->lproduct->product_add_form();
        $this->template_lib->full_admin_html_view($content);

    }

   //Insert Product and upload
    public function insert_product()
    {
        $this->permission->check_label('add_product')->create()->redirect();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_name', display('product_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('category_id', display('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('onsale', display('onsale'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('price', display('sell_price'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('supplier_price', display('supplier_price'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('model', display('model'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('supplier_id', display('supplier'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('variant[]', display('variant'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->index();

        } else {
            if ($_FILES['image_thumb']['name']) {
                //Chapter chapter add start
                $config['upload_path'] = './my-assets/image/product/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "*";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image_thumb')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cproduct');
                } else {
                    $image = $this->upload->data();
                    $image_url = "my-assets/image/product/" . $image['file_name'];

                    //Resize image config
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $image['full_path'];
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 400;
                    $config['height'] = 400;
                    $config['new_image'] = 'my-assets/image/product/thumb/' . $image['file_name'];
                    $this->upload->initialize($config);
                    $this->load->library('image_lib', $config);
                    $resize = $this->image_lib->resize();
                    //Resize image config

                    $thumb_image = $config['new_image'];
                }
            }
            $variant = $this->input->post('variant',TRUE);
            $variant_colors = $this->input->post('variant_colors',TRUE);

            if(!empty($variant_colors)){
                $full_variant = array_merge($variant, $variant_colors);
            }else{
                $full_variant = $variant;
            }

            $onsale = $this->input->post('onsale',TRUE);
            if($onsale){
                $onsale_price = $this->input->post('onsale_price',TRUE);
                $onsale_price = (!empty($onsale_price) ? $onsale_price : null);
            }else{
                $onsale_price = null;
            }

            $default_variant = $this->input->post('default_variant',TRUE);
            $product_id = $this->generator(8);

            // Product variant prices
            $variant_prices = $this->input->post('variant_prices',TRUE);

            $data = array(
                'product_id' => $product_id,
                'product_name' => $this->input->post('product_name',TRUE),
                'supplier_id' => $this->input->post('supplier_id',TRUE),
                'category_id' => $this->input->post('category_id',TRUE),
                'price' => $this->input->post('price',TRUE),
                'supplier_price' => $this->input->post('supplier_price',TRUE),
                'unit' => $this->input->post('unit',TRUE),
                'product_model' => $this->input->post('model',TRUE),
                'product_details' => $this->input->post('details',TRUE),
                'brand_id' => $this->input->post('brand',TRUE),
                'variants' => implode(",", (array)$full_variant),
                'default_variant' => $default_variant,
                'variant_price' => (!empty($variant_prices)?1:0),
                'type' => $this->input->post('type',TRUE),
                'best_sale' => $this->input->post('best_sale',TRUE),
                'onsale' => $onsale,
                'onsale_price' => $onsale_price,
                'review' => $this->input->post('review',TRUE),
                'video' => $this->input->post('video',TRUE),
                'description' => stripslashes($this->input->post('description', TRUE)),
                'tag' => $this->input->post('tag',TRUE),
                'specification' => stripslashes($this->input->post('specification', TRUE)),
                'invoice_details' => $this->input->post('invoice_details',TRUE),
                'image_large_details' => (!empty($image_url) ? $image_url : 'my-assets/image/product.png'),
                'image_thumb' => (!empty($thumb_image) ? $thumb_image : 'my-assets/image/product.png'),
                'status' => 1,
            );

            $result = $this->Products->product_entry($data);

            //Product variant prices
            if(isset($variant_prices) &&  !empty($variant_prices)){
                $size_variant = $this->input->post('size_variant[]',TRUE);
                $color_variant = $this->input->post('color_variant[]',TRUE);
                $variant_price_amt = $this->input->post('variant_price_amt[]',TRUE);

                if(!empty($size_variant)){
                    $vprice_list = [];
                    for($c=0;$c<count($size_variant);$c++){
                        if(!empty($size_variant[$c]) || !empty($color_variant[$c])){
                            $vprice_list[] = array(
                                'product_id' => $product_id,
                                'var_size_id' => $size_variant[$c],
                                'var_color_id' => $color_variant[$c],
                                'price' => $variant_price_amt[$c]
                            );
                        } 
                    }

                    if(!empty($vprice_list)){
                        $this->db->insert_batch('product_variants', $vprice_list);
                    }
                }
            }



            //gallery image insert start
            $dataInfo = [];
            $this->load->library('upload');
            $files = $_FILES;
            if (!empty($_FILES['imageUpload']['name'][0])) {
                $cpt = count($_FILES['imageUpload']['name']);

                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['imageUpload']['name'] = $files['imageUpload']['name'][$i];
                    $_FILES['imageUpload']['type'] = $files['imageUpload']['type'][$i];
                    $_FILES['imageUpload']['tmp_name'] = $files['imageUpload']['tmp_name'][$i];
                    $_FILES['imageUpload']['error'] = $files['imageUpload']['error'][$i];
                    $_FILES['imageUpload']['size'] = $files['imageUpload']['size'][$i];
                    $_FILES['encrypt_name'] = TRUE;
                    $this->upload->initialize($this->set_upload_options());
                    $this->upload->do_upload('imageUpload');
                    $dataInfo[] = $this->upload->data();
                    $image_url = "my-assets/image/gallery/" . $dataInfo[$i]['file_name'];

                    $imagedata = [
                        'image_gallery_id' => generator(15),
                        'product_id' => $product_id,
                        'image_url' => $image_url,
                        'img_thumb' => 'null',
                    ];
                    $result2 = $this->Galleries->image_entry($imagedata);
                }
            }
            //gallery image insert end=================


            if ($result) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                if (isset($_POST['add-product'])) {
                    redirect(base_url('dashboard/Cproduct/manage_product'));
                    exit;
                } elseif (isset($_POST['add-product-another'])) {
                    redirect(base_url('dashboard/Cproduct'));
                    exit;
                }
            } else {
                $this->session->set_userdata(array('error_message' => display('product_model_already_exist')));
                redirect(base_url('dashboard/Cproduct'));
            }
        }
    }



    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './my-assets/image/gallery/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        return $config;
    }
    //Manage Product
    public function manage_product($page = 0)
    {
        $this->permission->check_label('manage_product')->read()->redirect();
        $filter = array(
            'product_name' => $this->input->get('product_name',TRUE),
            'supplier_id'  => $this->input->get('supplier_id',TRUE),
            'category_id'  => $this->input->get('category_id',TRUE),
            'unit_id'      => $this->input->get('unit_id',TRUE),
            'model_no'     => $this->input->get('model_no',TRUE)
        );
        #
        #pagination starts
        #
        $config["base_url"]    = base_url('dashboard/Cproduct/manage_product/');
        $config["total_rows"]  = $this->Products->product_list_count($filter);
        $config["per_page"]    = 20;
        $config["uri_segment"] = 4;
        $config["num_links"]   = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']    = "<ul class='pagination'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #
        $content = $this->lproduct->product_list($filter,$links,$config["per_page"],$page);
        $this->template_lib->full_admin_html_view($content);
    }
    //Product Update Form
    public function product_update_form($product_id)
    {
        $this->permission->check_label('manage_product')->update()->redirect();

        $CI =& get_instance();
        $content = $CI->lproduct->product_edit_data($product_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // Product Update
    public function product_update()
    {
        $this->permission->check_label('manage_product')->update()->redirect();

        $image = null;
        if ($_FILES['image_thumb']['name']) {
            //Chapter chapter add start
            $config['upload_path'] = './my-assets/image/product/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_thumb')) {
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect('dashboard/Cproduct');
            } else {
                $image = $this->upload->data();
                $image_url = "my-assets/image/product/" . $image['file_name'];
                //Resize image config
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image['full_path'];
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 400;
                $config['height'] = 400;
                $config['new_image'] = 'my-assets/image/product/thumb/' . $image['file_name'];
                $this->upload->initialize($config);
                $this->load->library('image_lib', $config);
                $resize = $this->image_lib->resize();
                //Resize image config
                $thumb_image = $config['new_image'];

                //Old image delete
                $old_image = $this->input->post('old_img_lrg',TRUE);
                $old_file = substr($old_image, strrpos($old_image, '/') + 1);
                @unlink(FCPATH . 'my-assets/image/product/' . $old_file);

                //Thumb image delete
                $old_img_thumb = $this->input->post('old_thumb_image',TRUE);
                $old_file_thumb = substr($old_img_thumb, strrpos($old_img_thumb, '/') + 1);
                @unlink(FCPATH . 'my-assets/image/product/thumb/' . $old_file_thumb);
            }
        }

        $old_img_lrg = $this->input->post('old_img_lrg',TRUE);
        $old_thumb_image = $this->input->post('old_thumb_image',TRUE);
        $product_id = $this->input->post('product_id',TRUE);
        $onsale = $this->input->post('onsale',TRUE);
        if($onsale){
            $onsale_price = $this->input->post('onsale_price',TRUE);
            $onsale_price = (!empty($onsale_price) ? $onsale_price : null);
        }else{
            $onsale_price = null;
        }
        

        $variant = $this->input->post('variant',TRUE);
        $variant_colors = $this->input->post('variant_colors',TRUE);

        if(!empty($variant_colors)){
            $full_variant = array_merge($variant, $variant_colors);
        }else{
            $full_variant = $variant;
        }

        // Product variant prices
        $variant_prices = $this->input->post('variant_prices',TRUE);
        $provar_prices = $this->Products->get_product_variant_prices($product_id);


        $data = array(
            'product_name' => $this->input->post('product_name',TRUE),
            'supplier_id' => $this->input->post('supplier_id',TRUE),
            'category_id' => $this->input->post('category_id',TRUE),
            'price' => $this->input->post('price',TRUE),
            'supplier_price' => $this->input->post('supplier_price',TRUE),
            'unit' => $this->input->post('unit',TRUE),
            'product_model' => $this->input->post('model',TRUE),
            'product_details' => $this->input->post('details',TRUE),
            'brand_id' => $this->input->post('brand',TRUE),
            'variants' => implode(",", (array)$full_variant),
            'default_variant' => $this->input->post('default_variant',TRUE),
            'variant_price' => (!empty($variant_prices)?1:0),
            'video' => $this->input->post('video',TRUE),
            'type' => $this->input->post('type',TRUE),
            'best_sale' => $this->input->post('best_sale',TRUE),
            'onsale' => $onsale,
            'onsale_price' => $onsale_price,
            'invoice_details' => $this->input->post('invoice_details',TRUE),
            'review' => $this->input->post('review',TRUE),
            'description' => stripslashes($this->input->post('description', TRUE)),
            'tag' => $this->input->post('tag',TRUE),
            'specification' => stripslashes($this->input->post('specification', TRUE)),
            'image_large_details' => (!empty($image_url) ? $image_url : $old_img_lrg),
            'image_thumb' => (!empty($thumb_image) ? $thumb_image : $old_thumb_image),
            'status' => 1
        );

        $result = $this->Products->update_product($data, $product_id);

        //Product variant prices
        if(isset($variant_prices) &&  !empty($variant_prices)){
            $size_variant = $this->input->post('size_variant[]',TRUE);
            $color_variant = $this->input->post('color_variant[]',TRUE);
            $variant_price_amt = $this->input->post('variant_price_amt[]',TRUE);


            if(!empty($size_variant)){
                $vprice_list = [];
                for($c=0;$c<count($size_variant);$c++){
                    if(!empty($size_variant[$c]) || !empty($color_variant[$c])){
                        $vprice_list[] = array(
                            'product_id' => $product_id,
                            'var_size_id' => (!empty($size_variant[$c])?$size_variant[$c]:NULL),
                            'var_color_id' => (!empty($color_variant[$c])?$color_variant[$c]:NULL),
                            'price' => $variant_price_amt[$c]
                        );
                    } 
                }

                if(!empty($vprice_list)){
                    $this->db->delete('product_variants', array('product_id' => $product_id));
                    $this->db->insert_batch('product_variants', $vprice_list);
                }
            }
        }else{
            if(!empty($provar_prices)){
                $this->db->delete('product_variants', array('product_id' => $product_id));
            }
        }

        $old_gallery_image = $this->input->post('old_gallery_image',TRUE);

        $dataInfo = [];
        $dataInfo2 = [];
        $this->load->library('upload');
        $files = $_FILES;
        $cpt = count($_FILES['imageUpload']['name']);
        $m = 0;
        $n = 0;
        for ($i = 0, $j = 0; $i < $cpt; $i++, $j++) {

            if (!empty($old_gallery_image[$j])) {
                //update existing image
                if (!empty($files['imageUpload']['name'][$i])) {
                    $_FILES['imageUpload']['name'] = $files['imageUpload']['name'][$i];
                    $_FILES['imageUpload']['type'] = $files['imageUpload']['type'][$i];
                    $_FILES['imageUpload']['tmp_name'] = $files['imageUpload']['tmp_name'][$i];
                    $_FILES['imageUpload']['error'] = $files['imageUpload']['error'][$i];
                    $_FILES['imageUpload']['size'] = $files['imageUpload']['size'][$i];
                    $_FILES['encrypt_name'] = TRUE;
                    $this->upload->initialize($this->set_upload_options());
                    $this->upload->do_upload('imageUpload');
                    $dataInfo[] = $this->upload->data();
                    $image_url = "my-assets/image/gallery/" . $dataInfo[$m]['file_name'];
                    $data = array(
                        'product_id' => $product_id,
                        'image_url' => $image_url,
                        'img_thumb' => 'null',
                    );

                    $result2 = $this->Galleries->update_gallery_image($data, $old_gallery_image[$i]);
                    unlink(FCPATH . $old_gallery_image[$i]);
                    $m++;

                }
            } else {
                //insert new image
                $_FILES['imageUpload']['name'] = $files['imageUpload']['name'][$i];
                $_FILES['imageUpload']['type'] = $files['imageUpload']['type'][$i];
                $_FILES['imageUpload']['tmp_name'] = $files['imageUpload']['tmp_name'][$i];
                $_FILES['imageUpload']['error'] = $files['imageUpload']['error'][$i];
                $_FILES['imageUpload']['size'] = $files['imageUpload']['size'][$i];
                $_FILES['encrypt_name'] = TRUE;
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload('imageUpload');
                $dataInfo2[] = $this->upload->data();

                $image_url = "my-assets/image/gallery/" . $dataInfo2[$n]['file_name'];
                $imagedata = [
                    'image_gallery_id' => $this->auth->generator(15),
                    'product_id' => $product_id,
                    'image_url' => $image_url,
                    'img_thumb' => 'null',
                ];
                $result2 = $this->Galleries->image_entry($imagedata);
                $n++;
            }
        }
        if ($result == true) {
            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect('dashboard/Cproduct/manage_product');
        } else {
            $this->session->set_userdata(array('error_message' => display('product_model_already_exist')));
            redirect('dashboard/Cproduct/manage_product');
        }
    }

    // Product Delete
    public function product_delete($product_id)
    {
        $this->permission->check_label('manage_product')->delete()->redirect();

        $this->Products->delete_product($product_id);
    }

    //Retrieve Single Item  By Search
    public function product_by_search()
    {
        $this->permission->check_label('manage_product')->read()->redirect();

        $product_id = $this->input->post('product_id',TRUE);

        $products_list = $this->Products->product_search_item($product_id);
        $all_product_list = $this->Products->all_product_list();
        $i = 0;
        if ($products_list) {
            foreach ($products_list as $k => $v) {
                $i++;
                $products_list[$k]['sl'] = $i;
            }
            $currency_details = $this->Soft_settings->retrieve_currency_info();
            $data = array(
                'title' => display('manage_product'),
                'products_list' => $products_list,
                'all_product_list' => $all_product_list,
                'currency' => $currency_details[0]['currency_icon'],
                'position' => $currency_details[0]['currency_position'],
            );
            $data['module'] = "dashboard";
            $data['page'] = "product/product";

            echo Modules::run('template/layout', $data);

        } else {
            redirect('dashboard/Cproduct/manage_product');
        }
    }

    //Retrieve Single Item  By Search
    public function product_details($product_id)
    {
        $this->permission->check_label('manage_product')->read()->redirect();

        $details_info = $this->Products->product_details_info($product_id);
        $purchaseData = $this->Products->product_purchase_info($product_id);

        $totalPurchase = 0;
        $totalPrcsAmnt = 0;

        if (!empty($purchaseData)) {
            foreach ($purchaseData as $k => $v) {
                $purchaseData[$k]['final_date'] = $this->occational->dateConvert($purchaseData[$k]['purchase_date']);
                $totalPrcsAmnt = ($totalPrcsAmnt + $purchaseData[$k]['total_amount']);
                $totalPurchase = ($totalPurchase + $purchaseData[$k]['quantity']);
            }
        }
        $salesData = $this->Products->invoice_data($product_id);
        $totalSales = 0;
        $totaSalesAmt = 0;

        if (!empty($salesData)) {
            foreach ($salesData as $k => $v) {
                $salesData[$k]['final_date'] = $this->occational->dateConvert($salesData[$k]['date']);
                $totalSales = ($totalSales + $salesData[$k]['quantity']);
                $totaSalesAmt = ($totaSalesAmt + $salesData[$k]['total_price']);
            }
        }

        $stock = ($totalPurchase - $totalSales);

        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $data = array(
            'title' => display('product_details'),
            'product_name' => $details_info[0]['product_name'],
            'product_model' => $details_info[0]['product_model'],
            'price' => $details_info[0]['price'],
            'purchaseTotalAmount' => number_format($totalPrcsAmnt, 2, '.', ','),
            'salesTotalAmount' => number_format($totaSalesAmt, 2, '.', ','),
            'total_purchase' => $totalPurchase,
            'total_sales' => $totalSales,
            'purchaseData' => $purchaseData,
            'salesData' => $salesData,
            'stock' => $stock,
            'product_statement' => 'dashboard/Cproduct/product_sales_supplier_rate/' . $product_id,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );

        $content = $this->parser->parse('dashboard/product/product_details',$data,true);
        $this->template_lib->full_admin_html_view($content);

    }

    //Retrieve Single Item  By Search
    public function product_details_single()
    {
        $this->permission->check_label('manage_product')->read()->redirect();

        $product_id = $this->input->post('product_id',TRUE);

        $details_info = $this->Products->product_details_info($product_id);
        $purchaseData = $this->Products->product_purchase_info($product_id);
        $products_list = $this->Products->product_list();

        $totalPurchase = 0;
        $totalPrcsAmnt = 0;

        if (!empty($purchaseData)) {
            foreach ($purchaseData as $k => $v) {
                $purchaseData[$k]['final_date'] = $this->occational->dateConvert($purchaseData[$k]['purchase_date']);
                $totalPrcsAmnt = ($totalPrcsAmnt + $purchaseData[$k]['total_amount']);
                $totalPurchase = ($totalPurchase + $purchaseData[$k]['quantity']);
            }
        }

        $salesData = $this->Products->invoice_data($product_id);
        $totalSales = 0;
        $totaSalesAmt = 0;

        if (!empty($salesData)) {
            foreach ($salesData as $k => $v) {
                $salesData[$k]['final_date'] = $this->occational->dateConvert($salesData[$k]['date']);
                $totalSales = ($totalSales + $salesData[$k]['quantity']);
                $totaSalesAmt = ($totaSalesAmt + $salesData[$k]['total_amount']);
            }
        }

        $stock = ($totalPurchase - $totalSales);
        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $data = array(
            'title' => display('product_report'),
            'product_name' => $details_info[0]['product_name'],
            'product_model' => $details_info[0]['product_model'],
            'price' => $details_info[0]['price'],
            'purchaseTotalAmount' => number_format($totalPrcsAmnt, 2, '.', ','),
            'salesTotalAmount' => number_format($totaSalesAmt, 2, '.', ','),
            'total_purchase' => $totalPurchase,
            'total_sales' => $totalSales,
            'purchaseData' => $purchaseData,
            'salesData' => $salesData,
            'stock' => $stock,
            'product_list' => $products_list,
            'product_statement' => 'dashboard/Cproduct/product_sales_supplier_rate/' . $product_id,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );


        $data['module'] = "dashboard";
        $data['page'] = "product/product_details_single";

        echo Modules::run('template/layout', $data);

    }

    //Add supplier by ajax
    public function add_supplier()
    {
        $this->load->model('Suppliers');
        $this->form_validation->set_rules('supplier_name', display('supplier_name'), 'required');
        $this->form_validation->set_rules('mobile', display('mobile'), 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '3';
        } else {
            $data = array(
                'supplier_id' => $this->auth->generator(20),
                'supplier_name' => $this->input->post('supplier_name',TRUE),
                'address' => $this->input->post('address',TRUE),
                'mobile' => $this->input->post('mobile',TRUE),
                'details' => $this->input->post('details',TRUE),
                'status' => 1
            );

            $supplier = $this->Suppliers->supplier_entry($data);

            if ($supplier == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                echo '1';
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                echo '2';
            }
        }
    }

    // Insert category by ajax
    public function insert_category()
    {

        $category_id = $this->auth->generator(15);
        $this->form_validation->set_rules('category_name', display('category_name'), 'required');
        if ($this->form_validation->run() == FALSE) {
            echo '3';
        } else {
            //Customer  basic information adding.
            $data = array(
                'category_id' => $category_id,
                'category_name' => $this->input->post('category_name',TRUE),
                'status' => 1
            );
            $result = $this->Categories->category_entry($data);
            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                echo '1';
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                echo '2';
            }
        }
    }

    //Add Product CSV
    public function add_product_csv()
    {
        $this->permission->check_label('import_product_csv')->create()->redirect();
        $data = array(
            'title' => display('import_product_csv')
        );
         $content = $this->parser->parse('dashboard/product/add_product_csv',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    //CSV Upload File
    function uploadCsv()
    {
        $this->permission->check_label('import_product_csv')->create()->redirect();
        $count = 0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'], 'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE) {

            while ($csv_line = fgetcsv($fp, 1024)) {
                //keep this if condition if you want to remove the first row
                for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                    $insert_csv = array();
                    $insert_csv['supplier_id'] = (!empty($csv_line[0]) ? $csv_line[0] : '');
                    $insert_csv['category_id'] = (!empty($csv_line[1]) ? $csv_line[1] : '');
                    $insert_csv['product_name'] = (!empty($csv_line[2]) ? $csv_line[2] : '');
                    $insert_csv['price'] = (!empty($csv_line[3]) ? $csv_line[3] : '');
                    $insert_csv['supplier_price'] = (!empty($csv_line[4]) ? $csv_line[4] : '');
                    $insert_csv['unit'] = (!empty($csv_line[5]) ? $csv_line[5] : '');
                    $insert_csv['product_model'] = (!empty($csv_line[6]) ? $csv_line[6] : '');
                    $insert_csv['product_details'] = (!empty($csv_line[7]) ? $csv_line[7] : '');
                    $insert_csv['image_thumb'] = (!empty($csv_line[8]) ? $csv_line[8] : '');
                    $insert_csv['brand_id'] = (!empty($csv_line[9]) ? $csv_line[9] : '');
                    $insert_csv['variants'] = (!empty($csv_line[10]) ? $csv_line[10] : '');

                    $insert_csv['variant_prices'] = (!empty($csv_line[11]) ? $csv_line[11] : []);
                    $insert_csv['type'] = (!empty($csv_line[12]) ? $csv_line[12] : '');
                    $insert_csv['best_sale'] = (!empty($csv_line[13]) ? $csv_line[13] : 0);
                    $insert_csv['onsale'] = (!empty($csv_line[14]) ? $csv_line[14] : 0);
                    $insert_csv['onsale_price'] = (!empty($csv_line[15]) ? $csv_line[15] : '');
                    $insert_csv['invoice_details'] = (!empty($csv_line[16]) ? $csv_line[16] : '');
                    $insert_csv['image_large_details'] = (!empty($csv_line[17]) ? $csv_line[17] : '');
                    $insert_csv['review'] = (!empty($csv_line[18]) ? $csv_line[18] : '');
                    $insert_csv['description'] = (!empty($csv_line[19]) ? $csv_line[19] : '');
                    $insert_csv['tag'] = (!empty($csv_line[20]) ? $csv_line[20] : '');
                    $insert_csv['specification'] = (!empty($csv_line[21]) ? $csv_line[21] : '');
                    $insert_csv['status'] = (!empty($csv_line[22]) ? $csv_line[22] : 0);
                }
                if(!empty($insert_csv['image_thumb'])){

                    $image_thumb = ((strpos($insert_csv['image_thumb'], 'my-assets/image/product/thumb/') > 0)? $insert_csv['image_thumb']:'my-assets/image/product/thumb/'.$insert_csv['image_thumb']);
                }else{
                    $image_thumb = base_url('my-assets/image/product.png');
                }

                if(!empty($insert_csv['image_large_details'])){

                    $image_large_details = ((strpos($insert_csv['image_large_details'], 'my-assets/image/product/') > 0)? $insert_csv['image_large_details']:'my-assets/image/product/'.$insert_csv['image_large_details']);
                }else{
                    $image_large_details = base_url('my-assets/image/product.png');
                }

                //Data organizaation for insert to database
                $product_id = $this->generator(8);
                $data = array(
                    'product_id' => $product_id,
                    'supplier_id' => $insert_csv['supplier_id'],
                    'category_id' => $insert_csv['category_id'],
                    'product_name' => $insert_csv['product_name'],
                    'price' => $insert_csv['price'],
                    'supplier_price' => $insert_csv['supplier_price'],
                    'unit' => $insert_csv['unit'],
                    'product_model' => $insert_csv['product_model'],
                    'product_details' => $insert_csv['product_details'],
                    'image_thumb' => $image_thumb,
                    'brand_id' => $insert_csv['brand_id'],
                    'variants' => $insert_csv['variants'],
                    'variant_price' => (!empty($insert_csv['variant_prices'])?1:0),
                    'type' => $insert_csv['type'],
                    'best_sale' => $insert_csv['best_sale'],
                    'onsale' => $insert_csv['onsale'],
                    'onsale_price' => $insert_csv['onsale_price'],
                    'invoice_details' => $insert_csv['invoice_details'],
                    'image_large_details' => $image_large_details,
                    'review' => $insert_csv['review'],
                    'description' => $insert_csv['description'],
                    'tag' => $insert_csv['tag'],
                    'specification' => $insert_csv['specification'],
                    'status' => $insert_csv['status']
                );

                if ($count > 0) {
                    $result = $this->db->select('*')
                        ->from('product_information')
                        ->where('product_model', $data['product_model'])
                        ->get()
                        ->num_rows();

                    if ($result == 0 && !empty($data['product_model']) && !empty($data['supplier_id'])) {

                        $this->db->insert('product_information', $data);

                        $this->db->select('*');
                        $this->db->from('product_information');
                        $this->db->where('status', 1);
                        $query = $this->db->get();
                        foreach ($query->result() as $row) {
                            $json_product[] = array('label' => $row->product_name . "-(" . $row->product_model . ")", 'value' => $row->product_id);
                        }
                        $cache_file = './my-assets/js/admin_js/json/product.json';
                        $productList = json_encode($json_product);
                        file_put_contents($cache_file, $productList);

                    } else {

                        $this->db->where('supplier_id', $data['supplier_id']);
                        $this->db->where('product_model', $data['product_model']);
                        $this->db->update('product_information', $data);

                        $this->db->select('*');
                        $this->db->from('product_information');
                        $this->db->where('status', 1);
                        $query = $this->db->get();

                        foreach ($query->result() as $row) {
                            $json_product[] = array('label' => $row->product_name . "-(" . $row->product_model . ")", 'value' => $row->product_id);
                        }

                        $cache_file = './my-assets/js/admin_js/json/product.json';
                        $productList = json_encode($json_product);
                        file_put_contents($cache_file, $productList);
                    }

                    //Product variant prices
                    if(!empty($insert_csv['variant_prices'])) {

                        $variant_prices = explode('&', $insert_csv['variant_prices']);
                        if(is_array($variant_prices)){

                            $vprice_list = [];

                            foreach ($variant_prices as $vitem) {

                                $vitem_list = explode(',',$vitem);

                                if(is_array($vitem_list)){

                                    $size_variant = trim($vitem_list[0]);
                                    $color_variant = trim($vitem_list[1]);

                                    if(empty($vitem_list[2])){
                                        $color_variant = NULL;
                                        $variant_price_amt = trim($vitem_list[1]);
                                    }else{
                                        $variant_price_amt = trim($vitem_list[2]);
                                    }

                                    if(!empty($size_variant)){
                                        $vprice_list[] = array(
                                            'product_id' => $product_id,
                                            'var_size_id' => $size_variant,
                                            'var_color_id' => (!empty($color_variant)?$color_variant:NULL),
                                            'price' => $variant_price_amt
                                        );
                                    }
                                }
                            }

                             if(!empty($vprice_list)){
                                $this->db->delete('product_variants', array('product_id' => $product_id));
                                $this->db->insert_batch('product_variants', $vprice_list);
                            }

                        }
                    }
                }

                $count++;
            }
        }

        fclose($fp) or die("can't close file");
        $this->session->set_userdata(array('message' => display('successfully_added')));

        if (isset($_POST['add-product'])) {
            redirect(base_url('dashboard/Cproduct/manage_product'));
            exit;
        } elseif (isset($_POST['add-product-another'])) {
            redirect(base_url('dashboard/Cproduct'));
            exit;
        }
    }

    //This function is used to Generate Key
    public function generator($lenth)
    {

        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 8);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }

        $result = $this->Products->product_id_check($con);

        if ($result === true) {
            $this->generator(8);
        } else {
            return $con;
        }
    }


    public function get_default_variant()
    {
        $variants = $this->input->post('variants',TRUE);

        $variant_list = $this->db->select('*')->from('variant')->where_in('variant_id', $variants)->get()->result();
        $html = '';
        foreach ($variant_list as $variant) {
            $html .= '<option value="' . $variant->variant_id . '">' . $variant->variant_name . '</option>';
        }
        echo $html;
    }


    public function delete_gallery_image()
    {
        $this->permission->check_label('manage_product')->delete()->redirect();

        $imageId = $this->input->post('imageId',TRUE);

        $gallery_image = $this->db->select('image_url')->from('image_gallery')->where('image_gallery_id', $imageId)->get()->result();
        if ($gallery_image) {
            unlink(FCPATH . $gallery_image->image_url);
        }

        $this->db->where('image_gallery_id', $imageId);
        $this->db->delete('image_gallery');
    }
}