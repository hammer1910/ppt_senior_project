
@extends('Home_Master')
@section('content')

    <form action="" method="get">
        <meta name="_token" content="{{csrf_token()}}" />
        <input type="hidden" name="_token" value="{!! csrf_token()!!}">
        @include('doExamTop')
        <table height="100%" width="100%">
            <tbody>
            <tr>
                <td><br> <span style="font-size: 40px; text-align: center"> Part 3</span></td>
            </tr>
            <tr>
                <td><br><span style="font-size: 24px">Short Conversations</span>
                </td>
            </tr>
            <tr>
                <td><span style="font-size: 16px">  Directions: You will hear some conversations between two people. You will be asked to answer
three questions about what the speakers say in each conversation. Select the best response to each
question and mark the letter (A), (B), (C), or (D) on your answer sheet. The conversations will not
be printed in your test book and will be spoken only one time.</span><br><br>
                </td>
            </tr>
            <?php $questionOrder = 2?>
            <?php $questionID = 0?>
            @foreach($arrays as $value)

                <tr>
                    <td>
                        {{--<div class="question" data-question-id="{{$value['team']}}">--}}
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
                            <div class="question" data-question-id="{{$question['questionId']}}"><br>
                                <div class="questionOrder">Question {{$questionOrder++-1}}. {{$question['questionName']}} </div><br>
                                <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="a" type="radio">(A){{$question['a']}}<br>
                                <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="b" type="radio">(B){{$question['b']}}<br>
                                <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="c" type="radio">(C){{$question['c']}}<br>
                                <input id="{{$question['questionId']}}" name="{{$question['questionId']}}" value="d" type="radio">(D){{$question['d']}}<br>
                                <script>
                                    $(document).ready(function(){
                                        var radios = document.getElementsByName("{{$question['questionId']}}");
                                        var val = localStorage.getItem({{$question['questionId']}});
                                        for(var i=0;i<radios.length;i++){
                                            if(radios[i].value == val){
                                                radios[i].checked = true;
                                            }
                                        }
                                        $('input[name="{{$question['questionId']}}"]').on('change', function(){
                                            localStorage.setItem('{{$question['questionId']}}', $(this).val());

                                        });
                                    });
                                </script>
                                @endforeach


                                <?php $questionID = 0?>
                            </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
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
        @include('do_exam_master')
    </form>
@endsection

