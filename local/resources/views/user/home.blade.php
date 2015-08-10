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
      var friendsonlinecount = {{ $friendsonlinecount-10 }};
      var friendsofflinecount = {{ $friendsofflinecount-10 }};
      var friend;
      /* page home before create */
      $(document).on("pagebeforecreate", "#home", function (e, ui) {
          var items = '';
          @foreach ($friendsonline as $friend)
          @if ($friend->user1 == $user->id)
            items += "<li id='{{ $friend->user2 }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png'/>" + "{{ DB::table('users')->where('id', $friend->user2)->first()->fullname }}" + "</>"  + "</li>";
          @elseif ($friend->user2 == $user->id)
            items += "<li id='{{ $friend->user1 }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png'/>"  + "{{ DB::table('users')->where('id', $friend->user1)->first()->fullname }}" + "</>" + "</li>";
          @endif
          @endforeach
          @foreach ($friendsoffline as $friend)
            items += "<li id='{{ $friend->id }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png'/>"  + "{{ $friend->fullname }}" + "</>"  + "</li>";
          @endforeach

          $("#list").append(items);
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
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                  url: '{{ URL::to('/').'/user/getcontact/' }}' + friendsonlinecount + '/' + friendsofflinecount,
                  type: 'POST',
                  data: {_token: CSRF_TOKEN},
                  dataType: 'JSON',
                  success: function (data) {
                    $.each (data, function (index) {
                      items += "<li id='" + data[index].split(' ')[0] + "'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" +  data[index].split(' ')[1] + "</>"  + "</li>";
                      --friendsonlinecount;
                      --friendsofflinecount;
                      console.log (items);
                    });
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
          if (activePage[0].id == "home" && scrolled >= scrollEnd && (friendsonlinecount > 0 || friendsofflinecount > 0) && $('#searchbar').val().length == 0) {
              console.log("adding...");
              addMore(activePage);
          }
      });

      /*When search through input view*/
      $(document).on("input", "#searchbar", function (e) { 
        //your code
        var searchbar = $(this); 
        var items = '';
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        if(searchbar.val() == "")
        {
          friendsonlinecount = {{ $friendsonlinecount-10 }};
          friendsofflinecount = {{ $friendsofflinecount-10 }};
          @foreach ($friendsonline as $friend)
          @if ($friend->user1 == $user->id)
            items += "<li id='{{ $friend->user2 }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" + "{{ DB::table('users')->where('id', $friend->user2)->first()->fullname }}" + "</>"  + "</li>";
          @elseif ($friend->user2 == $user->id)
            items += "<li id='{{ $friend->user1 }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />"  + "{{ DB::table('users')->where('id', $friend->user1)->first()->fullname }}" + "</>" + "</li>";
          @endif
          @endforeach
          @foreach ($friendsoffline as $friend)
            items += "<li id='{{ $friend->id }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />"  + "{{ $friend->fullname }}" + "</>"  + "</li>";
          @endforeach

          $("#list").empty().append(items).listview("refresh");  
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
                $.each (data, function (index) {
                  $("#list").append("<li id='"  + data[index].split(' ')[0] + "'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='45' width='45' />" + data[index].split(' ')[1] + "</>" + "</li>").listview("refresh");
                });
            }
          });
        }

        console.log("searching..." + searchbar.val());
      });

      /*When click clear search input*/
      $(document).on('click', '.ui-input-clear', function () {
            var items = '';

            friendsonlinecount = {{ $friendsonlinecount-10 }};
            friendsofflinecount = {{ $friendsofflinecount-10 }};
            @foreach ($friendsonline as $friend)
            @if ($friend->user1 == $user->id)
              items += "<li id='{{ $friend->user2 }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png'/>" + "{{ DB::table('users')->where('id', $friend->user2)->first()->fullname }}" + "</>"  + "</li>";           
            @elseif ($friend->user2 == $user->id)
              items += "<li id='{{ $friend->user1 }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png'/>"  + "{{ DB::table('users')->where('id', $friend->user1)->first()->fullname }}" + "</>" + "</li>";
            @endif
            @endforeach
            @foreach ($friendsoffline as $friend)
              items += "<li id='{{ $friend->id }}'><a href='#'><img class='ui-li-icon' src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png'/>"  + "{{ $friend->fullname }}" + "</>"  + "</li>";
            @endforeach

            $("#list").empty().append(items).listview("refresh");  
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
                    console.log (friend);
                    $.mobile.changePage("#friendprofile");
                  }
              });
      }); 

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
                  <form class="userform">
                    <h2>Create new contact offline</h2>
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

                    <div class="ui-grid-a">
                        <div class="ui-block-a"><a href="#" data-rel="close" data-role="button" data-theme="c" data-mini="true">Cancel</a></div>
                        <div class="ui-block-b"><a href="#" data-rel="close" data-role="button" data-theme="b" data-mini="true">Save</a></div>
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
                  <input type="text" name="fullname" id="friendfullname" value="" data-clear-btn="true" data-mini="true" readonly> 

                  <label for="email">Email</label>
                  <input type="email" name="email" id="friendemail" value="" data-clear-btn="true" data-mini="true" readonly>

                  <label for="name">Phone</label>
                  <input type="text" name="phone" id="friendphone" value="" data-clear-btn="true" data-mini="true" readonly>

                  <label for="name">Pin BB</label>
                  <input type="text" name="pinbb" id="friendpinbb" value="" data-clear-btn="true" data-mini="true" readonly>

                  <label for="name">Facebook</label>
                  <input type="text" name="facebook" id="friendfacebook" value="" data-clear-btn="true" data-mini="true" readonly>

                  <label for="name">Twitter</label>
                  <input type="text" name="twitter" id="friendtwitter" value="" data-clear-btn="true" data-mini="true" readonly>

                  <label for="name">Instagram</label>
                  <input type="text" name="instagram" id="friendinstagram" value="" data-clear-btn="true" data-mini="true" readonly>
            </form>
          </div> <!-- /content --> 

          <div data-role="footer">
            <h1>Footer Text</h1>
          </div>
        </div>  <!-- /footer --> 

    </body>
</html>