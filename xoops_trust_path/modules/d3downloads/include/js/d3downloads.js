
if ( typeof jQuery == 'function' ) var $j = jQuery.noConflict() ;

function $dom( id ){
	return $j( '#' + id ) ;
}

function $id( id ){
	return $j( '#' + id ).get(0) ;
}

function $value( id ){
	return $j( '#' + id ).val() ;
}

function $id_filter( target, filter ){
	return $j( '#[ id' + filter + target + ']' ) ;
}

function set_show( params ){
	$j.each( arguments, function(){
		$dom( this ).show() ;
	});
}

function set_hide( params ){
	$j.each( arguments, function(){
		$dom( this ).hide() ;
	});
}

function change_show_hide( params ){
	$j.each( arguments, function(){
		$dom( this ).toggle() ;
	});
}

function change_by_fade_Out( params ){
	$j.each( arguments, function(){
		var targetDom = $dom( this ) ;
		var elestyle  = ( targetDom.css( 'display' ) == '' ) ? 'block' : targetDom.css( 'display' ) ;

		if ( elestyle == 'block' ) targetDom.fadeOut( 'slow' ) ;
		else targetDom.css( 'display', 'block' ) ;
	});
}

function disabled_true( params ){
	$j.each( arguments, function(){
		$dom( this ).attr( 'disabled', true ) ;
	});
}

function disabled_false( params ){
	$j.each( arguments, function(){
		$dom( this ).attr( 'disabled', false ) ;
	});
}

function disabled_on_off( params ){
	$j.each( arguments, function(){
		var targetDom = $dom( this ) ;
		var elevalue  = ( targetDom.attr( 'disabled' ) == '' ) ? false : targetDom.attr( 'disabled' ) ;
		var value     = ( elevalue == true ) ? false : true ;
		targetDom.attr( 'disabled', value ) ;
	});
}

function fade_In( params ){
	$j.each( arguments, function(){
		$dom( this ).fadeIn( 'slow' ) ;
	});
}

function fade_Out( params ){
	$j.each( arguments, function(){
		$dom( this ).fadeOut( 'slow' ) ;
	});
}

function focus_in( id ){
	$dom( id ).
		focus().
		addClass( 'd3downloads_focus' ).
		blur( function(){
			$j( this ).removeClass( 'd3downloads_focus' ) ;
		});
}

function d3downloadsInsertText( domobj, text ){
	if ( domobj.createTextRange && domobj.caretPos ){
		var caretPos = domobj.caretPos ;
		caretPos.text = caretPos.text.charAt( caretPos.text.length - 1 ) == ' ' ? text + ' ' : text ;
	} else if ( domobj.getSelection && domobj.caretPos ){
		var caretPos = domobj.caretPos ;
		caretPos.text = caretPos.text.charat( caretPos.text.length - 1 ) == ' ' ? text + ' ' : text ;
	} else if ( domobj.selectionStart ){
		tmpValue = new Array() ;
		posSt = domobj.selectionStart ;
		posEd = domobj.selectionEnd ;
		tmpValue[0]  = domobj.value.substring( 0, posSt ) ;
		tmpValue[1]  = domobj.value.substring( posEd,domobj.value.length ) ;
		domobj.value = tmpValue[0] + text + tmpValue[1] ;
	} else {
		domobj.value = domobj.value + text ;
	}
}

function d3downloads_appendText( targetId, text ){
	var targetDom = $id( targetId ) ;
	d3downloadsInsertText( targetDom, text ) ;
	targetDom.focus() ;
	return ;
}

function extra_InsertText( targetId, titleId, descId ){
	var targetDom = $id( targetId ) ;
	var titleDom  = $id( titleId ) ;
	var descDom   = $id( descId ) ;

	if ( descDom.value != '' ) {
		text = '<<' + titleDom.value + '>>' + descDom.value + '\n' ;
	} else {
		text = '<<' + titleDom.value + '>>' ;
	}
	if ( targetDom.value != '' && targetDom.value.slice( -1 ) != '\n' ) {
		inserttext = '\n' + text ;
	} else {
		inserttext = text ;
	}
	if ( titleDom.value != '' ) {
		targetDom.value = targetDom.value + inserttext ;
		titleDom.value  = descDom.value  = '' ;
		focus_in( targetId ) ;
		return ;
	}
}

