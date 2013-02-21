<?php
$authors_string = '';

$list = array();
foreach( $authors as $author ) {
	array_push( $list, ('<a href="/people/' . $author->person_id . '">' . $author->last . ', ' . substr($author->first, 0, 1 ) . '.</a>' ) );
}
?>

<div class="publication last span-14 append-bottom" id="publication-<?php echo $item->id; ?>">
	<?php echo join(', ', $list) ?>

	<span class='pub-year'><?php echo $item->journal_year; ?></span>
	<span class='pub-title'><a href="assets/media/<?php echo $item->uuid; ?>"><?php echo $item->title; ?></a></span>
	<span class='pub-journal'><?php echo $item->journal_title; ?></span>
	<span class='pub-volume'><?php echo $item->journal_volume; ?></span>
	<?php if( isset( $item->journal_issue ) && $item->journal_issue > 0 ) { ?>
		<span class='pub-issue'>(<?php echo $item->journal_issue; ?>)</span>
	<?php } ?>
	<?php if( isset( $item->journal_pages ) && $item->journal_pages > 0 ) { ?>
		:
		<span class='pub-pages'><?php echo $item->journal_pages; ?></span>.
	<?php } ?>.

</div>
