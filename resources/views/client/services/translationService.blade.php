@extends('client.layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="steper">
                        <div class="card">
                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('error') }}</p>
                                </div>
                            @endif
                            <form id="msform" role="form" method="post"
                                  action="{{ route('storeTranslationDocuments',$orderId) }}"
                                  enctype="multipart/form-data"
                                  autocomplete="off">
                                @csrf
                                <input type="hidden" name="orderId" value="{{$orderId}}">
                                <fieldset>
                                    <h2 id="heading">Translation Service</h2>
                                    <hr>
                                    <br><br>
                                    <div class="form-card">
                                        <div class="contactForm row">
                                            <br><br>
                                            <div class="col-md-6">
                                                <div class="continer">
                                                    <!--<div class="form-group text-left">
                                                        <span class="NOD-checkout-btn">Number of Doc </span>
                                                        <input type="number" class="NOD text-center" placeholder="Type"
                                                               name="numberOfDoc" required>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>-->
                                                    <div class="form-group text-left">
                                                        <span class="NOD-checkout-btn">Num. of Pages </span>
                                                        <input type="number" class="NOD text-center" placeholder="Type"
                                                               name="numberOfPages" id="numberOfPages" min="1" max="100" onchange="cal_fees()" 
															   onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required>
                                                        <small class="my_place">
                                                        </small>
                                                    </div>
                                                    @if (count($errors) > 0)
                                                        <div class="alert alert-danger">
                                                            <strong>Sorry!</strong> There were invalid file extensions
                                                            you try to upload.<br><br>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        Documents
                                                        <input type="file" name="Document[]" id="Document" multiple required
                                                               class="my_form-control center-block" onchange="Filevalidation()" placeholder="Type"
                                                               accept="application/pdf,application/vnd.ms-excel,application/msword"/>
															   <p id="size"></p>
                                                        <small class="my_place"> </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="continer">
                                                   <!-- <div class="form-group">
                                                        Is there any addition?
                                                        <br><br>
                                                        <textarea rows="4" name="note" style="background: #f5f4f4"
                                                                  class="my_form-control center-block" id=""
                                                                  placeholder="Limit to 3 senteces"></textarea>
                                                        <small class="my_place"> </small>
                                                    </div>-->
                                                </div>
                                            </div>
                                               </div>
											   <input type="submit" class=" action-button text-center" value="Upload"/>
											   <br><br>
											   <hr>
											   <div class="row">
											   <div class="col-md-6">
											   </div>
											   
											   <div class="col-md-6">
											   <span>Sub-Total:</span><span style="float:right;" id="subtot">00.00 $</span><br>
											   <span>Payment Processing Fees:</span><span style="float:right;" id="stripefee">00.00 $</span><br>
											   <span>Total:</span><span style="float:right;" id="total">00.00 $</span><br>
											   </div>
											   
											   </div>											    
											   <p class="required-p float-left"><br><br>This is a paid service. Each
												translation cost <span class="required-a">$20/ per page</span>. You will
												be transferred to billing page.</p>
									<p class="required-p float-left">Additional Payment Processing Fees (3.5%) are added into total amount</p>
                                    </div>
                                   

                                   
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </main>
	
	<script>
	var oldValue = "";
		// listen for "input" event, since that handles all keypresses as well as cut/paste
		document.getElementById("numberOfPages").addEventListener('input', function (event) {
		  var input = event.target;
		  if (validateInput(input.value)) {
			// update old value with new value
			oldValue = input.value;
		  }
		  else {
			// set value to last known valid value
			input.value = oldValue;
		  }
		});

		function validateInput(str) {
		  // check length, if is a number, if is whole number, if no periods
		  return /^[0-9]{0,3}$/.test(str);
		}
		
		 Filevalidation = () => {
        const fi = document.getElementById('Document');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
 
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= 4096) {
					 document.getElementById('size').innerHTML = '<i style="color:red;">File too Big, please select a file less than 2mb</i>';
					 document.getElementById('Document').value = '';
                } else {
                    document.getElementById('size').innerHTML = '<b>'
                    + file + '</b> KB';
                }
            }
        }
    }
	
	
	function cal_fees(){
		var pageNo = document.getElementById("numberOfPages").value;
		var subTot = pageNo * 20 ;
		var stripeRate = (subTot * 3.5) / 100 ;
		var tot = subTot + stripeRate;
		
		document.getElementById('subtot').innerHTML = subTot + ' $';
		document.getElementById('stripefee').innerHTML = stripeRate + ' $';
		document.getElementById('total').innerHTML = tot + ' $';
	}
	
	</script>
@endsection
