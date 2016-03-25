CKEDITOR.editorConfig = function(config)
{
	config.extraPlugins = "onchange";
	
	config.language = "ru";
	
//	config.uiColor = "#eee";
	config.skin = "moono";
	
	config.toolbar = "advanced";
	config.toolbar_advanced = [
		{
			name: 'document', 
			items: ['Source', '-', 'Maximize']
		},
		{
			name: 'clipboard', 
			items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
		},
		{
			name: 'links',
			items: ['Link', 'Unlink', 'Anchor']
		},
		{
			name: 'insert',
			items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
		},
		{
			name: 'styles',
			items: ['Font', 'FontSize', 'Styles', 'Format']
		},
		{
			name: 'colors',
			items: ['TextColor', 'BGColor']
		},
		{
			name: 'editing',
			items: ['Find', 'Replace', '-', 'SelectAll']
		},
		{
			name: 'basicstyles',
			items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
		},
		{
			name: 'paragraph',
			items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] 
		}
	];
};
