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

<div class="bootstrap-frm">
    <h1>订餐记录
        <span class="nearly">近10天提交的记录</span>
        <a class="top_bun button" href="{{ url('dinner/create') }}" class="button">去提交</a>
@if ($name == '马进') <a class="top_bun2 button" href="{{ url('dinner/export') }}" class="button">导出近30天</a>@endif
    </h1>

    <table class="list" cellpadding="0" cellspacing="0">
        <tr>{{--<th>ID</th>--}}<th>第几周</th><th>时间餐种</th><th>付款人</th><th>用餐人</th><th>金额</th><th>用餐日期</th><th class="sub_time">提交时间</th></tr>
        @foreach ($lists as $list)
            <tr>
                {{--<td>{{ $list->id }}</td>--}}
                <td>{{ $list->week }}</td>
                <td>{{ $list->time_kind }}</td>
                <td>{{ $list->name }}</td>
                <td>{{ $list->diner }}</td>
                <td>{{ $list->amount }}</td>
                <td>{{ $list->dinner_date }}</td>
                <td class="sub_time">{{ $list->created_at }}</td>
            </tr>

        @endforeach
    </table>
</div>
<script language="javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
<script language="javascript" src="{{ URL::asset('js/adaptation.js') }}"></script>
<script type="text/javascript">
    var ua = navigator.userAgent;

    var isIphone = ua.match(/(iPhone\sOS)\s([\d_]+)/),

        isAndroid = ua.match(/(Android)\s+([\d.]+)/),

        isMobile = isIphone || isAndroid;


    if(isMobile){
        $('.sub_time').hide();
    }
</script>
</body>
</html>