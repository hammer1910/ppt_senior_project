
@extends('Home_Master')

@section('content')
<style type="text/css">
    .center-on-page{
        margin-bottom: 50px;
        margin-left: 10px;
    }
    h1 {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        color: forestgreen;
    }
    /* Reset Select */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        appearance: none;
        outline: 0;
        box-shadow: none;
        border: 0 !important;
        background: #2c3e50;
        background-image: none;
    }
    /* Custom Select */
    .select {
        position: relative;
        display: block;
        width: 20em;
        height: 3em;
        line-height: 3;
        background: #2c3e50;
        overflow: hidden;
        border-radius: .25em;
    }
    select {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0 0 0 .5em;
        color: #fff;
        cursor: pointer;
    }
    select::-ms-expand {
        display: none;
    }
    /* Arrow */
    .select::after {
        content: '\25BC';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        padding: 0 1em;
        background: #34495e;
        pointer-events: none;
    }
    /* Transition */
    .select:hover::after {
        color: #f39c12;
    }
    .select::after {
        -webkit-transition: .25s all ease;
        -o-transition: .25s all ease;
        transition: .25s all ease;
    }

    button {
        height: 50px;
        width: 100px;
    }
</style>
<style>
    .content{
        width: 70%;
        margin: 0 auto;
    }
    .inlineTable{
       float: left;
        margin: 0 auto;
        /*display: block;*/
        /*margin: auto 0px;*/
    }
    .inlineTable2{
        float: left;
    }
