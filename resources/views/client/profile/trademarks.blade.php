@extends('client.layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<style>
input[type=date] {
        position: relative;
        width: 150px; height: 20px;
        color: white;
    }

    input[type=date]:before {
        position: absolute;
        top: 3px; left: 3px;
        content: attr(data-date);
        display: inline-block;
        color: black;
    }

    input[type=date]::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
        display: none;
    }

    input[type=date]::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 3px;
        right: 0;
        color: black;
        opacity: 1;
    }
</style>
    <div class="profile">
        <div class="container">
            <br><br>
            <div class="head">
                <br><br>
                <h3 class="text-center">My Trademarks
                    <hr>
                </h3>
            </div>
            <br><br>
            <div class="my-orders">
                <table class="table" class="text-center">
                    <thead>
                    <div class="search ">
                        <form action="{{ route('trademark-search') }}" method="GET" class="text-right" >
                            From : <input type="date" name="searchFrom" class="my_form-control " data-date="" data-date-format="DD/MM/YYYY" value="2020-01-01">
                            To : <input type="date" name="searchTo" class="my_form-control " data-date="" data-date-format="DD/MM/YYYY" value="2021-01-01">
                            <input type="submit" value="search" class="">
                        </form>
                    </div>
                    <br>
                    <tr class="text-center">
                        <th scope="col">Trademark ID</th>
                        <th scope="col">Reference</th>
                        <th scope="col">Label</th>
                        {{--                        <th scope="col">Deadline</th>--}}
                        <th scope="col">Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($trademarks as $data)
                        <tr class="text-center">
                            <th scope="row">
                                <a href="trademarks/{{  Illuminate\Support\Facades\Crypt::encryptString($data->id) }}"> {{ $data->id }}  </a>
                            </th>
                            <td>{{$data->trademark_reference}}</td>
                            <td>{{$data->trademark_label}}</td>
                            {{-- <td>{{$data->deadline}}</td>--}}
                            <td>{{date('d-m-Y', strtotime($data->created_at->toDateString()))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row float-right">
                    {{ $trademarks->links() }}
                </div>
                <br><br><br>
            </div>
        </div>
    </div>
	<script>
	$("input").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format( this.getAttribute("data-date-format") )
        )
    }).trigger("change")
	</script>
@endsection