function selectlist_appendText( targetId, selectId ){
	if ( is_xoopsdhtml( targetId ) ) {
		d3downloadsInsertText( $id( targetId ), $value( selectId ) ) ;
		focus_in( targetId ) ;
	} else if ( typeof FCKeditorAPI == 'object' ) {
		fckeditor_insert( $value( selectId ) )
	}
}

function selectlist_InsertText( targetId, selectId, delimiterId, delimiter ){
	var targetDom    = $dom( targetId ) ;
	var target_val   = targetDom.val() ;
	var selected_val = $value( selectId ) ;

	if ( selected_val != '' ) {
		if ( target_val == '' ) {
			targetDom.attr( 'value', selected_val ) ;
		} else {
			var selectdelimiter = ( delimiterId == '' ) ? delimiter : $value( delimiterId ) ;
			targetDom.attr( 'value', target_val + selectdelimiter + selected_val ) ;
		}
	}
	return ;
}

function showlogourlSelected_load( mode, shots_dir, xoops_url, imgId, selectId, showhideId, url ){
	var imgDom       = $dom( imgId ) ;
	var selected_val = $value( selectId ) ;
	xoopsUrl = xoops_url

	if ( selected_val == 0 ) {
		fade_Out( showhideId ) ;
	} else {
		set_show( showhideId ) ;
		switch( mode ) {
			case 'shots_dir' :
				shots_dir_load( shots_dir,imgDom, selected_val ) ;
				break ;
			default :
				album_load( url,imgDom, selected_val ) ;
		}
	}
	return ;
}

function shots_dir_load( shots_dir, imgDom, selected_val ){
	imgDom.attr( 'src', xoopsUrl + '/' + shots_dir + selected_val ) ;
	return ;
}

function album_load( url,imgDom, selected_val ){
	var parameter = 'type=logourl_load&id=' + encodeURIComponent( selected_val ) ;
	var successCallback = function ( xml, status ) {
		if ( status != 'error' ) {
			thumb = ( typeof xml == 'object' ) ? get_item_from_xml( xml, 'thumb', 0 ) : '' ;
			photo = ( typeof xml == 'object' ) ? get_item_from_xml( xml, 'photo', 0 ) : '' ;
			if ( thumb != '' ) imgDom.attr( 'src', xoopsUrl + '/' + thumb ) ;
			return ;
		}
	} ;

    $j.ajax({ type: 'GET', url: url, data: parameter, dataType : 'xml', success : successCallback }) ;
}

function get_item_from_xml( xml, item , key ){
	if( key == 0 ) return $j( item, xml ).text() ;
	var item_text = '' ;
	$j( xml ).find( item ).each(function(i){
		if( i == key ){
			item_text = $j( this ).text() ;
			return false ;
		}
	}) ;
	return item_text ;
}

function appendCode_load( mode, shots_dir, targetId, selectId, align ){
	var selected_val = $value( selectId ) ;

	if ( selected_val != '0' ) switch( mode ) {
		case 'shots_dir' :
			appendCode_by_shots_dir( shots_dir, targetId, selected_val, align ) ;
			if ( is_xoopsdhtml( targetId ) ) focus_in( targetId ) ;
			return ;
			break ;
		default :
			appendCode_by_album( targetId, selected_val, align )
			if ( is_xoopsdhtml( targetId ) ) focus_in( targetId ) ;
			return ;
	}
}

function appendCode_by_shots_dir( shots_dir, targetId, selected_val, align ){
	if ( is_xoopsdhtml( targetId ) ) {
		var addCode = '[siteimg align=' + align + ']' + shots_dir + selected_val + '[/siteimg]' ;
		d3downloadsInsertText( $id( targetId ), addCode ) ;
	} else if ( typeof FCKeditorAPI == 'object' ) {
		var addCode = '<img src="'+ xoopsUrl + '/' + shots_dir + selected_val +'" align="' + align + '" />' ;
		fckeditor_insert( addCode ) ;
	}
}

