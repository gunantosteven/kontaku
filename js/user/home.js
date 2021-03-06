var friendscount,
    notescount,
    searchfriendscount,
    searchnotescount,
    note,
    friend,
    friendonlineinvatitation,
    category,
    isLoadMore = true,
    isLoadMoreContact = true,
    isLoadMoreSearchContact = true,
    isLoadMoreNoteFinished = true,
    isLoadMoreNote = true,
    isLoadMoreSearchNote = true,
    beforePage = "",
    pageAfterLoadSuccess = "",
    CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

/* ===================================js page home=================================== */
$(document).on("pagebeforecreate", "#home", function (e, ui) {
     reloadContact();
});
$(document).on('pageshow', '#home', function(){  
  if(pageAfterLoadSuccess == "")
  {
    $.mobile.loading('show');
  }
}); 
$(window).load(function() {
    //everything is loaded
  if(pageAfterLoadSuccess == "")
  {
    $.mobile.loading('hide');
    pageAfterLoadSuccess = $('body').pagecontainer('getActivePage').prop('id');
  }
});
/* page home initialization */
$(document).on('pageinit', '#home', function(){  
  /* create friend offline */
  $(document).on('click', '#submit', function() { // catch the form's submit event
      // Send data to server through the Ajax call
      // action is functionality we want to call and outputJSON is our data
      $.ajax({url: index + "/user/create/friendoffline",
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
              		if(typeof result.over !== "undefined" && result.over)
              		{
              			alert(result.over); 
              		}
              		else
              		{
              			  $('input[id=createfullname]').val('');
	                    $('input[id=createphone]').val('');
	                    $('input[id=createphone2]').val('');
	                   	$.mobile.pageContainer.pagecontainer("change", "#");
                      reloadContact();
              		}
              } 
              else {
                  alert('Something error happened!'); 
              }
          },
          error: function (xhr, status, data) {
              // This callback function will trigger on unsuccessful action 
              if(xhr.responseJSON.status == false)
              {
                if(xhr.responseJSON.errors.fullname)
                {
                  alert(xhr.responseJSON.errors.fullname);
                }
                else if(xhr.responseJSON.errors.phone)
                {
                  alert(xhr.responseJSON.errors.phone);
                }
                else if(xhr.responseJSON.errors.phone2)
                {
                  alert(xhr.responseJSON.errors.phone2);
                }
              }
              else
              {
                alert('Network error has occurred please try again!'); 
              }    
          }
      });                            
      return false; // cancel original event to prevent form submitting
  });      

  $(document).on('click', '#menubutton', function() { // catch the form's menubutton event
    $.ajax({
          url: index + "/user/countinvitation",
          type: 'POST',
          data: {_token: CSRF_TOKEN, action : "getcountinvitation"},
          dataType: 'JSON',
          success: function (data) {
            if(data['count'] != null && data['count'] != null)
            {
              if(data['count'] != null && data['newinvitesnotification'] == true)
              {
                $('#subMenuInvites').text("Invites ( " + data['count'] + " ) *NEW");
              }
              else
              {
                $('#subMenuInvites').text("Invites ( " + data['count'] + " )");
              }
            }
            else
            {
              $('#subMenuInvites').text("Invites ( 0 )");
            }
        }}) 
  });

  $( "#menubutton" ).focus(function() {
    setTimeout(
      function() 
      {
        $.ajax({
          url: index + "/user/countinvitation",
          type: 'POST',
          data: {_token: CSRF_TOKEN, action : "getcountinvitation"},
          dataType: 'JSON',
          success: function (data) {
            if(data['count'] != null && data['count'] != null)
            {
              if(data['count'] != null && data['newinvitesnotification'] == true)
              {
                $('#subMenuInvites').text("Invites ( " + data['count'] + " ) *NEW");
              }
              else
              {
                $('#subMenuInvites').text("Invites ( " + data['count'] + " )");
              }
            }
            else
            {
              $('#subMenuInvites').text("Invites ( 0 )");
            }
        }}) 
      }, 1000);
  });

  /*When search through input view*/
  $(document).on("input", "#searchbar", function (e) { 
    if($("#searchbar").val() == "")
    {
       reloadContact();
    }
    else
    {
      $.ajax({
          url: index + "/user/search",
          type: 'POST',
          data: {_token: CSRF_TOKEN, search: $("#searchbar").val()},
          dataType: 'JSON',
          success: function (data) {
          	$("#collapsibleFavorites").hide();
            $("#listMyGroups").hide();

          	$("#collapsibleOtherContacts h2 #myHeaderOtherContacts").text("All Contacts");
          	$("#collapsibleOtherContacts").collapsible( "option", "collapsed", false );
            $("#list").empty();
            $.each (data['friends'], function (index) {
              if(data['friends'][index]['onlineoffline'] == "ONLINE")
              {
                if(data['friends'][index]['membertype'] == "PREMIUM")
                {
                  $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberpremium'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
                else if(data['friends'][index]['membertype'] == "BOSS")
                {
                  $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberboss'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
                else
                {
                  $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
              }
              else
              {
                $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
              }
            });
            searchfriendscount = data['searchfriendscount'];
            $("#totalcontacts").text('Total Found ' + data['totalfound']);
            $("#bubbleCountOtherContacts").hide();
        }
      });
    }
  });

  /* add more contact */
  function addMore(page) {
  	  if(isLoadMoreContact == true)
  	  {
	  	  	$.mobile.loading("show", {
	          text: "loading more..",
	          textVisible: true,
	          theme: "a"
	      });
  	  }
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
                  if(data['friends'][index]['onlineoffline'] == "ONLINE")
                  {
                    if(data['friends'][index]['membertype'] == "PREMIUM")
                    {
                      items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberpremium'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";  
                    }
                    else if(data['friends'][index]['membertype'] == "BOSS")
                    {
                      items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberboss'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";
                    }
                    else
                    {
                      items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";  
                    }
                  }
                  else
                  {
                    items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";  
                  }
                });
				if(friendscount == data['friendscount'])
				{
					isLoadMoreContact = false;
				}
				else
				{
					isLoadMoreContact = true;
				}
                friendscount = data['friendscount'];
                $("#list", page).append(items).listview("refresh");
                $.mobile.loading("hide");
                isLoadMore = true;
                if(pageAfterLoadSuccess == "")
			    {
			    	$.mobile.loading('show');
			    }
              }
          });
      }, 500);
  }

  /* add more search contact */
  function addMoreSearchContact(page) {
      if(isLoadMoreSearchContact == true)
  	  {
	  	  	$.mobile.loading("show", {
	          text: "loading more..",
	          textVisible: true,
	          theme: "a"
	      });
  	  }
      setTimeout(function () {
          var items = '';
          var count = 0;
          $.ajax({
              url: index + "/user/search/" + searchfriendscount,
              type: 'POST',
              data: {_token: CSRF_TOKEN, search: $("#searchbar").val()},
              dataType: 'JSON',
              success: function (data) {
                $.each (data['friends'], function (index) {
                  if(data['friends'][index]['onlineoffline'] == "ONLINE")
                  {
                    if(data['friends'][index]['membertype'] == "PREMIUM")
                    {
                      items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberpremium'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";  
                    }
                    else if(data['friends'][index]['membertype'] == "BOSS")
                    {
                      items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberboss'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";
                    }
                    else
                    {
                      items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";  
                    }
                  }
                  else
                  {
                    items += "<li id='" + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id']  + "?" + Math.random() + "'/>" +  data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>"  + "</li>";  
                  }
                });
				if(searchfriendscount == data['searchfriendscount'])
				{
					isLoadMoreSearchContact = false;
				}
				else
				{
					isLoadMoreSearchContact = true;
				}
                searchfriendscount = data['searchfriendscount'];
                $("#list", page).append(items).listview("refresh");
                $.mobile.loading("hide");
                isLoadMore = true;
                if(pageAfterLoadSuccess == "")
			    {
			    	$.mobile.loading('show');
			    }
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
	  	  if(isLoadMore == true)
	  	  {
	  	  	isLoadMore = false;
	  	  	addMore(activePage);
	  	  }
      }
      else if (activePage[0].id == "home" && scrolled >= scrollEnd && (searchfriendscount > 0) && $('#searchbar').val().length != 0) {
          if(isLoadMore == true)
	  	  {
	  	  	isLoadMore = false;
	  	  	addMoreSearchContact(activePage);
	  	  }
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
              url: index + "/user/friendprofile",
              type: 'POST',
              data: {_token: CSRF_TOKEN, id : $(this).attr('id')},
              dataType: 'JSON',
              success: function (data) {
                if(data != null)
                {
                  friend = data;
                  $.mobile.changePage("#friendprofile");
                  beforePage = "#home";
                }
              }
          });
    }
  }); 

  /*When click contact listview favorites*/
  $(document).on("click", "#listFavorites li" ,function (event) {
    if($(this).attr('id') !== undefined)
    {
      $.ajax({
              url: index + "/user/friendprofile",
              type: 'POST',
              data: {_token: CSRF_TOKEN, id : $(this).attr('id')},
              dataType: 'JSON',
              success: function (data) {
                if(data != null)
                {
                  friend = data;
                  $.mobile.changePage("#friendprofile");
                  beforePage = "#home";
                }
              }
          });
    }
  }); 

  // make new invites notification off
  $(document).on('click', '#subMenuInvites', function(e){
      $.ajax({url: index + "/user/newinvitesnotificationoff",
              data: {_token: CSRF_TOKEN, action : 'newinvitesnotificationoff' },
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

  $(document).on("click", "#btnRemoveCurrentPhoto" ,function (event) {
    $.ajax({
              url: index + "/user/removephoto",
              type: 'POST',
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (data) {
                $('#myphoto').attr('src', window.index + '/user/photo?' + Math.random());
              }
          });
  }); 

  $(document).on("scrollstop", function (e) {

        /* active page */
        var activePage = $.mobile.pageContainer.pagecontainer("getActivePage");

        /* window's scrollTop() */
        scrolled = $(window).scrollTop();

        if (activePage[0].id == "home" && scrolled != 0) {
         $('#toTop').fadeIn();  
        }
        else
        {
          $('#toTop').fadeOut();
        }
  });
});
$(document).on('pagebeforeshow', '#home', function(){  
  $('#myphoto').attr('src', window.index + '/user/photo?' + Math.random());

  $.ajax({
        url: index + "/user/fullname",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          if(data != null)
          {
            $('#myfullname').text(data.fullname);
          }
        }
    });
});  
/* ===================================end js page home=================================== */

/* ===================================js page mygroups=================================== */
$(document).on('pageinit', '#mygroups', function(){  
	$(document).on('click', '#submitCategory', function() { // catch the form's submit event
          // Send data to server through the Ajax call
          // action is functionality we want to call and outputJSON is our data
          $.ajax({url: index + "/user/create/groups",
              data: {_token: CSRF_TOKEN, action : 'create', formData : $('#createcategory').serialize()},
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
                       $('input[id=categorytitle]').val('');
                       reloadCategories();
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (xhr, status, data) {
                  // This callback function will trigger on unsuccessful action                
                  if(xhr.responseJSON.status == false)
                  {
                    if(xhr.responseJSON.errors.title)
                    {
                      alert(xhr.responseJSON.errors.title);
                    }
                  }
                  else
                  {
                    alert('Network error has occurred please try again!'); 
                  } 
              }
          });                              
          return false; // cancel original event to prevent form submitting
  });      
  $('#listmygroups').on('click', 'li', function() {
      category = {id:$(this).attr('id').split(";")[0], title:$(this).attr('id').split(";")[1]};
      $.mobile.changePage("#detailmygroups");
  }); 

}); 
/* getmygroups before show */
$(document).on('pagebeforeshow', '#mygroups', function(){    
  reloadCategories();
}); 
/* ===================================end js page mygroups=================================== */

/* ===================================js page deletemygroups=================================== */
$(document).on('pageinit', '#deletemygroups', function(){  
  $(document).on("click", "#submitdeletemygroups" ,function (event) {
      var count = $("#cbFieldSetDeleteMyGroups input:checked").length;
      var categoriesid = [];
      for(i=0;i<count;i++){
      	categoriesid[i] = $("#cbFieldSetDeleteMyGroups input:checked")[i].value;
      }
      $.ajax({url: index + "/user/delete/groups",
              data: {_token: CSRF_TOKEN, action : 'delete', categoriesid : categoriesid},
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
                  	   $.mobile.pageContainer.pagecontainer("change", "#mygroups");
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
/* deletemygroups before show */
$(document).on('pagebeforeshow', '#deletemygroups', function(){    
    $.ajax({
        url: index + "/user/getmygroups",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          $("#mainDeleteMyGroups").html("");
          $("#mainAddDetailMyGroups").html("");
          $("#mainDeleteDetailMyGroups").html("");
    	  $("#mainDeleteMyGroups").append('<fieldset id="cbFieldSetDeleteMyGroups" data-role="controlgroup">');
    	  $("#cbFieldSetDeleteMyGroups").append("<ul data-role='listview' id='listdeletedetailmygroups' data-filter='true' data-inset='true' data-divider-theme='a'>");
          $.each (data['categories'], function (index) {
          	$("#listdeletedetailmygroups").append('<input type="checkbox" name="cb-'+index+'" id="cb-'+index+'" value="'+data['categories'][index]['id'] +'"/><label for="cb-'+index+'">'+data['categories'][index]['title']+'</label>');	
          });
          $("#mainDeleteMyGroups").trigger("create");
      }})  
}); 
/* ===================================end js page deletemygroups=================================== */

/* ===================================js page detailmygroups=================================== */
$(document).on('pageinit', '#detailmygroups', function(){  
	/*When click contact listdetailmygroups*/
  $(document).on("click", "#listdetailmygroups li" ,function (event) {
    if($(this).attr('id') !== undefined)
    {
      $.ajax({
              url: index + "/user/friendprofile",
              type: 'POST',
              data: {_token: CSRF_TOKEN, id : $(this).attr('id')},
              dataType: 'JSON',
              success: function (data) {
                if(data != null)
                {
                  friend = data;
                  $.mobile.changePage("#friendprofile");
                  beforePage = "#detailmygroups";
                }
              }
          });
    }
  }); 
}); 
/* getmygroups before show */
$(document).on('pagebeforeshow', '#detailmygroups', function(){    
  if(category == null)
  {
	window.location.replace(window.index + "");
  } 
  reloadDetailCategories();
}); 
/* ===================================end js page detailmygroups=================================== */

/* ===================================js page adddetailmygroups=================================== */
$(document).on('pageinit', '#adddetailmygroups', function(){  
	/*When click contact listdetailmygroups*/
  $(document).on("click", "#submitadddetailmygroups" ,function (event) {
      var count = $("#cbFieldSet input:checked").length;
      var friends = [];
      for(i=0;i<count;i++){
      	friends[i] = $("#cbFieldSet input:checked")[i].value;
      }

      $.ajax({url: index + "/user/create/detailgroups",
              data: {_token: CSRF_TOKEN, action : 'create', categoryid : category.id, friends : friends},
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
                  	   $.mobile.pageContainer.pagecontainer("change", "#detailmygroups");
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
/* getmygroups before show */
$(document).on('pagebeforeshow', '#adddetailmygroups', function(){    
    $.ajax({
        url: index + "/user/getallcontactforgroup",
        type: 'POST',
        data: {_token: CSRF_TOKEN, categoryid : category.id},
        dataType: 'JSON',
        success: function (data) {
          $("#mainDeleteMyGroups").html("");
          $("#mainDeleteDetailMyGroups").html("");
          $("#mainAddDetailMyGroups").html("");
    	  $("#mainAddDetailMyGroups").append('<fieldset id="cbFieldSet" data-role="controlgroup">');
    	  $("#cbFieldSet").append("<ul data-role='listview' id='listadddetailmygroups' data-filter='true' data-inset='true' data-divider-theme='a'>");
          $.each (data['friends'], function (index) {
          	$("#listadddetailmygroups").append('<input type="checkbox" name="cb-'+index+'" id="cb-'+index+'" value="'+data['friends'][index]['id'] + ';' + data['friends'][index]['onlineoffline'] +'"/><label for="cb-'+index+'">' + '<img src="' + window.index + '/user/images/photos/' + data['friends'][index]['id'] + '?' + Math.random() + '"/>' + data['friends'][index]['fullname'] + '</label>');	
          });
          $("#mainAddDetailMyGroups").trigger("create");
      }})  
}); 
/* ===================================end js page adddetailmygroups=================================== */

/* ===================================js page deletedetailmygroups=================================== */
$(document).on('pageinit', '#deletedetailmygroups', function(){  
  $(document).on("click", "#submitdeletedetailmygroups" ,function (event) {
      var count = $("#cbFieldSetDeleteDetailMyGroups input:checked").length;
      var detailcategoriesid = [];
      for(i=0;i<count;i++){
      	detailcategoriesid[i] = $("#cbFieldSetDeleteDetailMyGroups input:checked")[i].value;
      }
      $.ajax({url: index + "/user/delete/detailgroups",
              data: {_token: CSRF_TOKEN, action : 'delete', detailcategoriesid : detailcategoriesid},
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
                  	   $.mobile.pageContainer.pagecontainer("change", "#detailmygroups");
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
/* deletedetailmygroups before show */
$(document).on('pagebeforeshow', '#deletedetailmygroups', function(){    
    $.ajax({
        url: index + "/user/getdetailgroups",
        type: 'POST',
        data: {_token: CSRF_TOKEN, categoryid : category.id},
        dataType: 'JSON',
        success: function (data) {
          $("#mainDeleteMyGroups").html("");
          $("#mainAddDetailMyGroups").html("");
          $("#mainDeleteDetailMyGroups").html("");
    	  $("#mainDeleteDetailMyGroups").append('<fieldset id="cbFieldSetDeleteDetailMyGroups" data-role="controlgroup">');
    	  $("#cbFieldSetDeleteDetailMyGroups").append("<ul data-role='listview' id='listdeletedetailmygroups' data-filter='true' data-inset='true' data-divider-theme='a'>");
          $.each (data['detailcategories'], function (index) {
          	$("#listdeletedetailmygroups").append('<input type="checkbox" name="cb-'+index+'" id="cb-'+index+'" value="'+data['detailcategories'][index]['id'] +'"/><label for="cb-'+index+'">' + '<img src="' + window.index + '/user/images/photos/' + data['detailcategories'][index]['friendid'] + '?' + Math.random() + '"/>' + data['detailcategories'][index]['fullname']+'</label>');	
          });
          $("#mainDeleteDetailMyGroups").trigger("create");
      }})  
}); 
/* ===================================end js page deletedetailmygroups=================================== */

/* ===================================js page friendprofile=================================== */
$(document).on('pageinit', '#friendprofile', function(){  
  $(document).on("click", "#backFriendProfile" ,function () {
  	if(pageAfterLoadSuccess == "home")
  	{
  		if(history.length > 1)
        {
          $.mobile.changePage(beforePage);
        }
        else
        {
          $.mobile.changePage("#home");
        }
  	}
  	else
  	{
  		if(beforePage != "")
	    {
	      $.mobile.changePage(beforePage);
	    }
	    else
	    {
	      $.mobile.changePage("#home");
	    }
      
      	if(pageAfterLoadSuccess != "")
	    {
        	pageAfterLoadSuccess = "home";
      	}
  	}
  }); 
  $(document).on('click', '#deletefriend', function() { 

    $.ajax({url: index + "/user/delete/friend",
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
                       $.mobile.pageContainer.pagecontainer("change", "#");
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

  $(document).on("click", "#btnRemoveFriendPhoto" ,function (event) {
    $.ajax({
            url: index + "/user/removefriendphoto",
            type: 'POST',
            data: {_token: CSRF_TOKEN, id: friend.id},
            dataType: 'JSON',
            success: function (data) {
              if(data.status)
              {
                $('#friendPic').attr('src', window.index + '/user/images/photos/friendsprofile/' + friend.id + '?' + Math.random());
                $('#' + friend.id).find('img').attr('src', window.index + '/user/images/photos/friendsprofile/' + friend.id + '?' + Math.random());
              }
          }
    });
  }); 

  $(document).on('mousedown', '#emailfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.email);
    }, 1500);
  });
  $(document).on('click', '#emailfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#urlfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ",index + "/" + friend.url);
    }, 1500);
  });
  $(document).on('click', '#urlfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#phonefriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.phone);
    }, 1500);
  });
  $(document).on('click', '#phonefriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#phone2friendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.phone2);
    }, 1500);
  });
  $(document).on('click', '#phone2friendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#addressfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.address);
    }, 1500);
  });
  $(document).on('click', '#addressfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#pinbbfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.pinbb);
    }, 1500);
  });
  $(document).on('click', '#pinbbfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#facebookfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.facebook);
    }, 1500);
  });
  $(document).on('click', '#facebookfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#twitterfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.twitter);
    }, 1500);
  });
  $(document).on('click', '#twitterfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#instagramfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.instagram);
    }, 1500);
  });
  $(document).on('click', '#instagramfriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

  $(document).on('mousedown', '#linefriendprofile', function(event) { 
    clearTimeout(this.downTimer);
    this.downTimer = setTimeout(function() {
      window.prompt("Copy to clipboard: ", friend.line);
    }, 1500);
  });
  $(document).on('click', '#linefriendprofile', function(event) { 
    clearTimeout(this.downTimer);
  });

});
/* show friend profile who clicked */
$(document).on('pagebeforeshow', '#friendprofile', function(){   
	if(friend == null)
	{
		window.location.replace(window.index + "");
	} 
	
    // make list empty first
    $("#actionFriendProfileList").empty();

    $('#friendPic').attr('src', window.index + '/user/images/photos/friendsprofile/' + friend.id + '?' + Math.random());
    $('#fullName').text(friend.fullname);
    if(friend.onlineoffline == "online")
    {
      $('#friendprofileonlineoffline').text('Status : ' + friend.status);
      $('#friendprofileupdated_at').text('Last Updated ' + friend.updated_at);
      $('#btnRemoveFriendPhoto').hide();
    }
    else
    {
      $('#friendprofileonlineoffline').text('OFFLINE');
      $('#friendprofileupdated_at').text('');
      $('#btnRemoveFriendPhoto').show();
    }

    if (friend.email) {
      $('#actionFriendProfileList').append('<li><a href="mailto:' + friend.email + '" id="emailfriendprofile"><h3>Email</h3>' +
          '<p>' + friend.email + '</p></a></li>');
    }
    if (friend.url) {
      $('#actionFriendProfileList').append('<li><a target="_blank" href="http://kontakku.com/' + friend.url + '" id="urlfriendprofile"><h3>URL</h3>' +
          '<p>kontakku.com/' + friend.url + '</p></a></li>');
    }
    if (friend.phone) {
      $('#actionFriendProfileList').append('<li><a href="tel:' + friend.phone + '" id="phonefriendprofile"><h3>Call This Phone 1</h3>' +
          '<p>' + friend.phone + '</p></a></li>');
      $('#actionFriendProfileList').append('<li><a href="sms:' + friend.phone + '" id="phonefriendprofile"><h3>SMS Phone 1</h3>' +
          '<p>' + friend.phone + '</p></a></li>');
    }
    if (friend.phone2) {
      $('#actionFriendProfileList').append('<li><a href="tel:' + friend.phone2 + '" id="phone2friendprofile"><h3>Call This Phone 2</h3>' +
          '<p>' + friend.phone2 + '</p></a></li>');
      $('#actionFriendProfileList').append('<li><a href="sms:' + friend.phone2 + '" id="phone2friendprofile"><h3>SMS Phone 2</h3>' +
          '<p>' + friend.phone2 + '</p></a></li>');
    }
    if (friend.address) {
      $('#actionFriendProfileList').append('<li style="white-space:normal;"><a id="addressfriendprofile"><h3>Address</h3>' +
          '<p>' + friend.address + '</p></a></li>');
    }
    if (friend.pinbb) {
      $('#actionFriendProfileList').append('<li><a id="pinbbfriendprofile"><h3>PIN BB</h3>' +
          '<p>' + friend.pinbb + '</p></a></li>');
    }
    if (friend.facebook.substring(0, 4) === "http") {
      $('#actionFriendProfileList').append('<li><a href="' + friend.facebook + '" target="_blank" id="facebookfriendprofile"><h3>Facebook</h3>' +
          '<p>' + friend.facebook+ '</p></a></li>');
    }
    else if(friend.facebook.indexOf(' ') >= 0)
    {
      $('#actionFriendProfileList').append('<li><a href="" id="facebookfriendprofile"><h3>Facebook</h3>' +
          '<p>' + friend.facebook+ '</p></a></li>');
    }
    else if (friend.facebook) {
      $('#actionFriendProfileList').append('<li><a href="https://www.facebook.com/' + friend.facebook + '" target="_blank" id="facebookfriendprofile"><h3>Facebook</h3>' +
          '<p>' + friend.facebook+ '</p></a></li>');
    }
    if (friend.twitter) {
      $('#actionFriendProfileList').append('<li><a href="https://twitter.com/' + friend.twitter + '" target="_blank" id="twitterfriendprofile"><h3>Twitter</h3>' +
          '<p>' + friend.twitter + '</p></a></li>');
    }
    if (friend.instagram) {
      $('#actionFriendProfileList').append('<li><a href="https://instagram.com/' + friend.instagram + '" target="_blank" id="instagramfriendprofile"><h3>Instagram</h3>' +
          '<p>' + friend.instagram + '</p></a></li>');
    }
    if(friend.line) {
      $('#actionFriendProfileList').append('<li><a href="http://line.me/R/ti/p/~' + friend.line + '" target="_blank" id="linefriendprofile"><h3>Line</h3>' +
          '<p>' + friend.line + '</p></a></li>');
    }

    if(friend.onlineoffline === 'online')
    {
      $('#editfriendprofilebuttonpage').addClass('ui-disabled');
    }
    else
    {
      $('#editfriendprofilebuttonpage').removeClass('ui-disabled');
    }
    
    if(friend.isfavorite === true)
    {
    	$("#isfavoriteflipswitch")
            .off("change") /* remove previous listener */
            .val('yes') /* update value */
            .flipswitch('refresh') /* re-enhance switch */
            .on("change", flipChangedIsFavorite); /* add listener again */
    }
    else
    {
      	$("#isfavoriteflipswitch")
            .off("change") /* remove previous listener */
            .val('no') /* update value */
            .flipswitch('refresh') /* re-enhance switch */
            .on("change", flipChangedIsFavorite); /* add listener again */
    }

    $('#actionFriendProfileList').listview('refresh');
});
/* ===================================end js page friendprofile=================================== */

