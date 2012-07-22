<?php

define( '_MD_D3DOWNLOADS_FILTERS_XPWIKI_TITLE','xpWiki renderer' );

if ( ! function_exists('d3downloads_xpwiki') ) {
	function d3downloads_xpwiki( $text, $html, $smiley, $xcode, $image, $br )
	{
		if ( ! class_exists( 'd3downloadsTextSanitizer' ) ) {
			require_once dirname( dirname( dirname(__FILE__) ) ).'/class/d3downloads.textsanitizer.php' ;
		}
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		if ( ! class_exists( 'XpWiki' ) ) {
			@ include_once XOOPS_TRUST_PATH.'/modules/xpwiki/include.php' ;
		}
		if( ! class_exists( 'XpWiki' ) ) die( 'xpWiki is not installed correctly' ) ;

		// Get instance. option is xpWiki module's directory name.
		// 引数は、xpWikiをインストールしたディレクトリ名です。
		$wiki =& XpWiki::getSingleton( 'xpwiki' );
	
		// xpWiki の動作を決定する設定値を変更できます。
		// $wiki->setIniConst( '[KEY]' , '[VALUE]' ); // $wiki->root->[KEY] = [VALUE];
		// $wiki->setIniRoot( '[KEY]' , '[VALUE]' );  // $wiki->cont->[KEY] = [VALUE];
	
		// ex, 改行を有効にする
		$wiki->setIniRoot( 'line_break' , 1 );
		// ex. レンダリングキャッシュをする
		$wiki->setIniRoot( 'render_use_cache' , 1 );
		// ex. レンダリングキャッシュの有効期限は新たにページが作成されるまで
		$wiki->setIniRoot( 'render_cache_min' , 0 ); // キャッシュ有効時間(分)
		// ex. 外部リンクの target 属性 '_blank'
		$wiki->setIniRoot( 'link_target' , '_blank' );
	
		if ($html != 1) {
 			// 第二引数は、xpWikiのCSSを適用するためのDIVクラス名
			// 通常インストールしたディレクトリ名です。
			// CSS を適用しない場合は空白 '' でOK。
			$text = $wiki->transform( $text , 'xpwiki' ) ;
		} else {
			$text = $myts->codePreConv( $text, $xcode ) ;
 			$text = $myts->makeClickable( $text );
			if( $smiley != 0 ) $text = $myts->smiley( $text ) ;
		}
		if( $xcode != 0 ) $text = $myts->xoopsCodeDecode( $text, $image ) ;
		if( $html && $br != 0) $text = $myts->nl2Br( $text ) ;
		if( $html ) $text = $myts->codeConv( $text, $xcode, $image ) ;
		$text = $myts->postCodeDecode( $text , $image ) ;
		return $text;
	}
}

?>