
        </div>
        <!-- END wrapper -->
    
        <script>
            var resizefunc = [];
        </script>

        <!-- Plugins  -->
        <script src="<?php echo base_url(); ?>theme/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/js/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="<?php echo base_url(); ?>theme/assets/js/bootstrap.min.js"></script>
<!--    <script src="<?php echo base_url(); ?>jsplugins/timepicker/jquery.timepicker.js"></script>-->
        <script src="<?php echo base_url(); ?>theme/assets/js/detect.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/js/fastclick.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/js/jquery.slimscroll.js"></script>
<!--    <script src="<?php echo base_url(); ?>theme/assets/js/jquery.blockUI.js"></script> -->
        <script src="<?php echo base_url(); ?>theme/assets/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/js/jquery.app.js"></script>
        

        <?php

            if( isset( $final_foot ) )
            {
                echo $final_foot;
            }

        
            // Add any javascripts
            if( isset( $javascripts ) )
            {
                foreach( $javascripts as $js )
                {
                    echo '<script src="' . $js . '"></script>' . "\n";
                }
            }

        ?>
        <script src="<?php echo base_url(); ?>theme/assets/js/custom.js"></script>
    </body>
</html>