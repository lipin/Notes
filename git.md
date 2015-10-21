## Git 常用资源
-------------------
### Git常用操作

#### 查看历史
```python
git log --pretty=oneline filename // 一行显示
git show xxxx // 查看某次修改
```
#### 删除远程分支
```python
git push orgin :remote_name
```
#### 恢复（删除）本地改动文件/新增文件夹
```python
git clean -d
git clean -df 
```

#### 创建分支
```python
git branch develop // 只创建分支
git checkout -b master develop // 创建并切换到 develop 分支
```
#### 合并分支
```python
git checkout master // 切换到主分支
git merge --no-ff develop // 把 develop 合并到 master 分支，no-ff 选项的作用是保留原分支记录
git rebase develop // 合并分支
git branch -d develop // 删除 develop 分支
```
#### 标签功能
```python
git tag // 显示所有标签
git tag -l 'v1.4.2.*' // 显示 1.4.2 开头标签
git tag v1.3 // 简单打标签   
git tag -a v1.2 9fceb02 // 后期加注标签
git tag -a v1.4 -m 'my version 1.4' // 增加标签并注释， -a 为 annotated 缩写
git show v1.4 // 查看某一标签详情
git push origin v1.5 // 分享某个标签
git push origin --tags // 分享所有标签
```
#### 回滚操作
```python
reset --hard v0.1
reflog
reset --hard v0.2
```
#### 取消某个文件的修改
```python
git checkout -- <filename>
```
删除文件
```python
git rm <filename>   直接删除文件
git rm --cached <filename>    删除文件暂存状态
```
移动文件
```python
git mv <sourcefile> <destfile>
```
查看文件更新
```python
git diff              查看未暂存的文件更新 
git diff --cached     查看已暂存文件的更新 
```
克隆远程分支
```python
git branch -r
git checkout origin/android
```
修复develop上的合并错误
```python
将merge前的commit创建一个分之，保留merge后代码
将develop reset --force到merge前，然后push --force
在分支中rebase develop
将分支push到服务器上重新merge
```
Git设置
```python
Git的全局设置在~/.gitconfig中，单独设置在project/.git/config下。

忽略设置全局在~/.gitignore_global中，单独设置在project/.gitignore下。
```
设置 commit 的用户和邮箱
```python
[user]
    name = xxx
    email = xxx@xxx.com
```
替换本地改动
```python
假如你想丢弃你在本地的所有改动与提交，可以到服务器上获取最新的版本历史，并将你本地主分支指向它：
git fetch origin
git reset --hard origin/master
```
实用小贴士
```python
内建的图形化 git：
gitk
彩色的 git 输出：
git config color.ui true
显示历史记录时，每个提交的信息只显示一行：
git config format.pretty oneline
交互式添加文件到暂存区：
git add -i
```