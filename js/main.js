$(document).ready(function(){
  $(".company-name").keyup(function(){
      var this_value = $(this).val();
      $(".dynamic-c-name").html(this_value);
  });

  $("#companyLogo").change(function(){
    var imageWidth;
    var imageHeight;
    var this_c = $(this);
    var file = this.files[0];
    var file_type = file.type;
    
    if(file_type == 'image/png' || file_type == 'image/webp' || file_type == 'image/jpg' || file_type == 'image/jpeg' || file_type == 'image/gif')
    { 
      var url = URL.createObjectURL(file);
      let img = new Image();
      img.src=url;
      img.onload = function() {
        imageWidth = img.width;
        imageHeight = img.height;
        if(imageWidth == imageHeight)
        {
          $(".company-logo-preview").attr("src",url);
          $(this_c).css("border","1px solid #8c8f94");
          $(".error-notice").html("");
        }
        else
        {
          $(".error-notice").html("Please upload same size of width and height image");
          $(this_c).css("border","1px solid red");
          $(this_c).val('');
        }
      }
    }
    else{
      $(".error-notice").html("Please upload only jpg,jpeg,gif,webp and png");
      $(this_c).css("border","1px solid red");
      $(this_c).val('');
    }
   
  });

  $(".online_offline").change(function(){
    var attr = $(this).attr('checked');
    if (typeof attr !== 'undefined' && attr !== false) {
      $(this).removeAttr('checked');
      $(".whatsapp-chat-avatar").removeClass("whatsapp-online");
      $(".whatsapp-chat-avatar").addClass("whatsapp-offline");
    }
    else{
      $(this).attr('checked','');
      $(".whatsapp-chat-avatar").addClass("whatsapp-online");
      $(".whatsapp-chat-avatar").removeClass("whatsapp-offline");
    }
  });
});