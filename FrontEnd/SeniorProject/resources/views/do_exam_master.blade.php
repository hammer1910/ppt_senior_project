<div align="center" style="top:100px;bottom: 10px;left: 500px; text-align: center">
    <button><a href="{{route('question_part1')}}" style="color: black" id="getQuestion">Part 1</a></button>
    <button><a href="{{route('question_part2')}}" style="color: black" id="getQuestion">Part 2</a></button>
    <button><a href="{{route('question_part3')}}" style="color: black" id="getQuestion">Part 3</a></button>
    <button><a href="{{route('question_part4')}}" style="color: black" id="getQuestion">Part 4</a></button>
    <button><a href="{{route('question_part5')}}" style="color: black" id="getQuestion">Part 5</a></button>
    <button><a href="{{route('question_part6')}}" style="color: black" id="getQuestion">Part 6</a></button>
    <button><a href="{{route('question_part7')}}" style="color: black" id="getQuestion">Part 7</a></button>

</div>
<div id="score" class="notView button2 " align="center">
    <input type="button" id="finish" value="Finish" onclick="deleteItems()">
</div>
</div>

<script>
    function func() {
    }

    function deleteItems() {
        localStorage.clear();
    }
    $('a#getQuestion').click(function () {
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
            url: "{{ url('/continue') }}",
            data: {myData1: JSON.stringify(user_answer)},
            success: function (data) {
                console.log("User Answers: " + JSON.stringify(data));
            },
            error: function (e) {
                console.log(e.message);
            }
        });
    });
    $("#finish").click(function () {
        localStorage.clear();
        var x = confirm("Do you want to finish?");
        if (x) {
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
                url: '{!! url('/complete')!!}',
                data: {myData: JSON.stringify(user_answer)},
                success: function (data) {
                    console.log("User Answers: " + JSON.stringify(data));
                },
                error: function (e) {
                    localStorage.clear();
                  window.location = "home";

                }
            });
        }
        else
            return false;

    });
</script>

