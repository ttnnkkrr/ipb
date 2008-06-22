<?php

/*
+--------------------------------------------------------------------------
|   Invision Power Board v2.3.5 Chinese Language Package
|   =======================================================================
|   作者: Skylook
|   =======================================================================
|   网站: http://www.ipbchina.com
|   发布: 2008-06-22
|   语言包版权归 IPBChina.COM 所有
+--------------------------------------------------------------------------
*/

//----- SET UP CUSTOM HEADERS AND FOOTERS HERE --//

$lang['header'] = "";

$lang['footer'] = <<<EOF

注意: 此邮件由系统自动生成,请勿回复.

<#BOARD_NAME#> 管理用户组敬启.
<#BOARD_ADDRESS#>

EOF;


//-------------------------------
// Admin created account notification
//-------------------------------

$lang['subject__account_created'] = '您的帐号已经成功创建';
$lang['account_created'] = <<<EOF
<#NAME#>,

您在 <#BOARD_NAME#> 的帐号已经成功创建.

如果在之前的注册过程中我们要求提供监护人的许可证明, 您收到此封信意味着我们已经收到许可证明并且存入文档.

您的帐号信息如下:

会员名称: <#NAME#>
电子邮件: <#EMAIL#>
会员密码: <#PASSWORD#>

请注意我们的论坛不会保存您未加密密码, 同时您也可以在您的个人面板中随时修改密码.

欢迎您访问我们的论坛!

<#BOARD_ADDRESS#>

EOF;


/*------------------------------------------------------------------------------------*/
// IPB 2.2.0
/*------------------------------------------------------------------------------------*/

//-------------------------------
// MODERATED: Add Friend Done
//-------------------------------

$lang['subject__new_friend_approved'] = '新加好友审核通过';
$lang['new_friend_approved'] = <<<EOF
<#MEMBERS_DISPLAY_NAME#>,

<#FRIEND_NAME#> 已经接受了您的加入好友请求!

您可以在这里登录论坛然后查看您的好友列表: <#LINK#>

EOF;

//-------------------------------
// MODERATED: Add Friend
//-------------------------------

$lang['subject__new_friend_request'] = '新加好友申请审核';
$lang['new_friend_request'] = <<<EOF
<#MEMBERS_DISPLAY_NAME#>,

<#FRIEND_NAME#> 希望能够成为您的好友!

您受到这条信息是因为 <#FRIEND_NAME#> 已经将您添加进了好友列表. 因为您选择了新加好友验证, 您可能需要登录到您的好友列表去审核这些申请.

您可以在这里登录论坛然后查看您的好友列表: <#LINK#>

EOF;

//-------------------------------
// Friend added
//-------------------------------

$lang['subject__new_friend_added'] = '新加好友成功';
$lang['new_friend_added'] = <<<EOF
<#MEMBERS_DISPLAY_NAME#>,

<#FRIEND_NAME#> 已经成功地添加您到其好友列表中.

您可以在这里登录论坛然后查看您的好友列表: <#LINK#>

EOF;

//-------------------------------
// MODERATED: Add Friend
//-------------------------------

$lang['subject__new_comment_request'] = '新留言等待审核';
$lang['new_comment_request'] = <<<EOF
<#MEMBERS_DISPLAY_NAME#>,

<#COMMENT_NAME#> 给您留下一条留言等待您的审核.

您受到这条信息是因为 <#COMMENT_NAME#> 在您的个人门户中发表了一条留言.
因为您选择对于每条留言进行验证, 因此在您审核通过这些留言之前他们将不会被显示出来.

您可以在这里登录论坛然后查看您的留言列表: <#LINK#>

EOF;

//-------------------------------
// Friend added
//-------------------------------

$lang['subject__new_comment_added'] = '新加留言成功';
$lang['new_comment_added'] = <<<EOF
<#MEMBERS_DISPLAY_NAME#>,

<#COMMENT_NAME#> 已经给您留下一条留言.

