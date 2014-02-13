<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    
	<title><?php echo ( isset($title)) ? $title : ''; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

<?php foreach (@$this->css as $css) { ?>
    <link rel="stylesheet" href="<?php echo $css;?>" type="text/css" media="screen">
<?php } ?>
<?php foreach (@$this->js as $js) { ?>
    <script src="<?php echo $js;?>"></script>
<?php } ?>

</head>
<body>
