@extends('client.layouts.app')
@section('content')

    <!--<img src="{{url('public/img/contactusbanner.jpg')}}" style="width:100%;height:100px;" >-->
	
    <div class="contact-form">
        <!--<br><h1 class="text-center">Contact us</h1><hr><br>-->
        @if (Session::has('success'))
            <div class="container">
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
            </div>
        @endif
        <br><br>
        <div class="contactForm container">
		<h3 class="text-center"> {{ trans('contact/contact.contact-us') }}
                <hr>
            </h3>
            <br>
			
            <div class="form-card">
                
                    <div class="row">
						<div class="col-md-6">
						<form role="form" method="post" action="{{route('send-email')}}" autocomplete="off">
                    @csrf
							<h5>{{ trans('contact/contact.feel_free_to_message') }}</h5><br>
                            <div class="form-group">
                                <input type="text" name="name" class="my_form-control  center-block"
                                        required>
                                <small class="my_place">{{ trans('contact/contact.name') }}</small>
                            </div>

               
                  
                            <div class="form-group">
                                <input type="email" name="email" class="my_form-control  center-block"
                                       required>
                                <small class="my_place">{{ trans('contact/contact.email') }}</small>
                            </div>

                   
                 
                            <div class="form-group">
                                <input type="text" name="subject" class="my_form-control  center-block"
                                        required>
                                <small class="my_place">{{ trans('contact/contact.topic') }}</small>
                            </div>
	
                  
                  
                            <div class="form-group">
                                <input type="text" name="phone" class="my_form-control  center-block"
                                        required>
                                <small class="my_place">{{ trans('contact/contact.phone') }}</small>
                            </div>
			
                     
                       
						
                            <div class="form-group">
                            <textarea type="text" name="message" class="my_form-control  center-block"
                                       rows="3" required></textarea>
									  <small class="my_place">{{ trans('contact/contact.message') }}</small>
                            </div>
							
                       
                   
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary mt-3 mx-auto">
                                    {{ trans('contact/contact.send') }}
									
									</button>
                            </div>
							 </form>
                          </div>


						<div class="col-md-6">
						<h5>{{ trans('contact/contact.our-address') }}</h5><br>
						<table>
						<tr>
						<td class="td-space">
						<p>
						<b>{{ trans('contact/contact.us-office') }}</b><br>
						@if(app()->getLocale() != "ar")
						Easy trademarks LLC.<br>
						@endif
						{{ trans('contact/contact.us-address-line1') }}<br>
						{{ trans('contact/contact.us-address-line2') }}<br>
						</p>
						</td>
						<td>
						<p>
						<b>{{ trans('contact/contact.egypt-office') }}</b><br>
						@if(app()->getLocale() != "ar")
						Easy trademarks LLC.<br>
						@endif
						{{ trans('contact/contact.egy-address-line1') }}<br>
						{{ trans('contact/contact.egy-address-line2') }}<br>
						</p>
						</td>
						</tr>
						</table>
						
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1271.6896138959432!2d-74.00792262010815!3d40.704703450439375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a161aaa68c5%3A0x7326c6b80e0fc527!2s99%20Wall%20St%2C%20New%20York%2C%20NY%2010005%2C%20USA!5e0!3m2!1sen!2seg!4v1617164833632!5m2!1sen!2seg" width="100%" height="250" style="border:0;" allowfullscreen></iframe>
						</div>
						
					     
                       
					


					
					
               
            </div>
        </div>
		<br><br>
    </div>
	

@endsection
