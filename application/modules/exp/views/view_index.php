<div class="center">

    <div id='home_center_top_content' class="table_image">
        
        <div class="spotlight" >
        
            <div class="spotlight_title" id='spotlight_title'>
                <h1><?=$rand_spotlight->title;?></h1>
            </div>
            <div class="spotlight_top" id='spotlight'>
                <div>            
                    <p><?=html_entity_decode($rand_spotlight->description);?></p>
                </div>
            </div>
            <div class="spotlight_bottom"  id='spotlight_menu'>
                <table><tr><td>
                <div class='spotlight_bottom_menu'>Spotlights: </div>
                <?php
                $count = 0;
                foreach($all_spotlights as $sp){
                    $class = "spotlight_bottom_menu";
                    $class .= $rand_spotlight->id == $sp->id ? " spotlight_index_highlight": " spotlight_index";
                    echo "<div class='$class' id='spotlight_" . $sp->id . "'>". ++$count . "</div>";
                }
                ?>
                <script type="text/javascript"><!--                
                    $(document).ready(function(){
                        $("#spotlight_menu * div").each(function(k, v){
                            if(null != v.id){
                                $(v).bind('click', function(){
                                
                                    var cur_sp = $(".spotlight_index_highlight");
                                    
                                    if(0 < cur_sp.length && cur_sp[0].id == this.id) return;
                                    
                                    var id = v.id.substr(v.id.indexOf('_') + 1);
                                    
                                    $.getJSON("json_rpc/getSpotlight/" + id, function(data) {
                                        $("#spotlight_title").html("<h1>" + data.title + "</h1>");
                                        $("#spotlight").html("<div><p>" + data.description + "</p></div>");
                                        cur_sp.removeClass("spotlight_index_highlight").addClass("spotlight_index");
                                        
                                        $("#spotlight_" + id).addClass("spotlight_index_highlight");
                                    });
                                });
                            }
                        });
                    });
                --></script>
                </td></tr></table>
            </div>
        </div>
        
    </div>
    
    <div class="bottom">
        <div id='map_header_surround' style="width: 984px; margin-top: 3px;">
            <div id='lchc_world_partners' style='margin:0px 5px 0px 0px; float:left;'>
            <img src="assets/images/InternationalCommunity.png" /></div>
            <div id='sci_fi_hist' style='margin:0px 100px 0px 0px; float:right;'><img src="assets/images/TrendingNow.png" /></div>
            <div style='clear:both'></div>
        </div>
        <div id='xmca_header_surround'></div>


        <div class="map">
                
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                <script type="text/javascript"><!--
                    $(document).ready(function(){ 
                        $("#lchc_world_partners").bind('click', function(){
                            createMap(prepareHomeCenterTopContent()[0]);
                        });

                        $("#sci_fi_hist").bind('click', function(){
                            createSciFiMap(prepareHomeCenterTopContent()[0]);
                        });
                        
                        $("#xmca_header_surround").bind('click', function(){
                            createXMCAWidget(prepareHomeCenterTopContent()[0]);
                        });

                        //Shadowbox.init();
                        
                        createMap(document.getElementById("map_canvas"));
                    });    
                    
                    function prepareHomeCenterTopContent(){
                        var hct = $("#home_center_top_content");
                        hct.empty();
                        var h = hct.css("height").replace("px", "");
                        var w = hct.css("width").replace("px", "");
                        hct.html("<div id='big_map_div' style='width:" + (w - 8) + "px;height:" + (h - 2) + "px;overflow-x:hidden;word-wrap: break-word;position:relative;left:1px;top:0px;padding:2px 2px 2px 2px;'></div>");
                        return $("#big_map_div");
                    }
                    
                    function createSciFiMap(div){
                        $(div).html("<iframe src='/sci_fi_hist.html' scrolling='auto' style='border-style:none;overflow-y:visible;width:100%;height:100%;background-color:#ffffff;'></iframe>");
                    }
                    
                    function createXMCAWidget(div){
                        $(div).html("<iframe src='/xmca?simplehtml=true' scrolling='auto' style='border-style:none;overflow-y:visible;width:100%;height:100%;background-color:#ffffff;'></iframe>");
                    }
                    
                    function createMap(div, zoomLevel){
                
                        var myLatlng = new google.maps.LatLng(32.768663,-117.105709);
                        var myOptions = {
                          zoom: (null == zoomLevel ? 1:zoomLevel),
                          center: myLatlng,
                          mapTypeId: google.maps.MapTypeId.HYBRID
                        }
                        var map = new google.maps.Map(div, myOptions);
                                        
                        $.ajax({
                            type: "GET",
                            url: "json_rpc/getPartnerProjectsSimple",
                            success: function(data){
                                for(var i=0; i < data.length; ++i){
                                    putOnMap(data[i], map);
                                }
                            }
                        });
                    }

                    function putOnMap(mapItem, map){
                        
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(mapItem.latitude,mapItem.longitude),
                            map: map
                            });
                            
                        google.maps.event.addListener(marker, 'click', function(){    
                        
                            $.ajax({
                                type: "GET",
                                url: "http://dev.lchc.ucsd.edu/json_rpc/getPartnerProjectData/" + mapItem.id,
                                success: function(data){
                                    new google.maps.InfoWindow({content: data[0].description}).open(map, marker);
                                }
                            });
                        });
                    }
                     
                    
                --></script>
                
            <div id="map_canvas" style='width:100%;height:100%;'></div>
            
        </div>
        
        <div class="xmca">
        
            <div id="xmca_posts_container">        
            
            <ul id="xmca_posts">
            
            <?php
            if(isset($discussions)) {
                foreach( $discussions as $discussion ){
                    echo '<li><div class="xmca_post">';
                    echo '    <div class="xmca_post_author">';
                    echo '      <img src="http://devgrow.com/plugins/jcollapsible/gravatar.gif" alt="" />';
                    echo '      <a href="/people/' . $discussion->pID . '" title="View all XMCA discussions with ' . htmlentities($discussion->auth_name) .' participating">' . htmlentities($discussion->auth_name) . '</a>';
                    echo '    </div>';
                    echo '    <div class="xmca_post_body">';
                    echo '      <h3><a href="/xmca?threadId=' . $discussion->yID . '">' . htmlentities($discussion->name) . '</a></h3>';
                    echo '      <abbr title="' . date('l, F jS, Y \a\t g:iA (T)', strtotime($discussion->updated_at)) . '">' . date('m.d.y', strtotime($discussion->updated_at)) . '</abbr>';
                    echo '    </div>';
                    echo '</div></li>';
                }
            } 
            ?>    
            
     
            </ul>
        </div>

    </div>   



</div>

    </div>
     