function appendCode_by_album( targetId, selected_val, align ){
	if ( thumb != '' && photo != '' ) {
		if ( is_xoopsdhtml( targetId ) ) {
			var addCode = '[siteurl=' + photo + '][siteimg align=' + align + ']' + thumb + '[/siteimg][/siteurl]' ;
		   	d3downloadsInsertText( $id( targetId ), addCode ) ;
		} else if ( typeof FCKeditorAPI == 'object' ) {
			var addCode = '<a href="' + xoopsUrl + '/' + photo + '" target="_blank" rel="lightbox[]"><img src="' + xoopsUrl + '/' + thumb + '" align="' + align + '" /></a>' ;
			fckeditor_insert( addCode ) ;
		}
	}
}

function str_load( url, tagetid ){
	var successCallback = function ( response, status ) {
		if ( status != 'error' ) $id( tagetid ).value = ( response != '' ) ? response : '' ;
	} ;

    $j.ajax({ type: 'GET', url: url, data: 'type=str_load', async : false, success : successCallback }) ;
}

function cansel_btn( url ){
	$j.get( url, 'type=cansel', function( request, status ) {
		if ( status != 'error' ) {
			location.href = ( request != '' ) ? request : document.referrer ;
			return ;
		}
	});
}

function select_imgurl( imgId, selectId, targetId ){
	var targetDom           = $dom( targetId ) ;
	var eleborder           = targetDom.css( 'border' ) ;
	var elesbackgroundColor = targetDom.css( 'backgroundColor' ) ;

	if ( $value( selectId ) != '0' ) {
		targetDom.
			focus().
			css( target_style() ).
			attr( 'value', $id( imgId ).src ).
			blur( function(){
				$j( this ).css( { border: eleborder, background: elesbackgroundColor } ) ;
			});
		return ;
	}
}

function file_url_line_initialize(){
	set_hide( 'upload' , 'max_submit_size' , 'submit_size_desc' ) ;
	disabled_true( 'url_hidden' , ':file' ) ;
}

function validate_by_ajax( value, type ){
	validate_error = 0 ;
 	var ajax_url  = $value( 'ajax_url' ) ;
	var parameter = 'type=' + type + '&value=' + encodeURIComponent( value ) ;

	var successCallback = function ( request, status ) {
		if ( status != 'error' && request == 'invalid' ){
			validate_error = 1 ;
		}
	} ;

    $j.ajax({ type: 'GET', url: ajax_url, data: parameter, async : false, success : successCallback }) ;
	return ( validate_error == 0 ) ? true : false ;
}

function check_url( url, lid, ajax_url, type ){
	var parameter = 'type=' + type + '&url=' + encodeURIComponent( url ) + '&lid=' + encodeURIComponent( lid ) ;

	var successCallback = function ( request, status ) {
		if ( status != 'error' && request != '' ){
			popup_info( request ) ;
			validate_error = 1 ;
		}
	} ;

    $j.ajax({ type: 'GET', url: ajax_url, data: parameter, async : false, success : successCallback }) ;
}

function info_set_empty( infoDom ){
	infoDom.
		hide().
		empty() ;
}

function form_validate_contentform( targetId, info, message ){
	var targetDom = $dom( targetId ) ;
	var infoDom   = $dom( info ) ;

	info_set_empty( infoDom ) ;

	if ( targetDom.val() == '' ) {
		 validate_info( targetDom, infoDom, message ) ;
		 return 1 ;
	}
	return 0 ;
}

