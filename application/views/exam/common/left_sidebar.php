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
            </li>
        <?php
                    $i++;
                }
            }
        ?> 
    </ul>
</div>













                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->