
        
<link rel="stylesheet" href="assets/styles/old_people.css" type="text/css" media="screen, projection">

<h1 class='content_header'>People</h1>
    <div class="inside_center">
<div class="article">

    
<?php  if( $people->num_rows() > 0 ){ $current_relationship = 'Faculty'; ?>
                        <div class="people" id="<?php echo str_replace(' ', '_', strtolower($current_relationship)); ?>">
                            <h3><?php echo htmlentities($current_relationship); ?></h3>
                            <ul>
<?php foreach( $people->result() as $person ){ ?>
<?php if( $person->relationship !== $current_relationship ){ $current_relationship = $person->relationship; ?>
                            </ul>
                        </div>
                        <div class="people" id="<?php echo str_replace(' ', '_', strtolower($current_relationship)); ?>">
                            <h3><?php echo htmlentities($current_relationship); ?></h3>
                            <ul>
<?php } ?>
                                <li><a href="old_people/<?php echo (empty($person->slug)) ? $person->id : $person->slug; ?>"><?php echo $person->first.' '.$person->last; ?></a></li>
<?php } ?>
                            </ul>
                        </div>
<?php } else{ ?>
                        <p class="notice"><strong>Notice:</strong> No people were found.</p>
<?php } ?>

    </div>
</div>
    
