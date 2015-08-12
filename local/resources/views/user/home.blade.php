<!DOCTYPE html>  
<html>      
    <head>      
        <title>Sample Page</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">   
        <meta name="csrf-token" content="{{ csrf_token() }}" />    
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    </head>   
    <script type="text/javascript"> 
      var friendscount;
      var friend;
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      /* page home before create */
      $(document).on("pagebeforecreate", "#home", function (e, ui) {
           reloadContact();
      });

      /* page home before create */
      $(document).on('pageinit', '#home', function(){  
        /* create friend offline */
        $(document).on('click', '#submit', function() { // catch the form's submit event
            if($('#createfullname').val().length > 0 && $('#createemail').val().length > 0){
                // Send data to server through the Ajax call
                // action is functionality we want to call and outputJSON is our data
                $.ajax({url: '{{ URL::to('/').'/user/friendoffline' }}',
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
      $(document).on('pagebeforeshow', '#friendprofile', function(){    
          $('input[id=friendfullname]').val(friend.fullname);
          $('input[id=friendemail]').val(friend.email);
          $('input[id=friendphone]').val(friend.phone);
          $('input[id=friendpinbb]').val(friend.pinbb);
          $('input[id=friendfacebook]').val(friend.facebook);
          $('input[id=friendtwitter]').val(friend.twitter);
          $('input[id=friendinstagram]').val(friend.instagram);
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
                  url: '{{ URL::to('/').'/user/getcontact/' }}' + friendscount,
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
          $(".ui-btn-left", activePage).text("Scrolled: " + scrolled);
          $(".ui-btn-right", activePage).text("ScrollEnd: " + scrollEnd);
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
              url: '{{ URL::to('/').'/user/search' }}',
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
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
                  url: '{{ URL::to('/').'/user/profile/' }}' + $(this).attr('id'),
                  type: 'POST',
                  data: {_token: CSRF_TOKEN},
                  dataType: 'JSON',
                  success: function (data) {
                    friend = data;
                    $.mobile.changePage("#friendprofile");
                  }
              });
      }); 

      function reloadContact() {
          $.ajax({
              url: '{{ URL::to('/').'/user/getcontact' }}',
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

    </script>
    <body>              
        <div data-role="page" id="home">      
            <div data-role="header">         
                <h1>
                    My Contact
                </h1>     
                <a  href="#left-menu" data-icon="bars" data-iconpos="notext">Button</a>
                <a href="#add-form" data-icon="plus" data-iconpos="notext">Add</a>
            </div><!-- /header -->      
            
            <input type="search" placeholder="Search" id="searchbar" />
            <div data-role="content" class="ui-content">                
                <ul data-role="listview" id="list" data-autodividers="true"></ul>
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>


             <div id="left-menu" data-role="panel" data-position="left" data-theme="b" data-position-fixed="false" data-display="overlay">
                <span>Menu</span>
                <a class="ui-btn ui-icon-home ui-btn-icon-left ui-btn-active" data-theme="b" data-rel="close" gid="0">Home</a>
                <a href="#myprofile" class="ui-btn ui-icon-user ui-btn-icon-left" data-theme="b" data-rel="close" gid="0">My Profile</a>
                <a href="#invites" class="ui-btn ui-icon-plus ui-btn-icon-left" data-theme="b" data-rel="close" gid="0">Invites</a>
                <a class="ui-btn ui-icon-gear ui-btn-icon-left" data-theme="b" data-rel="close" >Settings</a>
                <a class="ui-btn ui-icon-alert ui-btn-icon-left" data-theme="b" data-rel="close" >Reports a Problem</a>
                <a class="ui-btn ui-icon-info ui-btn-icon-left" data-theme="b" data-rel="close" >Help</a>
             </div>

              <div data-role="panel" data-position="right" data-position-fixed="false" data-display="overlay" id="add-form" data-theme="b">
                  <form id="createcontactoffline" class="ui-body ui-body-a ui-corner-all" data-ajax="false" >
                    <h2>Create new contact offline</h2>
                    <label for="name">Full Name</label>
                    <input type="text" name="fullname" id="createfullname" value="" data-clear-btn="true" data-mini="true">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="createemail" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Phone</label>
                    <input type="text" name="phone" id="createphone" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Pin BB</label>
                    <input type="text" name="pinbb" id="createpinbb" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Facebook</label>
                    <input type="text" name="facebook" id="createfacebook" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Twitter</label>
                    <input type="text" name="twitter" id="createtwitter" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Instagram</label>
                    <input type="text" name="instagram" id="createinstagram" value="" data-clear-btn="true" data-mini="true">

                    <div class="ui-grid-a">
                        <div class="ui-block-a"><a href="#" data-rel="close" data-role="button" data-theme="c" data-mini="true">Cancel</a></div>
                        <div class="ui-block-b"><input type="button" data-theme="b" name="submit"  id="submit" value="Submit" data-theme="b" data-mini="true"></div>
                    </div>
                </form>
              <!-- panel content goes here -->
            </div><!-- /panel -->
        </div><!-- /page -->      
        
        <div data-role="page" id="page2">         
            <div data-role="header">    
               <h1>
                  Page 2
                </h1>     
            </div>        
            
            <div data-role="content">         
            </div>        
            
            <div data-role="footer">         
            </div><!-- /fotoer -->     
            
        </div><!-- /page --> 

        <div data-role="page" id="myprofile">
          <div data-role="header" data-theme="a" id="header1">
             <h3>My Profile</h3>
             <a href="#" data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
          </div><!-- /header --> 

          <div data-role="main">
              <form class="userform">
                  <h2>Update My Profile</h2>
                  <label for="name">Full Name</label>
                  <input type="text" name="fullname" id="fullname" value="" data-clear-btn="true" data-mini="true"> 

                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Phone</label>
                  <input type="text" name="phone" id="phone" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Pin BB</label>
                  <input type="text" name="fullname" id="fullname" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Facebook</label>
                  <input type="text" name="facebook" id="facebook" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Twitter</label>
                  <input type="text" name="twitter" id="twitter" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Instagram</label>
                  <input type="text" name="instagram" id="instagram" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Status</label>
                  <input type="text" name="status" id="status" value="" data-clear-btn="true" data-mini="true">

                  <div class="ui-grid-a">
                      <div class="ui-block-a"><a href="#" data-rel="back" data-role="button" data-theme="c" data-mini="true">Cancel</a></div>
                      <div class="ui-block-b"><a href="#" data-rel="back" data-role="button" data-theme="b" data-mini="true">Save</a></div>
                  </div>
            </form>
          </div> <!-- /content --> 

          <div data-role="footer">
            <h1>Footer Text</h1>
          </div>
        </div>  <!-- /footer --> 

        <!-- friend profile -->
        <div data-role="page" id="friendprofile">
          <div data-role="header" data-theme="a" id="header1">
             <h3>My Friend Profile</h3>
             <a href="#" data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
          </div><!-- /header --> 

          <div data-role="main">
              <form class="userform">
                  <h2>Friend Profile</h2>
                  <label for="name">Full Name</label>
                  <input type="text" name="fullname" id="friendfullname" value="" data-mini="true" data-clear-btn="false" readonly> 

                  <label for="email">Email</label>
                  <input type="email" name="email" id="friendemail" value="" data-mini="true" data-clear-btn="false" readonly>

                  <label for="name">Phone</label>
                  <input type="text" name="phone" id="friendphone" value="" data-mini="true" data-clear-btn="false" readonly>

                  <label for="name">Pin BB</label>
                  <input type="text" name="pinbb" id="friendpinbb" value="" data-mini="true" data-clear-btn="false" readonly>

                  <label for="name">Facebook</label>
                  <input type="text" name="facebook" id="friendfacebook" value="" data-mini="true" data-clear-btn="false" readonly>

                  <label for="name">Twitter</label>
                  <input type="text" name="twitter" id="friendtwitter" value="" data-mini="true" data-clear-btn="false" readonly>

                  <label for="name">Instagram</label>
                  <input type="text" name="instagram" id="friendinstagram" value="" data-mini="true" data-clear-btn="false" readonly>
            </form>
          </div> <!-- /content --> 

          <div data-role="footer">
            <h1>Footer Text</h1>
          </div>
        </div>  <!-- /footer --> 

    </body>
</html>