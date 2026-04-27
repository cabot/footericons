/* Add/edit icon page
------------------------------------------------------------*/

/**
 * Return the correct FontAwesome class string for a given icon code.
 * FA7 brands icons use "fa-brands fa-xxx" (no "fa" prefix needed).
 * FA4 icons use "fa fa-xxx".
 * @param {string} code Icon code from icons.json.
 * @returns {string}
 */
function faClass(code) {
	return code.startsWith('fa-brands ') ? code : 'fa ' + code;
}

/**
 * Initialize Spectrum color picker for `.fi-input-color` inputs.
 * @returns {void}
 */
function spectrumize() {
	$(".fi-input-color").spectrum({
		type: "component",
		showPalette: false,
		showInput: true,
		showButtons: false,
		allowEmpty: false
	});
}

/**
 * Show or hide dependent settings based on selected option.
 * @param {HTMLElement|jQuery} selectElement The triggering <select> element.
 * @returns {void}
 */
function toggling(selectElement) {
	let $optionSelected = $("option:selected", selectElement),
		$select = $optionSelected.parent(),
		$hasToggler = $optionSelected.closest(".has-toggler"),
		$istogglable = $hasToggler.siblings().filter(".is-togglable");

	if ($optionSelected.val() == 0) {
		$istogglable.hide().addClass("is-closed");
	} else {
		$istogglable.show().removeClass("is-closed");
	}

	$select.on("change", function () {
		if ($(this).val() == 0) {
			$istogglable.slideUp(200).addClass("is-closed");
		} else {
			$istogglable.slideDown(200).removeClass("is-closed");
		}
	});
}

/**
 * Setup live preview for icon name (label).
 * @param {jQuery} $iconRow Icon edit row.
 * @param {jQuery} $legendRow Corresponding legend row.
 * @returns {void}
 */
function setupNamePreview($iconRow, $legendRow) {
	let $fiNameInput = $(".fi-name-input", $iconRow);
	$fiNameInput.on("input", function () {
		let linkName = $(this).val() || defaultLegendLang;
		$legendRow.children().last().text(linkName);
	});
}

/**
 * Update icon preview when the icon code (FontAwesome class) changes.
 * @param {jQuery} $iconRow Icon edit row.
 * @param {jQuery} $legendRow Corresponding legend row.
 * @returns {void}
 */
function setupCodePreview($iconRow, $legendRow) {
	let $fiCodeInput = $(".fi-code-input", $iconRow);
	$fiCodeInput.on("change", function () {
		let code = $(this).val() || 'fa-caret-right';
		$iconRow.find('.fi-input-preview').attr('class', 'fi-input-preview ' + faClass(code));
		// update inline legend
		if ($legendRow.find('.fi-icon').length) {
			let bgVal = $iconRow.find('.has-fi-bg-select option:selected').val();
			if (bgVal == 0) {
				$legendRow.find('.fi-icon').attr('class', 'fi-icon ' + faClass(code) + ' fa-stack-2x');
			} else {
				$legendRow.find('.fi-icon').attr('class', 'fi-icon ' + faClass(code) + ' fa-stack-1x');
			}
			$legendRow.find('.fi-icon').attr('data-icon', code);
		}
	});
}

/**
 * Update the legend's title attribute from the description.
 * @param {jQuery} $iconRow Icon edit row.
 * @param {jQuery} $legendRow Corresponding legend row.
 * @returns {void}
 */
function setupDescPreview($iconRow, $legendRow) {
	let $fiDesc = $(".fi-desc", $iconRow);
	$fiDesc.on("change", function () {
		let titleValue = $(this).val() || "";
		$legendRow.attr("title", titleValue);
	});
}

/**
 * Update preview colors by listening to color input changes.
 * @param {jQuery} $iconRow Icon edit row.
 * @param {jQuery} $legendRow Corresponding legend row.
 * @returns {void}
 */
function setupColorPreview($iconRow, $legendRow) {
	$(".fi-input-color", $iconRow).each(function () {
		if ($(this).data("css-var")) {
			$(this).on("change", function () {
				$legendRow.children().first().css($(this).data("css-var"), $(this).val());
			});
		}
	});
}

