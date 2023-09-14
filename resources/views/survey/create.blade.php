@extends('client.layouts.app')
<link rel="stylesheet" href="{{ asset('public/assets/css/slider-animation.css') }}">
<title>{{ $questions[0]->survey->survey_name }}</title>
@section('content')

<div class="container body-content">
    <h5>{{ trans('home/home.quiz') }} - {{ $questions[0]->survey->title }}</h5>
    <p>{{ $questions[0]->survey->message }}</p>
    <div class="container">
        <form action="{{route('survey.store')}}" method="POST">
            @csrf
            @foreach($questions as $questionKey => $question)
            <div class="row justify-content-start" style="padding-top:10px;" id="question-{{$questionKey}}">
                <div class="col" style="padding-top:10px;">
                    <p>{!! $question->question !!}</p>
                </div>
                <div class="col justify-content-end" style="padding-top:10px;">
                    @foreach($question->answers as $key => $answer)
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="defaultGroupExample{{$questionKey.$key}}" value="{{$answer->id}}" name="question_answer{{ $questionKey }}" required>
                            <label class="custom-control-label" for="defaultGroupExample{{$questionKey.$key}}">{{$answer->answer}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            @if($question->survey_id == 2 && isset($questions->is_master) &&  $questions->is_master == true)
                <div class="row justify-content-start" style="padding-top:10px;">
                    <div class="col" style="padding-top:10px;">
                        <label>{{ trans('home/home.question') }} </label>
                        <p>{{ trans('home/home.would-you-like-to-guess') }}</p>
                    </div>
                    <div class="col justify-content-end" style="padding-top:10px;">
                        <label>{{ trans('home/home.answer') }}</label>
                        <div class="slidecontainer">
                            <input type="range" min="0" max="100" class="slider" id="my-range" name="slider">
                            <p id="strength-value"></p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row justify-content-end" style="padding-top:10px;padding-bottom: 10px;">
                @if($question->survey_id == 1 && !isset($question->is_master))
                    <a href="{{route('survey.create', ['survey_id' => $question->survey_id, 'current_question_id' => $question->parent_question])}}"
                       class="btn btn-primary" style="color: white;margin:5px;">Previous</a>
                @endif
                @if($question->survey_id == 2 && !isset($question->is_master))
                   <a href="{{ route('survey.create', ['is_master' => true, 'survey_id' => 2]) }}"
                      class="btn btn-primary" style="color: white;margin:5px;">Previous</a>
                @endif
                <input type="submit" class="btn btn-primary" style="margin:5px;" value="Next">
            </div>
            <input type="hidden" name="survey_id" value="{{$question->survey_id}}">
        </form>
    </div>
</div>
<script>
    let slider = document.getElementById("my-range");
    let output = document.getElementById("strength-value");
    output.innerHTML = slider.value; // Display the default slider value
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>
@endsection