function category_form_validate( targetId, info, message ){
	var targetDom = $dom( targetId ) ;

	if ( typeof targetDom.val() != 'string' ) return 0 ;

 	var ajax_url  = $value( 'ajax_url' ) ;
	var infoDom   = $dom( info ) ;
	var parameter = 'type=category_form_validate&'+ targetId + '=' + encodeURIComponent( targetDom.val() ) ;

	validate_error = 0 ;
	info_set_empty( infoDom ) ;

	var successCallback = function ( request, status ) {
		if ( status != 'error' && request == 'invalid' ){
			validate_info( targetDom, infoDom, message ) ;
			validate_error = 1 ;
		}
	} ;

    $j.ajax({ type: 'GET', url: ajax_url, data: parameter, async : false, success : successCallback }) ;
	return validate_error ;
}

function validate_info( targetDom, infoDom, message ){
	targetDom.
		focus().
		css( target_style() ) ;
	infoDom.
		fadeIn( 2000 ).
		css( info_style() ).
		text( message ) ;
}

function ratelink_info( targetId, message ){
	var targetDom = $dom( targetId ) ;
	var ajax_url  = $value( 'url' ) ;
	var parameter = 'type=ratefile_check&lid=' + encodeURIComponent( $value( 'lid' ) ) ;

	validate_error = 0 ;
	infoDom_initialize() ;
	targetDom.css( { border: '' , background: '' } ) ;

	if( targetDom.val() <= 0 || targetDom.val() > 10 ) {
		targetDom.css( { border: 'solid 2px #CC0000' , background: '#FFFFCC' } ) ;
		popup_info( message ) ;
		validate_error++ ;
	}

	var successCallback = function ( request, status ) {
		if ( status != 'error' && request != '' ){
			popup_info( request ) ;
			validate_error++ ;
		}
	} ;

    $j.ajax({ type: 'GET', url: ajax_url, data: parameter, async : false, success : successCallback }) ;
	return ( validate_error == 0 ) ? true : false ;
}

function infoDom_initialize(){
	if ( typeof $id( 'popup_info' ) == 'object' ) $j( '#popup_info' ).remove() ;
}

function make_popup(){
	$j( 'body' ).append(
		'<div id="popup_info">' +
			'<div id="popup_close"></div>' +
			'<div id="popup_message"></div>' +
		'</div>'
	) ;
}

function popup_info( message ){
	make_popup() ;
	var infoDom = $j( '#popup_info' ) ;
	var textDom = $j( '#popup_message' ) ;
	var text    = ( textDom.html() == '' ) ? 
						'<ul>' + li_style() + message + '</li></ul>' :
						textDom.html().replace( /<\/ul>/ig, '' ) + li_style() + message + '</li></ul>' ;
	infoDom.
		show().
		css( popup_style( infoDom ) ).
		fadeOut( 12000 ) .
		click( function(){
			infoDom_initialize() ;
		}) ;
	textDom.
		html( text ).
		css( { 'margin-right': '20px' } ) ;
	$j( '#popup_close' ).
		css( { 'float': 'right' , 'cursor': 'pointer' } ).
		text( 'x' ) ;
	$j( 'body' ).keypress( function( event ) {
		if( event.keyCode == 27 ) infoDom.trigger( 'click' ) ;
	}) ;
}

function col_check_on_off( checkbox, target ){
	var check_val = ( checkbox.checked ) ? true : false ;

	$j.each( $id_filter( target , '*=' ), function(){
		this.checked = check_val ;
		$j( this ).css( checkbox_style( check_val ) ) ;
	});
}

function col_action_check( target ){
	validate_checked = 0 ;

	$j.each( arguments, function(){
		$j.each( $id_filter( this , '^=' ), function(){
			$j( this ).css( checkbox_style( this.checked ) ) ;
			if( this.checked ) validate_checked++ ;
		});
	});

	if( validate_checked == 0 ) col_action_check_info( target ) ;
}

function col_action_check_info( target ){
	$j.each( arguments, function(){
		$j.each( $id_filter( this , '^=' ), function(){
			$j( this ).css( { border: 'solid 3px #CC0000' , outline: 'solid 3px #CC0000' } ) ;
		});
	});
}

function select_check( target ){
	validate_selected = 0 ;

	$j.each( arguments, function(){
		$j.each( $id_filter( this , '^=' ), function(){
			$j( this ).css( selectbox_style() ) ;
			switch( $j( this ).val() ) {
				case  '0' :
					$j( this ).css( { border: 'solid 2px #CC0000' , background: '#FFFFCC' } ) ;
					break ;
				default :
					validate_selected++ ;
		    }
		});
	});
}

