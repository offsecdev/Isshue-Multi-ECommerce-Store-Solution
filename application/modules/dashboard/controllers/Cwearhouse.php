<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cwearhouse extends CI_Controller {

	function __construct() {
      parent::__construct();
		$this->load->library('lwearhouse');
		$this->load->model('Wearhouses');
		$this->load->model('Stores');
		$this->auth->check_user_auth();
    }
	//Default loading for wearhouse system.
	public function index()
	{
		$content = $this->lwearhouse->wearhouse_add_form();
		$this->template_lib->full_admin_html_view($content);
	}
	//Insert wearhouse
	public function insert_wearhouse()
	{
		$this->form_validation->set_rules('wearhouse_name', display('wearhouse_name'), 'trim|required');
		$this->form_validation->set_rules('wearhouse_address', display('wearhouse_address'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_wearhouse')
			);
        	$content = $this->parser->parse('wearhouse/add_wearhouse',$data,true);
			$this->template_lib->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'wearhouse_id' 		=> $this->auth->generator(15),
				'wearhouse_name' 	=> $this->input->post('wearhouse_name',TRUE),
				'wearhouse_address' => $this->input->post('wearhouse_address',TRUE),
				'user_id'			=> $this->session->userdata('user_id'),
				);

			$result=$this->Wearhouses->wearhouse_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-wearhouse'])){
					redirect('Cwearhouse/manage_wearhouse');
				}elseif(isset($_POST['add-wearhouse-another'])){
					redirect('Cwearhouse');
				}

			}else{
				$this->session->set_userdata(array('error_message'=>display('already_inserted')));
				redirect('Cwearhouse');
			}
        }
	}

	//Manage wearhouse
	public function manage_wearhouse()
	{
        $content =$this->lwearhouse->wearhouse_list();
		$this->template_lib->full_admin_html_view($content);;
	}
	
	//wearhouse Update Form
	public function wearhouse_update_form($wearhouse_id)
	{	
		$content = $this->lwearhouse->wearhouse_edit_data($wearhouse_id);
		$this->template_lib->full_admin_html_view($content);
	}
	// wearhouse Update
	public function wearhouse_update($wearhouse_id=null)
	{

		$this->form_validation->set_rules('wearhouse_name', display('wearhouse_name'), 'trim|required');
		$this->form_validation->set_rules('wearhouse_address', display('wearhouse_address'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('manage_wearhouse')
			);
        	$content = $this->parser->parse('wearhouse/wearhouse',$data,true);
			$this->template_lib->full_admin_html_view($content);
        }
        else
        {
			$data=array(
				'wearhouse_name' 	=> $this->input->post('wearhouse_name',TRUE),
				'wearhouse_address'	=> $this->input->post('wearhouse_address',TRUE),
				);

			$result=$this->Wearhouses->update_wearhouse($data,$wearhouse_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cwearhouse/manage_wearhouse');
			}else{
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cwearhouse/manage_wearhouse');
			}
        }
	}
	//wearhouse Product
	public function wearhouse_transfer(){
		$content = $this->lwearhouse->wearhouse_transfer_form();
		$this->template_lib->full_admin_html_view($content);
	}
	//Insert wearhouse product
	public function insert_wearhouse_product(){
		$this->form_validation->set_rules('wearhouse_name', display('wearhouse_name'), 'trim|required');
		$this->form_validation->set_rules('product_name', display('product_name'), 'trim|required');
		$this->form_validation->set_rules('variant', display('variant'), 'trim|required');
		$this->form_validation->set_rules('quantity', display('quantity'), 'trim|required');
		$this->form_validation->set_rules('tax', display('tax'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_wearhouse')
			);
        	$content = $this->parser->parse('wearhouse/add_wearhouse',$data,true);
			$this->template_lib->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'wearhouse_product_id' => $this->auth->generator(15),
				'wearhouse_id' 		   => $this->input->post('wearhouse_name',TRUE),
				'product_id' 	   => $this->input->post('product_name',TRUE),
				'variant_id' 	   => $this->input->post('variant',TRUE),
				'tax_id' 		   => $this->input->post('tax',TRUE),
				'quantity' 		   => $this->input->post('quantity',TRUE)
				);

			$result=$this->Wearhouses->wearhouse_product_entry($data);

			if ($result == TRUE) {
					
				$this->session->set_userdata(array('message'=>display('successfully_added')));

				if(isset($_POST['add-wearhouse'])){
					redirect('Cwearhouse/manage_wearhouse');
				}elseif(isset($_POST['add-wearhouse-another'])){
					redirect('Cwearhouse');
				}

			}else{
				$this->session->set_userdata(array('message'=>display('		successfully_updated')));
				redirect('Cwearhouse/manage_wearhouse');
			}
        }
	}
	//Manage wearhouse
	public function manage_wearhouse_product()
	{
        $content =$this->lwearhouse->wearhouse_product_list();
		$this->template_lib->full_admin_html_view($content);;
	}
	//wearhouse Product Update Form
	public function wearhouse_product_update_form($wearhouse_product_id)
	{	
		$content = $this->lwearhouse->wearhouse_product_edit_data($wearhouse_product_id);
		$this->template_lib->full_admin_html_view($content);
	}
	// wearhouse Product Update
	public function wearhouse_product_update($wearhouse_product_id=null)
	{

		$this->form_validation->set_rules('wearhouse_name', display('wearhouse_name'), 'trim|required');
		$this->form_validation->set_rules('product_name', display('product_name'), 'trim|required');
		$this->form_validation->set_rules('variant', display('variant'), 'trim|required');
		$this->form_validation->set_rules('quantity', display('quantity'), 'trim|required');
		$this->form_validation->set_rules('tax', display('tax'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
        	$data = array(
				'title' => display('add_wearhouse')
			);
        	$content = $this->parser->parse('wearhouse/add_wearhouse',$data,true);
			$this->template_lib->full_admin_html_view($content);
        }
        else
        {

			$data=array(
				'wearhouse_id' 		   => $this->input->post('wearhouse_name',TRUE),
				'product_id' 	   => $this->input->post('product_name',TRUE),
				'variant_id' 	   => $this->input->post('variant',TRUE),
				'tax_id' 		   => $this->input->post('tax',TRUE),
				'quantity' 		   => $this->input->post('quantity',TRUE),
				);


			$result=$this->Wearhouses->wearhouse_product_update($data,$wearhouse_product_id);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cwearhouse/manage_wearhouse_product');
			}else{
				$this->session->set_userdata(array('message'=>display('successfully_updated')));
				redirect('Cwearhouse/manage_wearhouse_product');
			}
        }
	}
	//Wearhosue transfer select
	public function wearhouse_transfer_select(){
		$transfer_id = $this->input->post('transfer_id',TRUE);
		$wearhouse_id = $this->input->post('wearhouse_id',TRUE);
		if ($transfer_id == 1) {
			echo "<script type=\"text/javascript\">
			$(document).ready(function() {
			  $(\".js-example-basic-single\").select2();
			});
			</script>";
			$result = $this->Wearhouses->wearhouse_select($wearhouse_id);
			echo "<label for=\"wearhouse\" class=\"col-sm-3 col-form-label\">".display('wearhouse')."<i class=\"text-danger\">*</i></label>
            <div class=\"col-sm-6\">
                <select class=\"form-control js-example-basic-single\" id=\"wearhouse\" name=\"t_warehouse\" required=\"\" >";
                foreach ($result as $wearhouse) {
                 	echo "<option value=".$wearhouse->wearhouse_id.">".$wearhouse->wearhouse_name."</option>";
                }
                echo "</select>
            </div>";
		}elseif($transfer_id == 2){
			echo "<script type=\"text/javascript\">
			$(document).ready(function() {
			  $(\".js-example-basic-single\").select2();
			});
			</script>";
			$result = $this->Stores->store_list_result();
			echo "<label for=\"store\" class=\"col-sm-3 col-form-label\">".display('store')."<i class=\"text-danger\">*</i></label>
            <div class=\"col-sm-6\">
                <select class=\"form-control js-example-basic-single\" id=\"store\" name=\"t_store_id\" required=\"\" >";
                foreach ($result as $store) {
                 	echo "<option value=".$store->store_id.">".$store->store_name."</option>";
                }
                echo "</select>
            </div>";
		}else{
			return FALSE;
		}
	}

	//Insert wearhouse transfer
	public function insert_wearhouse_transfer(){

		$transfer_to = $this->input->post('transfer_to',TRUE);
		if ($transfer_to == 1) {

			$quantity = $this->input->post('quantity',TRUE);

			$data = array(
				'transfer_id'  => $this->auth->generator(15),
				'warehouse_id' => $this->input->post('wearhouse_id',TRUE),
				'product_id'   => $this->input->post('product_id',TRUE),
				'variant_id'   => $this->input->post('variant_id',TRUE),
				'quantity' 	   => "-".$quantity,
				'transfer_by'  => $this->session->userdata('user_id'), 
				't_warehouse_id'  => $this->input->post('t_warehouse',TRUE), 
				'status'	   => 4,
				'date_time'    => date("m-d-Y"), 
			);

			$data1 = array(
				'transfer_id'  => $this->auth->generator(15),
				'warehouse_id' => $this->input->post('t_warehouse',TRUE),
				'product_id'   => $this->input->post('product_id',TRUE),
				'variant_id'   => $this->input->post('variant_id',TRUE),
				'quantity' 	   => $quantity,
				'transfer_by'  => $this->session->userdata('user_id'), 
				't_warehouse_id'  => $this->input->post('wearhouse_id',TRUE), 
				'date_time'    => date("m-d-Y"),
			);

			$result = $this->Wearhouses->wearhouse_transfer($data,$data1);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_inserted')));
				redirect('Cwearhouse/manage_wearhouse_product');
			}else{
				$this->session->set_userdata(array('error_message'=>display('product_is_not_available_please_purchase_product')));
				redirect('Cwearhouse/wearhouse_transfer');
			}
		}elseif ($transfer_to == 2) {
			$quantity = $this->input->post('quantity',TRUE);

			$data = array(
				'transfer_id'  => $this->auth->generator(15),
				'warehouse_id' => $this->input->post('wearhouse_id',TRUE),
				'product_id'   => $this->input->post('product_id',TRUE),
				'variant_id'   => $this->input->post('variant_id',TRUE),
				'quantity' 	   => "-".$quantity,
				'transfer_by'  => $this->session->userdata('user_id'), 
				't_store_id'   => $this->input->post('t_store_id',TRUE), 
				'status' 	   => 3,
				'date_time'    => date("m-d-Y"),
			);

			$data1 = array(
				'transfer_id'  => $this->auth->generator(15),
				'store_id' 	   => $this->input->post('t_store_id',TRUE),
				'product_id'   => $this->input->post('product_id',TRUE),
				'variant_id'   => $this->input->post('variant_id',TRUE),
				'quantity' 	   => $quantity,
				'transfer_by'  => $this->session->userdata('user_id',TRUE), 
				't_warehouse_id'  => $this->input->post('wearhouse_id',TRUE),
				'date_time'    => date("m-d-Y"), 
			);

			$result = $this->Wearhouses->wearhouse_to_store_transfer($data,$data1);

			if ($result == TRUE) {
				$this->session->set_userdata(array('message'=>display('successfully_inserted')));
				redirect('Cwearhouse/manage_wearhouse_product');
			}else{
				$this->session->set_userdata(array('error_message'=>display('product_is_not_available_please_purchase_product')));
				redirect('Cwearhouse/wearhouse_transfer');
			}
		}
	}
	// wearhouse Delete
	public function wearhouse_delete($warehouse_id)
	{
		$result = $this->Wearhouses->delete_wearhouse($warehouse_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Cwearhouse/manage_wearhouse');
		}else{
			$this->session->set_userdata(array('error_message'=>display('you_cant_delete_this_is_in_calculate_system')));
			redirect('Cwearhouse/manage_wearhouse');
		}
	}
	// wearhouse product Delete
	public function wearhouse_product_delete($transfer_id)
	{
		$this->Wearhouses->delete_wearhouse_product($transfer_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		return true;
	}

	//Add Wearhouse CSV
	public function add_wearhouse_csv()
	{
		$CI =& get_instance();
		$data = array(
			'title' => display('import_wearhouse_csv')
		);
		$content = $CI->parser->parse('wearhouse/add_wearhouse_csv',$data,true);
		$this->template_lib->full_admin_html_view($content);
	}
	//CSV Upload File
	function uploadCsv()
    {
        $count=0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'],'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE)
    	{
  
	        while($csv_line = fgetcsv($fp,1024))
	        {
	            //keep this if condition if you want to remove the first row
	            for($i = 0, $j = count($csv_line); $i < $j; $i++)
	            {
	                $insert_csv = array();
	                $insert_csv['wearhouse_name'] = (!empty($csv_line[0])?$csv_line[0]:null);
	                $insert_csv['wearhouse_address'] = (!empty($csv_line[1])?$csv_line[1]:null);
	            }
	      
	            $data = array(
	            	'wearhouse_id' 		=> $this->auth->generator(10),
	                'wearhouse_name' 	=> $insert_csv['wearhouse_name'],
	                'wearhouse_address' => $insert_csv['wearhouse_address'],
	            );

	            if ($count > 0) {
			        $result = $this->db->select('*')
			        					->from('wearhouse_set')
			        					->where('wearhouse_name',$data['wearhouse_name'])
			        					->get()
			        					->num_rows();

		        	if ($result == 0 && !empty($data['wearhouse_name'])) {
			        	$this->db->insert('wearhouse_set',$data);
			        }else {
					    $this->db->where('wearhouse_name',$data['wearhouse_name']);
			            $this->db->update('wearhouse_set',$data);
			        }
	            } 
	            $count++;
	        }
        }

        fclose($fp) or die("Can't close file");
        $this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-wearhouse'])){
			redirect(base_url('Cwearhouse/manage_wearhouse'));
			exit;
		}elseif(isset($_POST['add-wearhouse-another'])){
			redirect(base_url('Cwearhouse'));
			exit;
		}
    }
}