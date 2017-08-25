<?php
//var_dump($_FILES["file"]);
//print_r($_FILES);
//return;

$path="./files/";//定义一个上传后的目录
//$upfile=isset($_FILES["file"])?$_FILES["file"]:die("上传过程不合法！");   //pic是前面index.php上传文件时的name值！
foreach ($_FILES as $FILE) {
	$upfile = isset($FILE)?$FILE:die("上传过程不合法！");
	//1.获取上传文件信息
	//定义允许的类型 ，如果需要上传其他文件你只要对应的改文件属性就可以了，注意按格式。我这里主要是设置了只能上传图片，当然你也可以不要这个定义就可以什么都上传了。
	$typelist=array("image/jpeg","image/jpg","image/png","image/gif","text/plain","multipart/form-data","application/pdf","application/octet-stream");
	//上传后存放的路径
	$path="./files/";//定义一个上传后的目录

	//2.过滤上传文件的错误号
	if($upfile["error"]>0){ //$upfile["error"]是文件错误机制，可以针对对应提示的错误编码来对应的显示错误信息。
		//获取错误信息
		switch($upfile['error']){
			case 1:  
				$info="上传得文件超过了 php.ini中upload_max_filesize 选项中的最大值.";
				break;
			case 2:
				$info="上传文件大小超过了html中MAX_FILE_SIZE 选项中的最大值.";
				break;
			case 3:
				$info="文件只有部分被上传";
				break;
			case 4:
				$info="没有文件被上传.";
				break;
			case 6:
				$info="找不到临时文件夹.";
				break;
			case 7:
				$info="文件写入失败！";
				break;
		}
		echo("上传文件错误,原因:".$info);  //die是直接把错误输出并且停止继续执行下去
	}
	//3.本次上传文件大小的过滤（自己选择）删除后就可以不限制文件大小
	if($upfile['size']>1024*1024*2){
		echo("上传文件大小超出限制");	
		continue;
	}
	//4.类型过滤
	if(!in_array($upfile["type"],$typelist)){
		echo("上传文件类型非法!".$upfile["type"]);
		continue;
	}
	//5.上传后的文件名定义(随机获取一个文件名)
	$fileinfo=pathinfo($upfile["name"]);//解析上传文件名字
	//这里给文件的名字设置为当前时间年月日时分秒+随机设置数字，这一就可以防止名字冲突而覆盖了。
	//$newfile=date("YmdHis").rand(1000,9999).".".$fileinfo["extension"];
	$newfile=$upfile["name"];
	//为的是判断是否已经存在文件名称和路径
	if(file_exists($path.$newfile)){
		echo(" $newfile 文件名已存在！");
		continue;
	}

	//6.执行文件上传
	//判断是否是一个上传的文件
	if(is_uploaded_file($upfile["tmp_name"])){
		//执行文件上传(移动上传文件)  -->需要移动文件到当前的路径
		if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
			echo "文件上传成功!";//如果上传成功就提示成功
		//注意：如果你是想把文件名存到数据库你需要在这里直接用sql语句执行添加东西到数据库就可以了，并且文件的路径+名字是:$path.$newfile.
		}else{
			echo("上传文件失败！"); //如果上传失败就提示失败
		}
	}else{
		echo("不是一个上传文件!"); //如果不是文件就提示这个
	}
}
?>