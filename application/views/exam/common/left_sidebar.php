            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">

<?php
$question_ids = explode(",", $questions['questions']);
asort($question_ids);
?>


<div id="question-navigator" class="question-navigator" tabindex="5001" style="overflow: hidden; outline: none;">
    <ul id="navigator-in">
        <?php
            if($question_ids && is_array($question_ids) && count($question_ids) > 0) {
                $i = 1;
                foreach ($question_ids as $q_value) {
        ?>
            <li class="notvisited" class="question_btn" data-questionid="<?php echo $q_value; ?>">
                <span style="top: 0px;"><?php echo $i; ?></span>
                <input type="hidden" class="attend_status" value="notvisited" name="question_status[<?php echo $q_value; ?>][attend_status]">
                <input type="hidden" class="active_status" value="0" name="question_status[<?php echo $q_value; ?>][active_status]">
            </li>
        <?php
                    $i++;
                }
            }
        ?> 
    </ul>
    <div class="row">
        <div class="col-lg-12">
            <div class="left-full">
                <button class="btn btn-primary waves-effect waves-light review_stay" type="button" >Review Question </button>
            </div>
        </div>


        <div class="col-lg-12">
            <div style="margin-top:10px;">


                <div class="row">
                    <div class="col-lg-6">
                        <div class="left-full">
                            <button class="btn btn-icon waves-effect waves-light btn-info m-b-5"><i class="mdi mdi-flag-outline"></i> Instruction</button>
                        </div>
                    </div>
                    <div class="col-lg-6"> 
                        <div class="left-full">
                            <button class="btn btn-icon waves-effect btn-success m-b-5 save_continue"> <i class="mdi mdi-floppy"></i> Save </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-lg-12">
            <div class="saving_image" style="margin-top: 40px;">
                <img src="<?php echo base_url(); ?>theme/assets/images/saving.gif">
            </div>
            <div class="status_msg">
                
            </div>
        </div>
    </div>
</div>













                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->