function sel_submitter_line_initialize(){
	switch(  $j( '#sel_submitter' ).attr( 'checked' ) ) {
		case false :
			set_hide( 'submitter_select_line' ) ;
			disabled_true( 'submitter' ) ;
			break ;
		case true :
			set_show( 'submitter_select_line' ) ;
			disabled_false( 'submitter' ) ;
			break ;
    }
}

function category_edit_form_initialize(){
	set_hide( 'showimgurl_line' ) ;
	if ( typeof $id( 'useraccess_edit_info' ) == 'object' ) switch( $value( 'pid' ) ) {
		case '0' :
			set_show( 'user_access_edit' ) ;
			set_hide( 'useraccess_edit_info' ) ;
			break ;
		default :
			set_hide( 'user_access_edit' ) ;
			set_show( 'useraccess_edit_info' ) ;
	}
}

function select_box_showhide( selectId, showhideId ){
	var selected_val = $value( selectId ) ;

	$j.each( $id_filter( showhideId , '^=' ), function(){
		var style = ( this.id == showhideId + selected_val ) ? 'inline' : 'none' ;
		this.style.display = style ;
	});
}

function ime_mode_disabled( params ){
	$j.each( arguments, function(){
		if ( typeof $id( this ) == 'object' ) $dom( this ).css( { 'ime-mode' : 'disabled' } ) ;
	});
}

function change_fckeditor( value, id ){
	var ajax_url  = $value( 'ajax_url' ) ;
	var height    = ( typeof XpWiki == 'object' ) ? '100%' : $dom( id ).height() + 200 ;
	var parameter = 'type=change_editor&value=' + encodeURIComponent( value ) + '&id=' + encodeURIComponent( id ) + '&height=' + encodeURIComponent( height ) ;

	$j.get( ajax_url, parameter, function( request, status ) {
		if ( status != 'error' && request != '' ){
			desc_line_showhide( id ) ;
			$j( 'body' ).append( '<div id="_WYSIWYG">'+ request +'</div>' ) ;
			$j( '#html' ).
				attr( 'checked',  true ).
				css( checkbox_style( true ) ) ;
			$j( '#br' ).
				attr( 'checked',  false ).
				css( checkbox_style( false ) ) ;
			if ( typeof XpWiki == 'object' ) {
				$id_filter( '_FckBtn', '$=' ).remove() ;
				$id_filter( '_WrapBtn', '$=' ).remove() ;
			}
		}
	});
}

function show_fckeditor( id ){
	var oEditor  = FCKeditorAPI.GetInstance( id ) ;
	var textarea = $dom( id ) ;
	if ( oEditor.EditMode != FCK_EDITMODE_WYSIWYG ) oEditor.SwitchEditMode() ;
	textarea.hide() ;
	desc_line_showhide( id ) ;
	oEditor.SetHTML( textarea.val() ) ;
	if ( typeof XpWiki != 'object' ) $j( '#' + id + '___Frame' ).height( textarea.height() + 200 ) ;
}

function show_xoopsdhtml( id ){
	var oEditor  = FCKeditorAPI.GetInstance( id ) ;
	var textarea = $dom( id ) ;
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG ) oEditor.SwitchEditMode() ;
	textarea.
		show().
		attr( 'value' , fckeditor_value() ) ;
	if ( typeof XpWiki != 'object' ) textarea.height( $j( '#' + id + '___Frame' ).height() - 200 ) ;
	desc_line_showhide( id ) ;
}

function desc_line_showhide( id ){
	if ( is_fckeditor_frame() ) {
		if ( ! $j.support.noCloneEvent ) fckeditor_remove() ;
		else $j( '#' + id + '___Frame' ).toggle() ;
	}
	change_show_hide( id + '_bbcode_buttons_pre' , id + '_bbcode_buttons_post' , 'xoopsdhtmll' ) ;
	$j( '#' + id +' ~ .grippie' ).toggle() ;
	$j( '.xoopsOptSmaillies' ).toggle() ;
}

