<p>
Hello {{$user_name}},
</p>
<p>
A new document has been posted by our Intellectual property professionals relating to your trademark. Please log in to your account to view the updates, 
or <a href="{{url('trademarks').'/'.Illuminate\Support\Facades\Crypt::encryptString($trademark_id) }}">click here</a>
</p>
<p>
Trademark Name: {{$trademark_label}}
</p>
<p>
Trademark Reference Number: {{$trademark_ref}}
</p>
<br>
<p>
<b style="color:red;">This is a non-reply email.</b><br>
</p>
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