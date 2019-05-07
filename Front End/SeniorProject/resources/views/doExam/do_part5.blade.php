@extends('Home_Master')
@section('content')
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>


    <form action="" method="post">
        <meta name="_token" content="{{csrf_token()}}" />
        {{--<div id="clockdiv" class="time">--}}
        {{--<h1>Time</h1>--}}
        {{--<div>--}}
        {{--<span class="minutes"></span>--}}
        {{--<div class="smalltext">Minutes</div>--}}
        {{--</div>--}}
        {{--<div>--}}
        {{--<span class="seconds"></span>--}}
        {{--<div class="smalltext">Seconds</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        <input type="hidden" name="_token" value="{!! csrf_token()!!}">

        <style>
            body{

                font-family: sans-serif;
                font-weight: 100;
            }

            h1{
                color: #396;
                font-weight: 100;
                font-size: 40px;
                margin: 40px 0px 20px;
            }

            #clockdiv{
                font-family: sans-serif;
                color: #fff;
                display: inline-block;
                font-weight: 100;
                text-align: center;
                font-size: 30px;
                float: right;
            }

            #clockdiv > div{
                padding: 10px;
                border-radius: 3px;
                background: #00BF96;
                display: inline-block;
            }

            #clockdiv div > span{
                padding: 15px;
                border-radius: 3px;
                background: #00816A;
                display: inline-block;
            }

            .smalltext{
                padding-top: 5px;
                font-size: 16px;
            }
            div.time{
                position: -webkit-sticky;
                position: fixed;
                top: 0;
            }
        </style>

        <table height="100%" width="100%">
            <tbody>
            <tr>
                <td><br> <span style="font-size: 40px; align: center"> Part 5</span></td>
            </tr>
            <tr>
                <td><br><span style="font-size: 24px">Incomplete sentences</span>
                </td>
            </tr>
            <tr>
                <td><span style="font-size: 16px"> Directions: In each question, you will find a word or phrase missing. Four answer choices are
given below each sentence. You must choose the best answer to complete the sentence.</span><br><br>
                </td>
            </tr>
            <?php $question = 0?>

            @foreach($arrays as $value)
                <?php $question =$question+1 ?>
                <tr>
                    <td>
                        <div class="question" data-question-id="{{$value['questionId']}}">
                            <br>
                            <div class="questionOrder">Question {{$question}}. {{$value['questionName']}}</div>
                            <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="a" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">(A){{$value['a']}}<br>
                            <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="b" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">(B){{$value['b']}}<br>
                            <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="c" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">(C){{$value['c']}}<br>
                            <input class="radio" id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="d" {{ (old($value['questionId']) == '(A)A') ? 'checked' : '' }} type="radio">(D){{$value['d']}}<br>
                            <script>
                                $(document).ready(function(){
                                    var radios = document.getElementsByName("{{$value['questionId']}}");
                                    var val = localStorage.getItem({{$value['questionId']}});
                                    for(var i=0;i<radios.length;i++){
                                        if(radios[i].value == val){
                                            radios[i].checked = true;
                                        }
                                    }
                                    $('input[name="{{$value['questionId']}}"]').on('change', function(){
                                        localStorage.setItem('{{$value['questionId']}}', $(this).val());

                                    });
                                });
                            </script>
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
            {{--<input type="button" id="next" value="Next">--}}
        </div>
        {{--<input type="submit" id="finish" value="ok">--}}
        {{--<input type="text" id="test"  value="Test">--}}
        {{--</div>--}}


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
            // $(function(){
            //     $('input[type=radio]').each(function(){
            //         var state = JSON.parse( localStorage.getItem('radio_'  + $(this).attr('id')) );
            //
            //         if (state) this.checked = state.checked;
            //     });
            // });
            //
            // $(window).bind('unload', function(){
            //     $('input[type=radio]').each(function(){
            //         localStorage.setItem('radio_' + $(this).attr('id'), JSON.stringify({checked: this.checked})
            //         );
            //     });
            // });

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
