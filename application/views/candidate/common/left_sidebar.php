            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Main</li>

                            <li>
                                <a href="<?php echo base_url('candidate/dashboard') ?>" class="waves-effect waves-primary"><i
                                        class="ti-home"></i><span> Dashboard </span></a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect waves-primary"><i class="mdi mdi-book-multiple-variant"></i><span> Exam </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo base_url('candidate/exam/current') ?>"><i class="ti-eye"></i>Current</a></li>
                                    <!-- <li><a href="<?php echo base_url('candidate/exam/upcomming') ?>">Upcomming</a></li>
                                    <li><a href="<?php echo base_url('candidate/exam/expired') ?>">Expired</a></li> -->
                                    <li><a href="<?php echo base_url('candidate/exam/history') ?>"><i class="fa fa-history"></i>History </a></li>
                                </ul>
                            </li>

                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->