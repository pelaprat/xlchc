<?php

$config =
	array(

		'conversations' => array(
			array(
				'field'=>'subject',
				'label'=>'Subject',
				'rules'=>'required|trim|xss_clean'
			)),

		'media/upload' =>
			array(

				array(
					'field'=>'filename',
					'label'=>'Filename',
					'rules'=>'required|trim|xss_clean' ),
				array(
					'field'=>'html_archive',
					'label'=>'HTML Archive',
					'rules'=>'trim|xss_clean' ),
				array(
					'field'=>'description',
					'label'=>'Description',
					'rules'=>'trim|xss_clean' ))
				,

		'media_group' => array(
			array(
				'field'=>'name',
				'label'=>'name',
				'rules'=>'required|trim|xss_clean'
			)),

		'people' =>
			array(
		 		array(	'field'=>'relationship_id',
						 'label'=>'Relationship_id',
						 'rules'=>'trim|xss_clean' ),

						 array(
						 	'field'=>'slug',
						 	'label'=>'Slug',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'first',
						 	'label'=>'First Name',
						 	'rules'=>'required|trim|xss_clean'
						 ),
						 array(
						 	'field'=>'last',
						 	'label'=>'Last Name',
						 	'rules'=>'required|trim|xss_clean'
						 ),
						 array(
						 	'field'=>'institution',
						 	'label'=>'Institutional Affiliation',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'department',
						 	'label'=>'Departmental Affiliation',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'email',
						 	'label'=>'Email',
						 	'rules'=>'required|trim|valid_email|xss_clean'
						 ),
						 array(
						 	'field'=>'website',
						 	'label'=>'Website',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'gender',
						 	'label'=>'Gender',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'ethnicity',
						 	'label'=>'Ethnicity',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'research',
						 	'label'=>'Research Interests',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'image',
						 	'label'=>'Image',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'bio',
						 	'label'=>'Bio',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'pw_salt',
						 	'label'=>'Salt',
						 	'rules'=>'trim|xss_clean'
						 ),
						 array(
						 	'field'=>'pw_hash',
						 	'label'=>'Hash',
						 	'rules'=>'trim|xss_clean'
						 ))
				,

			'publications' => array(
								array(
									'field'=>'title',
									'label'=>'Title',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'abstract',
									'label'=>'Abstract',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'project',
									'label'=>'Project',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'url',
									'label'=>'Url',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'doi',
									'label'=>'Doi',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'pii',
									'label'=>'Pii',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'identifier',
									'label'=>'Identifier',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'citekey',
									'label'=>'Citekey',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'journal_title',
									'label'=>'Journal_title',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'journal_year',
									'label'=>'Journal_year',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'journal_volume',
									'label'=>'Journal_volume',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'journal_issue',
									'label'=>'Journal_issue',
									'rules'=>'trim|xss_clean'
								),
								array(
									'field'=>'journal_pages',
									'label'=>'Journal_pages',
									'rules'=>'trim|xss_clean'
								))
			 
				,

				 'partner_projects' => array(array(
									'field'=>'name',
									'label'=>'Name',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'description',
									'label'=>'Description',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'address',
									'label'=>'Address',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'country',
									'label'=>'Country',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'latitude',
									'label'=>'Latitude',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'longitude',
									'label'=>'Longitude',
									'rules'=>'required|trim|xss_clean'
								))
			 
				,

				 'pages' => array(
								array(
									'field'=>'uri',
									'label'=>'Uri',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'meta_title',
									'label'=>'Meta_title',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'meta_description',
									'label'=>'Meta_description',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'meta_keywords',
									'label'=>'Meta_keywords',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'meta_language',
									'label'=>'Meta_language',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'meta_content_type',
									'label'=>'Meta_content_type',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'title',
									'label'=>'Title',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'content',
									'label'=>'Content',
									'rules'=>'required|trim|xss_clean'
								))
			 
				,

				 'spotlight' => array(
								array(
									'field'=>'title',
									'label'=>'Title',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'description',
									'label'=>'Description',
									'rules'=>'required|trim|xss_clean'
								))

		,

				 'slides' => array(
								array(
									'field'=>'caption',
									'label'=>'Caption',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'url',
									'label'=>'URL',
									'rules'=>'trim|xss_clean'
								))

		,

				 'sideboxes' => array(
								array(
									'field'=>'title',
									'label'=>'Title',
									'rules'=>'required|trim|xss_clean'
								),
								array(
									'field'=>'content',
									'label'=>'Content',
									'rules'=>'trim|xss_clean'
								)),

				 'symposia' =>
				 	array(
				 		array(	'field' => 'subject',
				 				'label' => 'Subject',
				 				'rules' => 'required|trim|xss_clean' ),
				 		array(	'field' => 'summary',
				 				'label' => 'Summary',
				 				'rules' => 'required|trim|xss_clean' ),
				 		array(	'field' => 'f_private',
				 				'label' => 'Private?',
				 				'rules' => 'trim|xss_clean' )
				 	),

				 'symposia_chapters' =>
				 	array(
				 		array(	'field' => 'subject',
				 				'label' => 'Subject',
				 				'rules' => 'required|trim|xss_clean' ),
						array(	'field' => 'summary',
				 				'label' => 'Summary',
				 				'rules' => 'required|trim|xss_clean' )
				 	),

				'tags' => array(
					array(
						'field'=>'name',
						'label'=>'name',
						'rules'=>'required|trim|xss_clean'
					)),


				 'xgroups' => array(
								array(
									'field'=>'name',
									'label'=>'name',
									'rules'=>'required|trim|xss_clean'
								))
			   );

		// Paging Style.
		$config['full_tag_open']  = "<div class=\"box\"><ul class=\"paginator\">\r";
		$config['full_tag_close'] = "</ul></div>\r";
	
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = "</li>\r";
		$config['last_tag_open']  = '<li>';
		$config['last_tag_close'] = "</li>\r";
		$config['prev_tag_open']  = '<li>';
		$config['prev_tag_close'] = "</li>\r";
		$config['next_tag_open']  = '<li>';
		$config['next_tag_close'] = "</li>\r";
		$config['cur_tag_close'] = "</a></b></li>\r";
		$config['num_tag_open']  = '<li>';
		$config['num_tag_close'] = "</li>\r";


			   
?>