您受到这条信息是因为 <#COMMENT_NAME#> 在您的个人门户中发表了一条留言.

您可以在这里登录论坛然后查看您的留言列表: <#LINK#>

EOF;

/*------------------------------------------------------------------------------------*/
// SUBSCRIPTIONS
/*------------------------------------------------------------------------------------*/

//-------------------------------
// NEW PAID SUBSCRIPTION
//-------------------------------

$lang['subject__new_subscription'] = '新的付费订阅';
$lang['new_subscription'] = <<<EOF
您好!

这封邮件来自: <#BOARD_NAME#> 

请确认您的付费订阅信息.

----------------------------------
购买日期: <#PACKAGE#>
过期时间: <#EXPIRES#>
订阅地址: <#LINK#>
----------------------------------

EOF;

//-------------------------------
// SUBSCRIPTION EXPIRES
//-------------------------------

$lang['subject__subscription_expires'] = '付费订阅过期';
$lang['subscription_expires'] = <<<EOF
您好!

这封邮件来自: <#BOARD_NAME#>

提醒您您购买的付费订阅即将过期.

----------------------------------
购买日期: <#PACKAGE#>
过期时间: <#EXPIRES#>
订阅地址: <#LINK#>
----------------------------------

如果您希望继续使用付费订阅, 请在过期前续费.

如果您无意继续使用付费订阅, 请忽略此信息.

EOF;

$lang['subject__subscription_expires_recurring'] = '订阅过期通知';
$lang['subscription_expires_recurring'] = <<<EOF
您好!

这封邮件来自: <#BOARD_NAME#> 提醒您您购买的付费订阅即将过期.

----------------------------------
购买日期: <#PACKAGE#>
过期时间: <#EXPIRES#>
订阅地址: <#LINK#>
----------------------------------

如果您希望继续使用付费订阅您可以不必进行任何操作, 这样您的续订操作将自动完成.

如果您希望取消您的订阅服务, 您需要登录您的帐号并且在到期之前在后台进行取消订阅的操作. 例如, PayPal 会员需要登录到 PayPal 后台并且在那里取消订阅.

EOF;


//-------------------------------
// NEW MOD __TOPIC__
//-------------------------------

$lang['subject__new_topic_queue_notify'] = '新主题等待审核';
$lang['new_topic_queue_notify'] = <<<EOF
您好!

这封邮件来自: <#BOARD_NAME#>.

一个新主题已加入到待审核列表中等待您的审核.

----------------------------------
主题: <#TOPIC#>
论坛: <#FORUM#>
作者: <#POSTER#>
时间: <#DATE#>
管理待审核列表: <#LINK#>
----------------------------------

如果您不需要这个通知, 您可以很容易地退订这类邮件, 只要在论坛控制选项中删除您的邮件地址即可.

<#BOARD_ADDRESS#>

EOF;

//-------------------------------
// NEW MOD __POST__
//-------------------------------

$lang['subject__new_post_queue_notify'] = '新帖子等待审核';
$lang['new_post_queue_notify'] = <<<EOF
您好!

这封邮件来自: <#BOARD_NAME#>.

一篇新帖子已加入到待审核列表中等待您的审核.

----------------------------------
主题: <#TOPIC#>
论坛: <#FORUM#>
作者: <#POSTER#>
时间: <#DATE#>
管理待审核列表: <#LINK#>
----------------------------------

如果您不需要这个通知, 您可以很容易地退订这类邮件, 只要在论坛控制选项中删除您的邮件地址即可.

<#BOARD_ADDRESS#>

EOF;

//-------------------------------
// FORUM: WEEKLY
//-------------------------------

$lang['subject__digest_forum_weeky'] = '每周新主题摘要';
$lang['digest_forum_weeky'] = <<<EOF
<#NAME#>,

这是这一周在 "<#NAME#>" 中发表的帖子.

----------------------------------------------------------------------


<#CONTENT#>



----------------------------------------------------------------------

