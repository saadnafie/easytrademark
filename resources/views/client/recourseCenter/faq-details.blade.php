@extends('client.layouts.app')
@section('content')
    <div class="faq">
        <div class="container">
            <br><br><br>
            <h4 class="text-center"> FAQs
                <hr>
            </h4>
            <br><br>
            <div class="container">
                <div class="row" >
                    <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                            <h4><strong>{{ $faqs->question }}</strong></h4><br>
                                            {{ $faqs->answer }}<br>
                                        </div>
                                    </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    
@endsection
