<?php

$config = array(
             	


             	'tbl_users' => array(array(
                                	'field'=>'username',
                                	'label'=>'Username',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'password',
                                	'label'=>'Password',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'name',
                                	'label'=>'Name',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'tbl_users2' => array(array(
                                	'field'=>'username',
                                	'label'=>'Username',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'password',
                                	'label'=>'Password',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'name',
                                	'label'=>'Name',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   );
			   
?>