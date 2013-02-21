<?php 
   if( $slides->num_rows() > 0 ){ ?>
      <div id="slider">
<?php 
      foreach( $slides->result() as $slide ) { ?>
<?php 
         if( !empty($slide->url) ){ ?>
            <a href="<?php echo $slide->url; ?>"><img src="images/slides/<?php echo $slide->image; ?>" title="<?php echo $slide->caption; ?>" id="slide_<?php echo $slide->id; ?>" alt="A slideshow image."></a>
<?php    } else{ ?>
            <img src="images/slides/<?php echo $slide->image; ?>" title="<?php echo $slide->caption; ?>" id="slide_<?php echo $slide->id; ?>" alt="A slideshow image.">
<?php    } ?>
<?php } 
?>
      </div>
<?php 
   } 
?>