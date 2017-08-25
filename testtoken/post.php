<?php
/**	$var1 = isset($_POST["user"])?$_POST["user"]:"";
	$var2 = isset($_POST["password"])?$_POST["password"]:"";

	echo"123\n";
	echo $var1."\n";
	echo $var2;
	
	if (!empty($_FILES)) {
     function rearrange_files_array(array $array) {
         foreach ($array as &$value) {
             $_array = array();
             foreach ($value as $prop => $propval) {
                 if (is_array($propval)) {
                     array_walk_recursive($propval, function(&$item, $key, $value) use($prop) {
                         $item = array($prop => $item);
                     }, $value);
                     $_array = array_replace_recursive($_array, $propval);
                 } else {
                     $_array[$prop] = $propval;
                 }
             }
             $value = $_array;
         }
         return $array;
     }
     echo '<pre>'.print_r(rearrange_files_array($_FILES), true).'</pre>';
 }
 //var_dump($_FILES);
$uploads_dir = '/files';
foreach ($_FILES["0"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["0"]["tmp_name"];
        $name = $_FILES["0"]["name"];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
    }
}**/

$upfile=$_FILES["0"]; 
//判断是否是一个上传的文件
if(is_uploaded_file($upfile["tmp_name"])){
	//执行文件上传(移动上传文件)  -->需要移动文件到当前的路径
	if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
		echo "文件	上传成功!";//如果上传成功就提示成功
	//注意：如果你是想把文件名存到数据库你需要在这里直接用sql语句执行添加东西到数据库就可以了，并且文件的路径+名字是:$path.$newfile.
	}else{
		die("上传文件失败！"); //如果上传失败就提示失败
	}
}else{
	die("不是一个上传文件!"); //如果不是文件就提示这个
}
 
 
/**	
	$uploaddir = '/files/';
	$uploadfile = $uploaddir . basename($_FILES['txt']['name']);

	//echo '<pre>';
	if (move_uploaded_file($_FILES['txt']['tmp_name'], $uploadfile)) {
		echo "File is valid, and was successfully uploaded.\n";
	} else {
		echo "Possible file upload attack!\n";
	}

	echo 'Here is some more debugging info:';**/
	//print_r($_FILES);

	//print "</pre>";
?>