/* ===================================js page editfriendprofile=================================== */
$(document).on('pageinit', '#editfriendprofile', function(){  
  /* edit friend */
  $(document).on('click', '#editfriendsubmit', function() { // catch the form's submit event
        var formData = new FormData($('#formEditFriendOffline')[0]);
        formData.append("_token", CSRF_TOKEN);
        formData.append("id", friend.id);
        // Send data to server through the Ajax call
        // action is functionality we want to call and outputJSON is our data
        $.ajax({url: index + "/user/edit/friendoffline",
            data: formData,
            type: 'post',                   
            async: 'true',
            dataType: 'json',
            contentType: false,
            processData: false,
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
                      friend.phone2 = $('#editfriendphone2').val();
                      friend.address = $('#editfriendaddress').val();
                      friend.pinbb = $('#editfriendpinbb').val();
                      friend.facebook = $('#editfriendfacebook').val();
                      friend.twitter = $('#editfriendtwitter').val();
                      friend.instagram = $('#editfriendinstagram').val();
                      friend.line = $('#editfriendline').val();
                      $.mobile.back();
                      reloadContact();
                } else {
                    alert('Something error happened!'); 
                }
            },
            error: function (xhr, status, data) {
                // This callback function will trigger on unsuccessful action                
                if(xhr.responseJSON.status === false)
                {
                  if(xhr.responseJSON.errors.fullname)
                  {
                    alert(xhr.responseJSON.errors.fullname);
                  }
                  else if(xhr.responseJSON.errors.email)
                  {
                    alert(xhr.responseJSON.errors.email);
                  }
                  else if(xhr.responseJSON.errors.phone)
                  {
                    alert(xhr.responseJSON.errors.phone);
                  }
                  else if(xhr.responseJSON.errors.phone2)
                  {
                    alert(xhr.responseJSON.errors.phone2);
                  }
                  else if(xhr.responseJSON.errors.address)
                  {
                    alert(xhr.responseJSON.errors.address);
                  }
                  else if(xhr.responseJSON.errors.pinbb)
                  {
                    alert(xhr.responseJSON.errors.pinbb);
                  }
                  else if(xhr.responseJSON.errors.facebook)
                  {
                    alert(xhr.responseJSON.errors.facebook);
                  }
                  else if(xhr.responseJSON.errors.twitter)
                  {
                    alert(xhr.responseJSON.errors.twitter);
                  }
                  else if(xhr.responseJSON.errors.instagram)
                  {
                    alert(xhr.responseJSON.errors.instagram);
                  }
                  else if(xhr.responseJSON.errors.line)
                  {
                    alert(xhr.responseJSON.errors.line);
                  }
                  else if(xhr.responseJSON.errors.photo)
                  {
                    alert(xhr.responseJSON.errors.photo);
                  }
                }
                else
                {
                  alert('Network error has occurred please try again!'); 
                }    
            }
        });        
        return false; // cancel original event to prevent form submitting
  });    
});
/* edit friend profile */
$(document).on('pagebeforeshow', '#editfriendprofile', function(){    
  // initialization form edit
  $('#editfriendfullname').val(friend.fullname);
  $('#editfriendemail').val(friend.email);
  $('#editfriendphone').val(friend.phone);
  $('#editfriendphone2').val(friend.phone2);
  $('#editfriendaddress').val(friend.address);
  $('#editfriendpinbb').val(friend.pinbb);
  $('#editfriendfacebook').val(friend.facebook);
  $('#editfriendtwitter').val(friend.twitter);
  $('#editfriendinstagram').val(friend.instagram);
  $('#editfriendline').val(friend.line);
  // clear select photo
  $('#editfriendphoto').val('');
  $("#outputEditFriend").attr("src", index + "/image/" + friend.id);

  $("#exampleProfileEditFriend").prop("href", index + "/stevengunanto");
}); 
/* ===================================end js page editfriendprofile=================================== */

