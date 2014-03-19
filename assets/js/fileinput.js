/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-widgets
 * @version 1.0.0
 *
 * File input styled for Twitter Bootstrap 3.0 that utilizes HTML5 File Input's
 * advanced features. This plugin is inspired by the blog article at
 * http://www.abeautifulsite.net/blog/2013/08/whipping-file-inputs-into-shape-with-bootstrap-3/
 * and Jasny's File Input plugin http://jasny.github.io/bootstrap/javascript/#fileinput
 * 
 * Built for Yii Framework 2.0. But this is useful for various scenarios.
 * Author: Kartik Visweswaran
 * Copyright: 2013, Kartik Visweswaran, Krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
(function ($) {
	var isEmpty = function (value, trim) {
		return value === null || value === undefined || value == []
			|| value === '' || trim && $.trim(value) === '';
	}
	var getValue = function (options, param, value) {
		return (isEmpty(options) || isEmpty(options[param])) ? value : options[param];
	}
	var isImageFile = function (type, name) {
		return (typeof type !== "undefined") ? type.match('image.*') : name.match(/\.(gif|png|jpe?g)$/i);
	}
	var isTextFile = function (type, name) {
		return (typeof type !== "undefined") ? type.match('text.*') : name.match(/\.(txt|md|csv|htm|html|php|ini)$/i);
	}
	var FileInput = function (element, options) {
		this.$element = $(element)

		/* Initialize plugin option parameters */
		this.$input = getValue(options, 'elInput', this.$element.find(':file'));
		this.$caption = getValue(options, 'elCaptionText', this.$element.find('.file-caption-name'));
		this.$previewContainer = getValue(options, 'elPreviewContainer', this.$element.find('.file-preview'));
		this.$preview = getValue(options, 'elPreviewImage', this.$element.find('.file-preview-thumbnails'));
		this.$previewStatus = getValue(options, 'elPreviewStatus', this.$element.find('.file-preview-status'));
		this.$msgLoading = getValue(options, 'msgLoading', 'Loading &hellip;');
		this.$msgProgress = getValue(options, 'msgProgress', 'Loaded {percent}% of {file}');
		this.$msgSelected = getValue(options, 'msgSelected', '{n} files selected')
		this.$previewFileType = getValue(options, 'previewFileType', 'image')
		this.$wrapTextLength = getValue(options, 'wrapTextLength', 250)
		this.$wrapIndicator = getValue(options, 'wrapIndicator', ' <span class="wrap-indicator" title="{title}">[&hellip;]</span>')

		if (this.$input.length === 0) {
			return
		}
		this.$name = this.$input.attr('name') || options.name
		this.$hidden = this.$element.find('input[type=hidden][name="' + this.$name + '"]')
		this.$isIE == (window.navigator.appName == 'Microsoft Internet Explorer')

		if (this.$hidden.length === 0) {
			this.$hidden = $('<input type="hidden" />')
			this.$element.prepend(this.$hidden)
		}
		this.original = {
			preview: this.$preview.html(),
			hiddenVal: this.$hidden.val()
		}
		this.listen()
	}

	FileInput.prototype = {
		constructor: FileInput,
		listen: function () {
			this.$input.on('change', $.proxy(this.change, this))
			$(this.$input[0].form).on('reset', $.proxy(this.reset, this))
			this.$element.find('.fileinput-remove').on('click', $.proxy(this.clear, this))
		},
		trigger: function (e) {
			this.$input.trigger('click')
			e.preventDefault()
		},
		clear: function (e) {
			if (e) {
				e.preventDefault()
			}

			this.$hidden.val('')
			this.$hidden.attr('name', this.name)
			this.$input.attr('name', '')

			if (this.$isIE) {
				var inputClone = this.$input.clone(true);
				this.$input.after(inputClone);
				this.$input.remove();
				this.$input = inputClone;
			} else {
				this.$input.val('')
			}
			if (e !== false) {
				this.$input.trigger('change')
				this.$element.trigger('fileclear')
			}
			this.$preview.html('')
			this.$caption.html('')
			this.$element.removeClass('file-input-new').addClass('file-input-new')
		},
		reset: function (e) {
			this.clear(false)
			this.$hidden.val(this.original.hiddenVal)
			this.$preview.html(this.original.preview)
			this.$element.find('.fileinput-filename').text('')
			this.$element.trigger('filereset')
		},
		change: function (e) {
			var elem = this.$input, files = elem.get(0).files, numFiles = files ? files.length : 1,
				label = elem.val().replace(/\\/g, '/').replace(/.*\//, ''), preview = this.$preview,
				container = this.$previewContainer, status = this.$previewStatus, msgLoading = this.$msgLoading,
				msgProgress = this.$msgProgress, msgSelected = this.$msgSelected, tfiles,
				fileType = this.$previewFileType, wrapLen = parseInt(this.$wrapTextLength),
				wrapInd = this.$wrapIndicator

			if (e.target.files === undefined) {
				tfiles = e.target && e.target.value ? [
					{name: e.target.value.replace(/^.+\\/, '')}
				] : []
			}
			else {
				tfiles = e.target.files
			}
			if (tfiles.length === 0) {
				return
			}
			preview.html('')
			var total = tfiles.length
			for (var i = 0; i < total; i++) {
				(function (file) {
					var caption = file.name
					var isImg = isImageFile(file.type, file.name)
					var isTxt = isTextFile(file.type, file.name)

					if (preview.length > 0 && (fileType == "any" ? (isImg || isTxt) : (fileType == "text" ? isTxt : isImg)) && typeof FileReader !== "undefined") {
						var reader = new FileReader();
						status.html(msgLoading)
						container.addClass('loading')
						reader.onload = function (theFile) {
							var content = ''
							if (isTxt) {
								var strText = theFile.target.result
								if (strText.length > wrapLen) {
									wrapInd = wrapInd.replace("{title}", strText)
									strText = strText.substring(0, (wrapLen - 1)) + wrapInd
								}
								content = '<div class="file-preview-frame"><div class="file-preview-text" title="' + caption + '">' + strText + '</div></div>';
							}
							else {
								content = '<div class="file-preview-frame"><img src="' + theFile.target.result + '" class="file-preview-image" title="' + caption + '" alt="' + caption + '"></div>';
							}
							preview.append("\n" + content)
							if (i >= total - 1) {
								container.removeClass('loading')
								status.html('')
							}
						}
						reader.onprogress = function (data) {
							if (data.lengthComputable) {
								var progress = parseInt(((data.loaded / data.total) * 100), 10);
								var msg = msgProgress.replace('{percent}', progress).replace('{file}', file.name)
								status.html(msg);
							}
						}
						if (isTxt) {
							reader.readAsText(file);
						}
						else {
							reader.readAsDataURL(file);
						}
					}
					else {
						preview.append("\n" + '<div class="file-preview-frame"><div class="file-preview-other"><h2><i class="glyphicon glyphicon-file"></i></h2>' + caption + '</div></div>')
					}
				})(tfiles[i]);
			}
			var log = numFiles > 1 ? msgSelected.replace('{n}', numFiles) : label;
			this.$caption.html(log)
			this.$element.removeClass('file-input-new')
			elem.trigger('fileselect', [numFiles, label]);
		}
	}

	$.fn.fileinput = function (options) {
		return this.each(function () {
			var $this = $(this), data = $this.data('fileinput')
			if (!data) {
				$this.data('fileinput', (data = new FileInput(this, options)))
			}
			if (typeof options == 'string') {
				data[options]()
			}
		})
	};

})(window.jQuery);