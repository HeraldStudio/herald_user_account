##先声网用户中心使用文档
----------

###一、web应用中引导用户登录

####1.web页面中使用方法

在web页面中加入以下代码<pre>`<a href="http://herald.seu.edu.cn/useraccount/login.html?redirecturl={登录成功后跳转的连接地址}">登录</a>`</pre>
注：如果没有传递`redirecturl`参数，则默认跳转回发送请求的页面。

####2.其他需要返回信息的应用中使用方法

在某些应用中需要获取到登录用户的信息，可以向`http://herald.seu.edu.cn/useraccount/login.php`发送POST请求，参数：`{username: 一卡通号, password: 密码}`便可得到返回结果。

具体返回值说明：

<pre>
i.验证成功返回JSON：

{"code":200,"message":"登录成功!","data":"{\"truename\":XXX,\"cardnum\":213xxxxxx}"}

包含了用户的一卡通号和真实姓名的JSON信息。

ii.用户名或密码错误返回JSON：

{"code":1,"type":"AccountError","message":"用户名或密码错误!"}

iii.服务器故障返回JSON：

{"code":500,"type":"ServerError","message":"服务器故障!"}
</pre>

3.返回结果代码说明

>可以通过打印返回结果中的`code`字段查看返回代码
><table>
    <thead><tr><th>代码</th><th>说明</th></tr></thead>
    <tbody><tr><td>200</td><td>正确返回结果</td></tr><tr><td>1</td><td>用户名或密码错误</td><tr><td>500</td><td>服务器故障，(可能是网络连接错误，无法访问一卡通中心)</td></tr></tr></tbody>
</table>

###二、在web应用中获取当前登录用户

>获取键值为`HERALD_USER_SESSION_ID`的cookie，然后POST到`http://herald.seu.edu.cn/useraccount/getloginuserinfo.php`,参数名称是cookie。

###三、在web应用中登出

>获取键值为`HERALD_USER_SESSION_ID`的cookie，然后POST到`http://herald.seu.edu.cn/useraccount/logout.php`，参数名称是cookie。

###四、以上操作返回值说明

1.获取当前登录用户时返回结果

<pre>
有用户登录返回

{"code":200,"message":"已有用户登录!","data":"{\"truename\":XXX,\"cardnum\":213xxxxxx}"}

没有用户登录登录返回

{"code":404,"message":"没有用户登录!"}

cookie值为空返回

{"code":1,"type":"BadDataPost","message":"No cookie error!"}
</pre>

2.用户退出时返回

<pre>退出成功返回

{"code":200,"message":"登出成功!"}

cookie值为空时返回

{"code":3,"type":"CookieError","message":"cookie不存在!"}
</pre>

###五、使用示例

####Ruby On Rails

**1.调用方法**

新建`sessions`控制器

    rails generate controller Sessions --no-test-framework

在`sessions_helper.rb`文件中添加代码

    module SessionsHelper
    	def require_data
        current_cookie = cookies[:HERALD_USER_SESSION_ID]
        params = {'cookie' => current_cookie}
    		reponse_data = Net::HTTP.post_form(URI.parse('http://herald.seu.edu.cn/useraccount/getloginuserinfo.php'),params)
      end
    
      def has_user_login?
      	response_data_json = JSON::parse(require_data.body)
      	if response_data_json['code'] == 200
      		return true
      	else
      		return false
      	end
      end
    
      def current_user_info
      	response_data_json = JSON::parse(require_data.body)
      	current_user_info = JSON::parse(response_data_json['data'])
      end
    
      def user_logout
        current_cookie = cookies[:HERALD_USER_SESSION_ID]
      	params = {'cookie' => current_cookie}
    		reponse_data = Net::HTTP.post_form(URI.parse('http://herald.seu.edu.cn/useraccount/logout.php'),params)
      	response_data_json = JSON::parse(reponse_data.body)
      end
    end

**2.使用方法**

controller中获取登录用户信息

    if has_user_login? #判断是否有用户登录
    	@cardnum = current_user_info['cardnum']#获取用户一卡通号
    	@truename = current_user_info['truename']#获取用户姓名 
    	...
    else
    	...
    end

用户退出

>post方式访问/session/logout即可