/* ===================================js page editmyprofile=================================== */
$(document).on('pageinit', '#editmyprofile', function(){ 
  $(document).on("click", "#backEditMyProfile" ,function () {
    if(beforePage != "")
    {
      $.mobile.changePage(beforePage);
    }
    else
    {
      $.mobile.changePage("#home");
    }
  });  
  /* edit my profile */
  $(document).on('click', '#editmyprofilesubmit', function() { // catch the form's submit event
        var formData = new FormData($('#formEditMyProfile')[0]);
        formData.append("_token", CSRF_TOKEN);
        // Send data to server through the Ajax call
        // action is functionality we want to call and outputJSON is our data
        $.ajax({url: index + "/user/editprofile",
            data: formData,
            type: 'post',                   
            async: 'true',
            dataType: 'json',
            contentType: false,
            processData: false,
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
            error: function (xhr, status, data) {
                // This callback function will trigger on unsuccessful action                
                if(xhr.responseJSON.status === false)
                {
                  if(xhr.responseJSON.errors.fullname)
                  {
                    alert(xhr.responseJSON.errors.fullname);
                  }
                  else if(xhr.responseJSON.errors.phone)
                  {
                    alert(xhr.responseJSON.errors.phone);
                  }
                  else if(xhr.responseJSON.errors.phone2)
                  {
                    alert(xhr.responseJSON.errors.phone2);
                  }
                  else if(xhr.responseJSON.errors.address)
                  {
                    alert(xhr.responseJSON.errors.address);
                  }
                  else if(xhr.responseJSON.errors.pinbb)
                  {
                    alert(xhr.responseJSON.errors.pinbb);
                  }
                  else if(xhr.responseJSON.errors.facebook)
                  {
                    alert(xhr.responseJSON.errors.facebook);
                  }
                  else if(xhr.responseJSON.errors.twitter)
                  {
                    alert(xhr.responseJSON.errors.twitter);
                  }
                  else if(xhr.responseJSON.errors.instagram)
                  {
                    alert(xhr.responseJSON.errors.instagram);
                  }
                  else if(xhr.responseJSON.errors.line)
                  {
                    alert(xhr.responseJSON.errors.line);
                  }
                  else if(xhr.responseJSON.errors.status)
                  {
                    alert(xhr.responseJSON.errors.status);
                  }
                  else if(xhr.responseJSON.errors.note)
                  {
                    alert(xhr.responseJSON.errors.note);
                  }
                  else if(xhr.responseJSON.errors.photo)
                  {
                    alert(xhr.responseJSON.errors.photo);
                  }
                }
                else
                {
                  alert('Network error has occurred please try again!'); 
                }   
            }
        });                
      return false; // cancel original event to prevent form submitting
  });    

});
/* edit my profile before show */
$(document).on('pagebeforeshow', '#editmyprofile', function(){    
  // initialization form edit
  $.ajax({
            url: index + "/user/profile",
            type: 'POST',
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                // initialization my profile form
              $('#editmyprofilefullname').val(data.fullname);
              $('#editmyprofilephone').val(data.phone);
              $('#editmyprofilephone2').val(data.phone2);
              $('#editmyprofileaddress').val(data.address);
              $('#editmyprofilepinbb').val(data.pinbb);
              $('#editmyprofilefacebook').val(data.facebook);
              $('#editmyprofiletwitter').val(data.twitter);
              $('#editmyprofileinstagram').val(data.instagram);
              $('#editmyprofileline').val(data.line);
              $('#editmyprofilestatus').val(data.status);
              $('#editmyprofilenote').val(data.note);
              // clear select photo
              $('#editmyprofilephoto').val('');
              $("#outputEditProfile").attr("src", index + "/image/" + data.id);
            }
        });
  $("#exampleProfile").prop("href", index + "/stevengunanto");
}); 
/* ===================================end js page myprofile=================================== */