您可以点击以下链接阅读此主题:
<#BOARD_ADDRESS#>?showtopic=<#TOPIC_ID#>&view=getnewpost

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;

//-------------------------------
// FORUM: DAILY
//-------------------------------

$lang['subject__digest_forum_daily'] = '每日新主题摘要';
$lang['digest_forum_daily'] = <<<EOF
<#NAME#>,

这是每天的新帖摘要!

----------------------------------------------------------------------


<#CONTENT#>



----------------------------------------------------------------------

您可以点击以下链接阅读此主题:
<#BOARD_ADDRESS#>?showforum=<#FORUM_ID#>

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;

//-------------------------------
// TOPIC: WEEKLY
//-------------------------------

$lang['subject__digest_topic_weeky'] = '每周新帖摘要';
$lang['digest_topic_weeky'] = <<<EOF
<#NAME#>,

这是每周的新帖摘要!

----------------------------------------------------------------------


<#CONTENT#>



----------------------------------------------------------------------

该论坛如下:
<#BOARD_ADDRESS#>?showforum=<#FORUM_ID#>

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;

//-------------------------------
// TOPIC: DAILY
//-------------------------------

$lang['subject__digest_topic_daily'] = '每日新帖摘要';
$lang['digest_topic_daily'] = <<<EOF
<#NAME#>,

这是今天在 "<#TITLE#>" 中发表的帖子.

----------------------------------------------------------------------


<#CONTENT#>



----------------------------------------------------------------------

您可以点击以下链接阅读此帖子:
<#BOARD_ADDRESS#>?showtopic=<#TOPIC_ID#>&view=getnewpost

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;


//----------

$lang['subject__pm_notify'] = '您有新短消息';
$lang['pm_notify'] = <<<EOF
<#NAME#>,

<#POSTER#> 寄了一封短消息给您, 标题为 "<#TITLE#>".

您可以点击以下链接阅读此消息:

<#BOARD_ADDRESS#><#LINK#>

EOF;


$lang['send_text']	= <<<EOF
我想您会对以下的页面感兴趣: <#THE LINK#>

来自

<#USER NAME#>

EOF;

$lang['report_post'] = <<<EOF

<#MOD_NAME#>,

您收到这封信是因为会员 <#USERNAME#> 使用了 "向版主报告此帖子" 的功能.

------------------------------------------------
主题: <#TOPIC#>
------------------------------------------------
帖子链接: <#LINK_TO_POST#>
------------------------------------------------
报告内容:

<#REPORT#>

------------------------------------------------

EOF;


$lang['pm_archive'] = <<<EOF

<#NAME#>,
这封邮件是 <#BOARD_ADDRESS#> 寄出的.

您的短消息存档已经作为一个压缩文件添加在这封信的附件中.

EOF;

$lang['reg_validate'] = <<<EOF

<#NAME#>,
这封邮件是 <#BOARD_ADDRESS#> 寄出的.

您收到该邮件是因为有人使用这个邮件地址在我们的论坛注册.
如果您并没有在我们的论坛注册, 请不要理会这封邮件, 您不需要取消订阅或者做任何进一步的处理.

------------------------------------------------
激 活 提 示
------------------------------------------------

感谢您的注册.
我们需要对您的注册信息有效性做进一步的确认, 以确定您的邮件地址是正确的.
这样做是为了避免垃圾邮件的侵扰及账号资源的恶意抢占.

要激活您的帐号, 请点击以下链接:

<#THE_LINK#>

(AOL邮件的会员可能需要将此链接复制到浏览器).

------------------------------------------------
没起作用?
------------------------------------------------

如果您点击链接后还是无法注册生效, 请访问此页面:

<#MAN_LINK#>

它将会询问您的会员 ID 以及您的启动密码. 您需要提供的资料如下:

会员 ID: <#ID#>

启动密码: <#CODE#>

请复制粘贴或者输入上面的信息到表单相应的位置.

