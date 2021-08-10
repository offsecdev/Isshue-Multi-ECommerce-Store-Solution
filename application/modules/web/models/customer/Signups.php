<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signups extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //Insert user signup
    public function user_signup($data)
    {
        $CI =& get_instance();
        $CI->load->model('Soft_settings');
        $sms_service = $CI->Soft_settings->retrieve_setting_editdata();
        if ($sms_service[0]['sms_service'] == 1) {
            $mobile = $data['customer_mobile'];
            $this->send_sms("Registration", $mobile);
        }
        $result = $this->db->insert('customer_information', $data);
        
        if ($result) {
            $this->db->select('*');
            $this->db->from('customer_information');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
            }
            $cache_file = './my-assets/js/admin_js/json/customer.json';
            $customerList = json_encode($json_customer);
            file_put_contents($cache_file, $customerList);
            return TRUE;
        }
        return false;
    }

//send sms
    public function send_sms($type, $mobile)
    {
        $CI =& get_instance();
        $CI->load->model('Soft_settings');
        $gateway = $CI->Soft_settings->retrieve_active_getway();

        $sms_template = $CI->db->select('*')->from('sms_template')->where('type', $type)->get()->row();
        $sms = $CI->db->select('*')->from('sms_configuration')->where('status', 1)->get()->row();


        if (1 == $gateway->id) {
            /****************************
             * SMSRank Gateway Setup
             ****************************/

            $message = $sms_template->message;
            $url = "http://api.smsrank.com/sms/1/text/singles";
            $username = $sms->user_name;
            $password = base64_encode($sms->password);
            $message = base64_encode($message);
            $recipients = $mobile;

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, "$url?username=$username&password=$password&to=$recipients&text=$message");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
            curl_setopt($curl, CURLOPT_USERAGENT, $agent);
            $output = json_decode(curl_exec($curl), true);
            return true;
            curl_close($curl);

        }

        if (2 == $gateway->id) {
            /****************************
             * nexmo Gateway Setup
             ****************************/
            $api = $sms->user_name;
            $secret_key = $sms->password;
            $message = $sms_template->message;
            $from = $sms->sms_from;


            $data = array(
                'from' => $from,
                'text' => $message,
                'to' => $mobile
            );

            require_once APPPATH . 'libraries/nexmo/vendor/autoload.php';

            $basic = new \Nexmo\Client\Credentials\Basic($api, $secret_key);
            $client = new \Nexmo\Client($basic);

            $message = $client->message()->send($data);

            if (!$message) {
                return json_encode(array(
                    'status' => false,
                    'message' => 'Curl error: '
                ));
            } else {
                return json_encode(array(
                    'status' => true,
                    'message' => "success: "
                ));
            }


        }

        if (3 == $gateway->id) {
            /****************************
             * budgetsms Gateway Setup
             ****************************/
            $message = $sms_template->message;
            $from = $sms->sms_from;
            $userid = $sms->userid;
            $username = $sms->user_name;
            $handle = $sms->password;

            $data = array(
                'handle' => $handle,
                'username' => $username,
                'userid' => $userid,
                'from' => $from,
                'msg' => $message,
                'to' => $mobile
            );

            $url = "https://api.budgetsms.net/sendsms/?";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                return json_encode(array(
                    'status' => false,
                    'message' => 'Curl error: ' . curl_error($curl)
                ));
            } else {
                return json_encode(array(
                    'status' => true,
                    'message' => "success: " . $response
                ));
            }

            curl_close($curl);

        }

    }


    //Patent Category List
    public function parent_category_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('cat_type', 1);
        $this->db->where('status', 1);
        $this->db->order_by('menu_pos');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Category list
    public function category_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->order_by('category_name', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Best sales list
    public function best_sales()
    {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('best_sale', '1');
        $this->db->limit('6');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Footer block
    public function footer_block()
    {
        $this->db->select('*');
        $this->db->from('web_footer');
        $this->db->order_by('position');
        $this->db->limit('4');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
}