/* ===================================js page invites=================================== */
$(document).on('pageinit', '#invites', function(){  
  $('#listinvites').on('click', 'li', function() {
      friendonlineinvatitation = {id:$(this).attr('id').split(";")[0], fullname:$(this).attr('id').split(";")[1], status:$(this).attr('id').split(";")[2]};
      if($(this).attr('id').split(";")[3] === "got")
      {
        if(friendonlineinvatitation.status === "PENDING")
        {
          $.mobile.changePage("#gotinvitation");
        }
      }
      else if($(this).attr('id').split(";")[3] === "sent")
      {
        if(friendonlineinvatitation.status === "PENDING" || friendonlineinvatitation.status === "DECLINED")
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
              $("#listinvites").append("<li id='"  + data['users'][index]['id'] + ";" + data['users'][index]['fullname'] + ";" + data['users'][index]['status'] +  ";got'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['users'][index]['id'] + "?" + Math.random() + "'/>" + data['users'][index]['fullname'] + "<p>" + data['users'][index]['status'] + "</p>" + "</a>" + "</li>").listview("refresh");
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
            $("#listinvites").append("<li id='"  + data['users'][index]['id'] + ";" + data['users'][index]['fullname'] + ";" + data['users'][index]['status'] + ";sent'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['users'][index]['id'] + "?" + Math.random() + "'/>" + data['users'][index]['fullname'] + "<p>" + data['users'][index]['status'] + "</p>" + "</a>" + "</li>").listview("refresh");
          });
        }
    }})  

}); 
/* ===================================end js page invites=================================== */