</style>
<div class="container" id="listAnswer">
    <h1>COMPARE</h1>
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-sm-8 col-md-8 col-lg-8">
                    <div class="center-on-page" style="margin-left: 300px;">
                        <div class="select">
                            <select name="slct" id="slct">
                                <option>Choose user</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <button type="button" class="btn btn-primary" id="compare" style="margin-left: -100px;">Compare</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content" style="margin:0 auto;display:block;">
        <table border=1 class="inlineTable" id="1" style="margin-right: 10px">
            <caption id="1" style="text-align: center;font-size:x-large">
            </caption>
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
        <table border=1 class="inlineTable" id="2" >
            <caption id="2" style="text-align: center;font-size:x-large">
            </caption>
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>

    <table border=1 class="inlineTable2" id="3" style="margin-right: 10px;">
        <thead>
        </thead>
        <tbody>
        </tbody>
    </table>
    <table border=1 class="inlineTable2" id="4" >
        <thead>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
    <script>
       window.onload = function () {
           listUserFinish();
       };

        function listUserFinish() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                method: 'get',
                dataType: 'json',
                url: '{!! url('/listUserFinish')!!}',
                success: function (data) {
                    var select = document.getElementById('slct');
                    for (var i = 0; i < data.length; i++) {
                        $(select).append('<option value=' + data[i]['accountId'] + '>' + data[i]['name'] + '</option>');
                    }
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }
       $('#compare').on('click', function () {
           var userID = $('select[name=slct]').val();

           compareAnotherUser(userID);
       });
       function compareAnotherUser(userID) {
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               }
           });
           $.ajax({
               method: 'get',
               dataType: 'json',
               url: '{!! url('/compareAnswer')!!}'+'/'+userID,
               success: function (data) {

                   var tablePart1 =$('#listAnswer').find('table#1');
                   var tablePart2 =$('#listAnswer').find('table#2');
                   var trData = '';
                   var trData1 = '';
                   var trData2 = '';
                   var cap1 ='';
                   var cap2 = '';
                   if(data[0]['nameAnother'] != null) {
                       trData1 += ' <tr>\n' +
                           '            <th style="text-align: center">&#160;Question Number &#160;</th>\n' +
                           '            <th style="text-align: center"> &#160;Your Answer&#160; </th>\n' +
                           '            <th style="text-align: center">&#160; Friend Answer&#160; </th>\n' +
                           '            <th style="text-align: center">&#160; Final Answer&#160; </th>\n' +
                           '        </tr>';
                   }
                   else {

                       trData1 +=' <tr>\n'+
                           '            <th style="text-align: center">&#160; Question Number&#160; </th>\n' +
                           '            <th style="text-align: center">&#160; Your Answer &#160;</th>\n' +
                           '            <th style="text-align: center">&#160;Final Answer &#160;</th>\n' +
                           '        </tr>'

                   }
                   for (var i = 0; i < data.length; i++) {
                       if(data[i]['answerAnother'] != null ) {
                           if(data[i]['part']=== "1"){
                               if(data[i]['status']=== "uncorrect"){
                                   trData +='<tr>\n' +
                                       '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                                       '            <td  style="text-align: center;background-color: yellow">'+data[i]['answerUser']+'</td>\n' +
                                       '            <td  style="text-align: center;background-color: yellow">'+data[i]['answerAnother']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                                       '        </tr>';
                               }
                               else{
                                   trData +='<tr>\n' +
                                       '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['answerUser']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['answerAnother']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                                       '        </tr>';
                               };
                               // if(data[i]['status']=== "correct"){
                               //     trData +='<tr>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerUser']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerAnother']+'</td>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                               //         '        </tr>';
                               // }
                               // if(data[i]['status']=== "1"){
                               //     trData +='<tr>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerUser']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerAnother']+'</td>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                               //         '        </tr>';
                               // }
                           };
                           if(data[i]['part']=== "2"){
                               cap2 +='Part 2';
                               if(data[i]['status']=== "uncorrect"){

                               trData2 +='<tr>\n' +
                                   '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                                   '            <td  style="text-align: center;background-color: yellow">'+data[i]['answerUser']+'</td>\n' +
                                   '            <td  style="text-align: center;background-color: yellow">'+data[i]['answerAnother']+'</td>\n' +
                                   '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                                   '        </tr>';
                               }
                             else{
                                   trData2 +='<tr>\n' +
                                       '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['answerUser']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['answerAnother']+'</td>\n' +
                                       '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                                       '        </tr>';
                               };
                               // if(data[i]['status']=== "correct"){
                               //     trData2 +='<tr>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerUser']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerAnother']+'</td>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                               //         '        </tr>';
                               // };
                               // if(data[i]['status']=== "1"){
                               //     trData2 +='<tr>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['quetionNumber']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerUser']+'</td>\n' +
                               //         '            <td  style="text-align: center;">'+data[i]['answerAnother']+'</td>\n' +
                               //         '            <td  style="text-align: center">'+data[i]['finalAnswer']+'</td>\n' +
                               //         '        </tr>';
                               // };
                           };
                       }
                       else {
                           if(data[i]['part']=== "1") {
                               trData += '<tr>\n' +
                                   '            <td  style="text-align: center">' + data[i]['quetionNumber'] + '</td>\n' +
                                   '            <td  style="text-align: center;">' + data[i]['answerUser'] + '</td>\n' +
                                   '            <td  style="text-align: center">' + data[i]['finalAnswer'] + '</td>\n' +
                                   '        </tr>';
                           }
                           if(data[i]['part']=== "2") {
                               trData2 += '<tr>\n' +
                                   '            <td  style="text-align: center">' + data[i]['quetionNumber'] + '</td>\n' +
                                   '            <td  style="text-align: center;">' + data[i]['answerUser'] + '</td>\n' +
                                   '            <td  style="text-align: center">' + data[i]['finalAnswer'] + '</td>\n' +
                                   '        </tr>';
                           }


                       }
                   }
                   tablePart1.find('thead').html(trData1);
                   tablePart1.find('caption').html("Part 1");
                   tablePart1.find('tbody').html(trData);
                   var check=0;
                   for (var i = 0; i < data.length; i++) {

                       if(data[i]['part']=== "2"){
                           check++;
                       }
                   }
                   if(check === 0){
                       $('.content').css('width','40%');
                   }
                   else{
                       if(data[0]['nameAnother'] != null) {
                           $('.content').css('width','90%');
                       }else{
                           $('.content').css('width','70%');
                       }
                       tablePart2.find('thead').html(trData1);
                       tablePart2.find('caption').html("Part 2");
                       tablePart2.find('tbody').html(trData2);
                   }
               },
               error: function (e) {
                   console.log(e.message);
               }
           });
       }
    </script>
</div>
@endsection
