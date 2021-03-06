@extends('app')

@section('content')
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67268716-2', 'auto');
  ga('send', 'pageview', 'membertype');
</script>
<div id="main-content">
  <div class="row">
    <h1>Member Type</h1>
    <div class="col-md-8 col-md-offset-2 text-left">
          <p>In Kontakku there are three member types <b>MEMBER, PREMIUM</b>, and <b>BOSS.</b>

          <p>The difference amongst them are :</p>

          <table class="table">
            <thead>
              <tr>
                <th></th>
                <th>MEMBER</th>
                <th>PREMIUM</th>
                <th>BOSS</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Color Name</td>
                <td>Black</td>
                <td>Green</td>
                <td>Blue</td>
              </tr>
              <tr>
                <td>Badge</td>
                <td><span class="label label-default">MEMBER</span></td>
                <td><span class="label label-success">PREMIUM</span></td>
                <td><span class="label label-primary">BOSS</span></td>
              </tr>
              <tr>
                <td>Limit Contacts</td>
                <td>250</td>
                <td>500</td>
                <td>1000</td>
              </tr>
              <tr>
                <td>Limit Notes</td>
                <td>5</td>
                <td>50</td>
                <td>100</td>
              </tr>
              <tr>
                <td>Cost</td>
                <td>FREE</td>
                <td>$5 / IDR 50.000, 00</td>
                <td>$10 / IDR 100.000, 00</td>
              </tr>
            </tbody>
          </table>

          <p>
          ** Valid during the promotion period until 1 Agustus 2016.<br>
          * The registration fee is not refundable.
          * We do not charge a membership fee regularly, either monthly fees, annual fees, and renewal fees.
          </p>

          <p><b>Payment Method</b></p>
          <img src="{{ url("/img/logo-bca.png") }}" alt="" width="128px" height="40px" />
          <p><b>7290109552 a/n Steven Gunanto</b></p>

          <p> After you transfer, send SMS / Whatsapp Format : <b>YourURL MemberTypeYouChoose TransferAccountName</b> 
          <br> Example : <b>kontakku.com/stevengunanto BOSS Steven Gunanto</b>
          <br> Send to +6283854968000 or 083854968000. </p>

          <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_150x38.png" alt="Buy now with PayPal" />
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="QREWY3LXC7USC">
			<table>
			<tr><td><input type="hidden" name="on0" value="TYPE MEMBER">TYPE MEMBER</td></tr><tr><td><select name="os0">
				<option value="PREMIUM">PREMIUM $5,00 USD</option>
				<option value="BOSS">BOSS $10,00 USD</option>
			</select> </td></tr>
			</table>
			<input type="hidden" name="currency_code" value="USD">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		  </form><br>

          <p> After you transfer, send SMS / Whatsapp Format : <b>YourURL MemberTypeYouChoose EmailTransfer</b> 
          <br> Example : <b>kontakku.com/stevengunanto BOSS gunantosteven@gmail.com</b>
          <br> Send to +6283854968000 or 083854968000. </p>

          


          <p> If you require any more information or have any questions about our member type, please feel free to contact us by email at <a href="&#109;&#97;&#105;&#108;&#x74;&#x6f;&#58;&#115;&#x75;&#x70;&#x70;&#111;&#114;&#x74;&#64;&#x6b;&#111;&#110;&#116;&#x61;&#x6b;&#x6b;&#x75;&#x2e;&#99;&#111;&#x6d;">&#115;&#x75;&#x70;&#x70;&#111;&#114;&#x74;&#64;&#x6b;&#111;&#110;&#116;&#x61;&#x6b;&#x6b;&#x75;&#x2e;&#99;&#111;&#x6d;</a>.</p>
  </div>
</div>
@if (isset($error) && $error === true)
<script>
  window.alert('Error, maybe you have invited this contact. \nTry to check your contact list or invitation.');
</script>
@endif
@endsection