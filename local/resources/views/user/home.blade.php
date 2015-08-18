<!DOCTYPE html>  
<html>      
    <head>      
        <title>Sample Page</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">   
        <meta name="csrf-token" content="{{ csrf_token() }}" />    
        <!-- JavaScript -->
        <script type='text/javascript' src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script type='text/javascript' src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script type='text/javascript' src={{ asset('js/user/home.js') }}></script>
        <!-- CSS -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
        <link rel="stylesheet" href={{ asset('css/user/home.css') }} />
    </head>   
    <script type="text/javascript">
      var index = "{{ URL::to('/') }}";
      var userid = "{{ Auth::user()->id }}";
    </script>
    <style type="text/css">
      
    </style>
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
                        <div class="ui-block-b"><input type="button" data-theme="b" name="submit"   id="submit" value="Submit" data-theme="b" data-mini="true"></div>
                    </div>
                </form>
              <!-- panel content goes here -->
            </div><!-- /panel -->
        </div><!-- /page -->      

        <div data-role="page" id="myprofile">
          <form id="formEditMyProfile"  data-ajax="false">
          <div data-role="header" data-theme="a" id="header1">
             <h3>My Profile</h3>
             <a href="#" data-icon="back" data-iconpos="notext" data-rel="back">Cancel</a>
             <a href="#" data-role="button" id="editmyprofilesubmit" data-theme="b" data-mini="true">OK</a>
          </div><!-- /header --> 

          <div data-role="main">
                  <h2>Edit My Profile</h2>
                  <label for="name">Full Name</label>
                  <input type="text" name="fullname" id="editmyprofilefullname" value="" data-clear-btn="true" data-mini="true"> 

                  <label for="name">Phone</label>
                  <input type="text" name="phone" id="editmyprofilephone" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Pin BB</label>
                  <input type="text" name="pinbb" id="editmyprofilepinbb" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Facebook</label>
                  <input type="text" name="facebook" id="editmyprofilefacebook" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Twitter</label>
                  <input type="text" name="twitter" id="editmyprofiletwitter" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Instagram</label>
                  <input type="text" name="instagram" id="editmyprofileinstagram" value="" data-clear-btn="true" data-mini="true">
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
              <img id="friendPic"/>
              <div id="friendDetails">
                   <h3 id="fullName"></h3>
              </div>
             
              <ul id="actionFriendProfileList" data-role="listview" data-inset="true"></ul>

              <div class="ui-grid-a">
                  <div class="ui-block-a"><a href="#editfriendprofile" id="editfriendprofilebuttonpage"  data-role="button" data-theme="b" data-mini="true" data-icon="edit" data-iconpos="top">Edit</a></div>
                  <div class="ui-block-b"><a href="#popupDialog" data-rel="popup" data-position-to="window"  data-role="button"  data-transition="pop"  data-icon="delete" data-theme="b" data-mini="true" data-iconpos="top">Delete</a></div>
              </div>
              <!-- popupDialog creating form -->
              <div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
                  <div data-role="header" data-theme="a" class="ui-corner-top">
                      <h1>Delete Contact?</h1>
                  </div>
                  <div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
                      <h3 class="ui-title">Are you sure you want to delete this contact?</h3>
                      <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
                      <a href="#" id="deletefriend" data-role="button" data-inline="true"  data-transition="flow" data-theme="b">Delete</a>
                  </div>
              </div> <!-- end popup -->
          </div> <!-- /content --> 

          <div data-role="footer">
            <h1>Footer Text</h1>
          </div>
        </div>  <!-- /footer --> 

        <!-- edit friend profile -->
        <div data-role="page" id="editfriendprofile">
          <form id="formEditFriendOffline"  data-ajax="false">
                  <div data-role="header" data-theme="a" id="header1">
                     <h3>Edit Friend Contact</h3>
                     <a href="#" data-icon="back" data-iconpos="notext" data-rel="back">Cancel</a>
                     <a href="#" data-role="button" id="editfriendsubmit" data-theme="b" data-mini="true">OK</a>
                  </div><!-- /header --> 

                  <div data-role="main">
                    <h2>Edit Friend Contact</h2>
                    <label for="name">Full Name</label>
                    <input type="text" name="fullname" id="editfriendfullname" value="" data-clear-btn="true" data-mini="true"> 

                    <label for="email">Email</label>
                    <input type="email" name="email" id="editfriendemail" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Phone</label>
                    <input type="text" name="phone" id="editfriendphone" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Pin BB</label>
                    <input type="text" name="pinbb" id="editfriendpinbb" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Facebook</label>
                    <input type="text" name="facebook" id="editfriendfacebook" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Twitter</label>
                    <input type="text" name="twitter" id="editfriendtwitter" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Instagram</label>
                    <input type="text" name="instagram" id="editfriendinstagram" value="" data-clear-btn="true" data-mini="true">
                  </div> <!-- /content --> 
          </form>

          <div data-role="footer">
            <h1>Footer Text</h1>
          </div>
        </div>  <!-- /footer --> 

    </body>
</html>