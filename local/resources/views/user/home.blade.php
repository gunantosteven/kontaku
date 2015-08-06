<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <link href="http://jqmdesigner.appspot.com/gk/lib/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css" />
  <!-- Export CSS  -->
  <style>
    @import url(http://fonts.googleapis.com/css?family=BenchNine);
    @import url(http://fonts.googleapis.com/css?family=Poiret+One);
    @import url(http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300);
    @import url(http://fonts.googleapis.com/css?family=Archivo+Narrow);
    @import url(http://fonts.googleapis.com/css?family=Alegreya+Sans);
    @import url(http://fonts.googleapis.com/css?family=Roboto+Condensed);
    
    html,body,div[data-role="page"],.ui-content{
      height:100%;
      width:100%;
      padding:0;
      margin:0;
      text-shadow:none;
      font-family:'Roboto Condensed';
    }
    #top-b,#header1,#search,#add-icon,#list-content,#content-bg,#num-img{
      position:absolute;
      left:0;
      z-index:101;
      width:100%;
    }
    #content-bg{
      background:#fff;
      z-index:100;
      top:220px;
    }
    #top-b{
      height:8px;
      background:#a0120a;
    }
    #header1{
      background: #d01716; 
      box-shadow:0 1px 0 #b0120a; 
      margin-bottom:0px;
      height:56px;
      color:#fff;
      top:8px;
    }
    #header1 span{
      margin-top:-7px;
    }
    #header1 paper-icon-button{
      margin-top:-7px;
      fill:#fff;
    }
    #header1 paper-icon-button{
      margin:-7px -5px 0;
      fill:#fff;
    }
    #search{
      box-sizing:border-box;
      border-bottom:1px solid #eee;
      height:72px;
      overflow:hidden;
      background:#fff;
      top:64px;
    }
    #search paper-input{
      color:#ccc;
      box-sizing:border-box;
      border:none;
      padding:0 30px;
    }
    #list-content{
      position:absolute;
      top:136px;
    }
    .list1{
      height:70px;
      width:100%;
      font-size:15px;
      border-bottom:1px solid #eee;
      color:#555;
      background:#fff;
      position:absolute;
      left:0;
      -webkit-transition:color .2s,font-size .2s;
    }
    .list1:nth-child(1){
      top:0px;
    }
    .list1:nth-child(2){
      top:71px;
    }
    .list1:nth-child(3){
      top:142px;
    }
    .list1:nth-child(4){
      top:213px;
    }
    .list1:nth-child(5){
      top:284px;
    }
    .list1 div{
      width:40px;
      height:40px;
      margin:0 10px 0 10px;
      border-radius:50px;
      overflow:hidden;
      background:#ddd;
      border:3px solid #fff;
    }
    .list1 div img{
      margin-left:-5px;
      margin-top:5px;
      height:50px;
    }
    #add-icon{
      position:fixed;
      bottom:15px;
      right:15px;
      background:#d01716;
      width:40px;
      left:auto;
    }
    
    #detail{
      width:100%;
      height:100%;
      position:absolute;
      top:0;
      left:0;
      z-index:99;
      background:rgba(255,255,255,.9);
    }
    #detail-header{
      background:rgba(0,0,0,0);
      z-index:10;
      display:;
      position:relative;
      top:0;
      left:0;
      height:50px;
      padding:0;
    }
    #detail-header paper-icon-button{
      fill:rgba(255,255,255,.2);
      margin:-15px 6px 0 -5px;
      -webkit-transform:scale(.5);
    }
    #detail-header paper-icon-button:first-child{
      margin:-15px 6px 0 2px;
      -webkit-transition:.4s .1s cubic-bezier(.61,1.81,.78,.75);
    }
    #detail-header paper-icon-button:nth-child(2){
      -webkit-transition:.4s .2s cubic-bezier(.61,1.81,.78,.75);
    }
    #detail-header paper-icon-button:nth-child(3){
      -webkit-transition:.4s .3s cubic-bezier(.61,1.81,.78,.75);
    }
    #detail-header paper-icon-button:nth-child(4){
      -webkit-transition:.4s .4s cubic-bezier(.61,1.81,.78,.75);
    }
    #detail-header paper-icon-button:hover{
      fill:rgba(255,255,255,1);
    }
    #banner{
      position:absolute;
      top:0;
      left:0;
      width:100%;
      height:200px;
      overflow:hidden;
      z-index:9;
      opacity:1;
      -webkit-transition:.2s;
    }
    #banner img{
      width:100%;
      height:100%;
    }
    #detail-item{
      position:absolute;
      top:180px;
    }
    #detail-item paper-item{
      font-size:15px;
      margin:10px 10px 0 15px;
      width:100%;
      height:50px;
      opacity:0;
    }
    #detail-item paper-item b{
      display:block;
      width:60px;
      font-weight:normal;
    }
    #detail-item paper-item:nth-child(1){
      -webkit-transition:.2s .1s;
    }
    #detail-item paper-item:nth-child(2){
      -webkit-transition:.2s .2s;
    }
    #detail-item paper-item:nth-child(3){
      -webkit-transition:.2s .3s;
    }
    #detail-item paper-item:nth-child(4){
      -webkit-transition:.2s .4s;
    }
  </style>
  <!-- Load Polymer elements  -->
  <script src="http://jqmdesigner.appspot.com/components/platform/platform.js"></script>
  <link rel="import" href="http://jqmdesigner.appspot.com/components/core-icons/core-icons.html">
  <link rel="import" href="http://jqmdesigner.appspot.com/components/paper-icon-button/paper-icon-button.html">
  <link rel="import" href="http://jqmdesigner.appspot.com/components/paper-item/paper-item.html">
  <link rel="import" href="http://jqmdesigner.appspot.com/components/paper-fab/paper-fab.html">
  <link rel="import" href="http://jqmdesigner.appspot.com/components/core-toolbar/core-toolbar.html">
  <link rel="import" href="http://jqmdesigner.appspot.com/components/paper-input/paper-input.html">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <!-- Uncomment the following to include cordova in your android project -->
  <!--<script src="http://jqmdesigner.appspot.com/platforms/android/cordova.js"></script>-->
  <!-- Export JS  -->
  <script>
    (function () {
      $(document).on('pageinit', '#home', function () {
        var itemy;
        $('#content-bg').css({
          'height': ($('#home').height() - 220) + 'px'
        });
        $('.list1').on('click', function () {
          $(this).attr('show-this', 'true');
          itemy = $(this).offset().top;

          $('#top-b').fadeIn(250).animate({
            'margin-top': '-10px'
          }, {
            duration: 250,
            queue: false
          });
          $('#header1').fadeOut(250).animate({
            'margin-top': '-10px'
          }, {
            duration: 250,
            queue: false
          });
          $('#content-bg').fadeOut(250);
          setTimeout(function () {
            $('#search').fadeOut(250).animate({
              'margin-top': '-10px'
            }, {
              duration: 250,
              queue: false
            });
          }, 20);
          setTimeout(function () {
            $('#list-content .list1').not('.list1[show-this=true]').fadeOut(250).animate({
              'margin-top': '-10px'
            }, {
              duration: 250,
              queue: false
            });
            $('.list1[show-this=true]').animate({
              'top': '-45px'
            }, 250).css({
              'background': 'rgba(0,0,0,.2)',
              'color': '#fff',
              'font-size': '20px'
            });
          }, 40);
          setTimeout(function () {
            $('#add-icon').fadeOut(250).animate({
              'bottom': '0px',
            }, {
              duration: 250,
              queue: false
            });
          }, 60);

          $('#banner').css({
            'top': '-40px',
            'opacity': '1'
          });

          $('#detail-item paper-item').css({
            'margin-top': '0px',
            'opacity': '1'
          });

          $('#detail-header paper-icon-button').css({
            '-webkit-transform': 'scale(1)',
            'fill': 'rgba(255,255,255,.7)'
          });
        });

        //detail button

        $('#back-btn').on('click', function () {

          $('#top-b').fadeIn(250).animate({
            'margin-top': '0px'
          }, {
            duration: 250,
            queue: false
          });
          $('#header1').fadeIn(250).animate({
            'margin-top': '0px'
          }, {
            duration: 250,
            queue: false
          });
          $('#content-bg').fadeIn(250);
          setTimeout(function () {
            $('#search').fadeIn(250).animate({
              'margin-top': '0px'
            }, {
              duration: 250,
              queue: false
            });
          }, 20);
          setTimeout(function () {
            $('#list-content .list1').fadeIn(250).animate({
              'margin-top': '0px'
            }, {
              duration: 250,
              queue: false
            });
            $('.list1[show-this=true]').animate({
              'top': (itemy - 136) + 'px'
            }, 250);
            $('.list1').removeAttr('show-this').css({
              'background': 'rgba(0,0,0,0)',
              'color': '#333',
              'font-size': '15px'
            });
          }, 40);
          setTimeout(function () {
            $('.list1').removeAttr('show-this').css({
              'background': 'rgba(255,255,255,1)'
            });
          }, 50);
          setTimeout(function () {
            $('#add-icon').fadeIn(250).animate({
              'bottom': '15px'
            }, {
              duration: 250,
              queue: false
            });
          }, 60);

          $('#banner').css({
            'top': '0',
            'opacity': '0'
          });

          $('#detail-item paper-item').css({
            'margin-top': '10px',
            'opacity': '0'
          });

          $('#detail-header paper-icon-button').css({
            '-webkit-transform': 'scale(.5)',
            'fill': 'rgba(255,255,255,.2)'
          });
        });
		$('#left-menu a').on('click', function () {
          $('#left-menu a,#footerBtn a').removeClass('ui-btn-active');
          $('#footerBtn a').eq(0).addClass('ui-btn-active');
          $(this).addClass('ui-btn-active');
          var title = $(this).text();
          $('h3').text(title);
          var scoreGid = $(this).attr('gid');
          table.gid = scoreGid;
          table.range = '';
          table.query = '';
          table.refresh();
        });
      });
    })();
  </script>
  <title>EZo App</title>
