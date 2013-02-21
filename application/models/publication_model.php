<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publication_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add_publication( $data ) {
		$this->db->insert('publications', $data );
		return $this->db->insert_id();
	}


	function get_group_of_publication_authors( $list = array(),  $limit = NULL, $offset = NULL ) {

		$this->db->select('join_publications_people.*, people.*');
		$this->db->from('join_publications_people');
		$this->db->join('people', 'join_publications_people.person_id = people.id', 'left inner');
		$this->db->order_by(' publication_id, join_publications_people.id ');
		$this->db->limit( $limit, $offset );
		$this->db->where_in('publication_id', $list);

		$query = $this->db->get();
		return $query;
	}

    function get_publications() {
		$this->db->select('p.*, m.uuid');
		$this->db->from('publications p');
		$this->db->join('join_media_anything', 'p.id = join_media_anything.foreign_table_row_id', 'left');
		$this->db->join('media m', 'm.id = join_media_anything.media_id', 'left');
		$this->db->where( 'join_media_anything.foreign_join_table', 'publications' );
		$this->db->order_by('journal_year desc');
		return $this->db->get();
    }


	function get_publications_with_authors( $limit = NULL, $offset = NULL )
	{
		$this->db->select('publications.*, publications.id as publication_id, people.*, people.id as person_id, media.id as media_id, media.*');
		$this->db->join('join_publications_people', 'publications.id = join_publications_people.publication_id', 'left outer');
		$this->db->join('people', 'join_publications_people.person_id = people.id', 'left outer');
		$this->db->join('join_media_anything', 'publications.id = join_media_anything.foreign_table_row_id', 'left');
		$this->db->join('media', 'media.id = join_media_anything.media_id', 'left');
		$this->db->where( 'join_media_anything.foreign_join_table', 'publications' );
		$this->db->order_by(' publications.title asc, publications.journal_year asc ');
		$this->db->limit( $limit, $offset );
		$query = $this->db->get('publications');

		return $query;
	}

	function get_publication_authors($publication_id)
	{
//		$this->db->select('people.*');
//		$this->db->from('people, join_publications_people');
//		$this->db->where('join_publications_people.publication_id', $publication_id);
//		$this->db->where('join_publications_people.person_id', 'people.id');
//		$this->db->order_by('people.last', 'asc');

//		return $this->db->get();
		$query = 'SELECT people.* FROM people, join_publications_people WHERE join_publications_people.publication_id = '.intval($publication_id).' AND join_publications_people.person_id = people.id ORDER BY people.last ASC';
		return $this->db->query($query);
	}

	function get_publication_by_id( $id ) {

		$id += 0; //Force this thing to be an int. Just being careful since I'm not using CI's nice injection protection.

		$sql = "SELECT DISTINCT * 
		        FROM (
                      SELECT `publications`.*, `publications`.`id` as publication_id, `people`.`first`, 
                             `people`.`last`, `people`.`id` as person_id, `people`.`slug`, 
                             `people`.`department`, `people`.`image`, `people`.`bio`, 
                             `people`.`pw_salt`, `people`.`pw_hash`, `people`.`email`, `people`.`website`, 
                             `people`.`gender`, `people`.`ethnicity`, `people`.`research`, 
                             `people`.`institution`, `media`.`id` as media_id, `media`.`uuid`, `media`.`mime_type` 
                      FROM (`publications`) 
                      LEFT JOIN `join_publications_people` ON `publications`.`id` = `join_publications_people`.`publication_id` 
                      LEFT JOIN `people` ON `join_publications_people`.`person_id` = `people`.`id` 
                      LEFT JOIN `join_media_anything` ON `join_media_anything`.`foreign_table_row_id` = `publications`.`id` 
                      LEFT JOIN `media` ON `media`.`id` = `join_media_anything`.`media_id`
                      WHERE `publications`.`id` = $id and `join_media_anything`.`foreign_join_table` = 'publications'
                      ) as subq ORDER BY title asc, journal_year asc";

        $query = $this->db->query($sql);
		return $query;
	}
	

	function get_publication_by_author( $id, $limit = NULL, $offset = NULL ) {

		$this->db->select('publications.*, publications.id as publication_id, media.*, media.id as media_id, people.*, people.id as person_id');
		$this->db->join('join_media_anything', 'publications.id = join_media_anything.foreign_table_row_id', 'left inner');
		$this->db->join('media', 'join_media_anything.media_id = media.id', 'left inner');
		$this->db->join('join_publications_people', 'publications.id = join_publications_people.publication_id', 'left outer');
		$this->db->join('people', 'join_publications_people.person_id = people.id', 'left outer');
		$this->db->where( 'join_media_anything.foreign_join_table', 'publications' );
		$this->db->order_by(' publications.title asc, publications.journal_year asc ');
		$this->db->limit( $limit, $offset );
		$query = $this->db->get_where('publications', array( 'person_id' => $id ));

		return $query;
	}

	function update( $id, $values ) {
		$this->db->where( 'id', $id );
        $this->db->update( 'publications', $values );
	}


    function delete( $publication_id ){

		// Delete from media library
		$this->db->delete( 'join_media_anything',
			array(	'foreign_join_table'	=> 'publications',
			 		'foreign_table_row_id'	=>	$publication_id ));

		// Delete the publication authors and keywords
		$this->db->delete( 'join_publications_people',		array( 'publication_id' => $publication_id ));

		// Delete the symposium
        $this->db->delete( 'publications', array( 'id' => $publication_id ));
    }


	function count_publications() {
		return $this->db->count_all_results('publications');
	}

	function clean_publication_data( $pub_data ) {

		$f = array();

		if( $pub_data->num_rows() > 0 ) {
			foreach( $pub_data->result() as $publication ) {

				if( ! isset( $f[$publication->publication_id] )) {
					$f[$publication->publication_id]['data'] = $publication;
					$f[$publication->publication_id]['auth'] = array();
				}

				if( $publication->person_id != NULL ) {
					array_push( $f[$publication->publication_id]['auth'],
					array(	'id' => $publication->person_id,
							'slug' => $publication->slug,
							'first' => $publication->first,
							'last' => $publication->last,
							'institution' => $publication->institution,
							'department' => $publication->department,
							'email' => $publication->email,
							'website' => $publication->website,
							'gender' => $publication->gender,
							'ethnicity' => $publication->ethnicity,
							'research' => $publication->research,
							'image' => $publication->image,
							'bio' => $publication->bio,
							'pw_salt' => $publication->pw_salt,
							'pw_hash' => $publication->pw_hash ));
				}
			}
		}
		return $f;
	}
}

/* End of file publication_model.php */
/* Location: ./application/models/publication_model.php */
