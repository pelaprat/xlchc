<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('load_userdata') )
{
	function userdata_load( )
	{
		$ci =& get_instance();
		$p  = null;
		if( isset($ci->session) && isset( $ci->session->userdata['user-info'] ) ) {
	    	$p = $ci->session->userdata['user-info'];
		} else {
			$p = null;
		}

		return $p;
	}

	function userdata_down_points( $me, $amount ) {
		if( $me->current_user != null ) {
			$me->current_user->points -= $amount;
			$me->session->set_userdata( $me->current_user );
		}
	}

	function userdata_up_points( $me, $amount ) {
		if( $me->current_user != null ) {
			$me->current_user->points += $amount;
			$me->session->set_userdata( $me->current_user );
		}
	}

	function datetime_now() {
		$date = new Datetime();
		return $date->format('Y-m-d H:i:sP');
	}

	function html_to_text( $text ) {
		return preg_replace( '/<br>/', "\n", $text );
	}

	function text_to_html( $text ) {
		return preg_replace( '/\n/', '<br>', $text );
	}

	function lchc_hot_conversations( $me ) {
		return $me->Conversation_model->get_all( true, 5 );
	}

	function post_process_comment_data( $attachments ) {
		$data = array();
		foreach( $attachments->result() as $attachment ) {
			if( ! isset( $data[$attachment->comment_id] )) {
				$data[$attachment->comment_id] = array();
			}

			array_push( $data[$attachment->comment_id], $attachment );
		}

		return $data;
	}

	function prepareDOCHTML($url)	{ return "<a href='$url'><img src='assets/modules/admin/images/icon_doc.gif'></a>";}
	function preparePDFHTML($url)	{ return "<a href='$url'><img src='assets/modules/admin/images/icon_pdf.png'></a>";}
	function prepareMOVHTML($url)	{ return "<a href='$url'><img src='assets/modules/admin/images/icon_mov.png'></a>";}
	function prepareMP3HTML($url)	{ return "<a href='$url'><img src='assets/modules/admin/images/icon_mp3.png'></a>";}
	function prepareMPEGHTML($url)	{ return "<a href='$url'><img src='assets/modules/admin/images/icon_mpeg.png'></a>";}
	function prepareHTMLHTML($url)	{ return "<a href='$url/index.html' rel='shadowbox'><img src='assets/modules/admin/images/icon_html.png'></a>";}
	function prepareZIPHTML($url)	{ return "<a href='$url'><img src='assets/modules/admin/images/icon_zip.png'></a>";}

	function prepareImageHTML($url, $id = '', $class = '', $style = '', $height = '', $width = '', $border = '0')
	{
		if (is_array($url)) extract($url, EXTR_IF_EXISTS);

		$id = '' === $id ? '': "id='$id'";
		$class = '' === $class ? '': "class='$class'";
		$style = '' === $style ? '': "style='$style'";
		$height = '' === $height ? '': "height='$height'";
		$width = '' === $width ? '': "width='$width'";
		$border = '' === trim($border) ? '': "border='$border'";

		return "<div class='media_content_wrapper'><a href='$url'><img src='$url' $id $class $style $height $width $border></a></div>";
	}

	function display_media( $params ) {

		if(null == $params || null == $params['mime']) return;

		if(preg_match('/gif|png|jpg|jpeg/i', $params['mime'])){
			return prepareImageHTML($params);
		}
		else if(preg_match('/msword|doc/i', $params['mime'])){
			return prepareDOCHTML($params['url']);
		}
		else if(preg_match('/pdf/i', $params['mime'])){
			return preparePDFHTML($params['url']);
		}
		else if(preg_match('/mov/i', $params['mime'])){
			return prepareMOVHTML($params['url']);
		}
		else if(preg_match('/mp3/i', $params['mime'])){
			return prepareMP3HTML($params['url']);
		}
		else if(preg_match('/mpeg|mpg/i', $params['mime'])){
			return prepareMPEGHTML($params['url']);
		}
		else if(preg_match('/html/i', $params['mime'])){
			return prepareHTMLHTML($params['url']);
		}
		else if(preg_match('/zip/i', $params['mime'])){
			return prepareZIPHTML($params['url']);
		}
		else{
			return "Unknown File Type: " . $params['mime'];
		}
	}
}

/* End of file userdata_helper.php */
/* Location: ./application/helpers/userdata_helper.php */
