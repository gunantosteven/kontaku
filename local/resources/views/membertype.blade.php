@extends('app')

@section('content')
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
                <td>Cost</td>
                <td>FREE</td>
                <td>IDR 50.000, 00</td>
                <td>IDR 100.000, 00</td>
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

          <p> After you transfer send SMS Format : <b>YourURL MemberTypeYouChoose TransferAccountName</b> 
          <br> Example : <b>kontakku.com/stevengunanto BOSS Steven Gunanto</b>
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