<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Model {
  
    public $todays_date;
    public $sub_total;
    public $Idtrack_link=1;

    public function __construct(){
        parent::__construct();
        
date_default_timezone_set(DEF_TIMEZONE);
        $this->todays_date = date("m-d-Y");
    }
        
    //Payment account finder
    public function accounts_name_finder($status=1){
        $this->db->select("*");
        $this->db->from('accounts');
        $this->db->where('status',$status);
        $query = $this->db->get();
        return $query->result_array();  
    }

    //customer_ledger ENTRY
    public function customer_ledger( $data ){
        $this->db->insert('customer_ledger',$data); 
    }
        
    // supplier_ledger Entry
    public function supplier_ledger($data){
        $this->db->insert('supplier_ledger',$data); 
    }

    //Following function will receive payment inflow & Outflow.
    public function pay_table($data,$account_table){
        $account_table;
        $this->db->insert($account_table,$data);
    }

    //DRAWING ENTRY
    public function drawing_entry( $data )
    {
        $this->db->insert('drawing_add',$data); 
    }
    //TRANSACTION ENTRY
    public function expence_entry( $data )
    {
        $this->db->insert('expence_add',$data); 
    }
    //BANKING ENTRY
    public function banking_data_entry( $data )
    {
        $this->db->insert('daily_banking_add',$data); 
    }

    //BANKING ENTRY
   public function daily_closing_entry( $data ){
        $this->db->insert('daily_closing',$data); 
    }

    // This function will find out all closing information of daily closing.
    public function accounts_closing_data()
    {
      $last_closing_amount= $this->get_last_closing_amount();

      $cash_in=  $this->cash_data(2);
      $cash_out=  $this->cash_data(1);

      $cash_in_hand=$last_closing_amount[0]['amount']+$cash_in-$cash_out;
      return array(
            "title"             =>  display('day_closing'),
            "last_day_closing"  =>  number_format($last_closing_amount[0]['amount'], 2, '.', ','),
            "cash_in"           =>  number_format($cash_in, 2, '.', ','),
            "cash_out"          =>  number_format($cash_out, 2, '.', ','),
            "cash_in_hand"      =>  number_format($cash_in_hand, 2, '.', ',')
        );
    }
  
    //Cash data count
    public function cash_data($type)
    {
        $this->db->select('account_table_name');
        $this->db->from('accounts');
        $this->db->where('status',$type);
        $this->db->limit(1);

        $query=  $this->db->get();
        $cash=0;

        foreach($query->result_array() as $result)
        {
            $table=$result['account_table_name'];
            $this->db->select("sum(amount) as 'amount'");
            $this->db->from($table);
            $this->db->where(array('payment_type'=>1,'date >='=>$this->todays_date));
            $result_amount  =  $this->db->get();
            $amount         =  $result_amount->result_array();
            $cash           += $amount[0]['amount'];
        }
        return $cash;
    }

    //Account summary
    public function accounts_summary($type){
        
        $this->db->select('*');
        $this->db->from('accounts');
        $this->db->where('status',$type);
        $query=  $this->db->get();

        $accounts=array();
        $serial=1;
        $total=0;
        foreach($query->result_array() as $result)
        {
            $table=$result['account_table_name'];
        
            $this->db->select("count(amount) as no_trans, sum(amount) as total");
            $this->db->from($table);

            $this->db->where(
                array(
                    'date >='  => $this->todays_date,
                    'account_id'  => $result['account_id'],
                )
            );

            $result_account=  $this->db->get();
            $account=$result_account->result_array();
          
            $no_trans=$account[0]['no_trans'];
            $total +=$account[0]['total'];

            if($no_trans > 0)
            {
              
                $gmdate = gmdate("m-d-Y", time()-(24*60*60));
              
                $link= base_url()."dashboard/Caccounts/summary_single/".$gmdate."/".$this->todays_date."/".$table;
             
                $account_name="<a href='".$link."' >".$result['account_name']."</a>";
            
                $accounts[]=array(
                    "sl"        =>  $serial,
                    "table"     =>  $account_name,
                    "no_transection"    =>$no_trans,
                    "sub_total" =>  $account[0]['total']
                );
                $serial++;
            }
        }
        $this->sub_total=$total;
        return $accounts;
    }

    //Account summary datewise
    public function accounts_summary_datewise($start,$end,$type)
    {
        $this->db->select(' * ');
        $this->db->from('accounts');
        $this->db->where('status',$type);
        $query=  $this->db->get();
        $accounts=array();
        $serial=1;
        $total=0;
        foreach($query->result_array() as $result)
        {
            $table=$result['account_table_name'];
            $this->db->select("count(amount) as no_trans,sum(amount) as 'total'");
            $this->db->from($table);
            $this->db->where(
                array(
                    'date >='=>$start , 
                    'date <='=>$end,
                    'account_id'  => $result['account_id'],
                )
            );
            $result_account=  $this->db->get();
            $account=$result_account->result_array();
          
            $no_trans=$account[0]['no_trans'];
            $total +=$account[0]['total'];
            if($no_trans > 0)
            {
                $gmdate = gmdate("m-d-Y", time()-(24*60*60));
              
                $link= base_url()."dashboard/Caccounts/summary_single/".$start."/".$end."/".$table;
                $account_name="<a href='".$link."' >".$result['account_name']."</a>";
             
                $accounts[]=array("sl"=>$serial,"table"=>$account_name,"no_transection"=>$no_trans,"sub_total"=>$account[0]['total']);
                $serial++;
            }
        }
        $this->sub_total=$total;
        return $accounts;
    }
        
    #===========Single account summary details======#
    public function accounts_summary_details($start,$end,$table){
        $this->db->select(" * ");
        $this->db->from($table);
        $this->db->where(array('date >='=>$start , 'date <='=>$end));
        $result_account=  $this->db->get();
        $account=$result_account->result_array();

        $serial=1;
        $data=array();
        foreach ($account as $account)
        {
            $date=substr($account['date'], 0, 10);
            
            if($account['payment_type']==1){
                $payment_type="Cash";
            }elseif($account['payment_type']==2){
                $payment_type="Cheque";
            }else{
                $payment_type="Pay Order";
            }

            if ($table == 'payment') {
                $id = $this->idtracker($account['tracing_id']);
            }else{
                $id = $this->idtracker($account['customer_id']);
            }
            
           $data[]= array(
                "sl"            =>  $serial++,
                "table"         =>  $table,
                "date"          =>  $date,
                "transection_id"=>  $account['transection_id'],
                "customer_id"   =>  $id,
                "description"   =>  $account['description'],
                "amount"        =>  $account['amount'],
                "payment_type"  =>  $payment_type
            );
        }
        return $data;
    }
    
    #==========ID tracker customer/supplier=======#   
    public function idtracker($id){

        $this->db->select(" * ");
        $this->db->from('customer_information');
        $this->db->where(array('customer_id ='=>$id));
        $result_account=  $this->db->get();
        $account=$result_account->result_array();
        
        $afrows=$this->db->affected_rows();
        if($afrows==0){
            $this->db->select(" * ");
            $this->db->from('supplier_information');
            $this->db->where(array('supplier_id ='=>$id));
            $result_account=  $this->db->get();
            $account=$result_account->result_array();
            $afrows=$this->db->affected_rows();
            
            if($afrows==0)
            {
                return $id;
            }else{
                $supplier="<a href=".base_url()."dashboard/Csupplier/supplier_ledger/".$id.">".$account[0]['supplier_name']."</a>";
                if($this->Idtrack_link ==   1){
                    return $supplier;
                }
                else{
                    return $account[0]['supplier_name'];
                }
            }
        }
        else{
            $customer="<a href=".base_url()."dashboard/Ccustomer/customerledger/".$id.">".$account[0]['customer_name']."</a>";
            
            if($this->Idtrack_link==1){
                return $customer;
            }else{
                return $account[0]['customer_name'];
            }
        }
    }

    #=======IN/OUT delete===============#
    public function in_out_del($transection_id,$table){

        if($table == "received"){
            $this->db->delete('customer_ledger', array('transaction_id' => $transection_id));  
        }
        else{
            $this->db->delete('supplier_ledger', array('transaction_id' => $transection_id));
        }

        $this->db->delete($table, array('transection_id' => $transection_id)); 
    }
  
    //THis function will delete any data from table.
    public function data_del_table($table,$transection_id)
    {
        $this->db->delete($table, array('transection_id' => $transection_id)); 
    }

    //THis function will delete any data from table.
    public function delete_all_table_data($table,$condation)
    {
        $this->db->delete($table, $condation); 
    }

    #============Inflow edit==============#
    public function inflow_edit($transection_id,$table,$type){
        $this->load->model('settings');
         
        $this->db->select(' * ');
        $this->db->from('customer_ledger');
        $this->db->where('transaction_id',$transection_id);
        $query=  $this->db->get();
        $result=$query->result_array();
         
        if($result[0]["payment_type"]==1){
            $result[0]["payment"]="Cash";
        }else{
            $result[0]["payment"]="Cheque";
        }

        $this->Idtrack_link = 0; //0 means return will be without link.
        $result[0]["name"]  = $this->idtracker($result[0]["customer_id"]);
        $result[0]["accounts"]=$this->table_name($type);
        $result[0]["selected"]=$this->table_name_finder($table);
        $result[0]["selected_table_id"] = $table;
         
        $result[0]["transection_id"] = $transection_id;
         
        $result[0]["bank"]=$this->settings->get_bank_list();
        $result[0]['store_list'] = $this->Stores->store_list();

        $selected_store_id = $this->db->select('*')
                                        ->from($table)
                                        ->where('transection_id',$transection_id)
                                        ->get()
                                        ->row();

        $result[0]["selected_store"] = $this->db->select('*')
                                        ->from('store_set')
                                        ->where('store_id',$selected_store_id->store_id)
                                        ->get()
                                        ->result();
        //Banking selection
        $cheque_manager=$this->transection_info($transection_id,"cheque_manger",array("transection_id"=>$transection_id));

        if ($cheque_manager) {
           $bank_name=$this->transection_info($transection_id,"bank_add",array("bank_id"=>$cheque_manager[0]["bank_id"]));
          $result[0]["selected_bank_id"]=$cheque_manager[0]["bank_id"];
          $result[0]["selected_bank"]=$bank_name[0]["bank_name"];
        }
        return $result;
    }
    #========Inflow edit=============#
    public function outflow_edit($transection_id,$table,$type){

        $this->load->model('settings');

        $this->db->select(' * ');
        $this->db->from('supplier_ledger');
        $this->db->where('transaction_id',$transection_id);
        $query=  $this->db->get();
        $result=$query->result_array();

        if($result[0]["payment_type"]==1){
            $result[0]["payment"] = "Cash";
        }else{
            $result[0]["payment"] = "Cheque";
        }

        $this->Idtrack_link = 0; //0 means return will be without link.
        $result[0]["name"]=$this->idtracker($result[0]["supplier_id"]);
        $result[0]["accounts"]=$this->table_name($type);
        $result[0]["selected"]=$this->table_name_finder($table);
        $result[0]["selected_table_id"]=$table;
    

        $selected_store_id = $this->db->select('*')
                                        ->from($table)
                                        ->where('transection_id',$transection_id)
                                        ->get()
                                        ->row();

        $result[0]["selected_store"] = $this->db->select('*')
                                        ->from('store_set')
                                        ->where('store_id',$selected_store_id->store_id)
                                        ->get()
                                        ->result();

        $result[0]["transaction_id"]=$transection_id;
        $result[0]["bank"]=$this->settings->get_bank_list();
        $result[0]['store_list'] = $this->Stores->store_list();
        
        //Banking selection
        $cheque_manager=$this->transection_info($transection_id,"cheque_manger",array("transection_id"=>$transection_id));
        if ($cheque_manager) {
            $bank_name=$this->transection_info($transection_id,"bank_add",array("bank_id"=>$cheque_manager[0]["bank_id"]));
            $result[0]["selected_bank_id"]=$cheque_manager[0]["bank_id"];
            $result[0]["selected_bank"]=$bank_name[0]["bank_name"];
        }
        
        return $result;
    }
    #=============Check manager count===========#
    public function cheque_manager_count(){
        $this->db->select('*');
        $this->db->from('cheque_manger');
        $this->db->where('status',1);
        $query=  $this->db->get();
        return $result=$query->num_rows();
    }

    ######### Cheque Manager  || data Retreive ########## 
    public function cheque_manager($limit, $page)
    {
        $this->db->select(' * ');
        $this->db->from('cheque_manger');
        $this->db->where('status',1);
        $this->db->limit($limit, $page);
        $this->db->order_by('date','desc');
        $query=  $this->db->get();
        $result=$query->result_array();

        // Rearrange the internal data.
        $i=0;

        foreach($result as $res)
        {
            $result[$i]["sl"]=$i+1;
            $result[$i]["date"]=substr($res['date'], 0, 10);
            $result[$i]["name"]=$this->idtracker($res['customer_id']);

            if($res['cheque_status']=="0")
            { 
                $result[$i]["action"]=1;
                $result[$i]["action_value"]="No Clear";
            }
            else{ 
                $result[$i]["action"]=0;
                $result[$i]["action_value"]="Cleared";
            }

            $bank_name=$this->transection_info("","bank_add",array("bank_id"=>$res["bank_id"]));
            $result[$i]["bank_name"]=$bank_name[0]["bank_name"];
        $i++;
        }       
        return $result;
    }

    ######### Cheque Manager  || data Retreive ##########   
    public function table_name($type)
    {
        $this->db->select(' * ');
        $this->db->from('accounts');
        $this->db->where('status',$type);
        $query=  $this->db->get();
        return $query->result_array();
    } 
  
    public function table_name_finder($table_id)
    {
        $this->db->select(' * ');
        $this->db->from('accounts');
        $this->db->where('account_table_name',$table_id);
        $query=  $this->db->get();
        return $query->result_array();
    } 

    ######### Common function for updating data ############  
    public function data_update($data,$table,$condation)
    {
        $this->db->update($table,$data,$condation);
    }

    ##### ******* Update All *** &&&& End &&&&& #############
    public function transection_info($transection_id,$table,$condation)
    {
        $this->db->select(' * ');
        $this->db->from($table);
        $this->db->where($condation);
        $query=  $this->db->get();
        return $result=$query->result_array();
    }

    public function get_last_closing_amount( )
    {
        $sql = "SELECT amount FROM daily_closing WHERE date = ( SELECT MAX(date) FROM daily_closing)";
        $query = $this->db->query($sql);
        $result= $query->result_array();
        if ($result) {
        return $result;
        }else{
        return FALSE;
        }
    }

    public function invoice_paid_amount()
    {
        $sql = "SELECT sum(paid_amount) as paid_amount FROM invoice ";
        $query = $this->db->query($sql);
        $result= $query->result_array();
        if ($result) {
            return $result;
        }else{
            return FALSE;
        }

    }
  
    public function get_todays_draw_amount(){
        $this->db->select("sum(amount) as 'total_draw_amount'");
        $this->db->from('drawing_add');
        $this->db->where('date',$this->todays_date);
        $query = $this->db->get();      
        return $query->result_array();
    }
  
    public function get_todays_expense_amount(){
        $this->db->select("sum(amount) as 'total_expense_amount'");
        $this->db->from('expence_add');
        $this->db->where('date',$this->todays_date);
        $query = $this->db->get();      
        return $query->result_array();
    }
  
    public function get_todays_cheque_sales_amount(){
        $this->db->select("sum(amount) as 'total_chq_sales_amount'");
        $this->db->from('customer_ledger');
        $this->db->where(array('payment_type'=>2,'date'=>$this->todays_date));
        $query = $this->db->get();      
        return $query->result_array();
    }
  
    public function get_todays_cash_sales_amount(){
        $this->db->select("sum(amount) as 'total_cash_sales_amount'");
        $this->db->from('customer_ledger');
        $this->db->where(array('payment_type'=>1,'date'=>$this->todays_date));
        $query = $this->db->get();      
        return $query->result_array();
    } 
  
    public function get_todays_cheque_to_cash(){
        $this->db->select("sum(amount) as 'cheque_to_cash_amount'");
        $this->db->from('daily_banking_add');
        $this->db->where(array('deposit_type'=>"cheque",'transaction_type'=>"draw",'date'=>$this->todays_date));
        $query = $this->db->get();      
        return $query->result_array();
    }
    
    public function count_daily_closing_data(){
        $this->db->select('*');
        $this->db->from('daily_closing');
        $this->db->where('status',1);
        $query = $this->db->get();      
        return $query->num_rows();
    }

    public function get_closing_report_count(){
        $this->db->select("*");
        $this->db->from('daily_closing');
        $this->db->where('status',1);
        $query = $this->db->get();      
        return $query->num_rows();
    }

    public function get_closing_report(){
        $this->db->select("a.* ,((a.cash_in + if(b.paid_amount,b.paid_amount,0)) - cash_out) as 'cash_in_hand'");
        $this->db->from('daily_closing a');
        $this->db->join('invoice b','a.date=b.date','left');
        $this->db->where('a.status',1);
        $this->db->order_by('date','desc');
        $query = $this->db->get();      
        return $query->result_array();
    }
  
    public function get_date_wise_closing_report( $from_date,$to_date ){
        $dateRange = "date BETWEEN '$from_date%' AND '$to_date%'";
        $this->db->select("* ,cash_in - cash_out as 'cash_in_hand'");
        $this->db->from('daily_closing');
        $this->db->where('status',1);
        $this->db->where($dateRange, NULL, FALSE); 
        $this->db->order_by('date','desc');
        $query = $this->db->get();      
        return $query->result_array();    
    }

    //Table list
    public function account_list()
    {
        $this->db->select('*');
        $this->db->from('accounts');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
        return false;
    }

    //Table create
    public function account_create($account_id)
    {
        $account_name=$this->input->post('account_name',TRUE);
        $status=$this->input->post('account_type',TRUE);

        $account_exists = $this->db->select('*')
                                ->from('accounts')
                                ->where('account_name',$account_name)
                                ->get()
                                ->num_rows();

        if ($account_exists > 0) {
            $this->session->set_userdata(array('error_message'=>display('account_already_exists')));
            return true;
        }else{
            if($status==1){
                $account_table_name="payment";
            }else{
                $account_table_name="received";
            }
        
            $data = array(
                    'account_id'        =>  $this->auth->generator(10),
                    'account_name'      =>  $account_name,
                    'account_table_name'=>  $account_table_name,
                    'status'            =>  $status
                
                );
            
            $this->db->insert('accounts',$data);

            $this->session->set_userdata(array('message'=>display('successfully_created')));
        }
    }
    //Retrive table data by id
    public function retrive_table_data($account_id){
        $this->db->select('*');
        $this->db->from('accounts');
        $this->db->where('account_id',$account_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
        return false;
    }
    //Update table data by id
    public function update_table_data($account_name,$account_id){

            $this->db->where('account_id',$account_id);
            $this->db->update('accounts',$account_name);
            $this->session->set_userdata(array('message'=>display('successfully_updated')));
            return true;
       
    }
}