    <div class="row">
        <div class="col-lg-12">
            <div class="login-exceeded">

                <div class="text-center">
                    <a href="index.html" class="logo-lg"><i class="mdi mdi-radar"></i> <span>Excessive Attempts</span> </a>
                </div>

                <div class="card-box m-t-20">
                    <div class="text-center">
                        <i class="mdi mdi-alert login-exceeded-ico"></i>
                    </div>
                    <div class="text-center">
                        <p>
                            You have exceeded the maximum number of failed login 
                            attempts that this website will allow.
                        </p>
                        <p>
                            Your access to login and account recovery has been blocked for ' <?php echo ( (int) config_item('seconds_on_hold') / 60 ) ?> ' minutes.
                        </p>
                        <p>
                            contact us if you require assistance gaining access to your account.
                        </p>                    
                    </div>
                </div>

            </div>
        </div>
    
    </div>