</head>

<body unresolved touch-action="auto">
  <!-- Page: home  -->
  <div id="home" data-role="page">
    <div role="main" class="ui-content">
      <!-- contact list  -->
      <div id="top-b"></div>
      <div data-role="header"  data-theme="b" id="header1">
	      <h3>All Contacts</h3>
	      <a  class="ui-btn ui-btn-left ui-btn-icon-notext ui-icon-bars ui-mini ui-corner-all" href="#left-menu">Button</a>
	      <a href="#add-form" data-icon="plus" data-iconpos="notext">Add</a>
	  </div>
      <div id="left-menu" data-role="panel" data-position="left" data-theme="b" data-position-fixed="false" data-display="overlay">
	      <span>Menu</span>
	      <a class="ui-btn ui-icon-home ui-btn-icon-left ui-btn-active" data-theme="b" data-rel="close" gid="0">Home</a>
	      <a class="ui-btn ui-icon-user ui-btn-icon-left" data-theme="b" data-rel="close" gid="0">My Profile</a>
	      <a class="ui-btn ui-icon-plus ui-btn-icon-left" data-theme="b" data-rel="close" gid="0">Invites</a>
	      <a class="ui-btn ui-icon-gear ui-btn-icon-left" data-theme="b" data-rel="close" >Settings</a>
	      <a class="ui-btn ui-icon-alert ui-btn-icon-left" data-theme="b" data-rel="close" >Reports a Problem</a>
	      <a class="ui-btn ui-icon-info ui-btn-icon-left" data-theme="b" data-rel="close" >Help</a>
  	  </div>
      <div id="search">
        <paper-input label="Serch All Contact" multiline style="z-index:9;"></paper-input>
      </div>
      <div id="list-content">
        <paper-item horizontal center layout class="list1">
          <div>
            <img src="https://lh6.googleusercontent.com/-KyWnYxFqQhM/U7u7wdxR2AI/AAAAAAAA6AE/_5oTbJ7utwo/s000/OZSun_10s.png">
          </div><b>OXXO</b>&nbsp;Chang</paper-item>
        <paper-item horizontal center layout class="list1">
          <div>
            <img src="https://lh5.googleusercontent.com/-3BxoPIP1Cvs/U7u7xDnV87I/AAAAAAAA6AY/WiJXv9nS6oo/s800/OZSun_33s.png">
          </div><b>Robert</b>&nbsp;Downey Jr.</paper-item>
        <paper-item horizontal center layout class="list1">
          <div>
            <img src="https://lh6.googleusercontent.com/-g_kx9qTa4Tk/U7u7xLN2peI/AAAAAAAA6Ac/rXkMa7tT2Ik/s800/OZSun_27s.png">
          </div><b>Hugh</b>&nbsp;Jackman</paper-item>
        <paper-item horizontal center layout class="list1">
          <div>
            <img src="https://lh6.googleusercontent.com/-KQioaQrjEVE/U7u7wfHFkAI/AAAAAAAA6AQ/PGYD1yXXwco/s800/OZSun_1s.png">
          </div><b>Chris</b>&nbsp;Evans</paper-item>
        <!--<paper-item horizontal center layout class="list1">-->
        <!--  <div>-->
        <!--    <img src="https://lh5.googleusercontent.com/-wuYZOcgmD-Q/U7u7wdyAJ0I/AAAAAAAA6AM/RWDZgC1VYS0/s000/OZSun_19s.png">-->
        <!--  </div><b>Scarlett</b>&nbsp;Johansson</paper-item>-->
      </div>
	  <div data-role="header">
	    <h1>Page Header</h1>
	  </div>
      <div id="content-bg"></div>
      <!-- contact list  -->
      <div id="detail">
        <div id="detail-header">
          <div style="float:left;">
            <core-toolbar>
              <paper-icon-button icon="arrow-back" role="button" tabindex="0" style="float:left;" id="back-btn"></paper-icon-button>
            </core-toolbar>
          </div>
          <div style="float:right;">
            <core-toolbar>
              <paper-icon-button icon="create" role="button" tabindex="0" style="float:right;"></paper-icon-button>
              <paper-icon-button icon="polymer" role="button" tabindex="0" style="float:right;"></paper-icon-button>
              <paper-icon-button icon="favorite" role="button" tabindex="0" style="float:right;"></paper-icon-button>
            </core-toolbar>
          </div>
        </div>
        <div id="banner">
          <img src="https://lh4.googleusercontent.com/-6DB_Qbs7xO4/U7uVbbLfWGI/AAAAAAAA5_c/d0s4_syNArk/s000/google.jpg">
        </div>
        <div id="detail-item">
          <paper-item icon="settings-cell" horizontal center layout><b>PHONE</b>：0912-345-678</paper-item>
          <paper-item icon="settings-phone" horizontal center layout><b>TEL</b>：886-07-5350101</paper-item>
          <paper-item icon="mail" horizontal center layout><b>E-MAIL</b>：XXX@acb.com.tw</paper-item>
          <paper-item icon="settings" horizontal center layout><b>GOOGLE+</b>：XXX@google.com</paper-item>
        </div>
      </div>
    </div>
    <div data-role="panel" data-position="right" data-position-fixed="false" data-display="overlay" id="add-form" data-theme="b">

					<form class="userform">
						<h2>Create new user</h2>
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
  </div>
</body>

</html>
