        jQuery(document).on("click", "#send-it", function() {
            var a = document.getElementById("chat-input");
            if ("" != a.value) {
              var b = jQuery("#get-number").text(),
                c = document.getElementById("chat-input").value,
                d = "https://web.whatsapp.com/send",
                e = b,
                f = "&text=" + c;
              if (
                /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                  navigator.userAgent
                )
              )
                var d = "whatsapp://send";
              var g = d + "?phone=" + e + f;
              window.open(g, "_blank");
            }
          }),
          jQuery(document).on("click", ".informasi", function() {
              (document.getElementById("get-number").innerHTML = jQuery(this)
                .children(".my-number")
                .text()),
                jQuery(".start-chat,.get-new")
                  .addClass("show")
                  .removeClass("hide"),
                  jQuery(".home-chat,.head-home")
                  .addClass("hide")
                  .removeClass("show"),
                (document.getElementById("get-nama").innerHTML = jQuery(this)
                  .children(".info-chat")
                  .children(".chat-nama")
                  .text()),
                (document.getElementById("get-label").innerHTML = jQuery(this)
                  .children(".info-chat")
                  .children(".chat-label")
                  .text());
            }),
            jQuery(document).on("click", ".close-chat", function() {
              jQuery("#whatsapp-chat")
                .addClass("hide")
                .removeClass("show");
            }),
            jQuery(document).on("click", ".blantershow-chat", function() {
              jQuery("#whatsapp-chat")
                .addClass("show")
                .removeClass("hide");
            });