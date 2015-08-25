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
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="list" data-autodividers="true"></ul>
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>


             <div id="left-menu" data-role="panel" data-position="left" data-theme="b" data-position-fixed="false" data-display="overlay">
                <span>Menu</span>
                <a class="ui-btn ui-icon-home ui-btn-icon-left ui-btn-active" data-theme="b" data-rel="close" gid="0">Home</a>
                <a href="#invites" class="ui-btn ui-icon-plus ui-btn-icon-left" data-theme="b" data-rel="close" gid="0">Invites</a>
                <a href="#settings" class="ui-btn ui-icon-gear ui-btn-icon-left" data-theme="b" data-rel="close" >Settings</a>
                <a href="#reports" class="ui-btn ui-icon-alert ui-btn-icon-left" data-theme="b" data-rel="close" >Reports a Problem</a>
                <a href="#help" class="ui-btn ui-icon-info ui-btn-icon-left" data-theme="b" data-rel="close" >Help</a>
                <a href="{{ url("/auth/logout") }}" class="ui-btn ui-icon-power ui-btn-icon-left" data-theme="b" data-rel="close" data-ajax="false" >Sign Out</a>
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

        <div data-role="page" id="editmyprofile">
          <form id="formEditMyProfile"  data-ajax="false">
          <div data-role="header" data-theme="a" id="header1">
             <h3>My Profile</h3>
             <a href="#settingsaccount" data-icon="back" data-iconpos="notext" data-rel="back">Cancel</a>
             <a href="#" data-role="button" id="editmyprofilesubmit" data-theme="b" data-mini="true">OK</a>
          </div><!-- /header --> 

          <div class="ui-content" role="main">
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
             <a href="#home" data-icon="back" data-iconpos="notext">Back</a>
          </div><!-- /header --> 

          <div class="ui-content" role="main">
              <img id="friendPic"/>
              <div id="friendDetails">
                   <h3 id="fullName"></h3>
                   <p id="friendprofileonlineoffline"></p>
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
                     <a href="#friendprofile" data-icon="back" data-iconpos="notext" data-rel="back">Cancel</a>
                     <a href="#" data-role="button" id="editfriendsubmit" data-theme="b" data-mini="true">OK</a>
                  </div><!-- /header --> 

                  <div class="ui-content" role="main">
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
          </div> <!-- /footer --> 
        </div>  

        <div data-role="page" id="invites"><!-- Page Invites -->     
            <div data-role="header">         
                <h1>
                    Invites
                </h1>     
                <a href="#home" data-icon="back" data-iconpos="notext">Back</a>
                <a href="#addfriendsonline" data-icon="plus" data-iconpos="notext">Add By Url</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listinvites" data-filter="true" data-inset="true" data-divider-theme="a"></ul>
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page invites -->     

        <div data-role="page" id="addfriendsonline"><!-- Add Friends Online -->     
            <div data-role="header">         
                <h1>
                    Add Friends Online
                </h1>     
                <a href="#invites" data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">
              <form id="formSearchAddFriendOnline"  data-ajax="false">  
                <input type="text" placeholder="Search" name="search" id="searchbaraddfriendsonline" data-clear-btn="true"/>
                <input type="submit" name="search" value="Search" id="submitsearchaddfriendsonline"/>  
              </form>       
              <div class="center-wrapper">     
                  <img class='ui-li-icon' id="imguseraddfriendsonline" src='http://www.haverhill-ps.org/wp-content/uploads/sites/12/2013/11/user.png' height='80' width='80' />
                  <label for="name" id="fullnameuseraddfriendsonline">FullName</label>
                  <form id="formAddFriendOnline"  data-ajax="false">
                    <input type="hidden" name="id" id="iduseraddfriendsonline"/>
                    <a href="#" data-role="button" id="buttonaddfriendsonline" data-theme="b">ADD</a>
                  </form>
              </div>
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page invites -->    

        <div data-role="page" id="gotinvitation"><!-- Page Got Invitation -->     
            <div data-role="header">         
                <h1>
                    <label for="name" id="fullnameusergotinvitation">FullName</label>
                    <label for="status" id="statususergotinvitation">Status</label>
                </h1>     
                <a href="#invites" data-icon="back" data-iconpos="notext">Back</a>
                <div class="ui-btn-right" data-role="controlgroup" data-type="horizontal">
                  <a href="#" id="addfriendsonlinedecline" data-icon="delete" data-role="button" data-iconpos="notext">Decline</a>
                  <a href="#" id="addfriendsonlineaccept" data-icon="check" data-role="button" data-iconpos="notext">Accept</a>
                </div>
            </div><!-- /header -->        
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page invites -->  

        <div data-role="page" id="sentinvitation"><!-- Page Got Invitation -->     
            <div data-role="header">         
                <h1>
                    <label for="name" id="fullnameusersentinvitation">FullName</label>
                    <label for="status" id="statususersentinvitation">Status</label>
                </h1>     
                <a href="#invites" data-icon="back" data-iconpos="notext">Back</a>
                <div class="ui-btn-right" data-role="controlgroup" data-type="horizontal">
                  <a href="#" id="addfriendsonlinedelete" data-icon="delete" data-role="button" data-iconpos="notext">Delete</a>
                </div>
            </div><!-- /header -->        
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page invites -->  

        <div data-role="page" id="settings"><!-- Page Settings -->     
            <div data-role="header">         
                <h1>
                    Settings
                </h1>     
                <a href="#home" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listsettings" data-inset="true">
                  <li id="#"><a href='#settingsaccount'>Accounts</a></li>
                </ul>
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page Settings -->    

        <div data-role="page" id="settingsaccount"><!-- Page Settings Account -->     
            <div data-role="header">         
                <h1>
                    Accounts
                </h1>     
                <a href="#settings" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listsettings" data-inset="true">
                  <li id=''><a href='#editmyprofile'>Edit Profile</a></li>
                  <li id=''><a href='#changepassword'>Change Password</a></li>
                  <li id=''>
              		<div data-role="fieldcontain">
					    <label for="checkbox-based-flipswitch"><b>Private Account :</b></label>
					    <select id="privateaccountflipswitch" data-role="flipswitch">
						    <option value="no">No</option>
						    <option value="yes">Yes</option>
						</select>
					</div>
				  </li>
                </ul>
                
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page Settings Account -->    

        <div data-role="page" id="changepassword"><!-- Page Change Password -->     
            <form id="formChangePassword"  data-ajax="false">
                  <div data-role="header" data-theme="a" id="header1">
                     <h3>Change Password</h3>
                     <a href="#settingsaccount" data-icon="back" data-iconpos="notext" data-rel="back">Cancel</a>
                     <a href="#" data-role="button" id="changepasswordsubmit" data-theme="b" data-mini="true">Change</a>
                  </div><!-- /header --> 

                  <div class="ui-content" role="main">
                    <h2>Change Password</h2>
                    <label for="name">New Password</label>
                    <input type="password" name="new_password" id="changepasswordnewpassword" value="" data-clear-btn="true" data-mini="true"> 

                    <label for="email">Retype Password</label>
                    <input type="password" name="new_password2" id="changepasswordretypepassword" value="" data-clear-btn="true" data-mini="true">
                  </div> <!-- /content --> 
          </form>   
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page Settings -->  

        <div data-role="page" id="reports"><!-- Page Reports -->     
                  <div data-role="header" data-theme="a" id="header1">
                     <h3>Reports</h3>
                     <a href="#home" data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
                  </div><!-- /header --> 

                  <div class="ui-content" role="main">
                    <h2>Reports a problem</h2>
                    <p>You can directly email the problems to developer gunantosteven@gmail.com</p>
                  </div> <!-- /content --> 
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Footer</h1>
            </div>
        </div><!-- /end page Reports -->  

        <div data-role="page" id="help"><!-- Page Reports -->     
                  <div data-role="header" data-theme="a" id="header1">
                     <h3>Help</h3>
                     <a href="#home" data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
                  </div><!-- /header --> 

                  <div class="ui-content" role="main">
                  	<h2>The difference between Friend Offline and Online</h2>
                    <p>Friend Offline is like your contact phone. If your friend change his/her number you need to change his/her number to kontakku.</p>
                    <p>Friend Online is like social media. You can see updated contact your friend without you have to change it manually.</p>
                    <h2>Create Friend Offline</h2>
                    <p>1. Login to your account.</p>
                    <p>2. Click/Tap plus button on right top. It will show you form to input your friend offline.</p>
                    <p>3. Fill the blank form.</p>
                    <p>4. Click/Tap button submit. You can see now your friend contact in contacts list.</p>
                    <h2>Invite Friend Online</h2>
                    <p>1. Login to your account.</p>
                    <p>2. Click/Tap menu button on left top. It will show you some submenu, click/tap Invites.</p>
                    <p>3. Click/Tap plus button on right top. It will show you textbox and search button.</p>
                    <p>4. Type your friend url like stevengunanto if your friend url is kontakku.com/stevengunanto.</p>
                    <p>5. Click/Tap search button.</p>
                    <p>6. Click/Tap ADD button, you need to wait your friend accept your invitation.</p>
                  </div> <!-- /content --> 
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Copyright @ 2015 KONTAKKU. All rights reserved.</h1>
            </div>
        </div><!-- /end page Reports -->  

    </body>
</html>