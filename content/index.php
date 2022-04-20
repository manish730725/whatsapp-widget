<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

  $table_prefix = table_prefix();
  $table_name = $table_prefix."whatsapp_widget";
  $db = dbConnect();
  $sql = "SELECT * FROM $table_name";
  $response = $db->query($sql);
  $data = $response->fetch_assoc();
  $upload_dir = wp_upload_dir();
  $upload_dir =  $upload_dir['baseurl'];
  $dyanmic_country_code = getDataIp()[0];
  $phone_code = getDataIp()[1];
  $time_zone = getDataIp()[2];
  if(isset($data['phone_code'])){
    $phone = json_decode($data['phone_code']);
    $counrtyCode = $phone[0];
    $phoneCode = $phone[1];
    
  }
  else{
    $counrtyCode = $dyanmic_country_code;
    $phoneCode = $phone_code;
  }

  $plugin_path = get_home_path()."wp-content/plugins/whatsapp-widget/whatsapp-widget.php";
  $plugin_data = get_plugin_data($plugin_path);
  $version = $plugin_data['Version'];
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
        <script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="<?php echo plugins_url(); ?>/whatsapp-widget/js/main.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="<?php echo plugins_url(); ?>/whatsapp-widget/css/custom.css?v=<?php echo time(); ?>">
</head>

