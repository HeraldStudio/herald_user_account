#先声网用户中心使用方法
============================
##一、应用中引导用户登录

<p>在应用中提供链接至<a>http://herald.seu.edu.cn/useraccount/</a>页面，引导用户登录即可，登录后会自动跳转到之前页面</p>

##二、应用中获取会话状态的方法

<p>首先获取键值为HERALD_USER_SESSION_ID的cookie，然后在herald_session表中查找该cookie值对应的一条记录，即可获取到

相应的user_id，和ip 当满足访问者ip与数据表中的ip相等并且当前时间戳小于expired_time时，表示用户处于登录状态。</p>