如果这样仍无法激活您的帐号, 有可能是帐号已被管理员删除.
若出现以上情况, 请联系管理员以求解决.

真诚地感谢您注册 <#BOARD_NAME#>,并祝您在本论坛访问愉快!

EOF;

$lang['admin_newuser'] = <<<EOF

亲爱的管理员先生:

您收到该邮件是因为有新会员注册.

<#MEMBER_NAME#> 已在 <#DATE#> 完成注册.

您可以在后台管理中关闭这个会员的注册通知.

祝您愉快.

EOF;

$lang['lost_pass'] = <<<EOF

<#NAME#>,
这封邮件来自 <#BOARD_ADDRESS#> .

您收到这封邮件是因为您在 <#BOARD_NAME#> 使用了查找忘记密码的功能.

------------------------------------------------
重    要!
------------------------------------------------

如果您没有使用查找忘记密码的功能. 请千万不要进行下去.
并请删除这封邮件.

只有在您希望使用查找忘记密码的功能时才可以继续按照以下提示操作.

------------------------------------------------
以下是激活指示
------------------------------------------------

我们要求对您使用查找忘记密码的功能做确认, 以确定您有进行这个操作的资格.
这样做是为了避免垃圾邮件的侵扰及账号资源的恶意抢占.

如果在浏览器中没有看到表单,请点击以下链接.

<#MAN_LINK#>

(AOL邮件的会员可能需要将此链接复制到浏览器).

它将会询问您的会员 ID 以及您的启动密码. 您需要填写的资料如下:

会员 ID: <#ID#>

启动密码: <#CODE#>

请复制粘贴或者输入上面的信息到表单相应的位置.

一旦完成这个操作, 您将可以使用您的新密码(下面显示的)登录, 您也可以在任何时候通过个人控制面板更改您的密码.

------------------------------------------------
没起作用?
------------------------------------------------

如果您点击链接后还是无法注册生效,请访问此页面:

<#MAN_LINK#>

它将会询问您的会员 ID 以及您的启动密码. 您需要填写的资料如下:

会员 ID: <#ID#>

启动密码: <#CODE#>

请复制粘贴或者输入上面的信息到表单相应的位置.

------------------------------------------------
还没有作用吗?
------------------------------------------------

如果您还是无法重新激活您的帐号. 有可能是帐号已被删除或者您正处于其他的激活过程中. 比如正在注册中或者正在更改您注册的邮件地址
如果是这样, 请再次尝试先前的启动过程.
如果问题仍旧存在,请联系管理员.

发件人 IP 地址: <#IP_ADDRESS#>

EOF;

$lang['lost_pass_email_pass'] = <<<EOF

<#NAME#>,
这封邮件是 <#BOARD_ADDRESS#> 寄出的.

这封邮件是通知您关于忘记密码回复请求的处理结果.

------------------------------------------------
您的新密码
------------------------------------------------

您的会员名称: <#USERNAME#>
您的邮件地址: <#EMAIL#>
您的登录密码: <#PASSWORD#>

请在这里登录: <#LOGIN#>

请您在登录论坛的时候使用正确的登录信息 (会员名称或电子邮件) 进行登录.

------------------------------------------------
更改您的密码
------------------------------------------------

当您登录后请在 个人控制面板 中修改您的密码.

个人控制面板: <#THE_LINK#>


EOF;


$lang['newemail'] = <<<EOF

<#NAME#>,
这封邮件是 <#BOARD_ADDRESS#> 寄出的.

您收到这封邮件是因为使用了更改邮件地址功能.

------------------------------------------------
以下是激活指示
------------------------------------------------

我们要求对您使用更改邮件地址功能做进一步确认以确定您有资格进行这个操作.
这样做是为了避免垃圾邮件的侵扰及账号资源的恶意抢占.

如果在浏览器中没有看到表单, 请点击以下链接:

<#THE_LINK#>

(AOL邮件的会员可能需要将此链接复制到浏览器).

------------------------------------------------
没起作用?
------------------------------------------------

