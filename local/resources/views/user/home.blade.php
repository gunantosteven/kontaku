<!DOCTYPE html>  
<html>      
    <head>      
        <title>KontaKKu</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">   
        <meta name="csrf-token" content="{{ csrf_token() }}" />    
        <!-- JavaScript -->
        <script type='text/javascript' src={{ asset('js/jquery-1.11.1.min.js') }}></script>
        <script type='text/javascript' src={{ asset('js/jquery.mobile-1.4.5.min.js') }}></script>
        <script type='text/javascript' src={{ asset('js/user/home.js') }}></script>
        <!-- CSS -->
        <link rel="stylesheet" href={{ asset('css/jquery.mobile-1.4.5.min.css') }} />
        <link rel="stylesheet" href={{ asset('css/user/home.css') }} />
    </head>   
    <script type="text/javascript">
      var index = "{{ URL::to('/') }}";
    </script>
    <body>              
        <div data-role="page" id="home">      
            <div data-role="header">         
                <h1>
                    KontaKKu
                </h1>     
                <a  href="#left-menu" id="menubutton" data-icon="bars" data-iconpos="notext">Menu</a>
                <a href="#add-form" data-icon="plus" data-iconpos="notext">Add</a>
            </div><!-- /header -->      
            
            <input type="search" placeholder="Search" id="searchbar" />
            <center><font size="2" color="black" id="totalcontacts">Total Contacts 0</font></center>
            <div class="ui-content" role="main">      
              <ul data-role="listview">
                <li><a href="#mygroups">My Groups</a></li>
                <li data-role="list-divider"></li>
              </ul> 
              <div id="collapsibleFavorites" data-role="collapsible" data-inset="false" data-collapsed="false">
                <h2><span id="myHeaderFavorites">Favorites</span><span id="bubbleCountFavorites" class="ui-li-count">0</span></h2>
                <ul data-role="listview" id="listFavorites"></ul>
              </div>
              <div id="collapsibleOtherContacts" data-role="collapsible" data-inset="false" data-collapsed="false">
                <h2><span id="myHeaderOtherContacts">Other Contacts</span><span id="bubbleCountOtherContacts" class="ui-li-count">0</span></h2>
                <ul data-role="listview" id="list" data-autodividers="true"></ul>
              </div>
            </div><!-- /content -->     
            
             <div id="left-menu" data-role="panel" data-position="left" data-theme="a" data-position-fixed="false" data-display="overlay">
                <center><img id="myphoto"/></center>
                <center><font id="myfullname"></font></center>
                <center><a id="btnRemoveCurrentPhoto" data-role="button" data-theme="a" data-mini="true">Remove Current Photo</a></center>     
                <a class="ui-btn ui-icon-home ui-btn-icon-left ui-btn-active" data-theme="b" data-rel="close" gid="0">Home</a>
                <a id="subMenuInvites" href="#invites" class="ui-btn ui-icon-plus ui-btn-icon-left" data-theme="b" data-rel="close" gid="0">Invites</a>
                <a href="#importantphonecountry" class="ui-btn ui-icon-phone ui-btn-icon-left" data-theme="b" data-rel="close" >Important Phone</a>
                <a href="#settings" class="ui-btn ui-icon-gear ui-btn-icon-left" data-theme="b" data-rel="close" >Settings</a>
                <a href="#reports" class="ui-btn ui-icon-alert ui-btn-icon-left" data-theme="b" data-rel="close" >Reports a Problem</a>
                <a href="#help" class="ui-btn ui-icon-info ui-btn-icon-left" data-theme="b" data-rel="close" >Help</a>
                <a href="{{ url("/auth/logout") }}" class="ui-btn ui-icon-power ui-btn-icon-left" data-theme="b" data-rel="close" data-ajax="false" >Sign Out</a>
             </div>

              <div data-role="panel" data-position="right" data-position-fixed="false" data-display="overlay" id="add-form" data-theme="a">
                  <form id="createcontactoffline" class="ui-body ui-body-a ui-corner-all" data-ajax="false" >
                    <h2>Create new contact offline</h2>
                    <label for="name">Full Name</label>
                    <input type="text" name="fullname" id="createfullname" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Phone 1</label>
                    <input type="text" name="phone" id="createphone" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Phone 2</label>
                    <input type="text" name="phone2" id="createphone2" value="" data-clear-btn="true" data-mini="true">

                    <div class="ui-grid-a">
                        <div class="ui-block-a"><a href="#" data-rel="close" data-role="button" data-theme="c" data-mini="true">Cancel</a></div>
                        <div class="ui-block-b"><input type="button" data-theme="b" name="submit"   id="submit" value="Submit" data-theme="b" data-mini="true"></div>
                    </div>
                </form>
              <!-- panel content goes here -->
            </div><!-- /panel -->

            <!-- scroll to top button -->
            <div id="toTop"></div>
        </div><!-- /page -->      

        <div data-role="page" id="mygroups"><!-- Page MyGroups -->     
            <div data-role="header">         
                <h1>
                    My Groups
                </h1>     
                <a href="#home" data-icon="back" data-iconpos="notext">Back</a>
                <a href="#add-category" data-icon="plus" data-iconpos="notext">Add Category</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listmygroups" data-filter="true" data-inset="true" data-divider-theme="a"></ul>
                <div class="ui-grid-a">
                  <div class="ui-block-a"></div>
                  <div class="ui-block-b"><a href="#deletemygroups" id="deletemygroups"  data-role="button" data-theme="b" data-mini="true" data-icon="delete" data-iconpos="top">Delete</a></div>
                </div>
            </div><!-- /content -->      

            <div data-role="panel" data-position="right" data-position-fixed="false" data-display="overlay" id="add-category" data-theme="a">
              <h2>Create Category</h2>
              <form id="createcategory" class="ui-body ui-body-a ui-corner-all" data-ajax="false" >
                <label for="name">Category Title</label>
                <input type="text" name="title" id="categorytitle" value="" data-clear-btn="true" data-mini="true">
                <div class="ui-grid-a">
                    <div class="ui-block-a"><a href="#" data-rel="close" data-role="button" data-theme="c" data-mini="true">Cancel</a></div>
                    <div class="ui-block-b"><input type="button" data-theme="b" name="submitCategory"   id="submitCategory" value="Submit" data-theme="b" data-mini="true"></div>
                </div>
              </form>
            </div>
        </div><!-- /end page MyGroups -->  

        <div data-role="page" id="deletemygroups"><!-- Page deletemygroups -->     
            <div data-role="header">         
                <h1>
                    Select items
                </h1>     
                <a href="#mygroups" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main" id="mainDeleteMyGroups">    
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <center><a href="#" id="submitdeletemygroups"  data-role="button" data-theme="b" data-mini="true" data-icon="delete" data-iconpos="top">Delete</a></center>
            </div>
        </div><!-- /end page deletemygroups --> 

        <div data-role="page" id="detailmygroups"><!-- Page DetailMyGroups -->     
            <div data-role="header" id="header1">         
                <h1 id="myHeaderDetailGroups">
                    My Detail Groups
                </h1>     
                <a href="#mygroups" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listdetailmygroups" data-filter="true" data-inset="true" data-divider-theme="a"></ul>
                <div class="ui-grid-a">
                  <div class="ui-block-a"><a href="#adddetailmygroups" id="adddetailmygroups"  data-role="button" data-theme="b" data-mini="true" data-icon="plus" data-iconpos="top">Add</a></div>
                  <div class="ui-block-b"><a href="#deletedetailmygroups" id="deletedetailmygroups"  data-role="button" data-theme="b" data-mini="true" data-icon="delete" data-iconpos="top">Delete</a></div>
              </div>
            </div><!-- /content -->      

        </div><!-- /end page DetailMyGroups -->  

        <div data-role="page" id="adddetailmygroups"><!-- Page adddetailmygroups -->     
            <div data-role="header">         
                <h1>
                    Select items
                </h1>     
                <a href="#detailmygroups" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main" id="mainAddDetailMyGroups">    
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
              <center><a href="#" id="submitadddetailmygroups" class="custom-btn" data-role="button" data-theme="b" data-icon="plus" data-iconpos="top">Add</a></center>
            </div>
        </div><!-- /end page adddetailmygroups -->  

        <div data-role="page" id="deletedetailmygroups"><!-- Page deletedetailmygroups -->     
            <div data-role="header">         
                <h1>
                    Select items
                </h1>     
                <a href="#detailmygroups" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main" id="mainDeleteDetailMyGroups">    
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <center><a href="#" id="submitdeletedetailmygroups"  data-role="button" data-theme="b" data-mini="true" data-icon="delete" data-iconpos="top">Delete</a></center>
            </div>
        </div><!-- /end page deletedetailmygroups --> 


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

                  <label for="name">Phone 1</label>
                  <input type="text" name="phone" id="editmyprofilephone" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Phone 2</label>
                  <input type="text" name="phone2" id="editmyprofilephone2" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Pin BB</label>
                  <input type="text" name="pinbb" id="editmyprofilepinbb" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Facebook</label>
                  <input type="text" name="facebook" id="editmyprofilefacebook" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Twitter</label>
                  <input type="text" name="twitter" id="editmyprofiletwitter" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Instagram</label>
                  <input type="text" name="instagram" id="editmyprofileinstagram" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Line</label>
                  <input type="text" name="line" id="editmyprofileline" value="" data-clear-btn="true" data-mini="true">

                  <label for="name">Choose Photo</label>
                  <input type="file" name="photo"  id="editmyprofilephoto" value="" data-clear-btn="true" data-mini="true"/>

            </form>
          </div> <!-- /content --> 

        </div>  

        <!-- friend profile -->
        <div data-role="page" id="friendprofile">
          <div data-role="header" data-theme="a" id="header1">
             <h3>My Friend Profile</h3>
             <a data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
          </div><!-- /header --> 

          <div class="ui-content" role="main">
              <img id="friendPic"/>
              <div id="friendDetails">
                   <h3 id="fullName"></h3>
                   <p id="friendprofileonlineoffline"></p>
                   <font size="2px" id="friendprofileupdated_at"></font>
              </div>
             <a id="btnRemoveFriendPhoto" class="ui-btn ui-btn-inline ui-icon-delete ui-btn-icon-left" data-theme="a" data-mini="true">Remove Friend Photo</a>

              <ul id="actionFriendProfileList" data-role="listview" data-inset="true"></ul>

              <div class="ui-grid-b">
                  <div class="ui-block-a">
                    <center>
                      <select id="isfavoriteflipswitch" data-role="flipswitch">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                      </select>
                      <label for="checkbox-based-flipswitch"><b>Favorite Contact</b></label>
                    </center>
                  </div>
                  <div class="ui-block-b"><a href="#editfriendprofile" id="editfriendprofilebuttonpage"  data-role="button" data-theme="b" data-mini="true" data-icon="edit" data-iconpos="top">Edit</a></div>
                  <div class="ui-block-c"><a href="#popupDialog" data-rel="popup" data-position-to="window"  data-role="button"  data-transition="pop"  data-icon="delete" data-theme="b" data-mini="true" data-iconpos="top">Delete</a></div>
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

        </div>  

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

                    <label for="name">Phone1</label>
                    <input type="text" name="phone" id="editfriendphone" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Phone2</label>
                    <input type="text" name="phone" id="editfriendphone2" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Pin BB</label>
                    <input type="text" name="pinbb" id="editfriendpinbb" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Facebook</label>
                    <input type="text" name="facebook" id="editfriendfacebook" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Twitter</label>
                    <input type="text" name="twitter" id="editfriendtwitter" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Instagram</label>
                    <input type="text" name="instagram" id="editfriendinstagram" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Line</label>
                    <input type="text" name="line" id="editfriendline" value="" data-clear-btn="true" data-mini="true">

                    <label for="name">Choose Photo</label>
                    <input type="file" name="photo"  id="editfriendphoto" value="" data-clear-btn="true" data-mini="true"/>
                  </div> <!-- /content --> 
          </form>
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

            <div class="ui-content" role="main">
                <center><p>I'd like to invite you to be my friend contact.</p></center>
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
                  <li id=''><b>My Email </b><p><font id="settingsaccountmyemail" size="2px"></font></p></li>
                  <li id=''><b>My URL </b><p><font id="settingsaccountmyurl" size="2px"></font></p></li>
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
                    <label for="name">Old Password</label>
                    <input type="password" name="old_password" id="changepasswordoldpassword" value="" data-clear-btn="true" data-mini="true"> 

                    <label for="name">New Password</label>
                    <input type="password" name="new_password" id="changepasswordnewpassword" value="" data-clear-btn="true" data-mini="true"> 

                    <label for="email">Retype Password</label>
                    <input type="password" name="new_password2" id="changepasswordretypepassword" value="" data-clear-btn="true" data-mini="true">
                  </div> <!-- /content --> 
          </form>   
        </div><!-- /end page Change Password -->  

        <div data-role="page" id="reports"><!-- Page Reports -->     
                  <div data-role="header" data-theme="a" id="header1">
                     <h3>Reports</h3>
                     <a href="#home" data-icon="back" data-iconpos="notext" data-rel="back">Back</a>
                  </div><!-- /header --> 

                  <div class="ui-content" role="main">
                    <h2>Reports a problem</h2>
                    <p>You can directly email the problems to developer gunantosteven@gmail.com</p>
                  </div> <!-- /content --> 
        </div><!-- /end page Reports -->  

        <div data-role="page" id="help"><!-- Page Help -->     
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
                    <p>4. Type your friend url like <b>stevengunanto</b> if your friend url is kontakku.com/<b>stevengunanto</b>.</p>
                    <p>5. Click/Tap search button.</p>
                    <p>6. Click/Tap ADD button, you need to wait your friend accept your invitation.</p>
                    <p>Your friend contacts will be saved in server and It's secure to save here as long as you don't give your account</p>
                  </div> <!-- /content --> 
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Copyright @ 2015 KONTAKKU. All rights reserved.</h1>
            </div>
        </div><!-- /end page Help -->  

        <div data-role="page" id="importantphonecountry"><!-- Page Important Phone Country -->     
            <div data-role="header">         
                <h1>
                    Select Country
                </h1>     
                <a href="#home" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">    
                <ul data-role="listview" id="listimportantphonecountry" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Asia</li>
                    <li id=''><a href='#importantphonephilippines'>Philippines</a></li>
                    <li id=''><a href='#importantphoneindonesia'>Indonesian</a></li>
                    <li id=''><a href='#importantphoneindia'>India</a></li>
                    <li id=''><a href='#importantphoneiran'>Iran</a></li>
                    <li id=''><a href='#importantphoneisrael'>Israel</a></li>
                    <li id=''><a href='#importantphonejapan'>Japan</a></li>
                    <li id=''><a href='#importantphonesouthkorea'>South Korea</a></li>
                    <li id=''><a href='#importantphonelebanon'>Lebanon</a></li>
                    <li id=''><a href='#importantphonemalaysia'>Malaysia</a></li>
                    <li id=''><a href='#importantphonemongolia'>Mongolia</a></li>
                    <li id=''><a href='#importantphonesingapura'>Singapura</a></li>
                    <li id=''><a href='#importantphonesrilanka'>Sri Lanka</a></li>
                    <li id=''><a href='#importantphonetaiwan'>Taiwan</a></li>
                    <li id=''><a href='#importantphonethailand'>Thailand</a></li>
                    <li id=''><a href='#importantphoneturki'>Turki</a></li>
                    <li id=''><a href='#importantphonepakistan'>Pakistan</a></li>
                    <li id=''><a href='#importantphoneuniemiratarab'>Uni Emirat Arab</a></li>
                    <li id=''><a href='#importantphoneqatar'>Qatar</a></li>
                    <li id=''><a href='#importantphonerrcdaratan'>Republik Rakyat Tiongkok (Daratan)</a></li>
                    <li id=''><a href='#importantphonehongkong'>Republik Rakyat Tiongkok (Hong Kong)</a></li>
                    <li id=''><a href='#importantphonemakau'>Republik Rakyat Tiongkok (Makau)</a></li>
                    <li id=''><a href='#importantphonesaudiarabia'>Saudi Arabia</a></li>
                    <li id=''><a href='#importantphonevietnam'>Vietnam</a></li>
                </ul>
            </div><!-- /content -->      
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                 <h1>Source : id.wikipedia.org/wiki/Nomor_telepon_darurat</h1>
            </div>
        </div><!-- /end page Important Phone Country -->   

        <div data-role="page" id="importantphonephilippines"><!-- Page Important Phone Philippines -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonephilippines" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Emergency Telephone Numbers</li>
                    <li><a href='tel:112'>112<p>Emergency Telephone Numbers 1</p></a></li>
                    <li><a href='tel:911'>911<p>Emergency Telephone Numbers 2</p></a></li>
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:117'>117<p>Police</p></a></li>
                </ul>
            </div><!-- /content -->  
        </div><!-- /end page Important Phone Philippines -->   

        <div data-role="page" id="importantphoneindonesia"><!-- Page Important Phone Indonesia -->     
            <div data-role="header">         
                <h1>
                    Nomor telepon darurat
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneindonesia" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Polisi</li>
                    <li><a href='tel:110'>110<p>Polisi</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='118'>118<p>Ambulans 1</p></a></li>
                    <li><a href='119'>119<p>Ambulans 2</p></a></li>
                  <li data-role="list-divider">Badan Search and Rescue Nasional</li>
                    <li><a href='tel:115'>115<p>Badan Search and Rescue Nasional</p></a></li>
                  <li data-role="list-divider">Posko bencana alam</li>
                    <li><a href='tel:129'>129<p>Posko bencana alam</p></a></li>
                  <li data-role="list-divider">Perusahaan Listrik Negara (PLN)</li>
                    <li><a href='tel:123'>123<p>Perusahaan Listrik Negara (PLN)</p></a></li>
                  <li data-role="list-divider">Nomor darurat telpon selular dan satelit</li>
                    <li><a href='tel:112'>112<p>Nomor darurat telpon selular dan satelit</p></a></li>
                  <li data-role="list-divider">Keracunan</li>
                    <li><a href='tel:(021) 4250767'>(021) 4250767<p>Keracunan 1</p></a></li>
                    <li><a href='tel:(021) 4227875'>(021) 4227875<p>Keracunan 2</p></a></li>
                  <li data-role="list-divider">Pencegahan bunuh diri</li>
                    <li><a href='tel:(021) 7256526'>(021) 4250767<p>Pencegahan bunuh diri 1</p></a></li>
                    <li><a href='tel:(021) 7257826'>(021) 7257826<p>Pencegahan bunuh diri 2</p></a></li>
                    <li><a href='tel:(021) 7221810'>(021) 7221810<p>Pencegahan bunuh diri 3</p></a></li>
                  <li data-role="list-divider">Konseling masalah kejiwaan Direktorat Bina Pelayanan Kesehatan Jiwa Kemenkes RI</li>
                    <li><a href='tel:500-454'>500-454<p>Konseling masalah kejiwaan Direktorat Bina Pelayanan Kesehatan Jiwa Kemenkes RI</p></a></li>
                </ul>
            </div><!-- /content -->     
        </div><!-- /end page Important Phone Indonesia -->   

        <div data-role="page" id="importantphoneindia"><!-- Page Important Phone India -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneindia" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:100'>100<p>Police 1</p></a></li>
                    <li><a href='tel:103'>103<p>Police 2</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='tel:100'>101<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='tel:100'>102<p>Ambulans</p></a></li>
                  <li data-role="list-divider">From GSM</li>
                    <li><a href='tel:112'>112<p>From GSM</p></a></li>
                </ul>
            </div><!-- /content -->      
        </div><!-- /end page Important Phone India --> 

        <div data-role="page" id="importantphoneiran"><!-- Page Important Phone Iran -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneiran" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:110'>110<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='tel:125'>125<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='tel:115'>115<p>Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->      
        </div><!-- /end page Important Phone Iran --> 

        <div data-role="page" id="importantphoneisrael"><!-- Page Important Phone Israel -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneisrael" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:100'>100<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='tel:102'>102<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='tel:101'>101<p>Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->      
        </div><!-- /end page Important Phone Israel --> 

        <div data-role="page" id="importantphonejapan"><!-- Page Important Phone Japan -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonejapan" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:110'>110<p>Police</p></a></li>
                  <li data-role="list-divider">Emergency at sea</li>
                    <li><a href='tel:118'>118<p>Emergency at sea</p></a></li>
                  <li data-role="list-divider">Firefighters & Ambulans</li>
                    <li><a href='tel:119'>119<p>Firefighters & Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->      
        </div><!-- /end page Important Phone Japan --> 

        <div data-role="page" id="importantphonesouthkorea"><!-- Page Important Phone South Korea -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonesouthkorea" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:112'>112<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters & Ambulans</li>
                    <li><a href='tel:119'>119<p>Firefighters & Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->     
        </div><!-- /end page Important South Korea --> 

        <div data-role="page" id="importantphonelebanon"><!-- Page Important Phone Lebanon -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonelebanon" data-inset="true" data-filter="true">
                  <li><a href='tel:112'>112</a></li>
                </ul>
            </div><!-- /content -->      
        </div><!-- /end page Important Lebanon --> 

        <div data-role="page" id="importantphonemalaysia"><!-- Page Important Phone Malaysia -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonemalaysia" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:999'>999<p>Police</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='tel:999'>999<p>Ambulans</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='tel:999'>999<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Hansip</li>
                    <li><a href='tel:999'>991<p>Hansip</p></a></li>
                  <li data-role="list-divider">From GSM</li>
                    <li><a href='tel:112'>112<p>From GSM</p></a></li>
                </ul>
            </div><!-- /content -->      
        </div><!-- /end page Important Malaysia --> 

      <div data-role="page" id="importantphonemongolia"><!-- Page Important Phone Mongolia -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonemongolia" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Emergency Telephone Numbers</li>
                    <li><a href='tel:100'>100<p>Emergency Telephone Numbers</p></a></li>
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:101'>101<p>Police</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='tel:102'>102<p>Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Mongolia --> 

      <div data-role="page" id="importantphonesingapura"><!-- Page Important Phone Singapura -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonesingapura" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='tel:999'>999<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters & Ambulans</li>
                    <li><a href='tel:995'>995<p>Firefighters & Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->    
      </div><!-- /end page Important Singapura --> 

      <div data-role="page" id="importantphonesrilanka"><!-- Page Important Phone Sri Lanka -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonesrilanka" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Traffic accident</li>
                    <li><a href='tel:11-2691111'>11-2691111<p>Traffic accident</p></a></li>
                </ul>
            </div><!-- /content -->     
      </div><!-- /end page Important Sri Lanka --> 

      <div data-role="page" id="importantphonetaiwan"><!-- Page Important Phone Taiwan -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonetaiwan" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Firefighters & Ambulans</li>
                    <li><a href='119'>119<p>Firefighters & Ambulans</p></a></li>
                  <li data-role="list-divider">Police</li>
                    <li><a href='110'>110<p>Police</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Taiwan --> 

      <div data-role="page" id="importantphonethailand"><!-- Page Important Phone Thailand -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonethailand" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='191'>191<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='199'>199<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='1669'>1669<p>Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Taiwan --> 

      <div data-role="page" id="importantphoneturki"><!-- Page Important Phone Turki -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneturki" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='155'>155<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='110'>110<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='112'>112<p>Ambulans</p></a></li>
                  <li data-role="list-divider">Coast Guard</li>
                    <li><a href='158'>158<p>Coast Guard</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Turki --> 

      <div data-role="page" id="importantphonepakistan"><!-- Page Important Phone Pakistan -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonepakistan" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='15'>15<p>Police</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Pakistan --> 

      <div data-role="page" id="importantphoneuniemiratarab"><!-- Page Important Phone Uni Emirat Arab -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneuniemiratarab" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='999'>999<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='998'>998<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='997'>997<p>Ambulans</p></a></li>
                </ul>
            </div><!-- /content -->     
      </div><!-- /end page Important Uni Emirat Arab --> 

      <div data-role="page" id="importantphoneqatar"><!-- Page Important Phone Qatar -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphoneqatar" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Emergency Telephone Numbers</li>
                    <li><a href='999'>999<p>Emergency Telephone Numbers</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Qatar --> 

      <div data-role="page" id="importantphonerrcdaratan"><!-- Page Important Republik Rakyat Tiongkok (Daratan) -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonerrcdaratan" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='110'>110<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='119'>119<p>Firefighters</p></a></li>
                  <li data-role="list-divider">SAR</li>
                    <li><a href='120'>120<p>SAR</p></a></li>
                  <li data-role="list-divider">Traffic accident</li>
                    <li><a href='122'>122<p>Traffic accident</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Republik Rakyat Tiongkok (Daratan) --> 

      <div data-role="page" id="importantphonehongkong"><!-- Page Important Republik Rakyat Tiongkok (Hongkong) -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonehongkong" data-inset="true" data-filter="true">
                  <li data-role="list-divider">S.A.R</li>
                    <li><a href='999'>999<p>S.A.R (voice)</p></a></li>
                    <li><a href='992'>992<p>S.A.R ((SMS untuk pelanggan cacat))</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Republik Rakyat Tiongkok (Hongkong) --> 

      <div data-role="page" id="importantphonemakau"><!-- Page Important Republik Rakyat Tiongkok (Makau) -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonemakau" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Emergency Telephone Numbers</li>
                    <li><a href='999'>999<p>Emergency Telephone Numbers</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Republik Rakyat Tiongkok (Makau) --> 

      <div data-role="page" id="importantphonesaudiarabia"><!-- Page Important Saudi Arabia -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonesaudiarabia" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Police</li>
                    <li><a href='999'>999<p>Police 1</p></a></li>
                    <li><a href='993'>993<p>Police 2</p></a></li>
                  <li data-role="list-divider">Firefighters</li>
                    <li><a href='998'>998<p>Firefighters</p></a></li>
                  <li data-role="list-divider">Ambulans</li>
                    <li><a href='997'>997<p>Ambulans</p></a></li>
                  <li data-role="list-divider">Emergency</li>
                    <li><a href='911'>911<p>Emergency 1</p></a></li>
                    <li><a href='112'>112<p>Emergency 2</p></a></li>
                    <li><a href='08'>08<p>Emergency 3</p></a></li>
                </ul>
            </div><!-- /content -->      
      </div><!-- /end page Important Saudi Arabia --> 

      <div data-role="page" id="importantphonevietnam"><!-- Page Important Vietnam -->     
            <div data-role="header">         
                <h1>
                    Emergency Telephone Numbers
                </h1>     
                <a href="#importantphonecountry" data-icon="back" data-iconpos="notext">Back</a>
            </div><!-- /header -->      
            
            <div class="ui-content" role="main">                
                <ul data-role="listview" id="listimportantphonevietnam" data-inset="true" data-filter="true">
                  <li data-role="list-divider">Emergency Telephone Numbers</li>
                    <li><a href='115'>115<p>Emergency Telephone Numbers</p></a></li>
                  <li data-role="list-divider">Police</li>
                    <li><a href='113'>113<p>Police</p></a></li>
                  <li data-role="list-divider">Firefighers</li>
                    <li><a href='114'>114<p>Firefighers</p></a></li>
                </ul>
            </div><!-- /content -->     
      </div><!-- /end page Important Vietnam --> 
    </body>
</html>