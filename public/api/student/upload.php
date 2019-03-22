<?php 

if(isset($_FILES['files'])) {
	
	$errors = [];
	$path = '../../../backend/upload/';
	$exts = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
	
	$all_files = count($_FILES['files']['tmp_name']);
	
	for($i = 0; $i < $all_files; $i++) {
		$file_name = $_FILES['files']['name'][$i];
		$file_tmp = $_FILES['files']['tmp_name'][$i];
		$file_type = $_FILES['files']['type'][$i];
		$file_size = $_FILES['files']['size'][$i];
		$file_ext = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);

		$file = $path . $file_name;

		if (!in_array($file_ext, $exts)) {
			$errors[] = 'Invalid extension: ' . $file_name . ' ' . $file_type;
		}

		if ($file_size > 20000000) {
			$errors[] = 'File size too high: ' . $file_name . ' ' . $file_type;
		}

		if (empty($errors)) {
			move_uploaded_file($file_tmp, $file);
		}
	}
	if ($errors) { print_r($errors); }
}

?>