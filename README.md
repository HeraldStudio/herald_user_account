##先声网用户中心使用文档


----------

###一、web应用中引导用户登录

1.web页面中使用方法

>在web页面中加入以下代码<pre>`<a href="http://herald.seu.edu.cn/useraccount/login.html?redirecturl={登录成功后跳转的连接地址}">登录</a>`</pre>
注：如果没有传递`redirecturl`参数，则默认跳转回发送请求的页面, 如果是直接访问的这个页面，则跳转至先声首页。

2.其他需要返回信息的应用中使用方法

>在某些应用中需要获取到登录用户的信息，可以向`http://herald.seu.edu.cn/useraccount/login.php`发送POST请求，参数：`{username: 一卡通号, password: 密码}`便可得到返回结果。<br/>
具体返回值说明：<pre>
i.验证成功返回JSON：
{"code":200,"message":"登录成功!","data":"{\"truename\":XXX,\"cardnum\":213xxxxxx}"}
包含了用户的一卡通号和真实姓名的JSON信息。
ii.用户名或密码错误返回JSON：
{"code":1,"type":"AccountError","message":"用户名或密码错误!"}
iii.服务器故障返回JSON：
{"code":500,"type":"ServerError","message":"服务器故障!"}
</pre>

3.返回结果代码说明

>可以通过打印返回结果中的`code`字段查看返回代码<table>
    <thead><tr><th>代码</th><th>说明</th></tr></thead>
    <tbody><tr><td>200</td><td>正确返回结果</td></tr><tr><td>1</td><td>用户名或密码错误</td><tr><td>500</td><td>服务器故障，(可能是网络连接错误，无法访问一卡通中心)</td></tr></tr></tbody>
</table>