/**
 * Update icon background preview (shape, visibility) and handle toggler.
 * @param {jQuery} $iconRow Icon edit row.
 * @param {jQuery} $legendRow Corresponding legend row.
 * @returns {void}
 */
function setupBgPreview($iconRow, $legendRow) {
	let $fiBgSelect = $(".has-fi-bg-select", $iconRow);
	let $legendIconBg = $(".fi-icon-bg", $legendRow),
		$legendIcon = $(".fi-icon", $legendRow);

	toggling($fiBgSelect);

	$fiBgSelect.off('change.footericonsBg').on('change.footericonsBg', function () {
		let selectedOption = $(this).find("option:selected"),
			val = selectedOption.val();
		if (val == 0 || val === '0') {
			$legendIconBg.hide();
			$legendIcon.addClass('fa-stack-2x').removeClass('fa-stack-1x');
		} else {
			$legendIconBg.show();
			$legendIcon.addClass('fa-stack-1x').removeClass('fa-stack-2x');
			// reset bg shape classes then add the requested one
			$legendIconBg.removeClass('fa-circle fa-square fa-stop');
			if (val == 1 || val === '1') {
				$legendIconBg.addClass('fa-circle');
			} else if (val == 2 || val === '2') {
				$legendIconBg.addClass('fa-square');
			} else if (val == 3 || val === '3') {
				$legendIconBg.addClass('fa-stop');
			}
		}
	});
}

/**
 * Initialize the icon picker and attach open/select events.
 * @param {jQuery} $iconRow Icon edit row.
 * @param {Array<string>} icons List of available icons (FA classes).
 * @returns {void}
 */
function initIconPicker($iconRow, icons) {
	$(".fi-code-input").on("click", function () {
		if ($(".fi-darkwrapper").length) {
			return;
		}

		let $input = $(this),
			$inputPreview = $input.next(),
			$legendPreview = $input.closest("fieldset").children("legend").find("[data-icon]"),
			dataIcon = $legendPreview.attr("data-icon");

		$("body").append('<div class="fi-darkwrapper"><div class="fi-wrapper"><div class="fi-picker"><input type="text" id="fi-search" class="fi-search" placeholder="' + searchIconLang + '"><ul class="fi-list"></ul></div><button class="fi-close">' + closeIconsLang + '</button></div></div>');

		let $wrapper = $(".fi-darkwrapper");
		let $fiList = $wrapper.find('.fi-list');

		let itemsHtml = icons.map(function (icon) {
			return '<li class="fi-item' + (icon === dataIcon ? ' fi-selected' : '') + '" title="' + icon + '"><i class="' + faClass(icon) + '" data-icode="' + icon + '"></i><span class="sr-only">' + icon + '</span></li>';
		}).join('');
		$fiList.append(itemsHtml);

		let $search = $wrapper.find('#fi-search');
		let searchTimeout = null;
		$search.focus().on('keyup', function () {
			let rawFilter = $(this).val();
			clearTimeout(searchTimeout);
			searchTimeout = setTimeout(function () {
				let safeFilter = rawFilter.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
				let re = new RegExp(safeFilter, 'i');
				$fiList.children().each(function () {
					$(this).toggle(re.test($(this).attr('title')));
				});
			}, 150);
		});

		function closeWrapper() {
			$wrapper.remove();
			$(document).off('keydown.iconpicker');
		}

		$(document).on('keydown.iconpicker', function (e) {
			if (e.key === 'Escape') { closeWrapper(); }
		});

		$wrapper.on('click', closeWrapper);
		$wrapper.find('.fi-close').on('click', closeWrapper);
		$wrapper.find('.fi-picker').on('click', function (e) { e.stopPropagation(); });

		$fiList.on('click', '.fi-item', function () {
			let iconCode = $(this).children().data('icode');
			let stackClass = $legendPreview.hasClass('fa-stack-1x') ? 'fa-stack-1x' : 'fa-stack-2x';

			$(this).addClass('fi-selected').siblings().removeClass('fi-selected');
			$input.val(iconCode);
			$inputPreview.attr('class', 'fi-input-preview ' + faClass(iconCode));
			$legendPreview
				.attr('class', 'fi-icon ' + faClass(iconCode) + ' ' + stackClass)
				.attr('data-icon', iconCode);
			dataIcon = iconCode;
		});
	});
}

