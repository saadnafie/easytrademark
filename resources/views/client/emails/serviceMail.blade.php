<!DOCTYPE html>
<html>
<head>
   <title></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
   <style type="text/css">
   	@media screen {
       	@font-face {
           	font-family: 'Lato';
           	font-style: normal;
           	font-weight: 400;
           	src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
       	}
       	@font-face {
           	font-family: 'Lato';
           	font-style: normal;
           	font-weight: 700;
           	src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
       	}
       	@font-face {
           	font-family: 'Lato';
           	font-style: italic;
           	font-weight: 400;
           	src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
       	}
       	@font-face {
           	font-family: 'Lato';
           	font-style: italic;
           	font-weight: 700;
           	src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
       	}
   	}
   	/* CLIENT-SPECIFIC STYLES */
   	body,
   	table,
   	td,
   	a {
       	-webkit-text-size-adjust: 100%;
       	-ms-text-size-adjust: 100%;
   	}
   	table,
   	td {
       	mso-table-lspace: 0pt;
       	mso-table-rspace: 0pt;
   	}
   	img {
       	-ms-interpolation-mode: bicubic;
   	}
   	/* RESET STYLES */
   	img {
       	border: 0;
       	height: auto;
       	line-height: 100%;
       	outline: none;
       	text-decoration: none;
   	}
   	table {
       	border-collapse: collapse !important;
   	}
   	body {
       	height: 100% !important;
       	margin: 0 !important;
       	padding: 0 !important;
       	width: 100% !important;
   	}
   	/* iOS BLUE LINKS */
   	a[x-apple-data-detectors] {
       	color: inherit !important;
       	text-decoration: none !important;
       	font-size: inherit !important;
       	font-family: inherit !important;
       	font-weight: inherit !important;
       	line-height: inherit !important;
   	}
   	/* MOBILE STYLES */
   	@media screen and (max-width: 600px) {
       	h1 {
           	font-size: 32px !important;
           	line-height: 32px !important;
       	}
   	}
   	/* ANDROID CENTER FIX */
   	div[style*="margin: 16px 0;"] {
       	margin: 0 !important;
   	}
   </style>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
<div
   style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
  Thank you for choosing Easytrademarks.
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
   <!-- LOGO -->
   <tr>
   	<td bgcolor="#4B57FF" align="center">
       	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
           	<tr>
               	<td align="center" valign="top" style="padding: 40px 10px 40px 10px;"></td>
           	</tr>
       	</table>
   	</td>
   </tr>
   <tr>
   	<td bgcolor="#4B57FF" align="center" style="padding: 0px 10px 0px 10px;">
       	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
           	<tr>
               	<td bgcolor="#ffffff" align="center" valign="top"
                   	style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                   	<h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1> <img
                       	src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120"
                       	style="display: block; border: 0px;"/>
               	</td>
           	</tr>
       	</table>
   	</td>
   </tr>
   <tr>
   	<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
       	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
           	<tr>
               	<td bgcolor="#ffffff" align="left"
                   	style="padding: 20px 20px 20px 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; margin-bottom:20px !important;">
 <p style="margin: 0;">
     <br>
     <h4 style="color:red">ACTION REQUIRED.</h4><br>
 Hello {{$email->user_name}},
<br><br>
 Thank you for using our platform and Welcome. We are excited to have you here and share this journey with you.
 <br>
 We have received your order, please click on the link below to complete your payment. 
 </p>
               	</td>
           	</tr>
           	@if(isset($email->order_number) && $email->order_number != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; margin-bottom:0px !important;">
                       	<p>
                           	order Number : {{$email->order_number}}
                       	</p>
                   	</td>
               	</tr>
           	@endif
            @if(isset($email->tm_ref) && $email->tm_ref != null)
                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                        <p>
                            trademark reference: {{ $email->tm_ref }}
                        </p>
                    </td>
                </tr>
            @endif
           	@if(isset($email->trademark_label) && $email->trademark_label != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<p>
                           	trademark Label: {{ $email->trademark_label }}
                       	</p>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->trademark_word_en) && $email->trademark_word_en != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<p>
                           	trademark word english: {{ $email->trademark_word_en }}
                       	</p>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->trademark_word_ar) && $email->trademark_word_ar != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	trademark word arabic: {{ $email->trademark_word_ar }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
            @if(isset($email->country_name) && $email->country_name != null)
                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; margin-bottom:0px !important;">
                        <p>
                            Country: {{ $email->country_name }}
                        </p>
                    </td>
                </tr>
            @endif
           	@if(isset($email->class) && $email->class != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; margin-bottom:0px !important;">
                       	<p>
                           	class: {{ $email->class }}
                       	</p>
                   	</td>
               	</tr>
           	@endif

   @if(isset($email->filling_number) && $email->filling_number != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Filling Number : {{ $email->filling_number}}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->filling_date) && $email->filling_date != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Filling Date : {{ $email->filling_date }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->assignor_name) && $email->assignor_name != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Assignor Name : {{ $email->assignor_name }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->assignor_address) && $email->assignor_address != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Assignor Address : {{ $email->assignor_address }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->assignee_name) && $email->assignee_name != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Assignee Name: {{ $email->assignee_name }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->assignee_address) && $email->assignee_address != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Assignee Address : {{ $email->assignee_address }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->old_name) && $email->old_name != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Old Name : {{ $email->old_name }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->new_name) && $email->new_name != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	New Name : {{ $email->new_name }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->isArabic) && $email->isArabic != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	is Arabic : {{ $email->isArabic }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->explanation) && $email->explanation != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Explanation : {{ $email->explanation }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->brief) && $email->brief != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	brief : {{ $email->brief }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->OneClass) && $email->OneClass != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Class : {{ $email->OneClass }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->serviceDescription) && $email->serviceDescription != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	service Description : {{ $email->serviceDescription }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->old_address) && $email->old_address != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	Old Address : {{ $email->old_address }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->new_address) && $email->new_address != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<h5>
                           	New Address : {{ $email->new_address }}
                       	</h5>
                   	</td>
               	</tr>
           	@endif
           	@if(isset($email->total_fees_currency) && $email->total_fees_currency != null)
               	<tr>
                   	<td bgcolor="#ffffff" align="left"
                       	style="padding: 20px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;margin-bottom:0px !important;">
                       	<p>
                           	Total Fees : {{ $email->total_fees_currency .' '. $email->userCountryCurrencyCode}}
                       	</p>
                   	</td>
               	</tr>
           	@endif
            <tr>
                <td bgcolor="#ffffff" align="left"
                    style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                    <p style="margin: 0;"><b style="color:red;">Deadline to settle fees:</b> {{Carbon\Carbon::now()->addDays(7)}}</p>
                    <p style="margin: 0;"><b style="color:red;">Link to complete the order and settle your fees:</b> <a href="{{url('checkoutDetails/')}}/{{$email->tm_id}}/{{$email->order_id}}" >Click here!</a></p>
                    <b style="color:red;">This is a non-reply email.</b>
                  </td>
              </tr>
           	<tr>
               	<td bgcolor="#ffffff" align="left"
                   	style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;">
                   	<p style="margin: 0;">Should you need any help getting started please send an email to our client excellence representative Nada who would love to join you on your journey. </p>
               	</td>
           	</tr>

                    <tr>
                <td bgcolor="#ffffff" align="left"
                    style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                   	<p style="margin: 0;">
                   	<br>
                    Nada,
                    <br>
                    Email: help@easy-trademarks.com
                     <br>
                    Phone: 002-01553760719
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
                   	</p>
               	</td>
           	</tr>
       	</table>
   	</td>
   </tr>
</table>
</body>
</html>
