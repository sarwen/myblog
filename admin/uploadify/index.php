<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<h1>Uploadify Demo</h1>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form>
	<div id="uploadfiles"></div>
	<div id="fileQueue" style="clear:both"></div>
	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'buttonText': '选择文件..',
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php'
			});
		});
	</script>
	<script type="text/javascript">
		var timestamp = new Date().getTime();
		var token = Math.floor(Math.random() * 1000) + timestamp;
		$(function() {
			$('#file_upload').uploadify({
				'buttonText': '选择文件..',
				'fileObjName': 'simplefile',
				'method': 'post',
				'multi': true,
				'queueID': 'fileQueue',
				//'uploadLimit': 2,
				'fileTypeExts': '*.gif;*.png;*.jpg;*.bmp;*.jpeg;',
				'buttonImage': '/static/js/uploadify/select.png',
				'formData': {
					'timestamp': timestamp,
					'token': token
				},
				'swf': 'uploadify.swf',
				'uploader': 'uploadify.php',
				'onUploadStart': function() {
					$imgHtml = '<img class="upload_load" src="upload.gif" align="absmiddle" />';
					$('#uploadfiles').append($imgHtml);
				},
				'onUploadSuccess': function(file, data, response) {
					$('.upload_load').remove();
					var json = $.parseJSON(data);
					if (json.state == 'success') {
						$imgHtml = '<span id="file_' + json.file_id + '">';
						$imgHtml += '<a href="' + json.file + '" target="_blank">';
						$imgHtml += '<img src="' + json.file + '" width="100" height="100" align="absmiddle"/>';
						$imgHtml += '</a>';
						$imgHtml += '<a href="javascript:uploadifyRemove("' + json.file + '")">删除</a>';
						$imgHtml += '</span>';
						$($imgHtml).appendTo('#uploadfiles');
					} else {
						alert(json.message);
					}
				},
				'onQueueComplete': function() {
					$('.upload_load').remove();
				}
			});
		});
	</script>
</body>
</html>