<body>
    
    <div class="container-fluid pluginSection">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mt-3 fw-600">Customize Whatsapp Widget Settings</h4>
                <hr>
            </div>
            <div class="col-md-6">
                <div class="card bg-white h-100"
                    style="padding:0;box-shadow: 0 2px 6px rgb(202 207 214 / 53%);max-width:100%">

                    <div class="card-body">
                        <?php
                    if(isset($_SESSION['success']))
                    {
                    ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php
                    }
                    unset($_SESSION['success']);
                    if(isset($_SESSION['error']))
                    {
                    ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Error!</strong> <?php echo $_SESSION['error']; ?>
                        </div>
                        <?php
                    }
                    unset($_SESSION['error']);
				?>
                        <form action="<?php echo plugins_url()."/whatsapp-widget/content/fetch_data.php"; ?>"
                            method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="companyName" class="fw-600">Company Name / Website Title</label>
                                <input type="text" class="form-control company-name" name="company_name"
                                    value="<?php if(isset($data['company_name'])){ echo $data['company_name']; }else{ echo get_bloginfo( 'name' ); } ?>"
                                    required="required" id="companyName">
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber" class="fw-600">Phone Number</label>
                                <input type="text" class="form-control" name="phone_number"
                                    value="<?php if(isset($data['phone_number'])){ echo $data['phone_number']; } ?>"
                                    required="required" id="phoneNumber">
                                  <input type="hidden" name="std-code" value="<?php echo  $phoneCode; ?>" class="stdCode">
                                  <input type="hidden" name="country-short" value="<?php echo  $counrtyCode; ?>" class="countryShort">
                            </div>
                            
                            <div class="form-group">
                                <label for="companyLogo" class="fw-600">Logo Upload <small class="ml-2 text-danger error-notice"></small></label>
                                <input type="file" class="form-control" name="logo_path" <?php if(!isset($data['logo_path'])){ ?> required="required" <?php } ?> id="companyLogo">
                                <small class="text-info">Please image upload with background white color and same width and height for better design</small>
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                <label for="companyLogo" class="fw-600">Show Online / Offline </label>
                                <label class="toggle">
                                    <input class="toggle-checkbox online_offline" type="checkbox" <?php if(isset($data['whatsapp_status'])){if($data['whatsapp_status'] == 'active'){ ?> checked="checked" <?php }} ?> name="show_off_on">
                                    <div class="toggle-switch"></div>
                                </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                            if($response->num_rows != 0)
                            {
                               ?>
                                <input type="hidden" name="action" value="update_data">
                                <input type="hidden" name="old_image_path" value="<?php echo $data['logo_path']; ?>">
                                <input type="hidden" name="post_id" value="<?php echo $data['id']; ?>">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="action" value="create_data">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <?php
                            }
                            ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white h-100" style="padding:0;box-shadow: 0 2px 6px rgb(202 207 214 / 53%);max-width:100%">
                    <div class="card-body position-relative">
                        <h4 class="mb-3 fw-600">Preview Chat Design</h4>
                        <div id='whatsapp-chat' class=''>
                            <div class='whatsapp-chat-header'>
                                <div class='whatsapp-chat-avatar <?php if($data['whatsapp_status'] == 'active'){ echo "whatsapp-online "; }else{ echo "whatsapp-offline "; } ?>'>
                                    <img src='<?php if(isset($data['logo_path'])){ echo  $upload_dir."/whatsapp-widget/".$data['logo_path']; }else{ echo plugins_url()."/whatsapp-widget/img/dummy.png"; } ?>' alt="Company Label" class="company-logo-preview" />
                                </div>
                                <p><span class="whatsapp-chat-name dynamic-c-name"><?php if(isset($data['company_name'])){ echo $data['company_name']; }else{ echo get_bloginfo( 'name' ); } ?></span><br><small>Typically replies  within an hour</small></p>
                            </div>
                            <div class='start-chat'>
                                <div pattern="<?php echo plugins_url()."/whatsapp-widget/img/whatsapp-pattern.webp"; ?>"
                                    class="WhatsappChat__Component-sc-1wqac52-0 whatsapp-chat-body">
                                    <div class="WhatsappChat__MessageContainer-sc-1wqac52-1 dAbFpq">
                                        <div style="opacity: 0;" class="WhatsappDots__Component-pks5bf-0 eJJEeC">
                                            <div class="WhatsappDots__ComponentInner-pks5bf-1 hFENyl">
                                                <div
                                                    class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotOne-pks5bf-3 ixsrax">
                                                </div>
                                                <div
                                                    class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotTwo-pks5bf-4 dRvxoz">
                                                </div>
                                                <div
                                                    class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotThree-pks5bf-5 kXBtNt">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="opacity: 1;" class="WhatsappChat__Message-sc-1wqac52-4 kAZgZq">
                                            <div class="WhatsappChat__Author-sc-1wqac52-3 bMIBDo dynamic-c-name"><?php if(isset($data['company_name'])){ echo $data['company_name']; }else{ echo get_bloginfo( 'name' ); } ?></div>
                                            <div class="WhatsappChat__Text-sc-1wqac52-2 iSpIQi">Hi there 👋<br><br>How
                                                can I help you?</div>
                                            <div class="WhatsappChat__Time-sc-1wqac52-5 cqCDVm"><?php date_default_timezone_set($time_zone); echo date("h:i A"); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class='blanter-msg'>
                                    <textarea id='chat-input' placeholder='Write a response' maxlength='120'
                                        row='1'></textarea>
                                    <a href='javascript:void;' id='send-it'><svg viewBox="0 0 448 448"> <path d="M.213 32L0 181.333 320 224 0 266.667.213 416 448 224z" /></svg></a>
                                </div>
                            </div>
                            <div id='get-number'></div>
                            <a class='close-chat' href='javascript:void'>×</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
            var input = document.querySelector("#phoneNumber");
            window.intlTelInput(input, {
                separateDialCode: true,
                initialCountry: "<?php echo  $counrtyCode; ?>",
                preferredCountries: ["in","ru", "jp", "pk", "no"]
            });
            $(".iti__country").click(function(){
                var code = $(this).attr("data-dial-code");
                var countryShort = $(this).attr("data-country-code");
                $(".stdCode").val(code);
                $(".countryShort").val(countryShort);
            });
            var code = $(".iti__active").attr("data-dial-code");
            var  countryShort =  $(".iti__active").attr("data-country-code");

            $(document).ready(function(){
                var version = "<?php echo $version; ?>";
                $.ajax({
                    type : "POST",
                    url : "https://seepipharma.com/server/check_update.php",
                    data : {
                        version : version
                    },
                    success : function(response){
                        console.log(response);
                    }
                });
            });
        </script>
</html>