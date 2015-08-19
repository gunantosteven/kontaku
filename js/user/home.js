var friendscount;
var friend;
var friendonlineinvatitation;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

/* ===================================js page friendprofile=================================== */
$(document).on("pagebeforecreate", "#home", function (e, ui) {
     reloadContact();
});
/* page home initialization */
$(document).on('pageinit', '#home', function(){  
  /* create friend offline */
  $(document).on('click', '#submit', function() { // catch the form's submit event
      if($('#createfullname').val().length > 0 && $('#createemail').val().length > 0){
          // Send data to server through the Ajax call
          // action is functionality we want to call and outputJSON is our data
          $.ajax({url: index + "/user/friendoffline",
              data: {_token: CSRF_TOKEN, action : 'create', formData : $('#createcontactoffline').serialize()},
              type: 'post',                   
              async: 'true',
              dataType: 'json',
              beforeSend: function() {
                  // This callback function will trigger before data is sent
                  $.mobile.loading('show'); // This will show ajax spinner
              },
              complete: function() {
                  // This callback function will trigger on data sent/received complete
                  $.mobile.loading('hide'); // This will hide ajax spinner
              },
              success: function (result) {
                  if(result.status) {
                        $('input[id=createfullname]').val('');
                        $('input[id=createemail]').val('');
                        $('input[id=createphone]').val('');
                        $('input[id=createpinbb]').val('');
                        $('input[id=createfacebook]').val('');
                        $('input[id=createtwitter]').val('');
                        $('input[id=createinstagram]').val('');
                       $.mobile.pageContainer.pagecontainer("change", "home", {transition: "slide"});
                       reloadContact();
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });                   
      } else {
          alert('Please fill all necessary fields');
      }           
      return false; // cancel original event to prevent form submitting
  });    

  /*When search through input view*/
  $(document).on("input", "#searchbar", function (e) { 
    //your code
    var searchbar = $(this); 

    if(searchbar.val() == "")
    {
       reloadContact();
    }
    else
    {
      $.ajax({
          url: index + "/user/search",
          type: 'POST',
          data: {_token: CSRF_TOKEN, search: searchbar.val()},
          dataType: 'JSON',
          success: function (data) {
            $("#list").empty();
            $.each (data['friends'], function (index) {
              $("#list").append("<li id='"  + data['friends'][index]['id'] + "'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" + data['friends'][index]['fullname'] + "</>" + "</li>").listview("refresh");
            });
        }
      });
    }
  });

  /* add more contact */
  function addMore(page) {
      $.mobile.loading("show", {
          text: "loading more..",
          textVisible: true,
          theme: "b"
      });
      setTimeout(function () {
          var items = '';
          var count = 0;
          $.ajax({
              url: index + "/user/getcontact/" + friendscount,
              type: 'POST',
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (data) {
                $.each (data['friends'], function (index) {
                  items += "<li id='" + data['friends'][index]['id'] + "'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" +  data['friends'][index]['fullname'] + "</>"  + "</li>";
                });
                friendscount = data['friendscount'];
                $("#list", page).append(items).listview("refresh");
                $.mobile.loading("hide");
              }
          });
      }, 500);
  }

  /* scroll event */
  $(document).on("scrollstop", function (e) {
      var activePage = $.mobile.pageContainer.pagecontainer("getActivePage"),
          screenHeight = $.mobile.getScreenHeight(),
          contentHeight = $(".ui-content", activePage).outerHeight(),
          scrolled = $(window).scrollTop(),
          header = $(".ui-header", activePage).hasClass("ui-header-fixed") ? $(".ui-header", activePage).outerHeight() - 1 : $(".ui-header", activePage).outerHeight(),
          footer = $(".ui-footer", activePage).hasClass("ui-footer-fixed") ? $(".ui-footer", activePage).outerHeight() - 1 : $(".ui-footer", activePage).outerHeight(),
          scrollEnd = contentHeight - screenHeight + header + footer;
      if (activePage[0].id == "home" && scrolled >= scrollEnd && (friendscount > 0) && $('#searchbar').val().length == 0) {
          console.log("adding...");
          addMore(activePage);
      }
  });

  /*When click clear search input*/
  $(document).on('click', '.ui-input-clear', function () {
        reloadContact();
  });

  /*When click contact listview*/
  $(document).on("click", "#list li" ,function (event) {
    if($(this).attr('id') !== undefined)
    {
      $.ajax({
              url: index + "/user/profile/" + $(this).attr('id'),
              type: 'POST',
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (data) {
                  friend = data;
                  $.mobile.changePage("#friendprofile");
              }
          });
    }
  }); 

});
/* ===================================end js page home=================================== */

/* ===================================js page friendprofile=================================== */
$(document).on('pageinit', '#friendprofile', function(){  
  $(document).on('click', '#deletefriend', function() { 

    $.ajax({url: index + "/user/friend",
              data: {_token: CSRF_TOKEN, action : 'delete', id : friend.id, onlineoffline : friend.onlineoffline },
              type: 'delete',                   
              async: 'true',
              dataType: 'json',
              beforeSend: function() {
                  // This callback function will trigger before data is sent
                  $.mobile.loading('show'); // This will show ajax spinner
              },
              complete: function() {
                  // This callback function will trigger on data sent/received complete
                  $.mobile.loading('hide'); // This will hide ajax spinner
              },
              success: function (result) {
                  if(result.status) {
                       $.mobile.pageContainer.pagecontainer("change", "home", {transition: "slide"});
                       reloadContact();
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });            
  }); 
});
/* show friend profile who clicked */
$(document).on('pagebeforeshow', '#friendprofile', function(){    
    // make list empty first
    $("#actionFriendProfileList").empty();

    $('#friendPic').attr('src', 'http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png');
    $('#friendPic').attr('height', '65');
    $('#friendPic').attr('width', '65');
    $('#fullName').text(friend.fullname);
    $('#friendprofileonlineoffline').text("This is your friend " + friend.onlineoffline);
    if (friend.email) {
      $('#actionFriendProfileList').append('<li><a href="mailto:' + friend.email + '"><h3>Email</h3>' +
          '<p>' + friend.email + '</p></a></li>');
    }
    if (friend.phone) {
      $('#actionFriendProfileList').append('<li><a href="tel:' + friend.phone + '"><h3>Call This Number</h3>' +
          '<p>' + friend.phone + '</p></a></li>');
      $('#actionFriendProfileList').append('<li><a href="sms:' + friend.phone + '"><h3>SMS</h3>' +
          '<p>' + friend.phone + '</p></a></li>');
    }
    if (friend.pinbb) {
      $('#actionFriendProfileList').append('<li><a href=""><h3>PIN BB</h3>' +
          '<p>' + friend.pinbb + '</p></a></li>');
    }
    if (friend.facebook) {
      $('#actionFriendProfileList').append('<li><a href=""><h3>Facebook</h3>' +
          '<p>' + friend.facebook+ '</p></a></li>');
    }
    if (friend.twitter) {
      $('#actionFriendProfileList').append('<li><a href=""><h3>Twitter</h3>' +
          '<p>' + friend.twitter + '</p></a></li>');
    }
    if (friend.instagram) {
      $('#actionFriendProfileList').append('<li><a href=""><h3>Instagram</h3>' +
          '<p>' + friend.instagram + '</p></a></li>');
    }

    if(friend.onlineoffline == 'online')
    {
      $('#editfriendprofilebuttonpage').hide();
    }
    else
    {
      $('#editfriendprofilebuttonpage').show();
    }

    $('#actionFriendProfileList').listview('refresh');
});
/* ===================================end js page friendprofile=================================== */

/* ===================================js page editfriendprofile=================================== */
$(document).on('pageinit', '#editfriendprofile', function(){  
  /* create friend offline */
  $(document).on('click', '#editfriendsubmit', function() { // catch the form's submit event
    if($('#editfriendfullname').val().length > 0 && $('#editfriendemail').val().length > 0){
        // Send data to server through the Ajax call
        // action is functionality we want to call and outputJSON is our data
        $.ajax({url: index + "/user/friendoffline",
            data: {_token: CSRF_TOKEN, action : 'edit', id : friend.id, formData : $('#formEditFriendOffline').serialize()},
            type: 'put',                   
            async: 'true',
            dataType: 'json',
            beforeSend: function() {
                // This callback function will trigger before data is sent
                $.mobile.loading('show'); // This will show ajax spinner
            },
            complete: function() {
                // This callback function will trigger on data sent/received complete
                $.mobile.loading('hide'); // This will hide ajax spinner
            },
            success: function (result) {
                if(result.status) {
                      friend.fullname = $('#editfriendfullname').val();
                      friend.email = $('#editfriendemail').val();
                      friend.phone = $('#editfriendphone').val();
                      friend.pinbb = $('#editfriendpinbb').val();
                      friend.facebook = $('#editfriendfacebook').val();
                      friend.twitter = $('#editfriendtwitter').val();
                      friend.instagram = $('#editfriendinstagram').val();
                      $.mobile.pageContainer.pagecontainer("change", "home#friendprofile", {transition: "slide"});
                      reloadContact();
                } else {
                    alert('Something error happened!'); 
                }
            },
            error: function (request,error) {
                // This callback function will trigger on unsuccessful action                
                alert('Network error has occurred please try again!');
            }
        });                   
    } else {
        alert('Please fill all necessary fields');
    }           
      return false; // cancel original event to prevent form submitting
  });    
});
/* edit friend profile */
$(document).on('pagebeforeshow', '#editfriendprofile', function(){    
  // initialization form edit
  $('#editfriendfullname').val(friend.fullname);
  $('#editfriendemail').val(friend.email);
  $('#editfriendphone').val(friend.phone);
  $('#editfriendpinbb').val(friend.pinbb);
  $('#editfriendfacebook').val(friend.facebook);
  $('#editfriendtwitter').val(friend.twitter);
  $('#editfriendinstagram').val(friend.instagram);
}); 
/* ===================================end js page editfriendprofile=================================== */

/* ===================================js page myprofile=================================== */
$(document).on('pageinit', '#myprofile', function(){  
  /* create friend offline */
  $(document).on('click', '#editmyprofilesubmit', function() { // catch the form's submit event
    if($('#editmyprofilefullname').val().length > 0){
        // Send data to server through the Ajax call
        // action is functionality we want to call and outputJSON is our data
        $.ajax({url: index + "/user/editprofile",
            data: {_token: CSRF_TOKEN, action : 'edit', id : userid, formData : $('#formEditMyProfile').serialize()},
            type: 'put',                   
            async: 'true',
            dataType: 'json',
            beforeSend: function() {
                // This callback function will trigger before data is sent
                $.mobile.loading('show'); // This will show ajax spinner
            },
            complete: function() {
                // This callback function will trigger on data sent/received complete
                $.mobile.loading('hide'); // This will hide ajax spinner
            },
            success: function (result) {
                if(result.status) {
                       $.mobile.back();
                } else {
                    alert('Something error happened!'); 
                }
            },
            error: function (request,error) {
                // This callback function will trigger on unsuccessful action                
                alert('Network error has occurred please try again!');
            }
        });                   
    } else {
        alert('Please fill all necessary fields');
    }           
      return false; // cancel original event to prevent form submitting
  });    
});
/* edit my profile before show */
$(document).on('pagebeforeshow', '#myprofile', function(){    
  // initialization form edit
  $.ajax({
            url: index + "/user/profile/" + userid,
            type: 'POST',
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                // initialization my profile form
              $('#editmyprofilefullname').val(data.fullname);
              $('#editmyprofilephone').val(data.phone);
              $('#editmyprofilepinbb').val(data.pinbb);
              $('#editmyprofilefacebook').val(data.facebook);
              $('#editmyprofiletwitter').val(data.twitter);
              $('#editmyprofileinstagram').val(data.instagram);
            }
        });
}); 
/* ===================================end js page myprofile=================================== */

/* ===================================js page invites=================================== */
$(document).on('pageinit', '#invites', function(){  
  $('#listinvites').on('click', 'li', function() {
      friendonlineinvatitation = {id:$(this).attr('id').split(";")[0], fullname:$(this).attr('id').split(";")[1], status:$(this).attr('id').split(";")[2]};
      if($(this).attr('id').split(";")[3] == "got")
      {
        if(friendonlineinvatitation.status == "PENDING")
        {
          $.mobile.changePage("#gotinvitation");
        }
      }
      else if($(this).attr('id').split(";")[3] == "sent")
      {
        if(friendonlineinvatitation.status == "PENDING" || friendonlineinvatitation.status == "DECLINED")
        {
          $.mobile.changePage("#sentinvitation");
        }
      }
  }); 

}); 
/* invites before show */
$(document).on('pagebeforeshow', '#invites', function(){    
  $("#listinvites").empty();

  $.ajax({
        url: index + "/user/gotinvitation",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          if(data['users'][0] != null)
          {
            $("#listinvites").append("<li data-role='list-divider'>Got Invites</li>");
            $.each (data['users'], function (index) {
              $("#listinvites").append("<li id='"  + data['users'][index]['id'] + ";" + data['users'][index]['fullname'] + ";" + data['users'][index]['status'] +  ";got'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" + data['users'][index]['fullname'] + "<p>" + data['users'][index]['status'] + "</p>" + "</a>" + "</li>").listview("refresh");
            });
          }
      }})  
  $.ajax({
      url: index + "/user/sentinvitation",
      type: 'POST',
      data: {_token: CSRF_TOKEN},
      dataType: 'JSON',
      success: function (data) {
        if(data['users'][0] != null)
        {
          $("#listinvites").append("<li data-role='list-divider'>Sent Invites</li>");
          $.each (data['users'], function (index) {
            $("#listinvites").append("<li id='"  + data['users'][index]['id'] + ";" + data['users'][index]['fullname'] + ";" + data['users'][index]['status'] + ";sent'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" + data['users'][index]['fullname'] + "<p>" + data['users'][index]['status'] + "</p>" + "</a>" + "</li>").listview("refresh");
          });
        }
    }})  

}); 
/* ===================================end js page invites=================================== */

/* ===================================js page addfriendsonline=================================== */
$(document).on('pageinit', '#addfriendsonline', function(){  
  $(document).on('click', '#buttonaddfriendsonline', function() { 

    $.ajax({url: index + "/user/friendonline",
              data: {_token: CSRF_TOKEN, action : 'add', formData : $('#formAddFriendOnline').serialize()},
              type: 'post',                   
              async: 'true',
              dataType: 'json',
              beforeSend: function() {
                  // This callback function will trigger before data is sent
                  $.mobile.loading('show'); // This will show ajax spinner
              },
              complete: function() {
                  // This callback function will trigger on data sent/received complete
                  $.mobile.loading('hide'); // This will hide ajax spinner
              },
              success: function (result) {
                  if(result.status) {
                       $('#searchbaraddfriendsonline').val('');
                       $.mobile.pageContainer.pagecontainer("change", "home#invites", {transition: "slide"});
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });            
  }); 
  $(document).on('click', '#submitsearchaddfriendsonline', function() { 
      if($('#searchbaraddfriendsonline').val().length > 0){
        // Send data to server through the Ajax call
        // action is functionality we want to call and outputJSON is our data
        $.ajax({url: index + "/user/searchaddfriendsonline",
            data: {_token: CSRF_TOKEN, action : 'search', formData : $('#formSearchAddFriendOnline').serialize()},
            type: 'post',                   
            async: 'true',
            dataType: 'json',
            beforeSend: function() {
                // This callback function will trigger before data is sent
                $.mobile.loading('show'); // This will show ajax spinner
            },
            complete: function() {
                // This callback function will trigger on data sent/received complete
                $.mobile.loading('hide'); // This will hide ajax spinner
            },
            success: function (result) {
                if(result.status) 
                {
                  $('#fullnameuseraddfriendsonline').text(result['users'][0].fullname);
                  $('#iduseraddfriendsonline').val(result['users'][0].id);

                  $('#imguseraddfriendsonline').show();
                  $('#fullnameuseraddfriendsonline').show();
                  $('#buttonaddfriendsonline').show();
                } 
                else 
                {
                    $('#fullnameuseraddfriendsonline').val('');
                    $('#iduseraddfriendsonline').val('');

                    $('#imguseraddfriendsonline').hide();
                    $('#fullnameuseraddfriendsonline').hide();
                    $('#buttonaddfriendsonline').hide();
                    alert('User Not Found'); 
                }
            },
            error: function (request,error) {
                // This callback function will trigger on unsuccessful action                
                alert('Network error has occurred please try again!');
            }
        });                   
      } else {
          alert('Please fill all necessary fields');
      }           
        return false; // cancel original event to prevent form submitting
  });

});
$(document).on('pagebeforeshow', '#addfriendsonline', function(){ 
    $('#imguseraddfriendsonline').hide();
    $('#fullnameuseraddfriendsonline').hide();
    $('#buttonaddfriendsonline').hide();
}); 
/* ===================================end js page addfriendsonline=================================== */

/* ===================================js page gotinvitation=================================== */
$(document).on('pageinit', '#gotinvitation', function(){  
  $(document).on('click', '#addfriendsonlineaccept', function() { 
      $.ajax({url: index + "/user/acceptinvitation",
              data: {_token: CSRF_TOKEN, action : 'accept', id : friendonlineinvatitation.id},
              type: 'post',                   
              async: 'true',
              dataType: 'json',
              beforeSend: function() {
                  // This callback function will trigger before data is sent
                  $.mobile.loading('show'); // This will show ajax spinner
              },
              complete: function() {
                  // This callback function will trigger on data sent/received complete
                  $.mobile.loading('hide'); // This will hide ajax spinner
              },
              success: function (result) {
                  if(result.status) {
                       $.mobile.pageContainer.pagecontainer("change", "home#invites", {transition: "slide"});
                       reloadContact();
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });           
  });
  $(document).on('click', '#addfriendsonlinedecline', function() { 
        $.ajax({url: index + "/user/declineinvitation",
                data: {_token: CSRF_TOKEN, action : 'decline', id : friendonlineinvatitation.id},
                type: 'post',                   
                async: 'true',
                dataType: 'json',
                beforeSend: function() {
                    // This callback function will trigger before data is sent
                    $.mobile.loading('show'); // This will show ajax spinner
                },
                complete: function() {
                    // This callback function will trigger on data sent/received complete
                    $.mobile.loading('hide'); // This will hide ajax spinner
                },
                success: function (result) {
                    if(result.status) {
                         $.mobile.pageContainer.pagecontainer("change", "home#invites", {transition: "slide"});
                    } else {
                        alert('Something error happened!'); 
                    }
                },
                error: function (request,error) {
                    // This callback function will trigger on unsuccessful action                
                    alert('Network error has occurred please try again!');
                }
            });           
  });

});
/* edit friend profile */
$(document).on('pagebeforeshow', '#gotinvitation', function(){    
  // initialization form edit
  $('#fullnameusergotinvitation').text(friendonlineinvatitation.fullname);
  $('#statususergotinvitation').text(friendonlineinvatitation.status);
}); 
/* ===================================end js page gotinvitation=================================== */

/* ===================================js page sentinvitation=================================== */
$(document).on('pageinit', '#sentinvitation', function(){  
  $(document).on('click', '#addfriendsonlinedelete', function() { 
        $.ajax({url: index + "/user/deleteinvitation",
                data: {_token: CSRF_TOKEN, action : 'delete', id : friendonlineinvatitation.id},
                type: 'delete',                   
                async: 'true',
                dataType: 'json',
                beforeSend: function() {
                    // This callback function will trigger before data is sent
                    $.mobile.loading('show'); // This will show ajax spinner
                },
                complete: function() {
                    // This callback function will trigger on data sent/received complete
                    $.mobile.loading('hide'); // This will hide ajax spinner
                },
                success: function (result) {
                    if(result.status) {
                         $.mobile.pageContainer.pagecontainer("change", "home#invites", {transition: "slide"});
                    } else {
                        alert('Something error happened!'); 
                    }
                },
                error: function (request,error) {
                    // This callback function will trigger on unsuccessful action                
                    alert('Network error has occurred please try again!');
                }
            });           
  });

});
$(document).on('pagebeforeshow', '#sentinvitation', function(){    
  // initialization form edit
  $('#fullnameusersentinvitation').text(friendonlineinvatitation.fullname);
  $('#statususersentinvitation').text(friendonlineinvatitation.status);
}); 
/* ===================================end js page sentinvitation=================================== */

// function reloadContact
function reloadContact() {
    $.ajax({
        url: index + "/user/getcontact",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          $("#list").empty();
          $.each (data['friends'], function (index) {
            $("#list").append("<li id='"  + data['friends'][index]['id'] + "'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" + data['friends'][index]['fullname'] + "</>" + "</li>").listview("refresh");
          });
          friendscount = data['friendscount'];
      }})             
}