/**
 * Initialize preview handlers for editing an icon and load icons list via JSON.
 * @returns {void}
 */
function preview() {
	let $iconRow = $("#fi_edit"),
		fiBg = $(".has-fi-bg-select", $iconRow).find("option:selected").val(),
		stackClass = "",
		$legendRow = $("legend", $iconRow);

	if (fiBg == 0) {
		stackClass = "fa-stack-2x";
	} else {
		stackClass = "fa-stack-1x";
	}

	setupNamePreview($iconRow, $legendRow);
	setupCodePreview($iconRow, $legendRow);
	setupDescPreview($iconRow, $legendRow);
	setupColorPreview($iconRow, $legendRow);
	setupBgPreview($iconRow, $legendRow);
	$.getJSON(iconsJsonPath)
		.done(function (icons) { initIconPicker($iconRow, icons); })
		.fail(function () { initIconPicker($iconRow, []); });
}

spectrumize();
preview();

/**
 * AJAX callback invoked after applying a global style.
 * @param {Object} res Response object possibly containing `success`, `style`, and `MESSAGE_*`.
 * @returns {void}
 */
phpbb.addAjaxCallback('apply_style', function(res) {
	if (typeof res.success === 'undefined' || !res.success) {
		return;
	}

	if (res.style) {
		let style = res.style;
		$('.fi-preview').each(function () {
			var $preview = $(this);
			$preview.css('--fi-color', style.fi_color || '');
			$preview.css('--fi-color-hover', style.fi_color_hover || '');
			$preview.css('--fi-bgcolor', style.fi_bgcolor || 'transparent');
			$preview.css('--fi-bgcolor-hover', style.fi_bgcolor_hover || 'transparent');
			$preview.css('--fi-shadow-color', style.fi_shadow_color || 'transparent');

			let $link = $preview.find('.fi-link');
			let $iconBg = $preview.find('.fi-icon-bg');
			let fiBg = parseInt(style.fi_bg, 10) || 0;

			if (fiBg === 0) {
				$link.addClass('fi-nobg');
				if ($iconBg.length) {
					$iconBg.remove();
				}
				$preview.find('.fi-icon').removeClass('fa-stack-1x').addClass('fa-stack-2x');
			} else {
				$link.removeClass('fi-nobg');
				let stackClass = fiBg === 1 ? 'fa-circle' : (fiBg === 2 ? 'fa-square' : 'fa-stop');
				if (!$iconBg.length) {
					$preview.find('.fi-icon').before('<i class="fi-icon-bg fa ' + stackClass + ' fa-stack-2x" aria-hidden="true"></i>');
				} else {
					$iconBg.removeClass('fa-circle fa-square fa-stop').addClass(stackClass);
				}
				$preview.find('.fi-icon').removeClass('fa-stack-2x').addClass('fa-stack-1x');
			}
		});
	}

	if (res.MESSAGE_TITLE && res.MESSAGE_TEXT) {
		phpbb.alert(res.MESSAGE_TITLE, res.MESSAGE_TEXT);
	}
});

/**
 * AJAX callback invoked after deleting an icon.
 * @param {Object} res Response object.
 * @returns {void}
 */
phpbb.addAjaxCallback('fi_row_delete', function(res) {
	if (res.success !== false) {
		let iconRows = $('.fi-row-preview').length - 1;

		$(this).closest('tr').remove();

		$('.fi-actions').toggleClass('fi-disabled', iconRows <= 1);

		if (iconRows === 0) {
			$('#fi_no_items').removeAttr('hidden');
		}
	}

	if (res.MESSAGE_TITLE && res.MESSAGE_TEXT) {
		phpbb.alert(res.MESSAGE_TITLE, res.MESSAGE_TEXT);
	}
});
