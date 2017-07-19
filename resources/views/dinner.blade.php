<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>订餐提交</title>
    <link rel="shortcut icon" href="{{ URL::asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ URL::asset('css/dinner.css') }}">
</head>
<body>

<form method="post" class="bootstrap-frm">
    <h1>订餐提交
        <span>快金员工订餐记录,请填写以下内容.{{ csrf_field() }}</span>
        <a class="top_bun button" href="{{ url('dinner/') }}" class="button">查看记录</a>
    </h1>
    <label>
        <select name="week">
            <option value="">请选择周</option>
            <option selected='selected' value="{{ $weeks }}">本周</option>
            <option value="{{ $last_week }}">上周</option>

        </select>
    </label>
    <label>
        <select name="time_kind">
            <option value="">请选择具体时间及餐种</option>
            <option @if($week == 1) selected='selected' @endif value="周一">周一</option>
            <option @if($week == 2) selected='selected' @endif value="周二">周二</option>
            <option @if($week == 3) selected='selected' @endif value="周三">周三</option>
            <option @if($week == 4) selected='selected' @endif value="周四">周四</option>
            <option @if($week == 5) selected='selected' @endif value="周五">周五</option>
            <option @if($week == 6) selected='selected' @endif value="周六中餐">周六中餐</option>
            <option value="周六晚餐">周六晚餐</option>
            <option @if($week == 7) selected='selected' @endif value="周日中餐">周日中餐</option>
            <option value="周日晚餐">周日晚餐</option>
        </select>
    </label>
    <label>
        <input type="text" name="name" placeholder="付款人" value="{{ $name }}" />
    </label>
    <label>
        <input type="number" name="amount" placeholder="费用" value="25" />
    </label>
    <label>
        <textarea name="diner" placeholder="就餐名单，多人使用空格间隔">{{ $name }}</textarea>
    </label>

        <input type="button" class="button" value="提交" />

</form>
<div class="msg">
    <div class="info"><img src="{{ URL::asset('images/error.svg') }}" ><br><span class="info_con"></span></div>
    <p class="close">关闭</p>
</div>
<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
<script language="javascript" src="{{ URL::asset('js/adaptation.js') }}"></script>
<script type="text/javascript">
    $(function(){
        var but = 1;

        $('.close').click(function () {
            $('.msg').hide(800);
            but = 1;
        });

        $('input.button').click(function () {
            if(but == 1){
                but =2;
                var week = $("select[name='week']").val();
                var time_kind = $("select[name='time_kind']").val();
                var name = $("input[name='name']").val();
                var amount = $("input[name='amount']").val();
                var diner = $("textarea").val();
                var token = $("input[name='_token']").val();

                if(time_kind == '' || amount == '' || diner == ''){
                    $('.info_con').text('所有选项都是必填的');
                    $('.info img').attr('src', "{{ URL::asset('images/error.svg') }}");
                    $('.msg').show();

                    return;
                }
                //alert(week + ' ' + time_kind + ' ' + name + ' ' + amount + ' ' + diner);
                $.post(
                    "{{ url("/dinner/store") }}",
                    {week:week, time_kind:time_kind, name:name, amount:amount, diner:diner, _token:token},
                    function( data ) {
                        $('.info_con').text(data.info);
                        if(data.status == 1){
                            $('.info img').attr('src', "{{ URL::asset('images/ok.svg') }}");
                        }else{
                            $('.info img').attr('src', "{{ URL::asset('images/error.svg') }}");
                        }

                        $('.msg').show(800);

                        if(data.status == 1){
                            setTimeout(function () {
                                $('.msg').hide();
                                window.location.href = "{{ url("/dinner") }}";
                            }, 1000);
                        }
                    }
                );
            }

        });
    })

</script>
</body>
</html>