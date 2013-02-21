
    <script type='text/javascript'>

        var tl;
        $(document).ready(function() {

            var eventSource = new Timeline.DefaultEventSource(0);
            
            // Example of changing the theme from the defaults
            // The default theme is defined in 
            // http://simile-widgets.googlecode.com/svn/timeline/tags/latest/src/webapp/api/scripts/themes.js
            var theme = Timeline.ClassicTheme.create();
            //alert(theme);
            var lchctheme = Timeline.LCHCTheme.create();

<?php
            //in php you can get this 1so8601 date using date("c",$you_date_variable);
    echo "            var startProj = SimileAjax.DateTime.parseIso8601DateTime('$startTimeLineDate');\n";
    echo "            var endProj = SimileAjax.DateTime.parseIso8601DateTime('$endTimeLineDate');\n";
?>         

            theme.mouseWheel = "default";
            theme.timeline_start = startProj;
            theme.timeline_stop  = endProj;
            
            theme.event.bubble.width = 350;
            theme.event.bubble.height = 300;
            
            var d = Timeline.DateTime.parseGregorianDateTime("2005")
            
            
            var bandInfos = [
                Timeline.createBandInfo({
                    width:          "10%", 
                    intervalUnit:   Timeline.DateTime.YEAR, 
                    intervalPixels: 50,
                    eventSource:    eventSource,
                    date:           d,
                    theme:          lchctheme ,
                    layout:         'overview'  // original, overview, detailed
                }),
                Timeline.createBandInfo({
                    width:          "90%", 
                    intervalUnit:   Timeline.DateTime.MONTH, 
                    intervalPixels: 150,
                    eventSource:    eventSource,
                    date:           d,
                    theme:          theme,
                    layout:         'original'  // original, overview, detailed
                })/*,
                Timeline.createBandInfo({
                    width:          "10%", 
                    intervalUnit:   Timeline.DateTime.YEAR, 
                    intervalPixels: 50,
                    eventSource:    eventSource,
                    date:           d,
                    theme:          theme,
                    layout:         'overview'  // original, overview, detailed
                })*/
            ];
            bandInfos[0].syncWith = 1;
            bandInfos[0].highlight = true;
            /*
            bandInfos[2].syncWith = 1;
            bandInfos[2].highlight = true;
            */

            bandInfos[0].decorators = [
                new Timeline.SpanHighlightDecorator({
                    startDate:  startProj,
                    endDate:    endProj,
                    inFront:    false,
                    color:      "#8080ff",
                    opacity:    30,
                    startLabel: "",
                    endLabel:   "",
                    theme:      theme
                })
            ];
            /*
            bandInfos[2].decorators = [
                new Timeline.SpanHighlightDecorator({
                    startDate:  startProj,
                    endDate:    endProj,
                    inFront:    false,
                    color:      "#8080ff",
                    opacity:    20,
                    startLabel: "",
                    endLabel:   "",
                    theme:      theme
                })
            ];
            */
                                  
            tl = Timeline.create(document.getElementById("tl"), bandInfos, Timeline.HORIZONTAL);
            // Adding the date to the url stops browser caching of data during testing or if
            // the data source is a dynamic query...

<?php
    echo "            var searchParams =  'words=" . urlencode($words) .
                                          "&index_start=0&mode=" . $mode . 
                                          "&startDateInt=" . $startDateInt . 
                                          "&endDateInt=" . $endDateInt . 
                                          "&todayis=' + (new Date().getTime());\n";
    echo "            var jsonURL = '/json_rpc/getSearchThreadsTimeLine?' + searchParams;\n";
    echo "            tl.loadJSON(jsonURL, function(json, url) {\n";
?>
                eventSource.loadJSON(json, url);
            });
            
            /*
                HACK to control the display of very long pop-ups comgin from xmca search.
            */
            Timeline.OriginalEventPainter.prototype._showBubble = function (A,E,B){
                var D = document.createElement("div");
                var C = this._params.theme.event.bubble;

                $(D).load("xmca?threadId=" + B.getDescription() + "&" + searchParams + " #xmca-thread-messages", function(){
                    var threadHTML = this.innerHTML;
                    var width = 580, height = 480;
                    
                    D.innerHTML = "<div style='width:" + width + "px;height:" + height + "px;overflow-y:scroll;overflow-x:hidden;margin:0px 20px 0px 0px;'>.</div>";
                    
                    SimileAjax.WindowManager.cancelPopups();
                    SimileAjax.Graphics.createBubbleForContentAndPoint(D,A,E,C.width,null,C.maxHeight);

                    window.setTimeout(function (){                    
                        var xmcaContent = $(".simileAjax-bubble-contentContainer");
                        xmcaContent.css({"height": height, "width":(width + 25)});
                        $(".simileAjax-bubble-innerContainer").css({"height": xmcaContent.height(), "width":xmcaContent.width(), "border":"solid"});
                        $(".simileAjax-bubble-container").css({"width":(xmcaContent.width() + 5)});
                        D.innerHTML = threadHTML;

                    }, 210);
                });                
            };
        });
        var resizeTimerID = null;
        function onResize() {
            if (resizeTimerID == null) {
                resizeTimerID = window.setTimeout(function() {
                    resizeTimerID = null;
                    tl.layout();
                }, 500);
            }
        }
        
    </script>

<table width='100%'>

<?php
    echo "<tr><td>" . searchWidget($words, $mode, $simplehtml, $date_start, $date_end) . "</td></tr>";
    echo "<tr><td><div id='tl' class='timeline-default' style='height: 470px; width:100%; overflow-x:hidden; overflow-y:scroll;'></div></td></tr>";
    //echo "<tr><td><div id='tl' class='timeline-default' style='height: 500px; width:100%;'></div></td></tr>";
?>
</table>