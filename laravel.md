------
# Laravel - Mass Assignment安全问题

查到了Laravel中文手册，其中是这样描述的：
> 
在建立一个新的模型时，您把属性以数组的方式传入 create 方法，这些属性值会经由 mass-assignment 存成模型数据。这非常方便，然而，若盲目地将用户输入存到模型时，可能会造成严重的安全隐患。如果盲目的存入用户输入，用户可以随意的修改任何以及所有模型的属性。基于这个理由，所有 Eloquent 模型默认会防止 mass-assignment 。
在模型里设定 fillable 或 guarded 属性作为开始。
fillable 属性指定了哪些字段支持 mass-assignable 。可以设定在类里或是建立实例后设定。
guarded 与 fillable 相反，是作为「黑名单」而不是「白名单」：

## 在Laravel中使用Eloquent ORM，如想新增，更新数据，必须在对应Model中设置 fillable 或 guarded 属性。
具体设置规则请查阅手册http://laravel-china.org/docs/eloquent#mass-assignment

------
# laravel身份验证-Auth的使用
## laravel自带了auth类和User模型来帮助我们很方便的实现用户登陆、判断。
`app/config/auth.php`：
model 指定模型
table 指定用户表
通过 `Auth::check()` 就可以判断用户是否登陆状态，如果不是的话，直接重定向到 /login 这个url，为什么用`Redirect::guest()`而不用`Redirect::to()`呢，通过api手册可以查到：
`Redirect::guest()` 在重定向时会将当前url保存到session中，这样可以在登陆以后，使用`Redirect::intended()`方法跳转到之前的页面继续业务。
跳转到/login这个页面，当然得实现写好路由，可以指向某个控制器方法，详细的就不提了，假设login表单提交处理方法大致如下：
```python
public function postLogin()
{
    if (Auth::attempt(array('email' => $email, 'password' => $password)))
    {
        return Redirect::intended('/');
    }
}
```

`Auth::attempt()`方法可以用来验证用户提交的登陆信息是否和user表里的匹配，在例子中，password这个字段是固定的，你在user表中也应当有对应的字段，并且宽度至少60，切记不是MD5。而email字段就随便了，可能你是使用username作为唯一标识符的，这个因项目而异吧，这里就随便以 email 作为登陆账户名了，数据库中也有相应的字段。
可能有人会比较难以理解，其实只要换个角度，Auth只是帮我们实现了本来需要自己写的验证逻辑，还记得一开始配置的参数中有model和table，Auth就是根据这个自动帮我们查询，如果匹配成功会自动帮我们写入session，这样下次`Auth::check()`的时候就通过了。
`Redirect::intended('/')`这个方法的意思是跳转到之前的页面，如果像上面那样使用了`Redirect::guest()`方法，那么intended这里就会跳转到那时候的url，而它的参数只是一个默认值，再没有记录历史url的时候会跳转到'/'。

还可以继续优化，比如我们不应当在`BaseController`中进行`Auth::check`,我们可以利用`Route::filter`，在请求之前就进行验证，这方面可以参考手册中Route的相关章节。

Auth还有一些其他的方法，比如 `Auth::basic()` 可以实现`http basic`认证，详细的可以参考手册 "身份验证" 章节，以及相关api，本文只是描述下大致的验证流程，不会深究了
好的