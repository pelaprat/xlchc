<?php
    $ci =& get_instance();
    if(isset($ci->session)){
        $p = $ci->session->userdata['admin-user-info'];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Website Name &raquo; Administration &raquo; Dashboard</title>

        <base href="<?php echo $this->config->item('base_url'); ?>">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en-US" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />

        <!-- jQuery 1.4.2 and jQuery UI 1.8.1: -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.js"></script>
        
        <script type="text/javascript" src="/assets/scripts/jquery.mediapopup.js"></script>
        
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css" type="text/css" media="screen, projection" />

        <!-- Styles: -->
        <link rel="stylesheet" href="assets/modules/admin/styles/global.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="assets/modules/admin/styles/media.css" type="text/css" media="screen, projection" />

		<!-- Co-LCHC CSS Framework 1.0 -->
		<link rel="stylesheet" href="assets/styles/lchc/admin.css" type="text/css" media="screen, projection">

        <!-- Scripts: -->
        <script type="text/javascript" src="assets/modules/admin/scripts/global.js"></script>
        <script type="text/javascript" src="assets/scripts/add-generic.js"></script>

        <!-- Shadowbox -->
        <link rel="stylesheet" href="assets/shadowbox-3.0.3/shadowbox.css" type="text/css" />        
        <script type="text/javascript" src="assets/shadowbox-3.0.3/shadowbox.js"></script>
        <script type="text/javascript">
            Shadowbox.init();
        </script>


	<!--- CK Editor -->
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript"><!--

            var ckEditTextAreaIDs = {
                                        "pages": ['content'], 
                                        "spotlight": ['description'], 
                                        "people": ['research', 'bio'], 
                                        "partner_projects": ['description']
                                    };
            $(document).ready(function(){
                var page = window.location.href.replace(/.*admin\//, "").replace(/\/add.*|\/edit.*/, "");
                if(null == ckEditTextAreaIDs[page]) return;
                
                $("textarea").each(function(){
                    if(-1 != $.inArray(this.id, ckEditTextAreaIDs[page])){
                        $(this).addClass("ckeditor");
                    }
                });
            });
        --></script>
        
    </head>
    <body>
