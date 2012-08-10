/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    config.language = 'En';
	config.height = 300;
	config.width = '100%';
	config.skin = 'kama'; 
//    config.uiColor = '#aaaaaa';
	config.font_names='Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif';
    config.filebrowserBrowseUrl = '../xelfinder/manager.php?cb=ckeditor';
	config.filebrowserWindowHeight = 520;
	config.filebrowserWindowWidth = 800;
	config.autoGrow_maxHeight = 500;
	config.autoGrow_minHeight = 300;
	config.autoGrow_onStartup = true;
	config.protectedSource.push( /<\{[\s\S]*?\}>/g );   // Smarty code
	config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP code
};