function fckeditor_value(){
	var value = '' ;
	if ( typeof FCKeditorAPI == 'object' ) {
		var oEditor = FCKeditorAPI.GetInstance( description_id() ) ;
		value = replace_pagebreak( oEditor.GetHTML() ) ;
	}
	return value ;
}

function replace_pagebreak( value ){
	value = value.replace( /<p>(.*)\[pagebreak]<\/p>/gi, '$1[pagebreak]' ) ;
	value = value.replace( /<div>(.*)\[pagebreak]<\/div>/gi, '$1[pagebreak]' ) ;
	return value ;
}

function fckeditor_insert( value ){
	var oEditor = FCKeditorAPI.GetInstance( description_id() ) ;
	oEditor.InsertHtml( value ) ;
	oEditor.Focus() ;
}

function fckeditor_sethtml(){
	$j( "input[id^='makedownload_']" ).click(function() {
		var id = description_id() ;
		var oEditor = FCKeditorAPI.GetInstance( id ) ;
		if ( is_xoopsdhtml( id ) ) oEditor.SetHTML( $value( id ) ) ;
   });
}

function fckeditor_remove(){
	if ( is_fckeditor_frame() ) $j( '#' + description_id() + '___Frame' ).remove() ;
	if ( typeof $id( '_WYSIWYG' ) == 'object' ) $j( '#_WYSIWYG' ).remove() ;
}

function editor_selector_initialize(){
	var ajax_url = $value( 'ajax_url' ) ;
	$j.get( ajax_url, 'type=is_fckeditor', function( request, status ) {
		var selector = $j( '#editor_selector' ) ;
		if ( status != 'error' && request == 1 ) show_editor_selector( selector ) ;
		else selector.remove() ;
	});
}

function show_editor_selector( selector ){
	selector.
		addClass( 'd3downloads_editor_selector' ).
		fadeIn( 'slow' ).
		text( 'fckeditor' ) ;
}

function is_xoopsdhtml( id ){
	if ( ! is_fckeditor_frame() ) return true ;
	else return ( $dom( id ).css( 'display' ) == 'none' ) ? false : true ;
}

function is_fckeditor_frame(){
	return ( typeof $id( description_id() + '___Frame' ) == 'object' ) ? true : false ;
}

function description_id(){
	if ( typeof FCKobj == 'object' ) return FCKobj.Name ;
	else return ( typeof $id( 'makedownloadform' ) == 'object' ) ? 'desc' : 'description' ;
}

