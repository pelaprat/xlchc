<h1 class='content_header'>Publications</h1>

    <div class="inside_center">    

            <div class="article">

<?php 
if( $publications->num_rows() > 0 ){

    foreach( $publications->result() as $item ){ 
    
        $authors_string = '';
        $issue_string = '';
        $people = $this->Publication_model->get_publication_authors($item->id);
        
        if( $people->num_rows() > 0 ){ 
            foreach( $people->result() as $person ){
                $authors_string .= $person->last.', '.substr($person->first, 0, 1).'., ';
            }
        }
        
        if( !empty($item->journal_issue) )
            $issue_string = "(". $item->journal_issue . ")";
            
        echo "<div class='publication' id='publication-$item->id'>";
        echo substr($authors_string, 0, -2), ' (', $item->journal_year, ') ', $item->title, '. <strong>', $item->journal_title, ',</strong> '.$item->journal_volume.$issue_string.', '.$item->journal_pages.'.'; 
        echo "<br/>";
        if( !empty($item->filename) ){
            echo "<a href='uploads/$item->filename;'>Download</a> |" ;
        } 
        echo "<strong>Keywords: </strong>";
        echo "</div>";
    }
} 
else{ 
    echo "<p class='notice'><strong>Notice:</strong> No publications were found.</p>";
} 
?>
                    </div>
    </div>
