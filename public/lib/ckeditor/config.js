/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'id';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = '/lib/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '/lib/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = '/lib/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = '/lib/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = '/lib/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = '/lib/kcfinder/upload.php?opener=ckeditor&type=flash';
	config.filebrowserUploadMethod = 'form';
  config.extraPlugins = 'video,videoembed';
};