$j( function($){
    $( '#extra_InsertText' ).click( function(){
	 	 extra_InsertText( 'extra' , 'extra_add_title', 'extra_add_desc') ;
    });

    $( '#current_data' ).click( function(){
	 	selectlist_appendText( description_id(), 'current_data_list' ) ;
    });

    $( '#select_platform' ).change( function(){
	 	selectlist_InsertText( 'platform', 'select_platform', 'delimiter' ) ;
    });

    $( '#select_license' ).change( function(){
	 	selectlist_InsertText( 'license', 'select_license', 'delimiter' ) ;
    });

    $( '#select_categorie' ).change( function(){
	 	selectlist_InsertText( 'categories', 'select_categorie', '', ',' ) ;
    });

    $( '#select_lid' ).change( function(){
	 	selectlist_InsertText( 'download_id', 'select_lid', '', ',' ) ;
    });

    $( '#description_image' ).change( function(){
	 	showlogourlSelected( 'show_description_image' , 'description_image', 'show_description_image_line', $value( 'ajax_url' ) ) ;
    });

    $( '#logourl' ).change( function(){
	 	showlogourlSelected( 'showlogourl' , 'logourl', 'showlogourl_line', $value( 'ajax_url' ) ) ;
    });

    $( '#select_img' ).change( function(){
	 	showlogourlSelected( 'show_imgurl' , 'select_img', 'showimgurl_line' , $value( 'ajax_url' ) ) ;
    });

    $id_filter( 'description_image_' , '^=' ).click( function(){
 		var align    = this.id.slice( 18 ) ;
	 	appendCode( description_id(), 'description_image', align ) ;
    });

	$( '#report_submit' ).click( function(){
		str_load( $value( 'url' ) , 'auth' ) ;
		return ;
	});

	$( '#report_cancel' ).click( function(){
		cansel_btn( $value( 'url' ) ) ;
		return ;
    });

	$( '#rate_cancel' ).click( function(){
		cansel_btn( $value( 'url' ) ) ;
        return ;
    });

    $( '#insert_imgurl' ).click( function(){
	 	select_imgurl( 'show_imgurl', 'select_img', 'imgurl' ) ;
    });

    $( '#file_url_onoff' ).click( function(){
		change_show_hide( 'post_url' , 'upload' , 'max_submit_size' , 'submit_size_desc' ) ;
		disabled_on_off( 'url' , 'url_hidden' , ':file' ) ;
		if( this.checked ) $( '#url_hidden' ).attr( 'value' , $value( 'url' ) ) ;
    });

	$.each( $( ':checkbox' ), function(){
		$( this ).css( checkbox_style( this.checked ) ) ;
	});

	$( ':checkbox' ).change( function(){
		$( this ).css( checkbox_style( this.checked ) ) ;
	});

	$( 'select' ).change( function(){
		$( this ).css( selectbox_style() ) ;
	});

    $( '#sel_submitter' ).click( function(){
 		change_by_fade_Out( 'submitter_select_line' ) ;
 		disabled_on_off(  'submitter'  ) ;
		document.forms['filemanager'] .submit() ;
    });

    if ( typeof $id( 'useraccess_edit_info' ) == 'object' ) $( '#pid' ).change( function(){
		switch( $value( 'pid' ) ) {
			case '0' :
				fade_In( 'user_access_edit' ) ;
				fade_Out( 'useraccess_edit_info' ) ;
				break ;
			default :
				fade_Out( 'user_access_edit' ) ;
				fade_In( 'useraccess_edit_info' ) ;
		}
    });

	$( '#copy_mid' ).change( function(){
		select_box_showhide( 'copy_mid', 'copy_category_id_' ) ;
	});

    $( 'body' ).mousedown( function( event ){
		X = event.pageX ;
		Y = event.pageY ;
	});

    if ( typeof $.fn.TextAreaResizer == 'function' && $( 'textarea' ).length && typeof XpWiki != 'object' ) {
		if ( typeof fckeditor_exec != 'function' ) {
			$( 'textarea' ).addClass( 'resizable' ) ;
		} else {
			$( 'textarea:not( #desc )' ).addClass( 'resizable' ) ;
		}
		$( 'textarea.resizable:not( .processed )' ).TextAreaResizer() ;
	}

	ime_mode_disabled( 'size' , 'cat_weight' ) ;
	$id_filter( 'col_weight_' , '^=' ).css( { 'ime-mode' : 'disabled' } ) ;

    if ( typeof $.fn.seekAttention == 'function' && typeof $id( 'post_preview' ) == 'object' ){
		var previewDom = $( '#post_preview' ) ;
		var offsetTop  = ( $( '#form_title' ).length ) ? previewDom.offset().top - $( '#form_title' ).offset().top : 0 ;
		var paddingTop = ( offsetTop > 0 ) ? offsetTop : 0 ;
		var style = {
			 pulse:        false,
			 hideOnHover:  false,
			 paddingTop:   + paddingTop,
			 paddingLeft:  10,
			 paddingRight: 10,
			 opacity:      0.7
		}
		previewDom.seekAttention( style ) ;
    }

    if ( typeof $.fn.seekAttention == 'function' && $( '.d3downloads_error_message' ).length ) {
		var style = {
			 pulse:        false,
			 hideOnHover:  false,
			 opacity:      0.7
		}
		$( '.d3downloads_error_message' ).seekAttention( style ) ;
    }

	if ( typeof $id( 'makedownloadform' ) == 'object' ) $( "input[id^='makedownload_']" ).click(function() {
		validate_error = 0 ;
		var url       = $value( 'url' ) ;
		var lid       = $( "input[name='lid']" ).val() ;
		var ajax_url  = $value( 'ajax_url' ) ;
	 	infoDom_initialize() ;
	 	if( url.match(/^(https?|ftp):\/\//i ) ) check_url( url, lid, ajax_url, 'check_url' ) ;
	 	check_url( url, lid, ajax_url, 'check_unapproval' ) ;
		return ( validate_error == 0 ) ? true : false ;
    });

	if ( typeof $id( 'editor_selector' ) == 'object' ) editor_selector_initialize() ;

	$( '#editor_selector' ).click( function(){
		var selectDom = $( this ) ;
	 	var targetId  = description_id() ;
		var value     = selectDom.text() ;
		switch( value ) {
			case 'fckeditor' :
				var other_selector = 'xoopsdhtml' ;
				if ( ! is_fckeditor_frame() ) change_fckeditor( value, targetId ) ;
				else if ( typeof FCKeditorAPI == 'object' ) show_fckeditor( targetId ) ;
				break ;
			case 'xoopsdhtml' :
				var other_selector = 'fckeditor' ;
			 	if ( typeof FCKeditorAPI == 'object' ) show_xoopsdhtml( targetId ) ;
				break ;
		}
		selectDom.
			hide().
			text( other_selector ).
			fadeIn( 2000 ) ;
    });

	if ( typeof XpWiki == 'object' ) $( '#' + description_id() + '_FckBtn' ).live( 'click', function(){
		$( '#editor_selector' ).remove() ;
		$( '#filter_enabled_xpwiki' ).
			attr( 'checked',  true ).
			css( checkbox_style( true ) ) ;
		$( '#html' ).
			attr( 'checked',  false ).
			css( checkbox_style( false ) ) ;
    });
});

function target_style(){
	return { border: '1px solid #CC0000' , background: '#FFFFCC' } ;
}

function info_style(){
	return {
		'border':               'solid 1px #CC0000',
		'padding':              '5px',
		'margin-top':           '5px',
		'margin-bottom':        '5px',
		'-moz-border-radius':   '5px',
		'-webkit-border-radius':'5px',
		'color':                '#CC0000',
		'font-family':          'Tahoma, Arial, Helvetica, sans-serif',
		'text-align':           'left',
		'font-weight':          'bold',
		'font-size':            '12px'
	}
}

function popup_style( infoDom ){
	var height = ( infoDom.height() == 0 ) ? 30 : infoDom.height() + 15 ;
	var width  = 390 ;
	var top    = ( ( Y + height ) > $j( window ).height() ) ? Y - ( height * 2 ) : Y + 10 ;
	var left   = ( X - ( width + 10 ) > 0 ) ? X - ( width + 10 ) : X + 15 ;

	return {
		'position':             'absolute',
		'top':                  + top + 'px',
		'left':                 + left + 'px',
		'background-color':     '#000',
		'opacity':              '.90',
		'filter':               'alpha(opacity = .90)',
		'zoom':                 '1',
		'width':                + width + 'px',
		'padding':              '10px',
		'margin-top':           '5px',
		'margin-bottom':        '5px',
		'-moz-border-radius':   '5px',
		'-webkit-border-radius':'5px',
		'float':                'right',
		'color':                '#FFF',
		'font-family':          'Tahoma, Arial, Helvetica, sans-serif',
		'text-align':           'left',
		'font-weight':          'bold',
		'font-size':            '12px'
	}
}

function li_style(){
	return '<li style="color:#FFF;list-style-type:disc;">' ;
}

function checkbox_style( check_val ){
	return ( check_val ) ? 
				{ border: 'solid 2px greenyellow' , outline: 'solid 1px greenyellow' } :
				{ border: 'solid 1px #CCCCCC' , outline: 'solid 1px #CCCCCC' } ;
}

function selectbox_style(){
	return { 'border': 'solid 1px #000000' , 'background': '#FFFFFF' } ;
}
