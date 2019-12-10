<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/plugins/layui/css/layui.css" media="all">
</head>
<style>
    .game_td{
        height: 37px;
        line-height: 37px;
        width: 100px;
        text-align: center;
        border-bottom: 1px solid #e2e2e2;
        cursor: pointer;

    }
    .game_table{
        width: 100px;
        border-right: 1px solid #e2e2e2;
        float: left;
    }
    .last_game_td{
        border-bottom: none;

    }
    .body_right{

        height: 750px;
        width: 1300px;
        margin-left: 140px;

    }
    .category_show{
        height: 60px;
        width: 100%;
    }
    .category_li{
        float: left;
        line-height: 60px;
        height: 60px;
        width: 105px;
        text-align: center;
        margin-left: 10px;
    }
    .select_game {
        color:red;
    }
</style>

<body>
<div class="layui-everyday-list">
    <div class="form-element element-name">
        <div style="width: 400px;margin-top: 50px;text-align: center;height: 50px;line-height: 50px;color: red;font-size: 18px">添加IP限制</div>
        <div class="layui-form-item" >
            <label class="layui-form-label" style="width: 15%">IP:</label>
            <div class="layui-input-inline">
                <input type="text" name="modify_odd" class="layui-input" id="new_odd" value=""/>
            </div>
        </div>

        <button id="mondify_ajax" class="layui-btn layui-btn" style="margin-top: 20px;margin-left: 156px">添加</button>
    </div>
</div>

<script src="/plugins/layui/layui.js"></script>
<script src="/js/xin.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form,
            $ = layui.jquery,
            layer = layui.layer;
        //监听提交
        form.on('submit(demo1)', function(data) {
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                type: "POST",
                url: "/manager/secure",
                data: data.field,
                dataType: "json",
                success: function(res){
                    layer.close(index);
                    layer.msg(res.msg, {time:1100});
                    if (res.success) {
                        location.reload();
                    }
                }
            });
            return false;
        });

        $("#mondify_ajax").click(function () {
            var pattern = /(?:(?:(?:25[0-5]|2[0-4]\d|(?:(?:1\d{2})|(?:[1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|(?:(?:1\d{2})|(?:[1-9]?\d))))/;
            var ip = $("#new_odd").val();
            if(!pattern.test(ip)){
                layer.alert("请输入合法正确的IP地址");
                return false;
            }

            $.ajax({
                type: "POST",
                url: "/manager/add_ip_ajax",
                data: {"ip":ip},
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res){
                    layer.alert(res.msg);
                    if(res.code){
                        parent.location.reload()
                    }
                }
            });
        })
    });

</script>

</body>

</html>