            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="filter-section">
                                            <div class="page-title-box action-header">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-10">

                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input type="text" name="subject_name"  class="form-control" placeholder="Search Subject">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <select class="form-control select2 ppage" name="ppage">
                                                                                <option disabled="">Data Per Page</option>
                                                                                <option  value="5">5 Per Page</option>
                                                                                <option selected="" value="20">20 Per Page</option>
                                                                                <option value="50">50 Per Page</option>
                                                                                <option value="100">100 Per Page</option>
                                                                            </select>                                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary btn-custom waves-effect w-md waves-light m-b-5 subject_search" style="color:#fff;width: 100%;">Search&nbsp;<i class="ti-search"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                       </div>
                                                        <div class="col-md-12 col-lg-2">
                                                            <div class="action-group">
                                                                <button type="button" class="btn btn-primary btn-custom waves-effect w-md waves-light m-b-5 doubleClick" data-doubleatt=".double-add-subject" data-singleatt="<?php echo base_url('admin/subject/add'); ?>">Add</button>
                                                                <button style="display:none;" type="button" class="btn btn-primary btn-custom waves-effect w-md waves-light m-b-5 double-add-subject" data-toggle="modal" data-target=".bs-example-modal-lg">Add</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>
                                            <input type="hidden" class="filter_action" value="subject_filter">
                                            
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="subject_filter">
                                    <?php $this->load->view('candidate/exam/current/ajax/filter/list') ?>
                                </div>
                            </div>

                        </div>
                        <!-- end row -->

                    </div>
                    <!-- end container -->
                </div>
                <!-- end content -->

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->