<p>
Hello {{$user_name}},
</p>
<p>
You are one step closer to protecting your trademark. 
<br>
Your trademark response has been updated. 
</p>
<p>
Trademark Response: {{ $response }}
</p>
<p>
Trademark Reference: {{ $tm_ref }}
</p>
<p>
Trademark Label: {{ $tm_label }}
</p>



@if($publication != '')
<p>
click on the link: <a href="{{ $publication }}">Publication Service Link</a>
to settle the publication fees, and complete your registration process.
</p>
@endif

@if($finalregistration != '')
<p>
click on the link <a href="{{ $finalregistration }}">Final Registration Service Link</a>
to settle the Registration fees.
</p>
@endif

<p>
Order number: {{ $order_number }}
</p>
<p>
Order Country: {{ $order_country }}
</p>
<p>
Order Status: {{ $order_status }}
</p>
<p>Login to check your updates.</p>
<p>
<b style="color:red;">This is a non-reply email.</b><br>
</p>


@if($publication != '')
<p>
Trademark Publication Service Link: {{ $publication }}
</p>
@endif

@if($finalregistration != '')
<p>
Trademark Final Registration Service Link: {{ $finalregistration }}
</p>
@endif

<br>
Should you have any questions, please send an email referencing your order number to your client representative. 
<br>
@if($rep_username != null)
{{$rep_username}}
<br>
{{$rep_email}}
<br>
@else
Nada,
<br>
Email: help@easy-trademarks.com
<br>
Phone: 002-01553760719
<br>
@endif
<a href="https://www.linkedin.com/company/easytrademarks/" target="_blank">
	<img src="https://easy-trademarks.com/public/assets/img/hero/linkedin.png" alt="linkedin icon" width="40" height="40">
</a>
<a href="https://twitter.com/easytrademarks" target="_blank">
	<img src="https://easy-trademarks.com/public/assets/img/hero/twitter.png" alt="facebook icon" width="40" height="40">
</a>
<br>
<b>www.easy-trademarks.com</b> 
<br>
Empowering <span style="color:blue;">innovation</span>