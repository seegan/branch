<?php
if( ! isset( $on_hold_message ) )
{
    if( isset( $login_error_mesg ) )
    {
        echo '
            <div style="border:1px solid red;">
                <p>
                    Login Error #' . $this->authentication->login_errors_count . '/' . config_item('max_allowed_attempts') . ': Invalid Username, Email Address, or Password.
                </p>
                <p>
                    Username, email address and password are all case sensitive.
                </p>
            </div>
        ';
    }

    if( $this->input->get(AUTH_LOGOUT_PARAM) )
    {
        echo '
            <div style="border:1px solid green">
                <p>
                    You have successfully logged out.
                </p>
            </div>
        ';
    }
?>



        <div class="wrapper-page">

            <div class="text-center">
                <a href="index.html" class="logo-lg"><i class="mdi mdi-radar"></i> <span>Xtragenius</span> </a>
            </div>
            <?php   echo form_open( $login_url, ['class' => 'std-form'] );  ?>

                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="userName">User Name<span class="text-danger">*</span></label>
                            <input type="text" name="login_string" parsley-trigger="change" required
                                   placeholder="Enter User Name" class="form-control" id="userName">
                        </div>
                        <div class="form-group">
                            <label for="userName">Password<span class="text-danger">*</span></label>
                            <input type="password" name="login_pass" parsley-trigger="change" required id="login_pass" class="form-control password" placeholder="Enter Password" <?php 
                                if( config_item('max_chars_for_password') > 0 )
                                    echo 'maxlength="' . config_item('max_chars_for_password') . '"'; 
                            ?> autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" />
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-12 m-t-10">
                        <div class="m-l-15">
                            <div class="checkbox checkbox-primary">
                            <?php
                                if( config_item('allow_remember_me') )
                                {
                            ?>
                                <input type="checkbox" id="remember_me" name="remember_me" value="yes" />
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right m-t-20">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-custom w-md waves-effect waves-light" name="submit" value="Login" id="submit_button">Login</button>
                    </div>
                </div>

            <?php echo form_close(); ?>
        </div>

<?php
}
else
{
    $this->load->view('admin/login_limit');
    // EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
}
?>





