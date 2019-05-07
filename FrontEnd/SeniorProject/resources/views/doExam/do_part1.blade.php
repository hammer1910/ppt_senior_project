
@extends('Home_Master')

@section('content')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>


<form action="" method="post">
    <meta name="_token" content="{{csrf_token()}}" />
    <input type="hidden" name="_token" value="{!! csrf_token()!!}">

    @if (session('message'))
        <div class="alert alert-success" style="text-align: center; font-size: large">
            <strong>Success!</strong> {{session('message')}}
        </div>
    @endif

    <table height="100%" width="100%">
        <tbody>
        <tr>
            <td><br> <span style="font-size: 40px; text-align: center;margin: auto 0px;display: block"> Part 1</span></td>
        </tr>
        <tr>
            <td><br><span style="font-size: 24px">Questions 1-10 refer to the following job advertisement</span>
            </td>
        </tr>
        <tr>
            <td><span style="font-size: 16px">  Directions: For each question in this part, you will hear four statements about a picture in your test book. When you hear the statements, you must select the one statement that best describes what you see in the picture. Then find the number of the question on your answer sheet and mark your answer. The statements will not be printed in your test book and will be spoken only one time.</span><br><br>
            </td>
        </tr>
        <?php $question = 0?>

        @foreach($arrays as $value)
            <?php $question =$question+1 ?>
            <tr>
                <td>
                    <div class="question" data-question-id="{{$value['questionId']}}">
                        <br>
                        <div class="questionOrder"> Question {{$value['questionNumber']}}. Look at the picture ?</div>
                        {{--<div class="questionContent"> Look at the picture ?</div>--}}
                        <br><br>
                        <div align="center" class="imageContain img"><img src="{{$value['image']}}" style="height: 300px;width: 500px"></div>

                        <div style="margin: 0 auto; display: table">
                            <audio controls>
                                <source src="{{$value['fileMp3']}}" type="audio/ogg" style="display: block; margin: auto;">
                                <source src="{{$value['fileMp3']}}" type="audio/mpeg" style="display: block; margin: auto;">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    <div id="{{$value['questionId']}}" class="question_ID" >
                        <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="a" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio" style="display: inline-block">&#160;A<br>
                        <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="b" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio" style="display: inline-block">&#160;B<br>
                        <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="c" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio" style="display: inline-block">&#160;C<br>
                        <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="d" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio" style="display: inline-block">&#160;D<br>
                    </div>
                    </div>

                </td>
            </tr>
        @endforeach
        <script>
            $(document).ready(function(){
                userAnswerPart1();
            });
            function userAnswerPart1() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'get',
                    dataType: 'json',
                    url: '{!! url('/userAnswerPart1')!!}',
                    success: function (data) {
                        var i;
                        var j;
                        var questions = $('div.question');
                        var radios;
                        var question_id;
                        questions.each(function () {
                            question_id = $(this).data('question-id');
                            radios = document.getElementsByName(question_id);
                            for (i = 0; i < data.length; i++) {
                                if(question_id === data[i]['questionId']) {
                                    var id = data[i]['questionId'];
                                    localStorage.setItem(id, data[i]['answerUser']);
                                    var val = localStorage.getItem(id);
                                    for (j = 0; j < radios.length; j++) {
                                        if (radios[j].value === val) {
                                            radios[j].checked = true;
                                        }
                                    }
                                }
                            }
                        });
                        //radios = document.getElementsByName(question_id);

                        },
                    error: function (e) {
                        console.log(e.message);
                    }
                });
            }

        </script>
        </tbody>
    </table>
    {{--</div>--}}

    <div id="paging" class="paging">
    </div>
    <div id="score" class="notView button2 " align="center">
        {{--<button><a href="{{route('question_part2')}}" style="color: black">Next</a></button>--}}
        {{--<input type="button" id="next" value="Next">--}}
    </div>
        {{--<input type="submit" id="finish" value="ok">--}}
        {{--<input type="text" id="test"  value="Test">--}}
    {{--</div>--}}

    @include('do_exam_master')
    <script>
        function  func() {}
            $("#finish").click(function () {
                var user_answer = [];
                var questions = $('div.question');
                questions.each(function () {
                    var answer = $(this).find('input[type="radio"]:checked').val();
                    var id = $(this).data('question-id');
                    user_answer.push({"answerKey": answer, "questionId": id})
                });
                // console.log("User Answers: " + JSON.stringify(user_answer))
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    method: 'POST',
                    dataType: 'json',
                    url: "{{ url('/submit_part1') }}",
                    data: {myData: JSON.stringify(user_answer)},
                    success: function (data) {
                        console.log("User Answers: " + JSON.stringify(data));
                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });
            });
    </script>


</form>

    @endsection
