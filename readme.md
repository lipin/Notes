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