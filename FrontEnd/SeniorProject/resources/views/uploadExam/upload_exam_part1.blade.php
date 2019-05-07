<form id="add" action="{{route('upload.part1')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <h3 class="text-center" style="color: black;margin-top: 10px; font-size: xx-large">Upload</h3>
            @if (session('message'))
                <div class="alert alert-success" style="text-align: center; font-size: large">
                    <strong>Success!</strong> {{session('message')}}
                </div>
            @endif


            <button type="submit" id="finish" class="btn btn-outline-primary"
                    style="display: block; margin: auto; float: right; font-size: large">Upload <i class="fa fa-upload"></i>
            </button>

            {{--<input type="button" id="btn2" class="btn" value="Add Question">--}}
            <button type="button" id="btn2" class="btn btn-outline-primary" style="font-size: large">Add Question
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <div class="col-lg-4 ">

            <h3 class="text-center" style="color: black;margin-top: 10px">Question 1</h3>
            <div class="panel-body" style="margin-top: 1px">
                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                    <label>MP3</label>
                    <input type="file" class="form-control" name="mp3[]" required="mp3"/>
                    <div type="hidden" class="alert-warning">{{$errors->first('mp3')}}</div>
                </div>
                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                    <label>Image</label>
                    <input type="file" class="form-control" name="images[]" required="image"/>
                </div>

                <div class="form-group" style="margin-top: 1px;margin-bottom: 5px">
                    <label>Correct Answer </label>
                    <input class="form-control" name="correct_answer[]"
                           placeholder="Please Enter Correct Answer" required="text"/>
                    <div type="hidden" class="alert-warning">{{$errors->first('correct_answer')}}</div>
                </div>
            </div>


        </div>

        {{--<div id ="add">11</div>--}}


        <script>
            $(document).ready(function () {
                var i = 2;
                $("#btn2").click(function () {

                    $("#add").append(" <div class=\"col-lg-4 \" >\n" +
                        "\n" +
                        "            <h3 class=\"text-center\" style=\"color: black;margin-top: 10px\">Question " + (i++) + "</h3>\n" +
                        "            <div class=\"panel-body\" style=\"margin-top: 1px\">\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                        "                        <label>MP3</label>\n" +
                        "                        <input type=\"file\" class=\"form-control\" name=\"mp3[]\" required=\"mp3\"/>\n" +
                        "                    </div>\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\">\n" +
                        "                        <label>Image</label>\n" +
                        "                        <input type=\"file\" class=\"form-control\" name=\"images[]\" required=\"image\"/>\n" +
                        "                    </div>\n" +
                        "\n" +
                        "                    <div class=\"form-group\" style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                        "\n" +
                        "                        <label>Correct Answer </label>\n" +
                        "                        <div>\n" +
                        "                            <input class=\"form-control\" name=\"correct_answer[]\"\n" +
                        "                                   placeholder=\"Please Enter Correct Answer\" required=\"text\"/>\n" +
                        "\n" +
                        "\n" +
                        "                        </div>\n" +
                        "\n" +
                        "                            </div>\n");
                });
                // $("#add_question").click(function () {
                //     $("#answer").append("\n" +
                //         "                                                <div class=\"form-group\"style=\"margin-top: 1px;margin-bottom: 5px\" id=\"answer\">\n" +
                //         "\n" +
                //         "                                                    <label>Correct Answer </label>\n" +
                //         "                                                    <input type=\"button\" id=\"add_question\" style=\"float: right\" value=\"+\" >\n" +
                //         "                                                    <div>\n" +
                //         "                                                    <input class=\"form-control\"  name=\"correct_answer\"\n" +
                //         "                                                           placeholder=\"Please Enter Correct Answer\"/>\n" +
                //         "\n" +
                //         "\n" +
                //         "                                                    </div>")
                // });

            });
        </script>
</form>




