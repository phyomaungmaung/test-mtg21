// var tt=0;
function alertDelete(item,urldelete,urlindex,token,banner){
  var item_id  =   $(item).data('item');

  swal({   
      title: "Are you sure?",   
      text: "You will not be able to recover this "+banner+" file!",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Yes, delete",   
      cancelButtonText: "No, cancel",
      closeOnConfirm: false,
      closeOnCancel: true
  }, function(isConfirm){

      if (isConfirm)
      {
          $.ajax({
              url: urldelete,
              type: "POST",
              dataType: "html",
              data: {item:item_id, _token:token},
              success: function(result)
              {
                  try{
                      result =JSON.parse(result);
                  }catch (e){ }
                  // tt=result;
                  if(result=="success"){
                      window.location = urlindex;
                  }else if(result.mess ){
                      swal("Warning!", "Cannot delete this item !!!\n "+result.mess, "error");
                  } else{

                      swal("Warning!", "This item is used by other or you don't have permission!", "error");
                  }

              },
              error:function(){
                swal("Warning!", "This item is used by other or you don't have permission!", "error");
              }
          });
      }
      
  });
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var username = getCookie("username");
    if (username != "") {
        alert("Welcome again " + username);
    } else {
        username = prompt("Please enter your name:", "");
        if (username != "" && username != null) {
            setCookie("username", username, 365);
        }
    }
}

$(document).ready(function () {
    // checkCookie();
});

$.AdminLTESidebarTweak = {};

$.AdminLTESidebarTweak.options = {
    EnableRemember: true,
    NoTransitionAfterReload: false
    //Removes the transition after page reload.
};

$(function () {
    "use strict";

    $("body").on("collapsed.pushMenu", function(){
        if($.AdminLTESidebarTweak.options.EnableRemember){
            document.cookie = "toggleState=closed";
        }
    });
    $("body").on("expanded.pushMenu", function(){
        if($.AdminLTESidebarTweak.options.EnableRemember){
            document.cookie = "toggleState=opened";
        }
    });

    if($.AdminLTESidebarTweak.options.EnableRemember){
        var re = new RegExp('toggleState' + "=([^;]+)");
        var value = re.exec(document.cookie);
        var toggleState = (value != null) ? unescape(value[1]) : null;
        if(toggleState == 'closed'){
            if($.AdminLTESidebarTweak.options.NoTransitionAfterReload){
                $("body").addClass('sidebar-collapse hold-transition').delay(20).queue(function(){
                    $(this).removeClass('hold-transition');
                });
            }else{
                $("body").addClass('sidebar-collapse');
            }
        }
    }
});