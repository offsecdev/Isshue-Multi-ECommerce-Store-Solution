<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_dashboards extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//Retruve profile data
	public function profile_edit_data()
	{
		$customer_id = $this->session->userdata('customer_id');
		$this->db->select('*');
		$this->db->from('customer_information');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}

	//Update Customer Profile
	public function profile_update()
	{
		$this->load->library('upload');
	    if (($_FILES['image']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1024';
            $config['max_width']     = '*';
            $config['max_height']    = '*';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']  = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('customer_dashboard/edit_profile');
            } else {
                $view =$this->upload->data();
                $image=$config['upload_path'].$view['file_name'];
            }
        }

       	$old_image 	 = $this->input->post('old_image',TRUE);
       	$customer_id = $this->session->userdata('customer_id');

		$data = array(
			'first_name' 		=> $this->input->post('first_name',TRUE),
			'last_name'  		=> $this->input->post('last_name',TRUE),
			'customer_email'  	=> $this->input->post('email',TRUE),
			'customer_mobile'  	=> $this->input->post('customer_mobile',TRUE),
			'customer_short_address' => $this->input->post('customer_short_address',TRUE),
			'customer_address_1'=> $this->input->post('customer_address_1',TRUE),
			'customer_address_2'=> $this->input->post('customer_address_2',TRUE),
			'city'  			=> $this->input->post('city',TRUE),
			'state'  			=> $this->input->post('state',TRUE),
			'country'  			=> $this->input->post('country',TRUE),
			'zip'  				=> $this->input->post('zip',TRUE),
			'company'  			=> $this->input->post('company',TRUE),
			'image'  		    => (!empty($image)?$image:$old_image),
		);

		$this->db->where('customer_id',$customer_id);
		$this->db->update('customer_information',$data);

		return true;
	}

	//Change Password
	public function change_password($email,$old_password,$new_password)
	{
		$user_name 	= md5("gef".$new_password);
		$password 	= md5("gef".$old_password);
        $this->db->where(array('customer_email'=>$email,'password'=>$password));
		$query = $this->db->get('customer_information');
		$result =  $query->result_array();
		
		if (count($result) == 1)
		{	
			$this->db->set('password',$user_name);
			$this->db->where('password',$password);
			$this->db->where('customer_email',$email);
			$this->db->update('customer_information');

			return true;
		}
		return false;
	}
}