Hello @if($email->name)
   {{ $email->name }}
@else
   Customer
@endif
<p>Thank you for using our platform to help you understand how strong your trademark is. </p>
<p>The result of your survey shows that your trademark is; </p>
@if($email->finalMessage)
<p>
   your survey result message is : {{$email->finalMessage}}
</p>
@endif
@if($email->scoreMessage)
   <p>
   	your survey score message is : {{$email->scoreMessage}}
   </p>
@endif
@if($email->slider)
   <p>
   	your guess about how your trademark strength is : {{ $email->slider }}%
   </p>
@endif
@if($email->scorePercentage)
   <p>
   	your survey strength percentage is : {{ $email->scorePercentage }}%
   </p>
@endif
<p>Should you wish to have a one on one consultation to empower your brand further, please feel free to reach out to client our customer excellence representative Nada who would love to assist you on your journey.  </p>
<br>
Nada,
<br>
Email: help@easy-trademarks.com
<br>
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
