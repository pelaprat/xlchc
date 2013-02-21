<?php

    function configure_pagination_params( $obj, $uri, $total, $per_page = 30) {

        $config = array();
    
        $config['per_page']        = $per_page;
        $config['uri_segment']     = 4;
        $config['num_links']       = 5;

        $config['base_url']        = base_url() . $uri;
        $config['total_rows']      = $total;
        
        $config['allow_get_array'] = true;
        
        // Paging Style.
        $config['full_tag_open']   = "<div class=\"box\"><ul class=\"paginator\">\r";
        $config['full_tag_close']  = "</ul></div>\r";

        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = "</li>\r";
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = "</li>\r";
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = "</li>\r";
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = "</li>\r";

        $config['cur_tag_close']   = "</a></b></li>\r";
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = "</li>\r";
        $config['cur_tag_open']    = "<li><b><a href='" . $config['base_url'] . "/" . $obj->uri->segment(4) . "'>";

	    return $config;
    }

?>