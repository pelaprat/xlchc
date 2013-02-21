<?php $this->load->view('elements/header'); ?>
   <div class="article" style='vertical-align:top'>
      <h2><?php echo htmlentities($page->title); ?></h2>

      <div style="width: 200px; float: left;">
	<h3>Faculty</h3>
<?php
	foreach( $faculty->result() as $person ) { ?>
	   <a href="people/<?php echo (empty($person->slug)) ? $person->person_id : $person->slug; ?>"><?php echo $person->first.' '.$person->last; ?></a>
	   <br>
<?php
	} ?>

	<p>

        <h3>Associate Faculty</h3>
<?php
	foreach( $associated->result() as $person ) { ?>
	   <a href="people/<?php echo (empty($person->slug)) ? $person->person_id : $person->slug; ?>"><?php echo $person->first.' '.$person->last; ?></a>
	   <br>
<?php
	} ?>



      </div>

      <div style='width: 200px; margin-left: 210px;'>
        <h3>Graduate Students</h3>
<?php
	foreach( $graduate->result() as $person ) { ?>
	   <a href="people/<?php echo (empty($person->slug)) ? $person->person_id : $person->slug; ?>"><?php echo $person->first.' '.$person->last; ?></a>
	   <br>
<?php
	} ?>


	<p>

        <h3>Affiliated Members</h3>
<?php
	foreach( $affiliated->result() as $person ) { ?>
	   <a href="people/<?php echo (empty($person->slug)) ? $person->person_id : $person->slug; ?>"><?php echo $person->first.' '.$person->last; ?></a>
	   <br>
<?php
	} ?>
	</div>
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
