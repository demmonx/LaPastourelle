tinymce.init({
	selector : 'textarea.editor',
	language : "fr_FR",
	plugins : [ "image", "media", "link" ],
	video_template_callback : function(data) {
		return '<video width="'
				+ data.width
				+ '" height="'
				+ data.height
				+ '"'
				+ (data.poster ? ' poster="' + data.poster + '"' : '')
				+ ' controls="controls">\n'
				+ '<source src="'
				+ data.source1
				+ '"'
				+ (data.source1mime ? ' type="' + data.source1mime + '"' : '')
				+ ' />\n'
				+ (data.source2 ? '<source src="'
						+ data.source2
						+ '"'
						+ (data.source2mime ? ' type="' + data.source2mime
								+ '"' : '') + ' />\n' : '') + '</video>';
	}

});