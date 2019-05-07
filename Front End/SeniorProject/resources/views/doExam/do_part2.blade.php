
@extends('Home_Master')
@section('content')
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <form action="" method="post">
    <meta name="_token" content="{{csrf_token()}}" />
    <input type="hidden" name="_token" value="{!! csrf_token()!!}">
    <table height="100%" width="100%">
        <tbody>
        <tr>
            <td><br> <span style="font-size: 40px; text-align: center;margin: auto 0px;display: block"> Part 2</span></td>
        </tr>
        <tr>
            <td><br><span style="font-size: 24px">Questions 1-30 refer to the following job advertisement</span>
            </td>
        </tr>
        <tr>
            <td><span style="font-size: 16px">  You will hear a question or statement and three responses spoken in English. They will not be printed in your test book and will be spoken only one time. Select the best response to the question or statement and mark the letter (A), (B), or (C) on your answer sheet.</span><br><br>
            </td>
        </tr>
        <?php $questionOrder = 2?>
        <?php $questionID = 0?>
        @foreach($arrays as $value)
            <tr>
                <td>
                        <br>
                        <div class="questionContent"> Mark your answer on your answer sheet.</div>
                        <br><br>
                        <div style="margin: 0 auto; display: table">
                            <audio controls>
                                <source src="{{$value['fileMp3']}}" type="audio/ogg" style="display: block; margin: auto;">
                                <source src="{{$value['fileMp3']}}" type="audio/mpeg" style="display: block; margin: auto;">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        <?php $questionID =$questionID+1 ?>
                        @foreach($value['questions'] as $question)
                        <div class="question" data-question-id="{{$question['questionId']}}">
                            <div class="questionOrder">Question {{$questionOrder++-1}}</div>
                            <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="a" {{ (old($question['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">A<br>
                            <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="b" {{ (old($question['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">B<br>
                            <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="c" {{ (old($question['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">C<br>
                        @endforeach

                    <script>
                        $(document).ready(function(){
                            userAnswerPart2();
                        });
                        function userAnswerPart2() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            });
                            $.ajax({
                                method: 'get',
                                dataType: 'json',
                                url: '{!! url('/userAnswerPart2')!!}',
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
                        <?php $questionID = 0?>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
    {{--</div>--}}

    <div id="paging" class="paging">
    </div>
    <div id="score" class="notView button2 " align="center"> </div>
        @include('do_exam_master')
    <script>
        function  func() {
        }


        $("#finish").click(function () {
            var user_answer = [];
            var questions = $('div.question');
            questions.each(function() {
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
                data :{myData: JSON.stringify(user_answer)},
                success: function(data){
                    console.log("User Answers: " + JSON.stringify(data));
                },
                error: function(e){
                    console.log(e.message);
                }
            });
        });
    </script>

</form>
    @endsection

