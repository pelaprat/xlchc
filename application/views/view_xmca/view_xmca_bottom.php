
    </div>
    
<script type="text/javascript" src='assets/scripts/jquery.filter_input.js'></script>
<script type="text/javascript"><!--

    $(document).ready(function(){
    
        $("#xmca_search_start_date").datepicker();
        $("#xmca_search_end_date").datepicker();

        if( $("#xmca_search_q").length > 0){
            $("#xmca_search_q").filter_input({regex:'[a-zA-Z 0-9]'})
            .keydown(function(event){
                if(13 == event.keyCode){
                    $("#xmca_search_form").submit();
                }
            })
            .focus();
        }
    });
    
--></script>