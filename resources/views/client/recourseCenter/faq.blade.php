@extends('client.layouts.app')
@section('content')



<style>
        .highlight{
		color:red;
		background-color: yellow;
		}
		
#search_para
{
 color:grey;
}
.highlight1
{
 color:blue;
 text-decoration:underline;
}
    </style>
    <div class="faq">
        <div class="container">
            <br><br><br>
            <h4 class="text-center"> {{ trans('home/app.faq') }}
                <hr>
            </h4>
            <br><br>
            <div class="container">
                <div class="input-group mb-3 input-group-lg">
                  <input type="text"  class="form-control modal_search"  placeholder="Search.."  onkeyup="search()" id="myFilter"> <!-- onkeyup="myFunction" id="myFilter" id="x"-->
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                  </div>
                </div>
                <div class="row"  > <!-- id="myItems" id="textModal_x"-->
                    <div class="col-md-12" id="myItems">
                    @foreach ($faqs as $key => $data)
                        
                            <div class="card">
                                <div class="card-body">
                                            <h4><strong>{{$key+1}}- {{ $data->question }}</strong></h4><br>
                                            <p id="inputText">{!! substr($data->answer,0,500) !!} ...</p><br>
                                            <a class="btn btn-info float-right" href="{{url('FAQ-Detail')}}/{{$data->q_slug}}" target="_blank">{{ trans('home/app.read-more') }}</a>
                                        </div>
                                    </div>
                                
                    @endforeach
                    </div>
                </div>
                <br>
            </div>
 
        </div>
    </div>
    
    <script>
	
	
	
	
	
	function search (){
       var input = document.getElementById("myFilter").value; 
       var divelement = document.getElementById("myItems");
       var faqs = JSON.stringify(<?php echo json_encode($faqs) ?>);
       var x = JSON.parse(faqs, function(k,v){
            return v;
        });

       //console.log(x.length);
       //console.log("search: "+input);
       //console.log("faqs: "+faqs);
      // console.log('------------------------------');
        if(input.length > 0){
            //var res = x.filter(obj => Object.values(obj).some(val => val.includes(input)));
            divelement.innerHTML = "";
            const res = x.filter((s) => (s['answer_' + locale].includes(input) || s['question_' + locale].includes(input)));
            for (var i = 0 ; i < res.length ; i++){
                var ansindex = res[i]['answer_' + locale].indexOf(input);
                var quesindex = res[i]['question_' + locale].indexOf(input);
                var ans = res[i]['answer_' + locale] , ques = res[i]['question_' + locale];
                if (ansindex >= 0) { 
                    ans = res[i]['answer_' + locale].substring(0,ansindex) + "<span class='highlight'>" + res[i]['answer_' + locale].substring(ansindex,ansindex+input.length) + "</span>" + res[i]['answer_' + locale].substring(ansindex + input.length);
                }
                if (quesindex >= 0) {
                    ques = res[i]['question_' + locale].substring(0,quesindex) + "<span class='highlight'>" + res[i]['question_' + locale].substring(quesindex,quesindex+input.length) + "</span>" + res[i]['question_' + locale].substring(quesindex + input.length);
                }
                divelement.innerHTML += '<div class="card"> <div class="card-body">'+
                    '<h4><strong>'+(i+1)+'-'+ques+
                    '</strong></h4><br> <p id="inputText">'+
                    ans.substring(0, 500)+
                    '...</p><br> <a class="btn btn-info float-right" href="{{url("FAQ-Detail")}}/'+res[i].q_slug+
                    '"target="_blank">{{ trans("home/app.read-more") }}</a></div></div>';
            }
        }else{
            divelement.innerHTML = "";
            for (var i = 0 ; i < x.length ; i++){
                divelement.innerHTML += '<div class="card"> <div class="card-body">'+
                    '<h4><strong>'+(i+1)+'-'+x[i]['question_' + locale]+
                    '</strong></h4><br> <p id="inputText">'+
                    x[i]['answer_' + locale].substring(0, 500)+
                    '...</p><br> <a class="btn btn-info float-right" href="{{url("FAQ-Detail")}}/'+x[i].q_slug+
                    '"target="_blank">{{ trans("home/app.read-more") }}</a></div></div>';
            }
        }
    }
	
	
	
	
	
	
	
   /*    function myFunction() {
    var input, filter, cards, cardContainer, h5, title, i, inputText, index;
    input = document.getElementById("myFilter");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("myItems");
    cards = cardContainer.getElementsByClassName("card");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card-body");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
			cards[i].style.display = "";	
        } else {
            cards[i].style.display = "none";
        }
    }
	
}*/


    </script>
@endsection

