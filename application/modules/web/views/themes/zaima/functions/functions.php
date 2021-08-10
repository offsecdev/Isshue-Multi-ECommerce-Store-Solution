<?php
    $currency_new_id = $this->session->userdata('currency_new_id');
    global $target_con_rate;
    global $position1;
    global $currency1;
    $currency1 = 0;

    if (empty($currency_new_id)) {
        $result = $cur_info = $this->db->select('*')
            ->from('currency_info')
            ->where('default_status', '1')
            ->get()
            ->row();
        $currency_new_id = $result->currency_id;
    }

    
    if (!empty($currency_new_id)) {
        $cur_info = $this->db->select('*')
            ->from('currency_info')
            ->where('currency_id', $currency_new_id)
            ->get()
            ->row();

        $target_con_rate = $cur_info->convertion_rate;
        $position1 = $cur_info->currency_position;
        $currency1 = $cur_info->currency_icon;
    }

    ?>