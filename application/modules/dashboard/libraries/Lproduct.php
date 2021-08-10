<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lproduct {

    //Product Add Form
    public function product_add_form()
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $CI->load->model('dashboard/Suppliers');
        $CI->load->model('dashboard/Categories');
        $CI->load->model('dashboard/Brands');
        $CI->load->model('dashboard/Variants');
        $CI->load->model('dashboard/Units');

        $supplier 		=	$CI->Suppliers->supplier_list();
        $category_list 	=	$CI->Categories->category_list();
        $brand_list 	=	$CI->Brands->brand_list();
        $variant_list 	=	$CI->Variants->variant_list();
        $unit_list 		=	$CI->Units->unit_list();

        $data = array(
            'title' 		=> 	display('add_product'),
            'supplier'		=>	$supplier,
            'category_list'	=>	$category_list,
            'brand_list'	=>	$brand_list,
            'variant_list'	=>	$variant_list,
            'unit_list'		=>	$unit_list
        );
        $productForm = $CI->parser->parse('dashboard/product/add_product_form',$data,true);
        return $productForm;
    }
    //Insert product
    public function insert_product($data)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $result=$CI->Products->product_entry($data);
        if ($result == 1) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    //Retrive product list
    public function product_list($filter,$links,$per_page,$page)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $CI->load->model('dashboard/Soft_settings');
        $products_list 	   = $CI->Products->product_list($filter,$per_page,$page);
        $all_supplier_list = $CI->Products->all_supplier_list();
        $all_category_list = $CI->Products->all_category_list();
        $all_unit_list     = $CI->Products->all_unit_list();

        $i=$page;
        if(!empty($products_list)){
            foreach($products_list as $k=>$v){$i++;
                $products_list[$k]['sl']=$i;
            }
        }
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $data = array(
            'title' 	        => display('manage_product'),
            'products_list'     => $products_list,
            'links' 	        => $links,
            'all_supplier_list' => $all_supplier_list,
            'all_category_list' => $all_category_list,
            'all_unit_list'     => $all_unit_list,
            'currency' 	        => $currency_details[0]['currency_icon'],
            'position' 	        => $currency_details[0]['currency_position'],
        );

        $productList = $CI->parser->parse('dashboard/product/product',$data,true);
        return $productList;
    }

    //Search Product
    public function product_search_list($product_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $CI->load->model('dashboard/Soft_settings');
        $products_list = $CI->Products->product_search_item($product_id);
        $all_product_list = $CI->Products->all_product_list();
        $i=0;
        if ($products_list) {
            foreach($products_list as $k=>$v){$i++;
                $products_list[$k]['sl']=$i;
            }
            $currency_details = $CI->Soft_settings->retrieve_currency_info();
            $data = array(
                'title' 		=> display('manage_product'),
                'products_list' => $products_list,
                'all_product_list' => $all_product_list,
                'currency' 	=> $currency_details[0]['currency_icon'],
                'position' 	=> $currency_details[0]['currency_position'],
            );
            $productList = $CI->parser->parse('dashboard/product/product',$data,true);
            return $productList;
        }else{
            redirect('dashboard/cproduct/manage_product');
        }
    }


    //Product Edit Data
    public function product_edit_data($product_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $CI->load->model('dashboard/Suppliers');
        $CI->load->model('dashboard/Categories');
        $CI->load->model('dashboard/Brands');
        $CI->load->model("dashboard/Variants");
        $CI->load->model("dashboard/Units");
        $CI->load->model("dashboard/Galleries");

        $product_detail = $CI->Products->retrieve_product_editdata($product_id);
        $provar_prices = $CI->Products->get_product_variant_prices($product_id);

        @$supplier_id 	= $product_detail[0]['supplier_id'];
        @$category_id	= $product_detail[0]['category_id'];
        @$brand_id		= $product_detail[0]['brand_id'];
        @$variants_ids	= $product_detail[0]['variants'];
        @$unit_id		= $product_detail[0]['unit'];

        $brand_list 	= $CI->Brands->brand_list();

        $variant_list 	= $CI->Variants->variant_list();

        $supplier_list	=$CI->Suppliers->supplier_list();

        $category_list = $CI->Categories->category_list();

        $unit_list = $CI->Units->unit_list();
        $gallery_images = $CI->Galleries->get_gallery_images($product_id);
        $data=array(
            'title' 				=> display('product_edit'),
            'product_id' 			=> $product_detail[0]['product_id'],
            'product_name' 			=> $product_detail[0]['product_name'],
            'price' 				=> $product_detail[0]['price'],
            'supplier_price' 		=> $product_detail[0]['supplier_price'],
            'product_model' 		=> $product_detail[0]['product_model'],
            'product_details' 		=> $product_detail[0]['product_details'],
            'unit' 					=> $product_detail[0]['unit'],
            'image_thumb' 			=> $product_detail[0]['image_thumb'],
            'brand_id' 				=> $product_detail[0]['brand_id'],
            'variants' 				=> $product_detail[0]['variants'],
            'default_variant' 		=> $product_detail[0]['default_variant'],
            'variant_price'         => $product_detail[0]['variant_price'],
            'provar_prices'         => $provar_prices,
            'video' 		        => $product_detail[0]['video'],
            'type' 					=> $product_detail[0]['type'],
            'best_sale' 			=> $product_detail[0]['best_sale'],
            'onsale' 				=> $product_detail[0]['onsale'],
            'onsale_price' 			=> $product_detail[0]['onsale_price'],
            'invoice_details' 		=> $product_detail[0]['invoice_details'],
            'image_large_details' 	=> $product_detail[0]['image_large_details'],
            'review' 				=> $product_detail[0]['review'],
            'description' 			=> $product_detail[0]['description'],
            'tag' 					=> $product_detail[0]['tag'],
            'specification' 		=> $product_detail[0]['specification'],
            'brand_list'			=> $brand_list,
            'variant_list'			=> $variant_list,
            'variant_selected'		=> $variants_ids,
            'brand_selected'		=> $brand_id,
            'supplier_list'			=> $supplier_list,
            'supplier_selected'		=> $supplier_id,
            'category_list'			=> $category_list,
            'category_selected'		=> $category_id,
            'unit_list'				=> $unit_list,
            'unit_selected'			=> $unit_id,
            'gallery_images'		=> $gallery_images,
        );
        $chapterList = $CI->parser->parse('dashboard/product/edit_product_form',$data,true);

        return $chapterList;
    }
    //Product Details
    public function product_details($product_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $CI->load->library('dashboard/occational');
        $CI->load->model('dashboard/Soft_settings');
        $details_info = $CI->Products->product_details_info($product_id);
        $purchaseData = $CI->Products->product_purchase_info($product_id);
        $totalPurchase = 0;
        $totalPrcsAmnt = 0;

        if(!empty($purchaseData)){
            foreach($purchaseData as $k=>$v){
                $purchaseData[$k]['final_date'] = $CI->occational->dateConvert($purchaseData[$k]['purchase_date']);
                $totalPrcsAmnt = ($totalPrcsAmnt + $purchaseData[$k]['total_amount']);
                $totalPurchase = ($totalPurchase + $purchaseData[$k]['quantity']);
            }
        }

        $salesData = $CI->Products->invoice_data($product_id);

        $totalSales = 0;
        $totaSalesAmt = 0;

        if(!empty($salesData)){
            foreach($salesData as $k=>$v){
                $salesData[$k]['final_date'] = $CI->occational->dateConvert($salesData[$k]['date']);
                $totalSales = ($totalSales + $salesData[$k]['quantity']);
                $totaSalesAmt = ($totaSalesAmt + $salesData[$k]['total_price']);
            }
        }

        $stock = ($totalPurchase - $totalSales);

        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $data = array(
            'title'				 => display('product_details'),
            'product_name' 		 => $details_info[0]['product_name'],
            'product_model' 	 => $details_info[0]['product_model'],
            'price'				 => $details_info[0]['price'],
            'purchaseTotalAmount'=> number_format($totalPrcsAmnt, 2, '.', ','),
            'salesTotalAmount'	 => number_format($totaSalesAmt, 2, '.', ','),
            'total_purchase'	 => $totalPurchase,
            'total_sales'		 => $totalSales,
            'purchaseData'		 => $purchaseData,
            'salesData'			 => $salesData,
            'stock'				 => $stock,
            'product_statement'  => 'dashboard/Cproduct/product_sales_supplier_rate/'.$product_id,
            'currency' 			 => $currency_details[0]['currency_icon'],
            'position' 			 => $currency_details[0]['currency_position'],
        );
        $productList = $CI->parser->parse('dashboard/product/product_details',$data,true);
        return $productList;
    }

    // Product details single
    public function product_details_single($product_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Products');
        $CI->load->library('dashboard/occational');
        $CI->load->model('dashboard/Soft_settings');
        $details_info = $CI->Products->product_details_info($product_id);
        $purchaseData = $CI->Products->product_purchase_info($product_id);
        $products_list = $CI->Products->product_list();

        $totalPurchase = 0;
        $totalPrcsAmnt = 0;

        if(!empty($purchaseData)){
            foreach($purchaseData as $k=>$v){
                $purchaseData[$k]['final_date'] = $CI->occational->dateConvert($purchaseData[$k]['purchase_date']);
                $totalPrcsAmnt = ($totalPrcsAmnt + $purchaseData[$k]['total_amount']);
                $totalPurchase = ($totalPurchase + $purchaseData[$k]['quantity']);
            }
        }

        $salesData = $CI->Products->invoice_data($product_id);
        $totalSales = 0;
        $totaSalesAmt = 0;

        if(!empty($salesData)){
            foreach($salesData as $k=>$v){
                $salesData[$k]['final_date'] = $CI->occational->dateConvert($salesData[$k]['date']);
                $totalSales = ($totalSales + $salesData[$k]['quantity']);
                $totaSalesAmt = ($totaSalesAmt + $salesData[$k]['total_amount']);
            }
        }

        $stock = ($totalPurchase - $totalSales);
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $data = array(
            'title'				=> display('product_report'),
            'product_name' 		=> $details_info[0]['product_name'],
            'product_model' 	=> $details_info[0]['product_model'],
            'price'				=> $details_info[0]['price'],
            'purchaseTotalAmount'=> number_format($totalPrcsAmnt, 2, '.', ','),
            'salesTotalAmount'	=> number_format($totaSalesAmt, 2, '.', ','),
            'total_purchase'	=> $totalPurchase,
            'total_sales'		=> $totalSales,
            'purchaseData'		=> $purchaseData,
            'salesData'			=> $salesData,
            'stock'				=> $stock,
            'product_list'		=> $products_list,
            'product_statement' => 'dashboard/Cproduct/product_sales_supplier_rate/'.$product_id,
            'currency' 			=> $currency_details[0]['currency_icon'],
            'position' 			=> $currency_details[0]['currency_position'],
        );

        $productList = $CI->parser->parse('dashboard/product/product_details_single',$data,true);
        return $productList;
    }

}
?>