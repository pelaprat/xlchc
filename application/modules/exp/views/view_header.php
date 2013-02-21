<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <base href="<?php echo $this->config->item('base_url'); ?>" />
        
        <title>Laboratory of Comparative Human Cognition</title>
        <link rel="Shortcut Icon" href="assets/images/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="assets/styles/default.css" />
        <link rel="stylesheet" type="text/css" href="assets/styles/xmca.css" />
        

        <meta name="description" content="" />
        <meta name="keywords" content="" />


        <!-- jQuery 1.4.2 and jQuery UI 1.8.1: -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="assets/scripts/jquery.filter_input.js"></script>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css" type="text/css" media="screen, projection" />

    
        <link rel="stylesheet" type="text/css" href="assets/shadowbox-3.0.3/shadowbox.css" />
        <script type="text/javascript" src="assets/shadowbox-3.0.3/shadowbox.js"></script>
        <script type="text/javascript" src="assets/scripts/jquery.xdomainajax.js"></script>
        <!-- <script type="text/javascript" src="assets/scripts/jquery.jfeed.pack.js"></script> -->
        
        <script src="http://api.simile-widgets.org/timeline/2.3.1/timeline-api.js?bundle=true" type="text/javascript"></script>
        <script  type="text/javascript" src="assets/timeline-2.3.1/timeline_js/my-theme.js"></script>
        <link rel='stylesheet' href='http://api.simile-widgets.org/timeline/2.3.1/timeline-bundle.css' type='text/css' />




        <!-- Google Analytics: -->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-21644156-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </head>
<body id="<?php echo $body_id;?>" >

<div class="<?php echo $body_content_class;?>">

<div class="content">

    <div class="header">
        
        <div class="logo">
            
            <a href="/"><img src="assets/images/logo.png" alt="Laboratory of Comparative Human Cognition" /></a>
            
        </div>
        
        <div class="search_menu">
            
            <div class="search">
                <span style="float: left;">SEARCH:</span>
                        <form action="" method="get" name="search_form">
                            <input id="site_search" name="search_field" type="text" value="" size="25" maxlength="26" />
                            <input name="submit" type="button" value="GO" />
                        </form>
                        <script type="text/javascript"><!-- 
                            var search = $("#site_search");
                            search.focus();
                            search.keyup(function(event){
                            
                                if(!(event.keyCode >= 65 && event.keyCode <= 90 ||
                                     event.keyCode >= 97 && event.keyCode <= 122   )){
                                    return;
                                } 
                                
                                if(search[0].value.length < 2) { return;}
                                
                                document.title += search[0].value + "|";
                                
                            }).keydown(function(event){
                                if(8 == event.keyCode){
                                    document.title += search[0].value + "|";
                                }
                            });
                          --></script>
                    
            </div>
            
            <div class="menu">
            
                <ul id="navlist">
                    <li><a href="about" id="about_lchc_nav">About LCHC</a></li>
                    <li><a href="people" id="people_nav">People</a></li>
                    <li><a href="publications" id="publications_nav">Publications</a></li>
                    <li><a href="research" id="research_nav">Research</a></li>
                    <li><a href="resources" id="resources_nav">Resources</a></li>
                    <li><a href="xmca" id="xmca_nav">XMCA</a></li>
                </ul>
                
            </div>
            
        </div>        
    </div>