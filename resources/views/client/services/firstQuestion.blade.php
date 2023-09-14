@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
				<br><br>
                    <!--<div class="steper">-->
                        <div class="card" style="padding:40px;">
						<h2 id="heading" style="border-bottom:3px solid #eee;padding:10px;">
								{{ trans('servicelable/servicelable.have-you-ordered') }}
                                </h2>
								<br>
                                <!--<hr>-->
						 <div class="row">
                            <div class="col-md-6" style="border-right: 3px solid #eee;position: relative;">
                            <form id="msform" role="form" method="post" action="{{route('redirectServiceProcess')}}"
                                  autocomplete="off">
                                @csrf
                                <input name="countryPackageFeesID" type="hidden" value="{{ $countryPackageFees }}">
                                <input name="packageId" type="hidden" value="{{ $packageId }}">
                                <input name="serviceId" type="hidden" value="{{ $serviceId }}">
                                <input name="countryId" type="hidden" value="{{ $countryId }}">
                                
                                <div class="form-card">
                                   
                                            <br><br>
                                            <label style="font-size:25px;">
											 <input style="width:20px;width:1em;height:1em;" type="radio"
                                                       name="existingTrademarkLabel" 
                                                       {{sizeof($existingTrademarks) == 0  ? 'checked' : ''}}
                                                       id="NoTrademark"
                                                       value="no"
                                                       onclick="newTrademarkFunction();" checked>
													   
											{{ trans('servicelable/servicelable.new-trademark') }}&nbsp;
											 <span style="position: absolute" data-toggle="tooltip"
                                                      title="this is a new trademark which I have not used easy trademarks to service before">
                                                            <i class="circle-input-validation fa fa-exclamation-circle"
                                                               aria-hidden="true"></i>
                                                        </span>
                                                </label>
												<br><br>

											<div id="trademarkLabelId" style="display: none;">
                                                {{ trans('servicelable/servicelable.set-title-trademark') }}
                                                <input type="text" name="newTrademarkLabel"
                                                       class="my_form-control center-block " maxlength="20"
                                                       id="labelOfNewTrademark" placeholder="{{ trans('servicelable/servicelable.trademark-label') }}"
                                                       onkeyup="TrademarkLabelFunction()" onkeydown="TrademarkLabelFunction()"
                                                       value=""/>
                                                <small class="my_place">
                                                </small>
                                            </div>
											
											<input type="submit" class="action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                       style="pointer-events:none;background:#eee;" id="NewTrademarkBtn"/>
								</div>	
								</form>
                             </div>
									
							<div class="col-md-6">
									<form  id="msform" method="get" action="{{route('existTrademark')}}" >
										{{--@csrf--}}
                                <input name="countryPackageFeesID" type="hidden" value="{{ $countryPackageFees }}">

								<div class="form-card">
										 <br><br>
                                            <label style="font-size:25px;">
											 <input style="width:20px;width:1em;height:1em;" type="radio"
                                                       name="existingTrademarkLabel"
                                                       id="hasTrademark"
                                                       value="yes"
                                                       onclick="existingTrademarkFunction();TrademarkLabelFunction()" >
                                                    {{ trans('servicelable/servicelable.existing-trademark') }}&nbsp;
                                                <span style="position: absolute" data-toggle="tooltip"
                                                      title="this is an existing trademark which you have order different services in the same jurisdiction, or same services in different jurisdictions, or different classes in the same or different jurisdictions. ">
                                                                <i class="circle-input-validation fa fa-exclamation-circle"
                                                                   aria-hidden="true"></i>
												</span>
                                           </label>
                                            <br><br>
                                            <div id="trademarks" style="display: none">
											Select Trademark from list:
                                                <select name="existingTrademarkId" id="existingTrademark"
                                                        class="my_form-control " style="width:100%"
                                                        onchange="existingTrademarkFunction()">
                                                    @foreach($existingTrademarks as $trademark)
                                                        <option
                                                            value="{{ $trademark->id  }}">{{ $trademark->trademark_label   }}  </option>
                                                    @endforeach
                                                </select>
                                            </div>
            
                                <input type="submit"  class="action-button" value="{{ trans('servicelable/servicelable.next') }}"
                                       style="display:none;" id="ExistTrademarkBtn"/>
                                </div>
							</form>
                        </div>
                    </div>
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p style="text-align: center">{{ trans('servicelable/servicelable.login-to-access-exist-trademark') }}</p>
                                    <form action="{{route('forceUserLogin')}}" method="get">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="intendedUrl"
                                                   name="intendedUrl" value="{{ Request::url() }}">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            <!--</div>-->
			<br><br>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
			/*document.getElementById('NoTrademark').checked = true;
			document.getElementById('trademarkLabelId').style.display = 'block';
			document.getElementById('NewTrademarkBtn').style.display = 'block';*/
				
			
			
			/*if (document.getElementById('hasTrademark').checked) {
            document.getElementById('trademarks').style.display = 'block';
        } else {
            document.getElementById('trademarks').style.display = 'none';
			
        }*/
			
			
			
        });
		window.addEventListener("pageshow", () => {
  // update hidden input field
  document.getElementById('hasTrademark').checked = false;
});
    </script>
    <script>
	   
        if (document.getElementById('hasTrademark').checked) {
            document.getElementById('trademarks').style.display = 'block';
        } else {
            document.getElementById('trademarks').style.display = 'none';
			
        }
		
		
        //-----------------------------------Exist TM-------------------------------------------------
        function existingTrademarkFunction() {
            let existingTrademark = document.getElementById('existingTrademark').value;
            if (document.getElementById('hasTrademark').checked) {
                if (auth_user == 'false') {
                    $('#myModal').modal('show')
					document.getElementById('labelOfNewTrademark').value = '';
				document.getElementById('NoTrademark').checked = false;
			    document.getElementById('trademarkLabelId').style.display = 'none';
				document.getElementById('NewTrademarkBtn').style.display = 'none';
                }else{
                document.getElementById('trademarks').style.display = 'block';
				document.getElementById('ExistTrademarkBtn').style.display = 'block';
				
                document.getElementById('labelOfNewTrademark').value = '';
				document.getElementById('NoTrademark').checked = false;
			    document.getElementById('trademarkLabelId').style.display = 'none';
				document.getElementById('NewTrademarkBtn').style.display = 'none';
				}
                if (existingTrademark.length > 0) {
                    document.getElementById("NewTrademarkBtn").style.pointerEvents = 'auto';
                    document.getElementById("NewTrademarkBtn").style.background = '#4B57FF';
                } else {
                    document.getElementById("NewTrademarkBtn").style.pointerEvents = 'none';
                    document.getElementById("NewTrademarkBtn").style.background = '#eee';
                }
            } else {
                document.getElementById('trademarks').style.display = 'none';
            }
        }
		
		//-----------------------------------New TM-------------------------------------------------
		function newTrademarkFunction() {
            if (document.getElementById('NoTrademark').checked) {
                document.getElementById('trademarkLabelId').style.display = 'block';
				document.getElementById('NewTrademarkBtn').style.display = 'block';
                document.getElementById("NewTrademarkBtn").style.pointerEvents = 'none';
                document.getElementById("NewTrademarkBtn").style.background = '#eee';
				
                //document.getElementById('trademarks').value = '';
				document.getElementById('hasTrademark').checked = false;
				document.getElementById('trademarks').style.display = 'none';
				document.getElementById('ExistTrademarkBtn').style.display = 'none';
				}
        }
		
		

        let existingTrademark = document.getElementById('existingTrademark').value;
        if (document.getElementById('hasTrademark').checked) {
            document.getElementById('trademarks').style.display = 'block';
            if (existingTrademark.length > 0) {
                document.getElementById("NewTrademarkBtn").style.pointerEvents = 'auto';
                document.getElementById("NewTrademarkBtn").style.background = '#4B57FF';
            } else {
                document.getElementById("NewTrademarkBtn").style.pointerEvents = 'none';
                document.getElementById("NewTrademarkBtn").style.background = '#eee';
            }
        } else {
            document.getElementById('trademarks').style.display = 'none';
        }

        function TrademarkLabelFunction() {
            let TrademarkLabel = document.getElementById('labelOfNewTrademark').value;
            if (document.getElementById('NoTrademark').checked) {
                //document.getElementById('existingTrademark').value = '';
                document.getElementById('trademarkLabelId').style.display = 'block';
                if (TrademarkLabel.length > 0) {
                    document.getElementById("NewTrademarkBtn").style.pointerEvents = 'auto';
                    document.getElementById("NewTrademarkBtn").style.background = '#4B57FF';
                } else {
					console.log('check validation');
                    document.getElementById("NewTrademarkBtn").style.pointerEvents = 'none';
                    document.getElementById("NewTrademarkBtn").style.background = '#eee';
                }
            } else {
                document.getElementById('trademarkLabelId').style.display = 'none';
            }
        }

        let TrademarkLabel = document.getElementById('labelOfNewTrademark').value;
        if (document.getElementById('NoTrademark').checked) {
            document.getElementById('trademarkLabelId').style.display = 'block';
            if (TrademarkLabel.length > 0) {
                document.getElementById("NewTrademarkBtn").style.pointerEvents = 'auto';
                document.getElementById("NewTrademarkBtn").style.background = '#4B57FF';
            } else {
                document.getElementById("NewTrademarkBtn").style.pointerEvents = 'none';
                document.getElementById("NewTrademarkBtn").style.background = '#eee';
            }
        } else {
            document.getElementById('trademarkLabelId').style.display = 'none';
        }
    </script>
@endsection