如果您点击后仍然无法验证注册, 请访问这个页面:

<#MAN_LINK#>

它将会询问您的会员 ID 以及您的启动密码. 您需要的资料如下:

会员 ID: <#ID#>

启动密码: <#CODE#>

请复制粘贴或者输入上面的信息到表单相应的位置.

一旦启动完成, 您必须登录以更新您的会员档案.

当您激活完成后, 您可能需要登入来更新您的会员用户组权限.

------------------------------------------------
帮助! 发生错误!
------------------------------------------------

如果您无法重新启动您的帐号, 可能是帐号已被删除或者您正处于其他的启动过程中. 比如正在注册或者正在更改您注册的邮件地址, 如果是这样的, 请您先完成上一个启动过程.
如果问题仍旧存在, 请联系管理员.

EOF;

$lang['forward_page'] = <<<EOF

<#TO_NAME#>

<#THE_MESSAGE#>

---------------------------------------------------
请注意 <#BOARD_NAME#> 不对该信息的内容负责.
---------------------------------------------------

EOF;

$lang['subject__subs_with_post'] = '主题订阅回复通知';

$lang['subs_with_post'] = <<<EOF
<#NAME#>,

<#POSTER#> 已经对您订阅的主题 "<#TITLE#>" 进行回复

----------------------------------------------------------------------
<#POST#>
----------------------------------------------------------------------

该主题可以从这里访问:
<#BOARD_ADDRESS#>?showtopic=<#TOPIC_ID#>&view=getnewpost


或许在这个主题后已经有更多的回复. 但是每个订阅主题每天只有一封邮件被寄出.
这是为了限制寄到您信箱的邮件数.

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;

$lang['subject__subs_new_topic'] = '版面订阅回复通知';
$lang['subs_new_topic'] = <<<EOF
<#NAME#>,

<#POSTER#> 在论坛 "<#FORUM#>" 发表了一个新的主题,标题是 "<#TITLE#>".

----------------------------------------------------------------------
<#POST#>
----------------------------------------------------------------------

该主题可在这里找到:
<#BOARD_ADDRESS#>?showtopic=<#TOPIC_ID#>

请注意: 如果您想获得回复这个主题的邮件通知, 您可以点击位于主题页面上方的 "跟踪主题" 链接或者经由以下的链接访问:
<#BOARD_ADDRESS#>?act=Track&f=<#FORUM_ID#>&t=<#TOPIC_ID#>

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;

$lang['subject__subs_no_post'] = '主题订阅回复通知';
$lang['subs_no_post'] = <<<EOF
<#NAME#>,

<#POSTER#> 已经对您订阅的主题 "<#TITLE#>" 进行了回复.

该主题可以从这里访问:
<#BOARD_ADDRESS#>?showtopic=<#TOPIC_ID#>&view=getnewpost

如果您在个人控制面板中选择了 "立即通知所有关于这个主题的回复" 选项, 那么您将会在每一次有新回复时收到邮件通知. 否则, 每个订阅主题在您的下次访问前将只有一封邮件被寄出.
这样的设置是为了能够对您收件箱的订阅邮件数量进行一定的限制.

取消订阅:
--------------

您可以在任何时候登录到您的个人控制面板点击 "查看订阅主题" 的链接来取消订阅.

EOF;


$lang['email_member'] = <<<EOF
<#member_NAME#>,

<#FROM_NAME#> 经由 <#BOARD_ADDRESS#> 发送该邮件给您.

<#MESSAGE#>

---------------------------------------------------
请注意 <#BOARD_NAME#> 不对该信息的内容负责.
---------------------------------------------------

EOF;

$lang['complete_reg'] = <<<EOF

审核成功!

管理员已经批准了您在 <#BOARD_NAME#> 的注册申请或邮件地址变更请求. 您现在可以用您更改后的的资料登录, 并使用您在 <#BOARD_ADDRESS#> 的会员帐号.

EOF;

?>
