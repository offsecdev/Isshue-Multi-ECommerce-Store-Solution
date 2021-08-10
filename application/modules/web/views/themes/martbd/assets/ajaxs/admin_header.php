<?php
    if (!empty($this->session->userdata('err_message'))) {
        ?>
        <script>
            "use strict";
            Swal({
                position: 'center',
                type: 'warning',
                title: '<?php echo $this->session->userdata('err_message')?>',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
        <?php
        $this->session->unset_userdata('err_message');
    }
    ?>

    <?php
    if (!empty($this->session->userdata('order_completed'))) {
        ?>
        <script>
            "use strict";
            Swal({
                position: 'center',
                type: 'success',
                title: '<?php echo $this->session->userdata('order_completed')?>',
                showConfirmButton: false,
                timer: 4000
            }).then((result) => {
                <?php $this->session->unset_userdata('order_completed');  ?>
                location.reload();
            })
        </script>
        <?php

    }
    ?>