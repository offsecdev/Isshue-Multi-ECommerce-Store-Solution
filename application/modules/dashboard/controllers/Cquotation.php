<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cquotation extends MX_Controller {
	
	function __construct() {
      	parent::__construct();
      	$this->auth->check_user_auth();
    }
	public function index()
	{
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->quotation_add_form();
		$this->template_lib->full_admin_html_view($content);
	}
	//Add new quotation
	public function new_quotation()
	{
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->quotation_add_form();
		$this->template_lib->full_admin_html_view($content);
	}
	//Insert product and upload
	public function insert_quotation()
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$quotation_id = $CI->Quotations->quotation_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		$this->quotation_inserted_data($quotation_id);

		if(isset($_POST['add-quotation'])){
			redirect(base_url('Cquotation/manage_quotation'));
		}elseif(isset($_POST['add-quotation-another'])){
			redirect(base_url('Cquotation'));
		}
	}
	//Search Inovoice Item
	public function search_inovoice_item()
	{
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		
		$customer_id = $this->input->post('customer_id',TRUE);
        $content = $CI->lquotation->search_inovoice_item($customer_id);
		$this->template_lib->full_admin_html_view($content);
	}
	//Product Add Form
	public function manage_quotation()
	{	
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$CI->load->model('Quotations');

        $content = $CI->lquotation->quotation_list();
		$this->template_lib->full_admin_html_view($content);
	}
	
	//quotation Update Form
	public function quotation_update_form($quotation_id)
	{	
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->quotation_edit_data($quotation_id);
		$this->template_lib->full_admin_html_view($content);
	}
	//POS quotation page load
	public function pos_quotation(){
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->pos_quotation_add_form();
		$this->template_lib->full_admin_html_view($content);
	}
	// Quotation Update
	public function quotation_update()
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$quotation_id = $CI->Quotations->update_quotation();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		$this->quotation_inserted_data($quotation_id);
	}
	// Quotation paid data
	public function quot_paid_data($quotation_id){
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$quotation_id = $CI->Quotations->quot_paid_data($quotation_id);
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		redirect('Cquotation/manage_quotation');
	}
	//Retrive right now inserted data to cretae html
	public function quotation_inserted_data($quotation_id)
	{	
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->quotation_html_data($quotation_id);		
		$this->template_lib->full_admin_html_view($content);
	}
	//Retrive right now inserted data to cretae html
	public function quotation_details_data($quotation_id)
	{	
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->quotation_details_data($quotation_id);	
		$this->template_lib->full_admin_html_view($content);
	}
	//Retrive right now inserted data to cretae html
	public function pos_quotation_inserted_data($quotation_id)
	{	
		$CI =& get_instance();
		$CI->load->library('Lquotation');
		$content = $CI->lquotation->pos_quotation_html_data($quotation_id);		
		$this->template_lib->full_admin_html_view($content);
	}
	// retrieve_product_data
	public function retrieve_product_data()
	{	
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$product_id = $this->input->post('product_id',TRUE);
		$product_info = $CI->Quotations->get_total_product($product_id);
		echo json_encode($product_info);
	}
	// product_delete
	public function quotation_delete($quotation_id)
	{	
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$result = $CI->Quotations->delete_quotation($quotation_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			redirect('Cquotation/manage_quotation');
		}	
	}
	//AJAX quotation STOCKs
	public function product_stock_check($product_id)
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');

		$purchase_stocks = $CI->Quotations->get_total_purchase_item($product_id);	
		$total_purchase = 0;		
		if(!empty($purchase_stocks)){	
			foreach($purchase_stocks as $k=>$v){
				$total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
			}
		}
		$sales_stocks = $CI->Quotations->get_total_sales_item($product_id);
		$total_sales = 0;	
		if(!empty($sales_stocks)){	
			foreach($sales_stocks as $k=>$v){
				$total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
			}
		}
		
		$final_total = ($total_purchase - $total_sales);
		return $final_total ;
	}

	//Search product by product name and category
	public function search_product(){
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$product_name = $this->input->post('product_name',TRUE);
		$category_id  = $this->input->post('category_id',TRUE);
		$product_search = $this->Quotations->product_search($product_name,$category_id);
        if ($product_search) {
            foreach ($product_search as $product) {
            echo "<div class=\"col-xs-6 col-sm-4 col-md-2 col-p-3\">";
                echo "<div class=\"panel panel-bd product-panel select_product\">";
                    echo "<div class=\"panel-body\">";
                        echo "<img src=\"$product->image_thumb\" class=\"img-responsive\" alt=\"\">";
                        echo "<input type=\"hidden\" name=\"select_product_id\" class=\"select_product_id\" value='".$product->product_id."'>";
                    echo "</div>";
                    echo "<div class=\"panel-footer\">$product->product_model - $product->product_name</div>";
                echo "</div>";
            echo "</div>";
        	}
        }else{
        	echo "420";
        }
	}

	//Insert new customer
	public function insert_customer(){
		$CI =& get_instance();
		$CI->load->model('Quotations');

		$customer_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'customer_id' 		=> $customer_id,
			'customer_name' 	=> $this->input->post('customer_name',TRUE),
			'customer_mobile' 	=> $this->input->post('mobile',TRUE),
			'customer_email' 	=> $this->input->post('email',TRUE),
			'status' 			=> 1
			);

		$result=$this->Quotations->customer_entry($data);
		
		if ($result == TRUE) {		
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			redirect(base_url('Cquotation/pos_quotation'));
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			redirect(base_url('Cquotation/pos_quotation'));
		}
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("1","2","3","4","5","6","7","8","9");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,8);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}
}