/* ===================================js page addfriendsonline=================================== */
$(document).on('pageinit', '#addfriendsonline', function(){  
  $(document).on('click', '#buttonaddfriendsonline', function() { 

    $.ajax({url: index + "/user/create/friendonline",
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
                  		if(typeof result.over !== "undefined" && result.over)
	              		{
	              			alert(result.over); 
	              		}
	              		else
	              		{
	              			$('#searchbaraddfriendsonline').val('');
                       		$.mobile.pageContainer.pagecontainer("change", "#invites");
	              		}
                  } 
                  else if(result.status === false && result.msg !== "")
                  {
	                    alert(result.msg); 
                  }
                  else {
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
                  $('#imguseraddfriendsonline').attr('src', window.index + '/user/images/photos/friendsprofile/' + result['users'][0].id);
                  $('#fullnameuseraddfriendsonline').text(result['users'][0].fullname);
                  $('#iduseraddfriendsonline').val(result['users'][0].id);

                  $('#imguseraddfriendsonline').show();
                  $('#fullnameuseraddfriendsonline').show();
                  $('#buttonaddfriendsonline').show();
                } 
                else if(result.status === false && result.msg !== "")
                {
                    $('#fullnameuseraddfriendsonline').val('');
                    $('#iduseraddfriendsonline').val('');

                    $('#imguseraddfriendsonline').hide();
                    $('#fullnameuseraddfriendsonline').hide();
                    $('#buttonaddfriendsonline').hide();
                    alert(result.msg); 
                }
                else
                {
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
                       $.mobile.pageContainer.pagecontainer("change", "#invites");
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
                         $.mobile.pageContainer.pagecontainer("change", "#invites");
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
  if(friendonlineinvatitation == null)
  {
	window.location.replace(window.index + "");
  }  
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
                         $.mobile.pageContainer.pagecontainer("change", "#invites");
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
  if(friendonlineinvatitation == null)
  {
	window.location.replace(window.index + "");
  } 
  // initialization form edit
  $('#fullnameusersentinvitation').text(friendonlineinvatitation.fullname);
  $('#statususersentinvitation').text(friendonlineinvatitation.status);
}); 
/* ===================================end js page sentinvitation=================================== */

/* ===================================js page notes=================================== */
$(document).on("pageshow", "#notes", function (e, ui) {
	if($("#searchbarnotes").val() == "")
    {
       reloadNote();
    }
    else
    {
      $.ajax({
          url: index + "/user/searchnote",
          type: 'POST',
          data: {_token: CSRF_TOKEN, search: $("#searchbarnotes").val()},
          dataType: 'JSON',
          success: function (data) {
            $("#listNotes").empty();
            $.each (data['notes'], function (index) {
              $("#listNotes").append("<li data-icon='delete'><a class='view' id='" + data['notes'][index]['id'] + "' href='#'>" + data['notes'][index]['note'] + "<p>" + data['notes'][index]['updated_at'] + "</p></>"  + "<a href='#popupDialogDeleteNote' id='" + data['notes'][index]['id'] + "' data-rel='popup' class='delbtn' data-position-to='window' data-transition='pop'>remove</a></li>").listview("refresh");
            });
            searchnotescount = data['searchnotescount'];
            $("#totalnotes").text('Total Found ' + data['totalfound']);
        }
      });
    }
});
$(document).on('pageinit', '#notes', function(){  
    var deletedIdNoteClicked;

    $('#listNotes').on("click", ".delbtn", function() {
      deletedIdNoteClicked = $(this).attr('id');
    });

    $("#listNotes").on("click", ".view", function(e){
      if($(this).attr('id') !== undefined)
      {
        $.ajax({
                url: index + "/user/note",
                type: 'POST',
                data: {_token: CSRF_TOKEN, id : $(this).attr('id')},
                dataType: 'JSON',
                success: function (data) {
                  if(data != null)
                  {
                    note = data;
                    $.mobile.changePage("#fillnote");
                  }
                }
            });
      }
    }); 

    $(document).on('click', '#submitdeletenote', function() { 
      $.ajax({url: index + "/user/delete/note",
              data: {_token: CSRF_TOKEN, action : 'delete', id : deletedIdNoteClicked },
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
                       reloadNote();
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

    $(document).on('click', '#addnote', function() { 
      $.ajax({url: index + "/user/create/note",
              data: {_token: CSRF_TOKEN, action : 'create' },
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
                       note = result.note;
                       $.mobile.changePage("#fillnote");
                  } 
                  else if(result.status == false) {
                    if(result.message) {
                      alert(result.message); 
                    }
                  }
                  else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
      }); 
    });  

  /* add more contact */
  function addMoreNote(page) {
      if(isLoadMoreNote == true)
      {
          $.mobile.loading("show", {
            text: "loading more..",
            textVisible: true,
            theme: "a"
        });
      }
      setTimeout(function () {
          var items = '';
          var count = 0;
          $.ajax({
              url: index + "/user/getnote/" + notescount,
              type: 'POST',
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (data) {
                $.each (data['notes'], function (index) {
                  items += "<li data-icon='delete'><a class='view' id='" + data['notes'][index]['id'] + "' href='#'>" + data['notes'][index]['note'] + "<p>" + data['notes'][index]['updated_at'] + "</p></>"  + "<a href='#popupDialogDeleteNote' id='" + data['notes'][index]['id'] + "' data-rel='popup' class='delbtn' data-position-to='window' data-transition='pop'>remove</a></li>";  
                });
                if(notescount == data['notescount'])
                {
                  isLoadMoreNote = false;
                }
                else
                {
                  isLoadMoreNote = true;
                }
                notescount = data['notescount'];
                $("#listNotes", page).append(items).listview("refresh");
                $.mobile.loading("hide");
                isLoadMoreNoteFinished = true;
                if(pageAfterLoadSuccess == "")
                {
                  $.mobile.loading('show');
                }
              }
          });
      }, 500);
  }

  /* add more contact */
  function addMoreSearchNote(page) {
      if(isLoadMoreSearchNote == true)
      {
          $.mobile.loading("show", {
            text: "loading more..",
            textVisible: true,
            theme: "a"
        });
      }
      setTimeout(function () {
          var items = '';
          var count = 0;
          $.ajax({
              url: index + "/user/searchnote/" + searchnotescount,
              type: 'POST',
              data: {_token: CSRF_TOKEN, search: $("#searchbarnotes").val()},
              dataType: 'JSON',
              success: function (data) {
                $.each (data['notes'], function (index) {
                  items += "<li data-icon='delete'><a class='view' id='" + data['notes'][index]['id'] + "' href='#'>" + data['notes'][index]['note'] + "<p>" + data['notes'][index]['updated_at'] + "</p></>"  + "<a href='#popupDialogDeleteNote' id='" + data['notes'][index]['id'] + "' data-rel='popup' class='delbtn' data-position-to='window' data-transition='pop'>remove</a></li>";  
                });
                if(searchnotescount == data['searchnotescount'])
                {
                  isLoadMoreSearchNote = false;
                }
                else
                {
                  isLoadMoreSearchNote = true;
                }
                searchnotescount = data['searchnotescount'];
                $("#listNotes", page).append(items).listview("refresh");
                $.mobile.loading("hide");
                isLoadMoreNoteFinished = true;
                if(pageAfterLoadSuccess == "")
                {
                  $.mobile.loading('show');
                }
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
      if (activePage[0].id == "notes" && scrolled >= scrollEnd && (notescount > 0) && $('#searchbarnotes').val().length == 0) {
        if(isLoadMoreNoteFinished == true)
        {
          isLoadMoreNoteFinished = false;
          addMoreNote(activePage);
        }
      }
      else if (activePage[0].id == "notes" && scrolled >= scrollEnd && (searchnotescount > 0) && $('#searchbarnotes').val().length != 0) {
          if(isLoadMoreNoteFinished == true)
        {
          isLoadMoreNoteFinished = false;
          addMoreSearchNote(activePage);
        }
      }
  });

  $(document).on("input", "#searchbarnotes", function (e) { 
    if($("#searchbarnotes").val() == "")
    {
       reloadNote();
    }
    else
    {
      $.ajax({
          url: index + "/user/searchnote",
          type: 'POST',
          data: {_token: CSRF_TOKEN, search: $("#searchbarnotes").val()},
          dataType: 'JSON',
          success: function (data) {
            $("#listNotes").empty();
            $.each (data['notes'], function (index) {
              $("#listNotes").append("<li data-icon='delete'><a class='view' id='" + data['notes'][index]['id'] + "' href='#'>" + data['notes'][index]['note'] + "<p>" + data['notes'][index]['updated_at'] + "</p></>"  + "<a href='#popupDialogDeleteNote' id='" + data['notes'][index]['id'] + "' data-rel='popup' class='delbtn' data-position-to='window' data-transition='pop'>remove</a></li>").listview("refresh");
            });
            searchnotescount = data['searchnotescount'];
            $("#totalnotes").text('Total Found ' + data['totalfound']);
        }
      });
    }
  });

  /*When click clear search input*/
  $(document).on('click', '.ui-input-clear', function () {
        reloadNote();
  });

});
/* ===================================js page notes=================================== */

/* ===================================js fill note=================================== */
$(document).on('pageinit', '#fillnote', function(){  
  //setup before functions
  var typingTimer;                //timer identifier
  var doneTypingInterval = 1000;  //time in ms, 5 second for example
  var $input = $('#textareaNote');

  //on keyup, start the countdown
  $input.on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $input.on('keydown', function () {
    $('#infonote').text('You are typing...');
    clearTimeout(typingTimer);
  });

  //user is "finished typing," do something
  function doneTyping () {
    var formData = new FormData($('#formEditNote')[0]);
        formData.append("_token", CSRF_TOKEN);
        formData.append("id", note.id);
    //do something
    $.ajax({url: index + "/user/edit/note",
              data: formData,
              type: 'post',                   
              async: 'true',
              dataType: 'json',
              contentType: false,
              processData: false,
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
                    $('#infonote').text('Note\'s been saved');
                    if($('body').pagecontainer('getActivePage').prop('id') == 'notes')
                    {
                      reloadNote();
                    }
                  } else {
                    $('#infonote').text('Something error happened!');
                  }
              },
              error: function (xhr, status, data) {
                  // This callback function will trigger on unsuccessful action     
                  if(xhr.responseJSON.status == false)
                  {
                    if(xhr.responseJSON.errors.note)
                    {
                      alert(xhr.responseJSON.errors.note);
                    }
                  }
                  else
                  {
                    alert('Network error has occurred please try again!'); 
                  } 
              }
      });  
  }

});  
$(document).on("pagebeforeshow", "#fillnote", function (e, ui) {
  if(note == undefined)
  {
    $.mobile.changePage("#notes");
  }
  else
  {
    $('#infonote').text('Fill your note');
    $('#textareaNote').val(note.note);
  }
});
/* ===================================js fill note=================================== */

/* ===================================js page changepassword=================================== */
$(document).on('pageinit', '#changepassword', function(){  
  $(document).on('click', '#changepasswordsubmit', function() { 

    $.ajax({url: index + "/user/changepassword",
              data: {_token: CSRF_TOKEN, action : 'change', formData : $('#formChangePassword').serialize()},
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
                  	$('#changepasswordoldpassword').val("");
                    $('#changepasswordnewpassword').val("");
                    $('#changepasswordretypepassword').val("");
                    $('#changepasswordlogoutalldevices').attr('checked',false).checkboxradio('refresh');
                    $.mobile.pageContainer.pagecontainer("change", "#settingsaccount");
                  } else {
                      alert('Something error happened!\n' + result.message); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });            
  }); 

});
$(document).on('pagebeforeshow', '#changepassword', function(){ 
}); 
/* ===================================end js page changepassword=================================== */

/* ===================================js page settingsaccount=================================== */
$(document).on('pageinit', '#settingsaccount', function(){ 


});
$(document).on('pagebeforecreate', '#settingsaccount', function(){ 
  $.ajax({
            url: index + "/user/profile",
            type: 'POST',
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
              $('#settingsaccountmyemail').text(data.email);
              $('#settingsaccountmyusername').text(data.url);
              $('#settingsaccountmyurl').text("kontakku.com/" + data.url);
              $('#settingsaccountmembertype').text(data.membertype);
              $('#settingsaccountmylimitcontacts').text(data.limitcontacts);

              if(data.privateaccount === true)
              {
              	$("#privateaccountflipswitch")
		            .off("change") /* remove previous listener */
		            .val('yes') /* update value */
		            .flipswitch('refresh') /* re-enhance switch */
		            .on("change", flipChangedPrivateAccount); /* add listener again */
              }
              else
              {
                $("#privateaccountflipswitch")
		            .off("change") /* remove previous listener */
		            .val('no') /* update value */
		            .flipswitch('refresh') /* re-enhance switch */
		            .on("change", flipChangedPrivateAccount); /* add listener again */
              }

              if(data.showemailinpublic === true)
              {
                $("#showemailinpublicflipswitch")
                .off("change") /* remove previous listener */
                .val('yes') /* update value */
                .flipswitch('refresh') /* re-enhance switch */
                .on("change", flipChangedShowEmailInPublic); /* add listener again */
              }
              else
              {
                $("#showemailinpublicflipswitch")
                .off("change") /* remove previous listener */
                .val('no') /* update value */
                .flipswitch('refresh') /* re-enhance switch */
                .on("change", flipChangedShowEmailInPublic); /* add listener again */
              }

              if(data.privatephone1 === true)
              {
                $("#privatephone1flipswitch")
                .off("change") /* remove previous listener */
                .val('yes') /* update value */
                .flipswitch('refresh') /* re-enhance switch */
                .on("change", flipChangedPrivatePhone1); /* add listener again */
              }
              else
              {
                $("#privatephone1flipswitch")
                .off("change") /* remove previous listener */
                .val('no') /* update value */
                .flipswitch('refresh') /* re-enhance switch */
                .on("change", flipChangedPrivatePhone1); /* add listener again */
              }

              if(data.privatephone2 === true)
              {
                $("#privatephone2flipswitch")
                .off("change") /* remove previous listener */
                .val('yes') /* update value */
                .flipswitch('refresh') /* re-enhance switch */
                .on("change", flipChangedPrivatePhone2); /* add listener again */
              }
              else
              {
                $("#privatephone2flipswitch")
                .off("change") /* remove previous listener */
                .val('no') /* update value */
                .flipswitch('refresh') /* re-enhance switch */
                .on("change", flipChangedPrivatePhone2); /* add listener again */
              }
            }
        });

	$("#membertypehref").prop("href", index + "/site/membertype");
}); 
/* ===================================end js page settingsaccount=================================== */

// function reloadContact
function reloadContact() {
  $("#listMyGroups").show();
  isLoadMoreContact = true;
  isLoadMoreSearchContact = true;
	setBubbleCount();    
	getFavoritesContact();
	getContacts();
}

function reloadNote() {
  isLoadMoreNote = true;
  isLoadMoreSearchNote = true;
  countNotes();
  getNotes();
}

// function reloadCategories
function reloadCategories() {
	$("#listmygroups").empty();

	$.ajax({
	    url: index + "/user/getmygroups",
	    type: 'POST',
	    data: {_token: CSRF_TOKEN},
	    dataType: 'JSON',
	    success: function (data) {
	      $.each (data['categories'], function (index) {
	      	$("#listmygroups").append("<li id='"  + data['categories'][index]['id'] + ";" + data['categories'][index]['title'] + "'><a href='#'>" + data['categories'][index]['title'] + "<span class='ui-li-count'>" + data['categories'][index]['count'] + "</span>"  + "</a>" + "</li>").listview("refresh");
	      });
	  }})  
}

// function reloadDetailCategories
function reloadDetailCategories() {
	$("#listdetailmygroups").empty();
	$("#myHeaderDetailGroups").text(category.title);
	$.ajax({
	    url: index + "/user/getdetailgroups",
	    type: 'POST',
	    data: {_token: CSRF_TOKEN, categoryid : category.id},
	    dataType: 'JSON',
	    success: function (data) {
	      $.each (data['detailcategories'], function (index) {
	      	$("#listdetailmygroups").append("<li id='"  + data['detailcategories'][index]['friendid'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['detailcategories'][index]['friendid'] + "?" + Math.random() + "'/>" + data['detailcategories'][index]['fullname'] + "<p>" + data['detailcategories'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
	      });
	  }})  
}

function getFavoritesContact()
{
	// get favorites contact
	$.ajax({
        url: index + "/user/getfavorites",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          if(data['friends'].length == 0)
          {
          	$("#collapsibleFavorites").hide();
          }
          else
          {
          	$("#collapsibleFavorites").show();
          	$("#collapsibleFavorites").collapsible( "option", "collapsed", false );
            $("#listFavorites").empty();
            $.each (data['friends'], function (index) {
              if(data['friends'][index]['onlineoffline'] == "ONLINE")
              {
                if(data['friends'][index]['membertype'] == "PREMIUM")
                {
                  $("#listFavorites").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberpremium'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
                else if(data['friends'][index]['membertype'] == "BOSS")
                {
                  $("#listFavorites").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberboss'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
                else
                {
                  $("#listFavorites").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
              }
              else
              {
                $("#listFavorites").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
              }
           });
          }
      }})  
}

function getContacts()
{
	// get contacts
    $.ajax({
        url: index + "/user/getcontact",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          if(data['friends'].length == 0)
          {
            $("#collapsibleOtherContacts").hide();
          }
          else
          {
            $("#collapsibleOtherContacts").show();
            $("#collapsibleOtherContacts h2 #myHeaderOtherContacts").text("Other Contacts");
            $("#collapsibleOtherContacts").collapsible( "option", "collapsed", false );
            $("#list").empty();
            $.each (data['friends'], function (index) {
              if(data['friends'][index]['onlineoffline'] == "ONLINE")
              {
                if(data['friends'][index]['membertype'] == "PREMIUM")
                {
                  $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberpremium'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
                else if(data['friends'][index]['membertype'] == "BOSS")
                {
                  $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb memberboss'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
                else
                {
                  $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
                }
              }
              else
              {
                $("#list").append("<li id='"  + data['friends'][index]['id'] + "' class='ui-li-has-thumb'><a href='#'><img class='ui-li-icon' src='" + window.index + "/user/images/photos/" + data['friends'][index]['id'] + "?" + Math.random() + "'/>" + data['friends'][index]['fullname'] + "<p>" + data['friends'][index]['onlineoffline'] + "</p></>" + "</li>").listview("refresh");
              }
              
            });
          }
          friendscount = data['friendscount'];
      }})   
}

// function totalContacts
function setBubbleCount() {
    $.ajax({
        url: index + "/user/getbubblecount",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          if(data['totalcontacts'] == 0)
          {
            $("#totalcontacts").text('* No Contacts *');
          }
          else
          {
            $("#totalcontacts").text('Total Contacts ' + data['totalcontacts']);
            $("#bubbleCountFavorites").text(data['favoritescount']);
  	        $("#bubbleCountOtherContacts").show();
  	        $("#bubbleCountOtherContacts").text(data['totalcontacts'] - data['favoritescount']);
          }
      }})             
}

function getNotes()
{
  // get contacts
    $.ajax({
        url: index + "/user/getnote",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          $("#listNotes").empty();
          $.each (data['notes'], function (index) {
            $("#listNotes").append("<li data-icon='delete'><a class='view' id='" + data['notes'][index]['id'] + "' href='#'>" + data['notes'][index]['note'] + "<p>" + data['notes'][index]['updated_at'] + "</p></>"  + "<a href='#popupDialogDeleteNote' id='" + data['notes'][index]['id'] + "' data-rel='popup' class='delbtn' data-position-to='window' data-transition='pop'>remove</a></li>").listview("refresh");
          });
          notescount = data['notescount'];
      }})   
}

function countNotes() {
    $.ajax({
        url: index + "/user/countnote",
        type: 'POST',
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (data) {
          if(data['totalnotes'] == 0)
          {
            $("#totalnotes").text('* No Notes *');
          }
          else
          {
            $("#totalnotes").text('Total Notes ' + data['totalnotes']);
          }
      }})             
}

 /* change event handler */
function flipChangedIsFavorite(e) {
    $.ajax({url: index + "/user/changefavorite",
	          data: {_token: CSRF_TOKEN, action : 'change', id : friend.id, onlineoffline : friend.onlineoffline, isfavorite : this.value},
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
	              	if($("#searchbar").val() == "")
      				    {
                     reloadContact();
      				    }
	              } 
                else {
	                  alert('Something error happened!'); 
	              }
	          },
	          error: function (request,error) {
	              // This callback function will trigger on unsuccessful action                
	              alert('Network error has occurred please try again!');
	          }
	      }); 
}

/* change event handler */
function flipChangedPrivateAccount(e) {
	$.ajax({url: index + "/user/changeprivateaccount",
              data: {_token: CSRF_TOKEN, action : 'change', privateaccount : this.value},
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
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });  
}

/* change event handler */
function flipChangedShowEmailInPublic(e) {
  $.ajax({url: index + "/user/showemailinpublic",
              data: {_token: CSRF_TOKEN, action : 'change', showemailinpublic : this.value},
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
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });  
}

function flipChangedPrivatePhone1(e) {
  $.ajax({url: index + "/user/changeprivatephone1",
              data: {_token: CSRF_TOKEN, action : 'change', privatephone1 : this.value},
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
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });  
}

function flipChangedPrivatePhone2(e) {
  $.ajax({url: index + "/user/changeprivatephone2",
              data: {_token: CSRF_TOKEN, action : 'change', privatephone2 : this.value},
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
                  } else {
                      alert('Something error happened!'); 
                  }
              },
              error: function (request,error) {
                  // This callback function will trigger on unsuccessful action                
                  alert('Network error has occurred please try again!');
              }
          });  
}

var loadFileEditProfile = function(event) {
		var output = document.getElementById('outputEditProfile');
		output.src = URL.createObjectURL(event.target.files[0]);
  	};

var loadFileEditFriend = function(event) {
		var output = document.getElementById('outputEditFriend');
		output.src = URL.createObjectURL(event.target.files[0]);
  	};

function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");

  //
  // *** This styling is an extra step which is likely not required. ***
  //
  // Why is it here? To ensure:
  // 1. the element is able to have focus and selection.
  // 2. if element was to flash render it has minimal visual impact.
  // 3. less flakyness with selection and copying which **might** occur if
  //    the textarea element is not visible.
  //
  // The likelihood is the element won't even render, not even a flash,
  // so some of these are just precautions. However in IE the element
  // is visible whilst the popup box asking the user for permission for
  // the web page to copy to the clipboard.
  //

  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;

  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';

  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;

  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';

  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';


  textArea.value = text;

  document.body.appendChild(textArea);

  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }

  document.body.removeChild(textArea);
}