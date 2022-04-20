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
  $time_zone = getDataIp()[2];
  if(isset($data['phone_code'])){
    $phoneCode = json_decode($data['phone_code']);
    $phoneCode = $phoneCode[1];
   
  }

?>

<script src="<?php echo plugins_url(); ?>/whatsapp-widget/template/main.js?v=<?php echo time(); ?>"></script>
<link rel="stylesheet" href="<?php echo plugins_url(); ?>/whatsapp-widget/template/style.css?v=<?php echo time(); ?>">
    <div id='whatsapp-chat' class='hide'>
        <div class='whatsapp-chat-header'>
            <div class='whatsapp-chat-avatar <?php if($data['whatsapp_status'] == 'active'){ echo "whatsapp-online "; }else{ echo "whatsapp-offline "; } ?>'>
              <img src='<?php if(isset($data['logo_path'])){ echo  $upload_dir."/whatsapp-widget/".$data['logo_path']; }else{ echo plugins_url()."/whatsapp-widget/img/dummy.png"; } ?>' alt="Tedbree Logo" />
            </div>
            <p><span class="whatsapp-chat-name"><?php if(isset($data['company_name'])){ echo $data['company_name']; }else{ echo get_bloginfo( 'name' ); } ?></span><br><small>Typically replies within an hour</small></p>
        </div>
        
        <div class='start-chat'>
          <div pattern="<?php echo plugins_url(); ?>/whatsapp-widget/img/whatsapp-pattern.webp" class="WhatsappChat__Component-sc-1wqac52-0 whatsapp-chat-body">
            <div class="WhatsappChat__MessageContainer-sc-1wqac52-1 dAbFpq">
              <div style="opacity: 0;" class="WhatsappDots__Component-pks5bf-0 eJJEeC">
                <div class="WhatsappDots__ComponentInner-pks5bf-1 hFENyl">
                  <div class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotOne-pks5bf-3 ixsrax"></div>
                  <div class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotTwo-pks5bf-4 dRvxoz"></div>
                  <div class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotThree-pks5bf-5 kXBtNt"></div>
                </div>
              </div>
              <div style="opacity: 1;" class="WhatsappChat__Message-sc-1wqac52-4 kAZgZq">
                <div class="WhatsappChat__Author-sc-1wqac52-3 bMIBDo"><?php if(isset($data['company_name'])){ echo $data['company_name']; }else{ echo get_bloginfo( 'name' ); } ?></div>
                <div class="WhatsappChat__Text-sc-1wqac52-2 iSpIQi">Hi there 👋<br><br>How can I help you?</div>
                <div class="WhatsappChat__Time-sc-1wqac52-5 cqCDVm"><?php date_default_timezone_set($time_zone); echo date("h:i A"); ?></div>
              </div>
            </div>
          </div>
      
          <div class='blanter-msg'>
            <textarea id='chat-input' placeholder='Write a response' maxlength='120' row='1'></textarea>
            <a href='javascript:void;' id='send-it'><svg viewBox="0 0 448 448"><path d="M.213 32L0 181.333 320 224 0 266.667.213 416 448 224z"/></svg></a>
      
          </div>
        </div>
        <div id='get-number'><?php if(isset($data['phone_number'])){ echo $phoneCode.$data['phone_number']; } ?></div>
        <a class='close-chat' href='javascript:void'>×</a>
      </div>
      <a class='blantershow-chat' href='javascript:void' title='Show Chat'><svg width="20" viewBox="0 0 24 24"><defs/><path fill="#eceff1" d="M20.5 3.4A12.1 12.1 0 0012 0 12 12 0 001.7 17.8L0 24l6.3-1.7c2.8 1.5 5 1.4 5.8 1.5a12 12 0 008.4-20.3z"/><path fill="#4caf50" d="M12 21.8c-3.1 0-5.2-1.6-5.4-1.6l-3.7 1 1-3.7-.3-.4A9.9 9.9 0 012.1 12a10 10 0 0117-7 9.9 9.9 0 01-7 16.9z"/><path fill="#fafafa" d="M17.5 14.3c-.3 0-1.8-.8-2-.9-.7-.2-.5 0-1.7 1.3-.1.2-.3.2-.6.1s-1.3-.5-2.4-1.5a9 9 0 01-1.7-2c-.3-.6.4-.6 1-1.7l-.1-.5-1-2.2c-.2-.6-.4-.5-.6-.5-.6 0-1 0-1.4.3-1.6 1.8-1.2 3.6.2 5.6 2.7 3.5 4.2 4.2 6.8 5 .7.3 1.4.3 1.9.2.6 0 1.7-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.3-.3-.6-.4z"/></svg> Chat with Us</a>
