<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Count stock report
    public function count_stock_report()
    {
        $this->db->select("a.product_name,a.product_id,a.price,a.product_model,sum(b.quantity) as 'totalSalesQnty',(select sum(product_purchase_details.quantity) from product_purchase_details where product_id= `a`.`product_id`) as 'totalBuyQnty'");
        $this->db->from('product_information a');
        $this->db->join('invoice_details b', 'b.product_id = a.product_id');
        $this->db->where(array('a.status' => 1, 'b.status' => 1));
        $this->db->group_by('a.product_id');
        $query = $this->db->get();
        return $query->num_rows();

    }

    //Stock report
    public function stock_report($limit, $page)
    {
        $this->db->select("a.product_name,a.product_id,a.price,a.product_model,sum(b.quantity) as 'totalSalesQnty',(select sum(product_purchase_details.quantity) from product_purchase_details where product_id= `a`.`product_id`) as 'totalBuyQnty'");
        $this->db->from('product_information a');
        $this->db->join('invoice_details b', 'b.product_id = a.product_id');
        $this->db->where(array('a.status' => 1, 'b.status' => 1));
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_id', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Out of stock
    public function out_of_stock()
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(d.quantity) as totalSalesQnty,
			sum(b.quantity) as totalPurchaseQnty,
			e.purchase_date as purchase_date,
			e.purchase_id,
			(sum(b.quantity) - sum(d.quantity)) as stock
			");

        $this->db->from('product_information a');
        $this->db->join('product_category c', 'c.category_id = a.category_id', 'left');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('invoice_details d', 'd.product_id = a.product_id', 'left');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id', 'left');
        $this->db->group_by('a.product_id');
        $this->db->having('stock < 10', null, false);
        $this->db->having('totalPurchaseQnty < 10', null, false);
        $this->db->order_by('a.product_name', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Out of stock count
    public function out_of_stock_count()
    {
        $this->db->query("SET SQL_BIG_SELECTS=1"); // for avoid max_join_size.
        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(d.quantity) as totalSalesQnty,
			sum(b.quantity) as totalPurchaseQnty,
			e.purchase_date as purchase_date,
			e.purchase_id,
			(sum(b.quantity) - sum(d.quantity)) as stock
			");

        $this->db->from('product_information a');
        $this->db->join('product_category c', 'c.category_id = a.category_id', 'left');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('invoice_details d', 'd.product_id = a.product_id', 'left');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id', 'left');
        $this->db->group_by('a.product_id');
        $this->db->having('stock < 10', null, false);
        $this->db->having('totalPurchaseQnty < 10', null, false);
        $this->db->order_by('a.product_name', 'asc');

        $query = $this->db->get();
        return $query->num_rows();
    }

    //Stock report single item
    public function stock_report_single_item($product_id)
    {
        $this->db->select("a.product_name,a.price,a.product_model,sum(b.quantity) as 'totalSalesQnty',sum(c.quantity) as 'totalBuyQnty'");
        $this->db->from('product_information a');
        $this->db->join('invoice_details b', 'b.product_id = a.product_id');
        $this->db->join('product_purchase_details c', 'c.product_id = a.product_id');
        $this->db->where(array('a.product_id' => $product_id, 'a.status' => 1, 'b.status' => 1));
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Stock Report by date
    public function stock_report_bydate($product_id, $date, $limit, $page)
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as totalPurchaseQnty,
			e.purchase_date as purchase_date,
			e.purchase_id,
			f.unit_name
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name', 'asc');

        if (empty($product_id)) {
            $this->db->where(array('a.status' => 1));
        } else {
            //Single product information
            $this->db->where(array('a.status' => 1, 'e.purchase_date <= ' => $date, 'a.product_id' => $product_id));
        }

        $this->db->limit($limit, $page);
        $query = $this->db->get();

        return $query->result_array();
    }

    //Counter of unique product histor which has been affected
    public function product_counter($product_id, $date)
    {
        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as totalPurchaseQnty,
			e.purchase_date as purchase_date,
			e.purchase_id,
			f.unit_name
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name', 'asc');

        if (empty($product_id)) {
            $this->db->where(array('a.status' => 1));
        } else {
            //Single product information
            $this->db->where(array('a.status' => 1, 'e.purchase_date <= ' => $date, 'a.product_id' => $product_id));
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    //Stock report product by date
    public function stock_report_product_bydate($product_id, $supplier_id, $from_date, $to_date, $per_page, $page)
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as 'totalPurchaseQnty',
			e.purchase_date as date
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name', 'asc');
        $this->db->limit($per_page, $page);

        if (empty($supplier_id)) {
            $this->db->where(array('a.status' => 1));
        } else {
            $this->db->where(
                array(
                    'a.status' => 1,
                    'a.supplier_id' => $supplier_id,
                    'a.product_id' => $product_id
                )
            );
            $this->db->where("STR_TO_DATE(e.purchase_date, '%m-%d-%Y') BETWEEN DATE('".$from_date."') AND DATE('".$to_date."')");
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //Stock report product by date count
    public function stock_report_product_bydate_count($product_id, $supplier_id, $from_date, $to_date)
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as 'totalPurchaseQnty',
			e.purchase_date as date
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name', 'asc');

        if (empty($supplier_id)) {
            $this->db->where(array('a.status' => 1));
        } else {
            $this->db->where(
                array(
                    'a.status' => 1,
                    'a.supplier_id' => $supplier_id,
                    'a.product_id' => $product_id
                )
            );
            $this->db->where("STR_TO_DATE(e.purchase_date, '%m-%d-%Y') BETWEEN DATE('".$from_date."') AND DATE('".$to_date."')");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    //Stock report supplier by date
    public function stock_report_supplier_bydate($product_id, $supplier_id, $date, $perpage, $page)
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as 'totalPrhcsCtn',
			e.purchase_date as purchase_date,
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name', 'asc');

        if (empty($supplier_id)) {
            $this->db->where(array('a.status' => 1));
        } else {
            $this->db->where('a.status', 1);
            $this->db->where('e.purchase_date <=', $date);
            $this->db->where('a.supplier_id', $supplier_id);
        }
        $this->db->limit($perpage, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Counter of unique product histor which has been affected
    public function product_counter_by_supplier($supplier_id, $date)
    {
        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as 'totalPrhcsCtn',
			e.purchase_date as purchase_date,
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('product_purchase e', 'e.purchase_id = b.purchase_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name', 'asc');

        if (empty($supplier_id)) {
            $this->db->where(array('a.status' => 1));
        } else {
            $this->db->where('a.status', 1);
            $this->db->where('e.purchase_date <=', $date);
            $this->db->where('a.supplier_id', $supplier_id);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

//get stock report store wise
    public function stock_report_by_store($from_date, $to_date, $store_id, $perpage, $page, $product_id = false)
    {
        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			b.date_time as purchase_date,
            g.variant_name,
			g.variant_id,
            ga.variant_id as variant_color,
            ga.variant_name as variant_color_name,
			h.store_name,
			h.store_id,
			");
        $wh = "date_format( str_to_date( date_time, '%m-%d-%Y' ) , '%Y-%m-%d' ) Between '" . $from_date . "' AND'" . $to_date . "'";

        $this->db->from('product_information a');
        $this->db->join('transfer b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('variant ga', 'ga.variant_id = b.variant_color', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->group_by('a.product_id');
        $this->db->group_by('g.variant_id');
        $this->db->group_by('h.store_id');
        $this->db->order_by('a.product_name', 'asc');

        $this->db->where('a.status', 1);
        $this->db->where('b.store_id', $store_id);
        if(!empty($product_id)){
            $this->db->where('a.product_id', $product_id);
        }
        $this->db->where($wh);

        $this->db->limit($perpage, $page);
        $query = $this->db->get();
        return $query->result_array();
    }


//Stock report variant by date
    public function stock_report_variant_bydate($from_date, $to_date, $store_id, $perpage, $page)
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			sum(b.quantity) as totalPrhcsCtn,
			b.date_time as purchase_date,
			g.variant_name,
			g.variant_id,
			h.store_name,
			h.store_id,
			");

        $this->db->from('product_information a');
        $this->db->join('transfer b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->where('b.store_id !=', null);
        $this->db->where('b.t_store_id =', null);
        $this->db->group_by('a.product_id');
        $this->db->group_by('g.variant_id');
        $this->db->group_by('h.store_id');
        $this->db->order_by('a.product_name', 'asc');

        if (empty($from_date)) {
            $this->db->where('a.status', 1);
        } else {
            $this->db->where('a.status', 1);
            $this->db->where('b.date_time >=', $from_date);
            $this->db->where('b.date_time <=', $to_date);
            $this->db->where('b.store_id', $store_id);
        }
        $this->db->limit($perpage, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Counter of unique product histor which has been affected
    public function stock_report_variant_bydate_count($from_date, $to_date, $store_id, $product_id = false)
    {

        $this->db->select("
			a.product_name,
			a.unit,
			a.product_id,
			a.price,
			a.supplier_price,
			a.product_model,
			c.category_name,
			b.date_time as purchase_date,
			g.variant_name,
			g.variant_id,
			h.store_name,
			h.store_id,
			");
        $wh = "date_format( str_to_date( date_time, '%m-%d-%Y' ) , '%Y-%m-%d' ) Between '" . $from_date . "' AND'" . $to_date . "'";
        $this->db->from('product_information a');
        $this->db->join('transfer b', 'b.product_id = a.product_id', 'left');
        $this->db->join('product_category c', 'c.category_id = a.category_id');
        $this->db->join('unit f', 'f.unit_id = a.unit', 'left');
        $this->db->join('variant g', 'g.variant_id = b.variant_id', 'left');
        $this->db->join('store_set h', 'h.store_id = b.store_id');
        $this->db->group_by('a.product_id');
        $this->db->group_by('g.variant_id');
        $this->db->group_by('h.store_id');
        $this->db->order_by('a.product_name', 'asc');


        $this->db->where('a.status', 1);
        $this->db->where('b.store_id', $store_id);
        if(!empty($product_id)){
            $this->db->where('a.product_id', $product_id);
        }
        $this->db->where($wh);
        $query = $this->db->get();

        return $query->num_rows();
    }

// ====================STORE WISE STOCK REPORT =======================
    public function store_wise_product($per_page = NULL, $page = NULL)
    {

        $this->db->select('
			a.store_name,
			a.store_id,
			b.*,
			SUM(b.quantity) as quantity,
			c.product_name,
			c.product_id,
			c.product_model,
			d.variant_name,
			d.variant_id				
			');
        $this->db->from('store_set a');
        $this->db->join('transfer b', 'a.store_id= b.store_id', 'left');
        $this->db->join('product_information c', 'c.product_id = b.product_id');
        $this->db->join('variant d', 'd.variant_id = b.variant_id');

        $this->db->group_by('b.product_id');
        $this->db->group_by('b.variant_id');
        $this->db->group_by('a.store_id');
        $this->db->order_by('a.store_name', 'asc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        $result = $query->result();

        $test = [];
        foreach ($result as $product) {

            $sql = 'select sum(a.quantity) as sell from order_details a  where store_id="' . $product->store_id . '" and product_id="' . $product->product_id . '" and variant_id="' . $product->variant_id . '"';
            $product_sell = $this->db->query($sql)->row();
            $test[] = array_merge((array)$product, (array)$product_sell);
        }


        if ($test != NULl && !empty($test)) {
            return $test;
        }
        return false;


    }

    // ====================INDIVIDUAL STORE WISE STOCK REPORT =======================
    public function individual_store_wise_product($per_page = NULL, $page = NULL)
    {

        $store_id = $this->session->userdata('store_id');

        $this->db->select('
			a.store_name,
			a.store_id,
			b.*,
			SUM(b.quantity) as quantity,
			c.product_name,
			c.product_id,
			c.product_model,
			d.variant_name,
			d.variant_id				
			');
        $this->db->from('store_set a');
        $this->db->join('transfer b', 'a.store_id= b.store_id', 'left');
        $this->db->join('product_information c', 'c.product_id = b.product_id');
        $this->db->join('variant d', 'd.variant_id = b.variant_id');

        $this->db->where('b.store_id=', $store_id);
        $this->db->group_by('b.product_id');
        $this->db->group_by('b.variant_id');
        $this->db->group_by('a.store_id');
        $this->db->order_by('a.store_name', 'asc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        $result = $query->result();

        $test = [];
        foreach ($result as $product) {

            $sql = 'select sum(a.quantity) as sell from invoice_details a  where store_id="' . $store_id . '" and product_id="' . $product->product_id . '" and variant_id="' . $product->variant_id . '"';
            $product_sell = $this->db->query($sql)->row();
            $test[] = array_merge((array)$product, (array)$product_sell);
        }


        if ($test != NULl && !empty($test)) {
            return $test;
        }
        return false;


    }

//=============sales report store wise=================

    public function retrieve_sales_report_store_wise($store_id, $start_date = null, $end_date = null)
    {
         $dateRange = "STR_TO_DATE(a.date, '%m-%d-%Y') BETWEEN DATE('$start_date') AND DATE('$end_date')";
        $this->db->select("a.*,b.store_name");
        $this->db->from('invoice a');
        $this->db->join('store_set b', 'a.store_id = b.store_id');
        $this->db->where('a.store_id', $store_id);
        if ($dateRange) {
            $this->db->where($dateRange, NULL, FALSE);
        }
        $this->db->order_by('a.date', 'desc');
        $this->db->limit('500');
        $query = $this->db->get();
        return $query->result_array();
    }


    //Retrieve todays_sales_report
    public function todays_total_sales_report()
    {
        $today = date('m-d-Y');

        $this->db->select('date,
			invoice,
			SUM(total_amount) as total_sale');
        $this->db->from('invoice');
        $this->db->where('date', $today);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve todays_total_purchase_report
    public function todays_total_purchase_report()
    {
        $today = date('m-d-Y');

        $this->db->select('purchase_date,
			invoice_no,
			SUM(grand_total_amount) as total_purchase');
        $this->db->from('product_purchase');
        $this->db->where('purchase_date', $today);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve todays_total_discount_report
    public function todays_total_discount_report()
    {
        $today = date('m-d-Y');

        $this->db->select('date,
			invoice,
			SUM(invoice_discount) as total_discount');
        $this->db->from('invoice');
        $this->db->where('date', $today);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve todays_sales_report
    public function todays_sales_report($per_page, $page)
    {
        $today = date('m-d-Y');
        $this->db->select("a.*,b.customer_id,b.customer_name");
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('a.date', $today);
        $this->db->limit($per_page, $page);
        $this->db->order_by('a.invoice_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve todays_sales_report_count
    public function todays_sales_report_count()
    {
        $today = date('m-d-Y');
        $this->db->select("a.*,b.customer_id,b.customer_name");
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('a.date', $today);
        $this->db->order_by('a.invoice_id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //Retrieve store_to_store_transfer
    public function store_to_store_transfer($from_date = false, $to_date = false, $from_store = false, $to_store = false)
    {
        $today = date("m-d-Y");
        $this->db->select("
			a.*,
			b.store_name,
			c.product_name,
			c.product_model,
			d.variant_name,
			e.store_name as t_store_name
			");
        $this->db->from('transfer a');
        $this->db->join('store_set b', 'b.store_id = a.store_id');
        $this->db->join('product_information c', 'c.product_id = a.product_id');
        $this->db->join('variant d', 'd.variant_id = a.variant_id');
        $this->db->join('store_set e', 'e.store_id = a.t_store_id');


        if (!empty($from_store)) {
            $this->db->where('a.store_id', $from_store);
        }
        if (!empty($to_store)) {
            $this->db->where('a.t_store_id', $to_store);
        }

        if (!empty($from_date) && !empty($to_date)) {
             $dateRange = "STR_TO_DATE(a.date_time, '%m-%d-%Y') BETWEEN DATE('$from_date') AND DATE('$to_date')";
        }

        $this->db->where('a.status', 1);
        $this->db->order_by('a.transfer_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve store_to_warehouse_transfer
    public function store_to_warehouse_transfer($from_date, $to_date, $from_store, $t_wearhouse)
    {
        $today = date("m-d-Y");
        $this->db->select("
			a.*,
			b.store_name,
			c.product_name,
			c.product_model,
			d.variant_name,
			e.wearhouse_name as t_wearhouse_name
			");
        $this->db->from('transfer a');
        $this->db->join('store_set b', 'b.store_id = a.store_id');
        $this->db->join('product_information c', 'c.product_id = a.product_id');
        $this->db->join('variant d', 'd.variant_id = a.variant_id');
        $this->db->join('wearhouse_set e', 'e.wearhouse_id = a.t_warehouse_id');
        if (!empty($from_store)) {
            $this->db->where('a.date_time >=', $from_date);
            $this->db->where('a.date_time <=', $to_date);
            $this->db->where('a.store_id', $from_store);
            $this->db->where('a.t_warehouse_id', $t_wearhouse);
        }
        $this->db->where('a.status', 2);
        $this->db->order_by('a.transfer_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve store_to_warehouse_transfer
    public function warehouse_to_store_transfer($from_date, $to_date, $wearhouse, $t_store)
    {
        $today = date("m-d-Y");
        $this->db->select("
			a.*,
			b.store_name,
			c.product_name,
			c.product_model,
			d.variant_name,
			e.wearhouse_name
			");
        $this->db->from('transfer a');
        $this->db->join('store_set b', 'b.store_id = a.t_store_id');
        $this->db->join('product_information c', 'c.product_id = a.product_id');
        $this->db->join('variant d', 'd.variant_id = a.variant_id');
        $this->db->join('wearhouse_set e', 'e.wearhouse_id = a.warehouse_id');
        if (!empty($wearhouse)) {
            $this->db->where('a.date_time >=', $from_date);
            $this->db->where('a.date_time <=', $to_date);
            $this->db->where('a.warehouse_id', $wearhouse);
            $this->db->where('a.t_store_id', $t_store);
        }
        $this->db->where('a.status', 3);
        $this->db->order_by('a.transfer_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve store_to_warehouse_transfer
    public function warehouse_to_warehouse_transfer($from_date, $to_date, $wearhouse, $t_wearhouse)
    {
        $today = date("m-d-Y");
        $this->db->select("
			a.*,
			b.wearhouse_name,
			c.product_name,
			c.product_model,
			d.variant_name,
			e.wearhouse_name as t_wearhouse_name
			");
        $this->db->from('transfer a');
        $this->db->join('wearhouse_set b', 'b.wearhouse_id = a.warehouse_id');
        $this->db->join('product_information c', 'c.product_id = a.product_id');
        $this->db->join('variant d', 'd.variant_id = a.variant_id');
        $this->db->join('wearhouse_set e', 'e.wearhouse_id = a.t_warehouse_id');
        if (!empty($wearhouse)) {
            $this->db->where('a.date_time >=', $from_date);
            $this->db->where('a.date_time <=', $to_date);
            $this->db->where('a.warehouse_id', $wearhouse);
            $this->db->where('a.t_warehouse_id', $t_wearhouse);
        }
        $this->db->where('a.status', 4);
        $this->db->order_by('a.transfer_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve todays_purchase_report
    public function todays_purchase_report($per_page = null, $page = null)
    {
        $today = date('m-d-Y');
        $this->db->select("a.*,b.supplier_id,b.supplier_name");
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.purchase_date', $today);
        $this->db->order_by('a.purchase_id', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve todays_purchase_report count
    public function todays_purchase_report_count()
    {
        $today = date('m-d-Y');
        $this->db->select("a.*,b.supplier_id,b.supplier_name");
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where('a.purchase_date', $today);
        $this->db->order_by('a.purchase_id', 'desc');
        $this->db->limit('500');
        $query = $this->db->get();
        return $query->num_rows();
    }


    //Total profit report
    public function total_profit_report($perpage, $page)
    {

        $this->db->select("a.date,a.invoice,b.invoice_id,
			CAST(sum(total_price) AS DECIMAL(16,2)) as total_sale");
        $this->db->select('CAST(sum(`quantity`*`supplier_rate`) AS DECIMAL(16,2)) as total_supplier_rate', FALSE);
        $this->db->select("CAST(SUM(total_price) - SUM(`quantity`*`supplier_rate`) AS DECIMAL(16,2)) AS total_profit");
        $this->db->from('invoice a');
        $this->db->join('invoice_details b', 'b.invoice_id = a.invoice_id');
        $this->db->group_by('b.invoice_id');
        $this->db->order_by('a.invoice', 'desc');
        $this->db->limit($perpage, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Total profit report
    public function total_profit_report_count()
    {

        $this->db->select("a.date,a.invoice,b.invoice_id,sum(total_price) as total_sale");
        $this->db->select('sum(`quantity`*`supplier_rate`) as total_supplier_rate', FALSE);
        $this->db->select("(SUM(total_price) - SUM(`quantity`*`supplier_rate`)) AS total_profit");
        $this->db->from('invoice a');
        $this->db->join('invoice_details b', 'b.invoice_id = a.invoice_id');
        $this->db->group_by('b.invoice_id');
        $this->db->order_by('a.invoice', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //Tax report product wise
    public function tax_report_product_wise($from_date, $to_date)
    {

        $today = date("m-d-Y");
        $this->db->select("
			a.amount,
			a.date,
			a.invoice_id,
			b.product_name,
			c.tax_name
			");
        $this->db->from('tax_collection_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id', 'left');
        $this->db->join('tax c', 'c.tax_id = a.tax_id');

        if (empty($from_date)) {
            $this->db->where('a.date', $today);
        } else {
            $this->db->where("STR_TO_DATE(a.date, '%m-%d-%Y') BETWEEN DATE('$from_date') AND DATE('$to_date')");
        }
        $this->db->order_by('a.date', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Tax report product wise
    public function tax_report_invoice_wise($from_date=false, $to_date=false)
    {

        $today = date("m-d-Y");
        $this->db->select("
			a.tax_amount,
			a.date,
			a.invoice_id,
			c.tax_name
			");
        $this->db->from('tax_collection_summary a');
        $this->db->join('tax c', 'c.tax_id = a.tax_id');

        if (empty($from_date)) {
            $this->db->where('a.date', $today);
        } else {
            $this->db->where("STR_TO_DATE(a.date, '%m-%d-%Y') BETWEEN DATE('$from_date') AND DATE('$to_date')");
        }
        $this->db->order_by('a.date', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function monthly_sales_report()
    {
        $query1 = $this->db->query("
			SELECT 
			date,
			EXTRACT(MONTH FROM STR_TO_DATE(date,'%m-%d-%Y')) as month,
			COUNT(invoice_id) as total
			FROM 
			invoice
			WHERE 
			EXTRACT(YEAR FROM STR_TO_DATE(date,'%m-%d-%Y'))  >= EXTRACT(YEAR FROM NOW())
			GROUP BY 
			EXTRACT(YEAR_MONTH FROM STR_TO_DATE(date,'%m-%d-%Y'))
			ORDER BY
			month ASC
			")->result();

        $query2 = $this->db->query("
			SELECT 
			purchase_date,
			EXTRACT(MONTH FROM STR_TO_DATE(purchase_date,'%m-%d-%Y')) as month, 
			COUNT(purchase_id) as total_month
			FROM 
			product_purchase
			WHERE 
			EXTRACT(YEAR FROM STR_TO_DATE(purchase_date,'%m-%d-%Y'))  >= EXTRACT(YEAR FROM NOW())
			GROUP BY 
			EXTRACT(YEAR_MONTH FROM STR_TO_DATE(purchase_date,'%m-%d-%Y'))
			ORDER BY
			month ASC
			")->result();

        return [$query1, $query2];
    }

    //Retrieve all Report
    public function retrieve_dateWise_SalesReports($start_date = false, $end_date=false)
    {
        $dateRange = "STR_TO_DATE(a.date, '%m-%d-%Y') BETWEEN DATE('$start_date') AND DATE('$end_date')";

        $this->db->select("a.*,b.customer_id,b.customer_name");
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where($dateRange, NULL, FALSE);
        $this->db->order_by('a.date', 'desc');
        $this->db->limit('500');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve all Report
    public function retrieve_dateWise_PurchaseReports($start_date, $end_date)
    {
        $dateRange = "STR_TO_DATE(a.purchase_date, '%m-%d-%Y') BETWEEN DATE('$start_date') AND DATE('$end_date')";

        $this->db->select("a.*,b.supplier_id,b.supplier_name");
        $this->db->from('product_purchase a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->where($dateRange, NULL, FALSE);
        $this->db->order_by('a.purchase_date', 'desc');
        $this->db->limit('500');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve date wise profit report
    public function retrieve_dateWise_profit_report($start_date, $end_date)
    {
        $this->db->select("a.date,a.invoice,b.invoice_id,
			CAST(sum(total_price) AS DECIMAL(16,2)) as total_sale");
        $this->db->select('CAST(sum(`quantity`*`supplier_rate`) AS DECIMAL(16,2)) as total_supplier_rate', FALSE);
        $this->db->select("CAST(SUM(total_price) - SUM(`quantity`*`supplier_rate`) AS DECIMAL(16,2)) AS total_profit");

        $this->db->from('invoice a');
        $this->db->join('invoice_details b', 'b.invoice_id = a.invoice_id');

        $this->db->where('a.date >=', $start_date);
        $this->db->where('a.date <=', $end_date);

        $this->db->group_by('b.invoice_id');
        $this->db->order_by('a.invoice', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve date wise profit report
    public function retrieve_dateWise_profit_report_count($start_date, $end_date)
    {
        $this->db->select("a.date,a.invoice,b.invoice_id,sum(total_price) as total_sale");
        $this->db->select('sum(`quantity`*`supplier_rate`) as total_supplier_rate', FALSE);
        $this->db->select("(SUM(total_price) - SUM(`quantity`*`supplier_rate`)) AS total_profit");

        $this->db->from('invoice a');
        $this->db->join('invoice_details b', 'b.invoice_id = a.invoice_id');

        $this->db->where('a.date >=', $start_date);
        $this->db->where('a.date <=', $end_date);

        $this->db->group_by('b.invoice_id');
        $this->db->order_by('a.invoice', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //Product wise sales report
    public function product_wise_report()
    {
        $today = date('m-d-Y');
        $this->db->select("a.*,b.customer_id,b.customer_name");
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('a.date', $today);
        $this->db->order_by('a.invoice_id', 'desc');
        $this->db->limit('500');
        $query = $this->db->get();
        return $query->result_array();
    }

    //RETRIEVE DATE WISE SEARCH SINGLE PRODUCT REPORT
    public function retrieve_product_search_sales_report($start_date, $end_date)
    {
        $dateRange = "STR_TO_DATE(c.date, '%m-%d-%Y') BETWEEN DATE('$start_date') AND DATE('$end_date')";
        $this->db->select("a.*,b.product_name,b.product_model,c.date,d.customer_name");
        $this->db->from('invoice_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id');
        $this->db->join('invoice c', 'c.invoice_id = a.invoice_id');
        $this->db->join('customer_information d', 'd.customer_id = c.customer_id');
        $this->db->where($dateRange, NULL, FALSE);
        $this->db->order_by('c.date', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //RETRIEVE DATE WISE SEARCH SINGLE PRODUCT REPORT
    public function retrieve_product_search_sales_report_count($start_date, $end_date)
    {
        $dateRange = "STR_TO_DATE(c.date, '%m-%d-%Y') BETWEEN DATE('$start_date') AND DATE('$end_date')";

        $this->db->select("a.*,b.product_name,b.product_model,c.date,d.customer_name");
        $this->db->from('invoice_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id');
        $this->db->join('invoice c', 'c.invoice_id = a.invoice_id');
        $this->db->join('customer_information d', 'd.customer_id = c.customer_id');
        $this->db->where($dateRange, NULL, FALSE);
        $this->db->order_by('c.date', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //Retrieve company Edit Data
    public function retrieve_company()
    {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_stock_items($id)
    {
        $this->db->select("
			a.product_name,			
			a.product_id,
            a.variants
			");

        $this->db->from('product_information a');

        $this->db->where('a.product_id', $id);
        $query = $this->db->get();
        $product = $query->result_array();
        $variants = explode(',', $product[0]['variants']);
        $product_info = [
            'product_name' => $product[0]['product_name'],
            'variants' => $variants
        ];
        //====================================

        foreach ($product_info['variants'] as $variant):

            $this->db->select("a.variant_id, a.variant_name, sum(b.quantity) as totalPurchaseQnty, 
        (select sum(c.quantity) from invoice_details c where c.product_id=b.product_id and c.variant_id=b.variant_id) as totalSalesQty,
         a.variant_name");

            $this->db->from('variant a', null, false);
            $this->db->join('product_purchase_details b', 'a.variant_id=b.variant_id');

            $this->db->where('a.variant_id', $variant);
            $this->db->where('b.product_id', $id);
            $query = $this->db->get();
            $tt[] = $query->result_array();

        endforeach;

        $data = [
            'product_name' => $product[0]['product_name'],
            'products' => $tt
        ];

        return $data;

    }

}