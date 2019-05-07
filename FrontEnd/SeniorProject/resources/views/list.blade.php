<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>


<form action="" method="post">
    <meta name="_token" content="{{csrf_token()}}" />
    <div id="clockdiv" class="time">
        <h1>Time</h1>
        <div>
            <span class="minutes"></span>
            <div class="smalltext">Minutes</div>
        </div>
        <div>
            <span class="seconds"></span>
            <div class="smalltext">Seconds</div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{!! csrf_token()!!}">

    <style>
        body{
            text-align: center;
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
            position: sticky;
            top: 0;
        }
    </style>

    <table height="100%" width="100%">
        <tbody>
        <tr>
            <td><br> <span style="font-size: 40px; text-align: center"> Part 1</span></td>
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
                        <div class="questionOrder">{{$question}}</div>
                        <div class="questionContent"> Look at the picture ?</div>
                        <br><br>
                        <div align="center" class="imageContain img"><img src="{{$value['image']}}" style="height: 300px;width: 500px"></div>

                        <div style="margin: 0 auto; display: table">
                            <audio controls>
                                <source src="{{$value['fileMp3']}}" type="audio/ogg" style="display: block; margin: auto;">
                                <source src="{{$value['fileMp3']}}" type="audio/mpeg" style="display: block; margin: auto;">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        <input id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="a" type="radio">(A)A<br>
                        <input id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="b" type="radio">(B)B<br>
                        <input id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="c" type="radio">(C)C<br>
                        <input id="{{$value['questionId']}}" name="{{$value['questionId']}}" value="d" type="radio">(D)D<br>
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

        <input type="button" id="finish" value="Finish">
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
    <script>
        function getTimeRemaining(endtime) {
            var t = Date.parse(endtime) - Date.parse(new Date());
            var seconds = Math.floor((t / 1000) % 60);
            var minutes = Math.floor((t / 1000 / 60) % 60);
            return {
                'total': t,
                'minutes': minutes,
                'seconds': seconds
            };
        }

        function initializeClock(id, endtime) {
            var clock = document.getElementById(id);
            var minutesSpan = clock.querySelector('.minutes');
            var secondsSpan = clock.querySelector('.seconds');

            function updateClock() {
                var t = getTimeRemaining(endtime);
                minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                if (t.total <= 0) {
                    clearInterval(timeinterval);
                    alert("Done");
                }
            }


            updateClock();
            var timeinterval = setInterval(updateClock, 1000);
        }

        var deadline = new Date(Date.parse(new Date()) + 1200*1000);
        initializeClock('clockdiv', deadline);

    </script>
    {{--<script type="text/javascript">--}}
    {{--$(function () {--}}
    {{--var tongpage = $("#sumpage").val();--}}
    {{--alert("tong so phan tu la: " +tongpage);--}}
    {{--var s = parseInt(tongpage);--}}
    {{--var kq = parseInt(s/3);--}}
    {{--alert("tong so trang la: " +kq);--}}
    {{--window.pagObj = $('#pagination').twbsPagination({--}}
    {{--totalPages: kq,--}}
    {{--visiblePages: 3--}}
    {{--}).on('page', function (event, page) {--}}
    {{--$.ajax({--}}
    {{--type : "GET",--}}
    {{--contentType : "application/json",--}}
    {{--url : "/do/" + page,--}}
    {{--//data : comment,--}}
    {{--timeout : 100000,--}}
    {{--success : function(data) {--}}
    {{--console.log(data);--}}
    {{--display(data);--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}


    {{--function display(data) {--}}
    {{--$("#dataTable tbody").html(data);--}}
    {{--}--}}
    {{--});--}}
    {{--</script>--}}
</form>
