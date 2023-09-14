@extends('client.layouts.app')
@section('content')
<div class="container body-content">
    <div class="container">
        @if(isset($finalAnswer))
            <div class="row">
                <h2>Final Answer</h2>
            </div>
            <p>{!! $finalAnswer !!}</p>
            <div class="row justify-content-end" style="padding-top:10px; padding-bottom: 10px;">
                <a style="margin:5px;" href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 1]) }}" class="btn btn-primary">Re-Take</a>
                <a style="margin:5px;" href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 2]) }}" class="btn btn-primary">Strength Assessment Survey</a>
                <a style="margin:5px;" href="{{ url('/service-search') . '/' . 2 }}" class="btn btn-primary">Start Registration</a>
            </div>
        @endif
        @if(isset($surveyResult))
            @if(!empty($surveyResult['finalMessage']))
                <div class="row">
                    <h3>Final Answer</h3>
                </div>
                <p>{{ $surveyResult['finalMessage'] }}</p>
            @endif
                <div class="row">
                    <h3>Your Expectation Of Trademark Strength</h3>
                </div>
                <p>{{ $surveyResult['slider'] }}%</p>
                <div class="row">
                    <h3>Score Percentage</h3>
                </div>
                <p>{{ $surveyResult['scorePercentage'] }}%</p>
                <div class="row">
                    <h3>Score Messages</h3>
                </div>
                <p>{{ $surveyResult['scoreMessage'] }}</p>
            <div class="row justify-content-end" style="padding-top:10px;padding-bottom: 10px">
                <a style="margin:5px;" href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 2]) }}" class="btn btn-primary">Restart</a>
                <a style="margin:5px;" href="{{ route('home') }}" class="btn btn-primary">Home</a>
            </div>
            <section class="mb-4">
                <p class="text-center w-responsive mx-auto mb-5">Enter your contact details if you would like us to send you tips on how to make your trademark stronger</p>
                <div class="row">
                    <div class="col-md-9 mb-md-0 mb-5">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br />
                        @endif
                        <form method="post" action="{{route('survey.mail')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form mb-0">
                                        <input type="text" id="name" name="name" class="form-control" required>
                                        <label for="name" class="">Your name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="md-form mb-0">
                                        <input type="email" id="email" name="email" class="form-control" required>
                                        <label for="email" class="">Your email</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="score" value="{{$surveyResult['score']}}">
                            <input type="hidden" name="max_score" value="{{$surveyResult['maxScore']}}">
                            <input type="hidden" name="score_percentage" value="{{$surveyResult['scorePercentage']}}">
                            <input type="hidden" name="slider" value="{{$surveyResult['slider']}}">
                            @if(!empty($surveyResult['finalMessage']))
                                <input type="hidden" name="final_message" value="{{$surveyResult['finalMessage']}}">
                            @endif
                            @if(!empty($surveyResult['scoreMessage']))
                                <input type="hidden" name="score_message" value="{{$surveyResult['scoreMessage']}}">
                            @endif
                            <div class="g-recaptcha" data-sitekey="6LcriscZAAAAAKzeYYRaG9ajcCmZuENlPH40_tkq"></div>
                            <div class="text-center text-md-left">
                                <input type="submit" class="btn btn-primary" value="Send">
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
    grecaptcha.execute();
</script>
