<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {

	var $current_user;
	var $user_reputation_points;

	function __construct() {
		parent::__construct();

		// Load Tag model
		$this->load->model('Tag_model', '', TRUE );

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
	}

	function add( $tagable ) {
		if( $tagable == 'conversation' ) {
			$x = $this->tagable_add( 'conversation', 'conversations', $this->input->post( 'conversation_id' ));
			return $this->conversation_action( $x, $this->input->post( 'conversation_id' ) );

		} elseif( $tagable == 'symposium' ) {
			$x = $this->tagable_add( 'symposium', 'symposia', $this->input->post( 'symposium_id' ));
			return $this->symposium_action( $x, $this->input->post( 'symposium_id' ) );

		} elseif( $tagable == 'symposium_chapter' ) {
			$x = $this->tagable_add( 'symposium_chapter', 'symposia_chapters', $this->input->post( 'symposium_chapter_id' ));
			return $this->symposium_chapter_action( $x, $this->input->post( 'symposium_chapter_id' ) );

		}
	}

	function create( $tagable ) {
		if( $tagable == 'conversation' ) {
			$x = $this->tagable_create( 'conversation', 'conversations', $this->input->post( 'conversation_id' ));
			return $this->conversation_action( $x, $this->input->post( 'conversation_id' ) );

		} elseif( $tagable == 'symposium' ) {
			$x = $this->tagable_create( 'symposium', 'symposia', $this->input->post( 'symposium_id' ));
			return $this->symposium_action( $x, $this->input->post( 'symposium_id' ) );

		} elseif( $tagable == 'symposium_chapter' ) {
			$x = $this->tagable_create( 'symposium_chapter', 'symposia_chapters', $this->input->post( 'symposium_chapter_id' ));
			return $this->symposium_chapter_action( $x, $this->input->post( 'symposium_chapter_id' ) );

		}
	}

	function delete( $tagable, $identifier ) {
		if( $tagable == 'conversation' ) {
			if( $x = $this->tagable_delete( 'conversation', 'conversations', $identifier ) ) {
				return $this->conversation_action( TRUE, $x->conversation_id );
			} else {
				return $this->conversation_action( TRUE, FALSE );
			}
		} elseif( $tagable == 'symposium' ) {
			if( $x = $this->tagable_delete( 'symposium', 'symposia', $identifier ) ) {
				return $this->symposium_action( TRUE, $x->symposium_id );
			} else {
				return $this->symposium_action( TRUE, FALSE );
			}
		} elseif( $tagable == 'symposium_chapter' ) {
			if( $x = $this->tagable_delete( 'symposium_chapter', 'symposia_chapters', $identifier ) ) {
				return $this->symposium_chapter_action( TRUE, $x->symposium_chapter_id );
			} else {
				return $this->symposium_chapter_action( TRUE, FALSE );
			}
		}
	}

	/*********************/
	/** PRIVATE METHODS **/
	/*********************/

	private

	function conversation_action( $r, $id ) {
		$r	? redirect( base_url() . '/conversations/detail/' . $id )
			: redirect( base_url() . '/conversations' );
	}

	function symposium_action( $r, $id ) {
		$r	? redirect( base_url() . '/symposia/detail/' . $id )
			: redirect( base_url() . '/symposia' );
	}

	function symposium_chapter_action( $r, $id ) {
		$r	? redirect( base_url() . '/symposia/chapter/' . $id )
			: redirect( base_url() . '/symposia' );
	}

	/*********************/
	/** Central Methods **/
	/*********************/

	function tagable_add( $tagable_s, $tagable_p, $tagable_id ) {

		///////////////////////////////////
		// Must have permission to do this.
		if(	$this->current_user != null &&
			$this->current_user->reputation >= $this->user_reputation_points['can_add_tag_association'] ) {

				$tag_data    = $this->input->post( 'tag' );

				$tag_id = -1;
				foreach( $tag_data as $tag => $id ) {
					if( preg_match( '/tag_\d+$/', $tag )) {
						$tag_id = $id;
					}
				}

				///////////////////////////////////
				// First check to see if this
				// association is already in place.
				$this->load->model('Tag_model', '', TRUE );
				if( $this->Tag_model->tag_association_exists( $tagable_s, $tagable_p, $tagable_id, $tag_id )) {
					// Do nothing

				} else {
					$this->Tag_model->tag_association_add( $tagable_s, $tagable_p, $tagable_id, $tag_id );
				}

				return TRUE;
		} else {
			return FALSE;
		}
	}

	function tagable_create( $tagable_s, $tagable_p, $tagable_id ) {

		$tag_data = trim( $this->input->post( 'name' ));

		///////////////////////////////////
		// Must have permission to do this.
		if(	$tag_data != ''							&&
			$this->current_user != null 			&&
			$this->current_user->reputation >= $this->user_reputation_points['can_create_tag'] ) {

			$this->load->model('Tag_model', '', TRUE );

			////////////////////////////
			// Go through each named tag
			// in case several given.
			$tags = explode( ',', $tag_data);

			foreach( $tags as $name ) {
				$name = trim($name);

				//////////////////////////
				// Make sure this tag
				// doesn't already exist.
				$tag = $this->Tag_model->get_tag_by_name( $name );
				if( $tag == null ) {
	
					// Create the tag
					$tag_id = $this->Tag_model->add( array(	'name' => $name,
															'created_at' => datetime_now(),
															'updated_at' => datetime_now() ));
	
					// We know the association
					//  cannot yet exist, so make
					//  one without checking.
					$this->Tag_model->tag_association_add( $tagable_s, $tagable_p, $tagable_id, $tag_id );
				} else {
	
					///////////////////////////
					// The tag exists, but does
					// the association?
					if( ! $this->Tag_model->tag_association_exists( $tagable_s, $tagable_p, $tagable_id, $tag->id )) {
						$this->Tag_model->tag_association_add( $tagable_s, $tagable_p, $tagable_id, $tag->id );
					} else {
						// Do nothing
					}
				}
			}

			return TRUE;

		} else {
			return FALSE;
		}
	}

	function tagable_delete( $tagable_s, $tagable_p, $join_id ) {

		///////////////////////////////////
		// Must have permission to do this.
		if(	$this->current_user != null &&
			$this->current_user->reputation >= $this->user_reputation_points['can_delete_tag_association'] ) {

			///////////////////////////
			// Get information about
			// the tagable and the tag.
			$assocation_data = $this->Tag_model->tag_association_data( $tagable_s, $tagable_p, $join_id );

			//////////////////////////
			// Delete the association.
			$this->Tag_model->tag_association_delete( $tagable_s, $tagable_p, $join_id );

			return $assocation_data;

		} else {
			return FALSE;
		}
	}

}

/* End of file tags.php */
/* Location: ./application/controllers/tags.php */
