var friendscount;
var friend;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var isEditFriendProfile = false; // check if user edit friend profile. 

/* page home before create */
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
});

/* show friend profile who clicked */
$(document).on('pagebeforeshow', '#home', function(){   
      if(isEditFriendProfile)
      {
        $.mobile.pageContainer.pagecontainer("change", "home", {transition: "slide"});
        reloadContact();
        isEditFriendProfile = false;
      }
});

/* show friend profile who clicked */
$(document).on('pagebeforeshow', '#friendprofile', function(){    
    // make list empty first
    $("#actionFriendProfileList").empty();

    $('#friendPic').attr('src', 'http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png');
    $('#friendPic').attr('height', '65');
    $('#friendPic').attr('width', '65');
    $('#fullName').text(friend.fullname);
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
    $('#actionFriendProfileList').listview('refresh');
});

/* page edit friend initialization */
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
                      isEditFriendProfile = true;
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

/* edit friend profile */
$(document).on('pagebeforeshow', '#editfriendprofile', function(){    
  console.log(friend.fullname);

  // initialization form edit
  $('#editfriendfullname').val(friend.fullname);
  $('#editfriendemail').val(friend.email);
  $('#editfriendphone').val(friend.phone);
  $('#editfriendpinbb').val(friend.pinbb);
  $('#editfriendfacebook').val(friend.facebook);
  $('#editfriendtwitter').val(friend.twitter);
  $('#editfriendinstagram').val(friend.instagram);
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
