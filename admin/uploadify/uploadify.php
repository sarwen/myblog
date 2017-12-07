<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

//删除文件
if(isset($_GET['action'])){
	$file = $_POST['filePath'];
	unlink($file);
	echo $file;
	exit;
}
// Define a destination
$targetFolder = '/uploads'; // Relative to the root
$verifyToken = md5('unique_salt' . $_POST['timestamp']);


//echo $_POST['token'];
//echo $_FILES;
if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	/*$err = array('message'=>dirname($_SERVER['PHP_SELF']),'www'=>$_SERVER['HTTP_HOST']);

	echo json_encode($err,true);exit;*/
	$tempFile = $_FILES['simplefile']['tmp_name'];

	$resPath = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . $targetFolder;
	if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
		$targetPath =$_SERVER['DOCUMENT_ROOT'].'/myblog/admin/uploadify' . $targetFolder;
	}else{
		$targetPath =$_SERVER['DOCUMENT_ROOT'].'/admin/uploadify' . $targetFolder;
	}
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['simplefile']['name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['simplefile']['name']);

	if (in_array($fileParts['extension'],$fileTypes)) {//echo json_encode($aa,true);exit;
		/*$err = array('message'=>'文件上传失败','11'=>is_dir($targetPath),'path'=>$targetPath,'file'=>file_exists($tempFile),'55'=>$targetFile);
		echo json_encode($err,true);exit;*/
		if(!(move_uploaded_file($tempFile,$targetFile) && file_exists($targetPath))){
			$err = array('message'=>'文件上传失败');
			echo json_encode($err,true);exit;
		}
		$res = array(
				'file'=>'http://'.$resPath.'/'.$_FILES['simplefile']['name'],
				'file_id'=>$verifyToken,
				'state'=>'success',
				'path'=>$targetFile
			);
		echo json_encode($res,true);exit;
	} else {
		$err = array('message'=>'文件格式不对');
		echo json_encode($err,true);exit;
		//echo 'Invalid file type.';
	}
}else{
	$err = array('message'=>'验证失败');
	echo json_encode($err,true);exit;
}
?>