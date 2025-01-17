<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/plugins/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/build/css/app.css" media="all">
</head>
<style>
    .text_div{
        height: 30px;
        line-height: 0px;
        display: inline-block;

    }
    .text_div1{
        height: 30px;
        line-height: 0px;
        display: inline-block;

    }
    .text_span{
        display: inline-block ;
        padding-left: 100%;
    }
    .username_input{
        width: 150px;
        display: inline-block;
    }
</style>

<body>
<div class="layui-fluid main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>分润详情</legend>
    </fieldset>
    <form method="post" action="{{url('manager/profit_detail')}}?leader_id={{Request::input('leader_id')}}">
        {{ csrf_field() }}
        <div style="display: inline-block">
            <div>
                <div class="text_div">用户ID<span class="text_span"></span></div>
                <input value="{{ Request::input('user_id')?Request::input('user_id'):''}}" name="user_id" type="text" class="layui-input username_input">
            </div>
        </div>
        <div style="display: inline-block;margin-top: 20px;">
            <div>
                <div class="text_div" style="margin-left: 20px">日期<span class="text_span"></span></div>
                <div style="display: inline-block">
                    <input value="{{ Request::input('date_begin')?Request::input('date_begin'):''}}"  type="text" class="layui-input" id="date_begin" name="date_begin" style="width: 100px">
                </div> —
                <div style="display: inline-block">
                    <input value="{{ Request::input('date_end')?Request::input('date_end'):''}}" type="text" class="layui-input" id="date_end" name="date_end" style="width: 100px">
                </div>
            </div>
        </div>
        <input type="submit" class="layui-btn" value="查询">
        <input type="button" class="layui-btn" id="back_agent" value="返回代理列表">
    </form>
        <div class="layui-form">
        <table class="layui-table">
            <thead>
                <tr>
                    <th>用户ID</th>
                    <th>用户账号</th>
                    <th>用户名</th>
                    <th>订单总价</th>
                    <th>订单分润比</th>
                    <th>订单分润</th>
                    <th class="{{ Request::get('column')=='created_at'?(Request::get('sort')=='asc'?'sorting_asc':'sorting_desc'):'sorting_both' }} sorting" sort="created_at">分润时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profit_list as $item)
                    <tr>
                        <td>{{$item['user_id']}}</td>
                        <td>{{$item['user']['username']}}</td>
                        <td>{{$item['info']['name']}}</td>
                        <td>{{$item['order_amount']}}</td>
                        <td>{{$item['profit_percent']}}%</td>
                        <td>{{$item['profit_amount']}}</td>
                        <td>{{$item['created_at']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            {{ $profit_list->appends([
              'leader_id' => Request::input('leader_id'),
              'user_id' => Request::input('user_id'),
              'order_sn' => Request::input('order_sn'),
              'column' => Request::input('column'),
               'sort' => Request::input('sort')
     ])->links() }}
    </div>
</div>
<script src="/plugins/layui/layui.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form,
            $ = layui.jquery,
            layer = layui.layer;

        $('.config-btn').click(function () {
            var config_id = $(this).attr('config_id');
            layer.open({
                type: 2,
                title: '公告编辑',
                shadeClose: true,
                shade: 0.8,
                area: ['50%', '80%'],
                maxmin: true,
                content: '{{ route("manager.announcement.edit") }}?id='+config_id,
            });
        });

        $('.getUser_detail').click(function () {
            var user_id = $(this).prev().val()
            var url = "{{ url('manager/getUser_detail')}}?user_id="+user_id;
            layui.use('layer',function(){
                var layer=layui.layer;
                layer.open({
                    type:2,
                    title:'用户详情',
                    shadeClose:true,
                    shade:0,
                    area:['500px','600px'],
                    content:url,
                    skin:'accountOp',
                })
            })
        });

        @if ($errors->has('error'))
        layer.msg("{{ $errors->first('error') }}");
        @endif
        $(".sorting").click(function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            var column = $(this).attr('sort');
            if($(this).hasClass("sorting_desc")){
                var sort = 'asc';
            }else {
                var sort = 'desc';
            }
            location.href = '{{ url("manager/profit_detail") }}?leader_id={{ Request::input("leader_id") }}&?user_type={{ Request::input("order_sn") }}&user_id={{ Request::input("user_id") }}&column='+column+'&sort='+sort;
        })
        $("#back_agent").click(function () {
            location.href = '{{url('manager/agentCenter') }}';
        })
        layui.use('laydate', function(){
            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: '#date_begin' //指定元素
            });
        });
        layui.use('laydate', function(){
            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: '#date_end' //指定元素
            });
        });
    });
</script>

</body>

</html>