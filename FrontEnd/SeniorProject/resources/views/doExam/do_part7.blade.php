
@extends('Home_Master')
@section('content')

    <form action="" method="post">
        <meta name="_token" content="{{csrf_token()}}" />
        <input type="hidden" name="_token" value="{!! csrf_token()!!}">
        <table height="100%" width="100%">
            <tbody>
            <tr>
                <td><br> <span style="font-size: 40px; text-align: center"> Part 7</span></td>
            </tr>
            <tr>
                <td><br><span style="font-size: 24px">Text completion</span>
                </td>
            </tr>
            <tr>
                <td><span style="font-size: 16px">  Directions: Read the texts on the following pages. Below the texts, four answer choices are
given. Select the most appropriate answer to complete the text.</span><br><br>
                </td>
            </tr>
            <?php $questionOrder = 0?>
            <?php $questionID = 0?>
            @foreach($arrays as $value)
                <?php $questionID = $questionID+1?>
                <tr>
                    <td>
                        {{--<div class="question" data-question-id="{{$value['team']}}">--}}
                        <br>
                        {{--<div class="questions">{{$questionID}}.</div><br>--}}
                        <div class="questionContent"> Mark your answer on your answer sheet.</div>
                        <br><br>

                        <div align="center" class="imageContain img"><img src="{{$value['image']}}" style="height: 500px;width: 650px"></div>


                        @foreach($value['questions'] as $question)
                            <?php $questionOrder =$questionOrder+1 ?>
                            <div class="question" data-question-id="{{$question['questionId']}}"><br>
                                <div class="questionOrder">Question {{$questionOrder}}. {{$question['questionName']}}</div><br>
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

                                <?php $questionOrder = 0?>
                            </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        {{--</div>--}}

        <div id="paging" class="paging">
        </div>
        <div id="score" class="notView button2 " align="center">

            {{--<button><a href="{{route('question_part2')}}" style="color: black">Next</a></button>--}}
            {{--<button><a href="{{route('question_part2')}}" style="color: black">Next</a></button>--}}
            {{--<input type="submit" id="finish" value="ok">--}}
            {{--<input type="text" id="test"  value="Test">--}}
        </div>

        </div>
        </div>
        <script>
            function  func() {
                // var user_answer=[];
                // var type = document.getElementsByName("answer");
                // for(var i=0; i<type.length; i++){
                //     if (type[i].checked){
                //         var id = type[i].id;
                //         var answer =  type[i].value;
                //         user_answer.push({"answerKey":answer,"questionId":id})
                //
                //     }
                // }
                // $("#finish").click(function () {
                //     $.ajax({
                //         type: 'POST',
                //         dataType: 'JSON',
                //         url: "QuestionController.php",
                //         data :'myData='+ user_answer,
                //         success: function(data){
                //             alert("success");
                //
                //         },
                //         error: function(e){
                //             console.log(e.message);
                //         }
                //     });
                // })
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

