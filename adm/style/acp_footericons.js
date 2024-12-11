// Spectrum color
function spectrumize() {
	$(".fi-input-color").spectrum({
		type: "component",
		showPalette: false,
		showInput: true,
		showButtons: false,
		allowEmpty: false
	});
}

// Show/hide icon settings
function toggling(row) {
	let $optionSelected = $("option:selected", row),
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

// Help user to configure icons
function preview() {
	let inputHeight = $(".fi-input-color").first().outerHeight();

	$("#footericons_size").on("change", function () {
		let sizeVal = $(this).val();
		$(".fi-row-legend").css("--fi-size", sizeVal)
	});

	$(".fi-row").each(function () {
		let $iconRow = $(this),
			fiBg = $(".has-fi-bg-select", $iconRow).find("option:selected").val(),
			stackClass = "",
			$fiUrl = $(".fi-url-input", $iconRow),
			$required = $(".required", $iconRow),
			$deleteButton = $(".fi-delete-button", $iconRow),
			$deleteIcon = $("i", $deleteButton),
			$deleteText = $(".fi-delete-text", $deleteButton),
			$deleteInfo = $deleteButton.siblings(".fi-delete-info"),
			$legendRow = $("legend", $iconRow);

		if (fiBg == 0) {
			stackClass = "fa-stack-2x";
		} else {
			stackClass = "fa-stack-1x";
		}

		// Icon link URL
		$fiUrl.each(function () {
			if ($(this).is(".is-validated")) {
				$deleteButton.show();
			}

			$(this).on("change", function () {
				$deleteButton.toggleClass("fi-restore fi-delete");
				$deleteIcon.toggleClass("fa-rotate-left fa-trash-o");

				if (!$(this).val()) {
					$deleteText.html(restoreIconLang);
					$deleteInfo.fadeIn();
					$required.prop("required", false);
					if ($(this).is(".is-validated")) {
						$(this).closest("dl").nextAll().not(".is-closed").slideUp(200);
					}
				} else {
					$deleteButton.show();
					$deleteText.html(deleteIconLang);
					$deleteInfo.fadeOut(200);
					$required.prop("required", true);
					if ($(this).is(".is-validated")) {
						$(this).closest("dl").nextAll().not(".is-closed").slideDown(200);
					}
				}
			});
		});

		// Delete button
		$deleteButton.each(function () {
			let tempVal = $fiUrl.val();

			$(this).on("click", function (e) {
				e.preventDefault();
				$(this).toggleClass("fi-restore fi-delete");
				$deleteIcon.toggleClass("fa-rotate-left fa-trash-o");

				if ($(this).is(".fi-restore")) {
					$fiUrl.val("");
					$deleteText.html(restoreIconLang);
					$deleteInfo.fadeIn();
					$required.prop("required", false);
					$(this).parent().nextAll().not(":first, .is-closed").slideUp(200);
				} else {
					$fiUrl.val(tempVal);
					$deleteText.html(deleteIconLang);
					$deleteInfo.fadeOut(200);
					$required.prop("required", true);
					$(this).parent().nextAll().not(":first, .is-closed").slideDown(200);
				}
			})
		});

		// Icon link name
		$(".fi-name-input", $iconRow).each(function () {
			if (!$fiUrl.val()) {
				$(this).prop("required", false);
			} else {
				$(this).prop("required", true);
			}

			// Icon link name preview
			$(this).on("input", function () {
				let linkName;

				if (!$(this).val()) {
					linkName = defaultLegendLang;
				} else {
					linkName = $(this).val();
				}
				$legendRow.children().last().text(linkName);
			});
		});

		// Icon title attribute preview
		$(".fi-desc", $iconRow).each(function () {
			$(this).on("change", function () {
				let titleValue;

				if (!$(this).val()) {
					titleValue = "";
				} else {
					titleValue = $(this).val();
				}
				$legendRow.attr("title", titleValue);
			});
		});

		// Colors preview
		$(".fi-input-color", $iconRow).each(function () {
			if ($(this).data("css-var")) {
				$(this).on("change", function () {
					$legendRow.children().first().css($(this).data("css-var"), $(this).val());
				});
			}
		});

		// Icon background type preview
		$(".has-fi-bg-select", $iconRow).each(function () {
			let optionSelected = $("option:selected", $(this)),
				$siblings = $(".is-togglable", $iconRow),
				$legendIconBg = $(".fi-icon-bg", $legendRow),
				$legendIcon = $(".fi-icon", $legendRow);

			toggling($(this));

			// Need to tweak color view width
			if ($siblings.is(":hidden")) {
				$siblings.find(".sp-colorize-container").width(inputHeight + "px");
			}

			if (optionSelected.val() == 0) {
				$legendIconBg.hide()
				$legendIcon.addClass("fa-stack-2x").removeClass("fa-stack-1x");
			} else {
				$legendIconBg.show();
				$legendIcon.addClass("fa-stack-1x").removeClass("fa-stack-2x");
			}

			$("select", $(this)).on("change", function () {
				if ($(this).val() == 0) {
					$legendIconBg.hide();
					$legendIcon.addClass("fa-stack-2x").removeClass("fa-stack-1x");
				} else {
					$legendIconBg.show();
					$legendIcon.addClass("fa-stack-1x").removeClass("fa-stack-2x");
					if ($(this).val() == 1) {
						$legendIconBg.addClass("fa-circle").removeClass("fa-square fa-stop");
					} else if ($(this).val() == 2) {
						$legendIconBg.addClass("fa-square").removeClass("fa-circle fa-stop");
					} else if ($(this).val() == 3) {
						$legendIconBg.addClass("fa-stop").removeClass("fa-square fa-circle");
					}
				}
			});
		});

	});

	// Global reset
	$('input[name="reset"]').on("click", function () {
		$(".fi-delete-info").fadeOut(200);
		$(".fi-delete-button").removeClass("fi-restore").addClass("fi-delete");
		$(".fi-delete-text").html(deleteIconLang);
		$("dl, .fi-top").not(".is-closed").slideDown(200);
	});

	(function ($) {
		$.iconize = function () {
			var icons = ["fa-500px", "fa-address-book", "fa-address-book-o", "fa-address-card", "fa-address-card-o", "fa-adjust", "fa-adn", "fa-align-center", "fa-align-justify", "fa-align-left", "fa-align-right", "fa-amazon", "fa-ambulance", "fa-american-sign-language-interpreting", "fa-anchor", "fa-android", "fa-angellist", "fa-angle-double-down", "fa-angle-double-left", "fa-angle-double-right", "fa-angle-double-up", "fa-angle-down", "fa-angle-left", "fa-angle-right", "fa-angle-up", "fa-apple", "fa-archive", "fa-area-chart", "fa-arrow-circle-down", "fa-arrow-circle-left", "fa-arrow-circle-o-down", "fa-arrow-circle-o-left", "fa-arrow-circle-o-right", "fa-arrow-circle-o-up", "fa-arrow-circle-right", "fa-arrow-circle-up", "fa-arrow-down", "fa-arrow-left", "fa-arrow-right", "fa-arrow-up", "fa-arrows", "fa-arrows-alt", "fa-arrows-h", "fa-arrows-v", "fa-asl-interpreting", "fa-assistive-listening-systems", "fa-asterisk", "fa-at", "fa-audio-description", "fa-automobile", "fa-backward", "fa-balance-scale", "fa-ban", "fa-bandcamp", "fa-bank", "fa-bar-chart", "fa-bar-chart-o", "fa-barcode", "fa-bars", "fa-bath", "fa-bathtub", "fa-battery", "fa-battery-0", "fa-battery-1", "fa-battery-2", "fa-battery-3", "fa-battery-4", "fa-battery-empty", "fa-battery-full", "fa-battery-half", "fa-battery-quarter", "fa-battery-three-quarters", "fa-bed", "fa-beer", "fa-behance", "fa-behance-square", "fa-bell", "fa-bell-o", "fa-bell-slash", "fa-bell-slash-o", "fa-bicycle", "fa-binoculars", "fa-birthday-cake", "fa-bitbucket", "fa-bitbucket-square", "fa-bitcoin", "fa-black-tie", "fa-blind", "fa-bluetooth", "fa-bluetooth-b", "fa-bold", "fa-bolt", "fa-bomb", "fa-book", "fa-bookmark", "fa-bookmark-o", "fa-braille", "fa-briefcase", "fa-btc", "fa-bug", "fa-building", "fa-building-o", "fa-bullhorn", "fa-bullseye", "fa-bus", "fa-buysellads", "fa-cab", "fa-calculator", "fa-calendar", "fa-calendar-check-o", "fa-calendar-minus-o", "fa-calendar-o", "fa-calendar-plus-o", "fa-calendar-times-o", "fa-camera", "fa-camera-retro", "fa-car", "fa-caret-down", "fa-caret-left", "fa-caret-right", "fa-caret-square-o-down", "fa-caret-square-o-left", "fa-caret-square-o-right", "fa-caret-square-o-up", "fa-caret-up", "fa-cart-arrow-down", "fa-cart-plus", "fa-cc", "fa-cc-amex", "fa-cc-diners-club", "fa-cc-discover", "fa-cc-jcb", "fa-cc-mastercard", "fa-cc-paypal", "fa-cc-stripe", "fa-cc-visa", "fa-certificate", "fa-chain", "fa-chain-broken", "fa-check", "fa-check-circle", "fa-check-circle-o", "fa-check-square", "fa-check-square-o", "fa-chevron-circle-down", "fa-chevron-circle-left", "fa-chevron-circle-right", "fa-chevron-circle-up", "fa-chevron-down", "fa-chevron-left", "fa-chevron-right", "fa-chevron-up", "fa-child", "fa-chrome", "fa-circle", "fa-circle-o", "fa-circle-o-notch", "fa-circle-thin", "fa-clipboard", "fa-clock-o", "fa-clone", "fa-close", "fa-cloud", "fa-cloud-download", "fa-cloud-upload", "fa-cny", "fa-code", "fa-code-fork", "fa-codepen", "fa-codiepie", "fa-coffee", "fa-cog", "fa-cogs", "fa-columns", "fa-comment", "fa-comment-o", "fa-commenting", "fa-commenting-o", "fa-comments", "fa-comments-o", "fa-compass", "fa-compress", "fa-connectdevelop", "fa-contao", "fa-copy", "fa-copyright", "fa-creative-commons", "fa-credit-card", "fa-credit-card-alt", "fa-crop", "fa-crosshairs", "fa-css3", "fa-cube", "fa-cubes", "fa-cut", "fa-cutlery", "fa-dashboard", "fa-dashcube", "fa-database", "fa-deaf", "fa-deafness", "fa-dedent", "fa-delicious", "fa-desktop", "fa-deviantart", "fa-diamond", "fa-digg", "fa-dollar", "fa-dot-circle-o", "fa-download", "fa-dribbble", "fa-drivers-license", "fa-drivers-license-o", "fa-dropbox", "fa-drupal", "fa-edge", "fa-edit", "fa-eercast", "fa-eject", "fa-ellipsis-h", "fa-ellipsis-v", "fa-empire", "fa-envelope", "fa-envelope-o", "fa-envelope-open", "fa-envelope-open-o", "fa-envelope-square", "fa-envira", "fa-eraser", "fa-etsy", "fa-eur", "fa-euro", "fa-exchange", "fa-exclamation", "fa-exclamation-circle", "fa-exclamation-triangle", "fa-expand", "fa-expeditedssl", "fa-external-link", "fa-external-link-square", "fa-eye", "fa-eye-slash", "fa-eyedropper", "fa-fa", "fa-facebook", "fa-facebook-official", "fa-facebook-square", "fa-fast-backward", "fa-fast-forward", "fa-fax", "fa-feed", "fa-female", "fa-fighter-jet", "fa-file", "fa-file-archive-o", "fa-file-audio-o", "fa-file-code-o", "fa-file-excel-o", "fa-file-image-o", "fa-file-movie-o", "fa-file-o", "fa-file-pdf-o", "fa-file-photo-o", "fa-file-picture-o", "fa-file-powerpoint-o", "fa-file-sound-o", "fa-file-text", "fa-file-text-o", "fa-file-video-o", "fa-file-word-o", "fa-file-zip-o", "fa-files-o", "fa-film", "fa-filter", "fa-fire", "fa-fire-extinguisher", "fa-firefox", "fa-first-order", "fa-flag", "fa-flag-checkered", "fa-flag-o", "fa-flash", "fa-flask", "fa-flickr", "fa-floppy-o", "fa-folder", "fa-folder-o", "fa-folder-open", "fa-folder-open-o", "fa-font", "fa-font-awesome", "fa-fonticons", "fa-fort-awesome", "fa-forumbee", "fa-forward", "fa-foursquare", "fa-free-code-camp", "fa-frown-o", "fa-futbol-o", "fa-gamepad", "fa-gavel", "fa-gbp", "fa-ge", "fa-gear", "fa-gears", "fa-genderless", "fa-get-pocket", "fa-gg", "fa-gg-circle", "fa-gift", "fa-git", "fa-git-square", "fa-github", "fa-github-alt", "fa-github-square", "fa-gitlab", "fa-gittip", "fa-glass", "fa-glide", "fa-glide-g", "fa-globe", "fa-google", "fa-google-plus", "fa-google-plus-square", "fa-google-wallet", "fa-graduation-cap", "fa-gratipay", "fa-grav", "fa-group", "fa-h-square", "fa-hacker-news", "fa-hand-grab-o", "fa-hand-lizard-o", "fa-hand-o-down", "fa-hand-o-left", "fa-hand-o-right", "fa-hand-o-up", "fa-hand-paper-o", "fa-hand-peace-o", "fa-hand-pointer-o", "fa-hand-rock-o", "fa-hand-scissors-o", "fa-hand-spock-o", "fa-hand-stop-o", "fa-handshake-o", "fa-hard-of-hearing", "fa-hashtag", "fa-hdd-o", "fa-header", "fa-headphones", "fa-heart", "fa-heart-o", "fa-heartbeat", "fa-history", "fa-home", "fa-hospital-o", "fa-hotel", "fa-hourglass", "fa-hourglass-1", "fa-hourglass-2", "fa-hourglass-3", "fa-hourglass-end", "fa-hourglass-half", "fa-hourglass-o", "fa-hourglass-start", "fa-houzz", "fa-html5", "fa-i-cursor", "fa-id-badge", "fa-id-card", "fa-id-card-o", "fa-ils", "fa-image", "fa-imdb", "fa-inbox", "fa-indent", "fa-industry", "fa-info", "fa-info-circle", "fa-inr", "fa-instagram", "fa-institution", "fa-internet-explorer", "fa-intersex", "fa-ioxhost", "fa-italic", "fa-joomla", "fa-jpy", "fa-jsfiddle", "fa-key", "fa-keyboard-o", "fa-krw", "fa-language", "fa-laptop", "fa-lastfm", "fa-lastfm-square", "fa-leaf", "fa-leanpub", "fa-legal", "fa-lemon-o", "fa-level-down", "fa-level-up", "fa-life-bouy", "fa-life-buoy", "fa-life-ring", "fa-life-saver", "fa-lightbulb-o", "fa-line-chart", "fa-link", "fa-linkedin", "fa-linkedin-square", "fa-linode", "fa-linux", "fa-list", "fa-list-alt", "fa-list-ol", "fa-list-ul", "fa-location-arrow", "fa-lock", "fa-long-arrow-down", "fa-long-arrow-left", "fa-long-arrow-right", "fa-long-arrow-up", "fa-low-vision", "fa-magic", "fa-magnet", "fa-mail-forward", "fa-mail-reply", "fa-mail-reply-all", "fa-male", "fa-map", "fa-map-marker", "fa-map-o", "fa-map-pin", "fa-map-signs", "fa-mars", "fa-mars-double", "fa-mars-stroke", "fa-mars-stroke-h", "fa-mars-stroke-v", "fa-maxcdn", "fa-meanpath", "fa-medium", "fa-medkit", "fa-meetup", "fa-meh-o", "fa-mercury", "fa-microchip", "fa-microphone", "fa-microphone-slash", "fa-minus", "fa-minus-circle", "fa-minus-square", "fa-minus-square-o", "fa-mixcloud", "fa-mobile", "fa-mobile-phone", "fa-modx", "fa-money", "fa-moon-o", "fa-mortar-board", "fa-motorcycle", "fa-mouse-pointer", "fa-music", "fa-navicon", "fa-neuter", "fa-newspaper-o", "fa-object-group", "fa-object-ungroup", "fa-odnoklassniki", "fa-odnoklassniki-square", "fa-opencart", "fa-openid", "fa-opera", "fa-optin-monster", "fa-outdent", "fa-pagelines", "fa-paint-brush", "fa-paper-plane", "fa-paper-plane-o", "fa-paperclip", "fa-paragraph", "fa-paste", "fa-pause", "fa-pause-circle", "fa-pause-circle-o", "fa-paw", "fa-paypal", "fa-pencil", "fa-pencil-square", "fa-pencil-square-o", "fa-percent", "fa-phone", "fa-phone-square", "fa-photo", "fa-picture-o", "fa-pie-chart", "fa-pied-piper", "fa-pied-piper-alt", "fa-pied-piper-pp", "fa-pinterest", "fa-pinterest-p", "fa-pinterest-square", "fa-plane", "fa-play", "fa-play-circle", "fa-play-circle-o", "fa-plug", "fa-plus", "fa-plus-circle", "fa-plus-square", "fa-plus-square-o", "fa-podcast", "fa-power-off", "fa-print", "fa-product-hunt", "fa-puzzle-piece", "fa-qq", "fa-qrcode", "fa-question", "fa-question-circle", "fa-question-circle-o", "fa-quora", "fa-quote-left", "fa-quote-right", "fa-ra", "fa-random", "fa-ravelry", "fa-rebel", "fa-recycle", "fa-reddit", "fa-reddit-alien", "fa-reddit-square", "fa-refresh", "fa-registered", "fa-remove", "fa-renren", "fa-reorder", "fa-repeat", "fa-reply", "fa-reply-all", "fa-resistance", "fa-retweet", "fa-rmb", "fa-road", "fa-rocket", "fa-rotate-left", "fa-rotate-right", "fa-rouble", "fa-rss", "fa-rss-square", "fa-rub", "fa-ruble", "fa-rupee", "fa-s15", "fa-safari", "fa-save", "fa-scissors", "fa-scribd", "fa-search", "fa-search-minus", "fa-search-plus", "fa-sellsy", "fa-send", "fa-send-o", "fa-server", "fa-share", "fa-share-alt", "fa-share-alt-square", "fa-share-square", "fa-share-square-o", "fa-shekel", "fa-sheqel", "fa-shield", "fa-ship", "fa-shirtsinbulk", "fa-shopping-bag", "fa-shopping-basket", "fa-shopping-cart", "fa-shower", "fa-sign-in", "fa-sign-language", "fa-sign-out", "fa-signal", "fa-signing", "fa-simplybuilt", "fa-sitemap", "fa-skyatlas", "fa-skype", "fa-slack", "fa-sliders", "fa-slideshare", "fa-smile-o", "fa-snapchat", "fa-snapchat-ghost", "fa-snapchat-square", "fa-snowflake-o", "fa-soccer-ball-o", "fa-sort", "fa-sort-alpha-asc", "fa-sort-alpha-desc", "fa-sort-amount-asc", "fa-sort-amount-desc", "fa-sort-asc", "fa-sort-desc", "fa-sort-down", "fa-sort-numeric-asc", "fa-sort-numeric-desc", "fa-sort-up", "fa-soundcloud", "fa-space-shuttle", "fa-spinner", "fa-spoon", "fa-spotify", "fa-square", "fa-square-o", "fa-stack-exchange", "fa-stack-overflow", "fa-star", "fa-star-half", "fa-star-half-empty", "fa-star-half-full", "fa-star-half-o", "fa-star-o", "fa-steam", "fa-steam-square", "fa-step-backward", "fa-step-forward", "fa-stethoscope", "fa-sticky-note", "fa-sticky-note-o", "fa-stop", "fa-stop-circle", "fa-stop-circle-o", "fa-street-view", "fa-strikethrough", "fa-stumbleupon", "fa-stumbleupon-circle", "fa-subscript", "fa-subway", "fa-suitcase", "fa-sun-o", "fa-superpowers", "fa-superscript", "fa-support", "fa-table", "fa-tablet", "fa-tachometer", "fa-tag", "fa-tags", "fa-tasks", "fa-taxi", "fa-telegram", "fa-television", "fa-tencent-weibo", "fa-terminal", "fa-text-height", "fa-text-width", "fa-th", "fa-th-large", "fa-th-list", "fa-themeisle", "fa-thermometer", "fa-thermometer-0", "fa-thermometer-1", "fa-thermometer-2", "fa-thermometer-3", "fa-thermometer-4", "fa-thermometer-empty", "fa-thermometer-full", "fa-thermometer-half", "fa-thermometer-quarter", "fa-thermometer-three-quarters", "fa-thumb-tack", "fa-thumbs-down", "fa-thumbs-o-down", "fa-thumbs-o-up", "fa-thumbs-up", "fa-ticket", "fa-times", "fa-times-circle", "fa-times-circle-o", "fa-times-rectangle", "fa-times-rectangle-o", "fa-tint", "fa-toggle-down", "fa-toggle-left", "fa-toggle-off", "fa-toggle-on", "fa-toggle-right", "fa-toggle-up", "fa-trademark", "fa-train", "fa-transgender", "fa-transgender-alt", "fa-trash", "fa-trash-o", "fa-tree", "fa-trello", "fa-tripadvisor", "fa-trophy", "fa-truck", "fa-try", "fa-tty", "fa-tumblr", "fa-tumblr-square", "fa-turkish-lira", "fa-tv", "fa-twitch", "fa-twitter", "fa-twitter-square", "fa-umbrella", "fa-underline", "fa-undo", "fa-universal-access", "fa-university", "fa-unlink", "fa-unlock", "fa-unlock-alt", "fa-unsorted", "fa-upload", "fa-usb", "fa-usd", "fa-user", "fa-user-circle", "fa-user-circle-o", "fa-user-md", "fa-user-o", "fa-user-plus", "fa-user-secret", "fa-user-times", "fa-users", "fa-vcard", "fa-vcard-o", "fa-venus", "fa-venus-double", "fa-venus-mars", "fa-viacoin", "fa-viadeo", "fa-viadeo-square", "fa-video-camera", "fa-vimeo", "fa-vimeo-square", "fa-vine", "fa-vk", "fa-volume-control-phone", "fa-volume-down", "fa-volume-off", "fa-volume-up", "fa-warning", "fa-wechat", "fa-weibo", "fa-weixin", "fa-whatsapp", "fa-wheelchair", "fa-wheelchair-alt", "fa-wifi", "fa-wikipedia-w", "fa-window-close", "fa-window-close-o", "fa-window-maximize", "fa-window-minimize", "fa-window-restore", "fa-windows", "fa-won", "fa-wordpress", "fa-wpbeginner", "fa-wpexplorer", "fa-wpforms", "fa-wrench", "fa-xing", "fa-xing-square", "fa-y-combinator", "fa-y-combinator-square", "fa-yahoo", "fa-yc", "fa-yc-square", "fa-yelp", "fa-yen", "fa-yoast", "fa-youtube", "fa-youtube-play", "fa-youtube-square", "fa-brands fa-debian", "fa-brands fa-steam-symbol", "fa-brands fa-pix", "fa-brands fa-korvue", "fa-brands fa-odnoklassniki-square", "fa-brands fa-zhihu", "fa-brands fa-intercom", "fa-brands fa-google-pay", "fa-brands fa-wodu", "fa-brands fa-git-square", "fa-brands fa-nutritionix", "fa-brands fa-wordpress-simple", "fa-brands fa-pushed", "fa-brands fa-teamspeak", "fa-brands fa-canadian-maple-leaf", "fa-brands fa-ember", "fa-brands fa-strava", "fa-brands fa-creative-commons-sampling-plus", "fa-brands fa-gulp", "fa-brands fa-buy-n-large", "fa-brands fa-wolf-pack-battalion", "fa-brands fa-airbnb", "fa-brands fa-mastodon", "fa-brands fa-joomla", "fa-brands fa-discourse", "fa-brands fa-sitrox", "fa-brands fa-critical-role", "fa-brands fa-viacoin", "fa-brands fa-pinterest-square", "fa-brands fa-flipboard", "fa-brands fa-mixcloud", "fa-brands fa-amilia", "fa-brands fa-medium", "fa-brands fa-reacteurope", "fa-brands fa-quora", "fa-brands fa-vaadin", "fa-brands fa-tumblr", "fa-brands fa-usb", "fa-brands fa-medrt", "fa-brands fa-slack", "fa-brands fa-edge-legacy", "fa-brands fa-node-js", "fa-brands fa-old-republic", "fa-brands fa-telegram", "fa-brands fa-stumbleupon-circle", "fa-brands fa-dribbble", "fa-brands fa-btc", "fa-brands fa-yammer", "fa-brands fa-npm", "fa-brands fa-buffer", "fa-brands fa-pinterest", "fa-brands fa-rockrms", "fa-brands fa-jenkins", "fa-brands fa-suse", "fa-brands fa-replyd", "fa-brands fa-behance-square", "fa-brands fa-firefox-browser", "fa-brands fa-skyatlas", "fa-brands fa-alipay", "fa-brands fa-php", "fa-brands fa-uber", "fa-brands fa-cc-amex", "fa-brands fa-yandex-international", "fa-brands fa-sketch", "fa-brands fa-dev", "fa-brands fa-git", "fa-brands fa-ideal", "fa-brands fa-js", "fa-brands fa-hornbill", "fa-brands fa-free-code-camp", "fa-brands fa-bots", "fa-brands fa-android", "fa-brands fa-python", "fa-brands fa-themeco", "fa-brands fa-black-tie", "fa-brands fa-leanpub", "fa-brands fa-connectdevelop", "fa-brands fa-weebly", "fa-brands fa-grunt", "fa-brands fa-perbyte", "fa-brands fa-get-pocket", "fa-brands fa-creative-commons-nc-jp", "fa-brands fa-trello", "fa-brands fa-goodreads-g", "fa-brands fa-cpanel", "fa-brands fa-deviantart", "fa-brands fa-kaggle", "fa-brands fa-staylinked", "fa-brands fa-supple", "fa-brands fa-pied-piper-square", "fa-brands fa-wix", "fa-brands fa-rust", "fa-brands fa-fantasy-flight-games", "fa-brands fa-snapchat", "fa-brands fa-cc-jcb", "fa-brands fa-waze", "fa-brands fa-fort-awesome", "fa-brands fa-apper", "fa-brands fa-pinterest-p", "fa-brands fa-ns8", "fa-brands fa-medapps", "fa-brands fa-octopus-deploy", "fa-brands fa-salesforce", "fa-brands fa-buromobelexperte", "fa-brands fa-wirsindhandwerk", "fa-brands fa-sass", "fa-brands fa-sellsy", "fa-brands fa-html5", "fa-brands fa-readme", "fa-brands fa-yandex", "fa-brands fa-kickstarter-k", "fa-brands fa-pied-piper-hat", "fa-brands fa-gg-circle", "fa-brands fa-cc-diners-club", "fa-brands fa-microblog", "fa-brands fa-d-and-d", "fa-brands fa-gitter", "fa-brands fa-bluetooth", "fa-brands fa-docker", "fa-brands fa-jira", "fa-brands fa-raspberry-pi", "fa-brands fa-deezer", "fa-brands fa-imdb", "fa-brands fa-bitbucket", "fa-brands fa-simplybuilt", "fa-brands fa-servicestack", "fa-brands fa-google-drive", "fa-brands fa-line", "fa-brands fa-viadeo", "fa-brands fa-google-play", "fa-brands fa-slideshare", "fa-brands fa-autoprefixer", "fa-brands fa-trade-federation", "fa-brands fa-earlybirds", "fa-brands fa-ussunnah", "fa-brands fa-phabricator", "fa-brands fa-fort-awesome-alt", "fa-brands fa-uikit", "fa-brands fa-jedi-order", "fa-brands fa-gripfire", "fa-brands fa-facebook", "fa-brands fa-cmplid", "fa-brands fa-dropbox", "fa-brands fa-cc-amazon-pay", "fa-brands fa-creative-commons-remix", "fa-brands fa-figma", "fa-brands fa-js-square", "fa-brands fa-uniregistry", "fa-brands fa-mendeley", "fa-brands fa-mixer", "fa-brands fa-ravelry", "fa-brands fa-twitch", "fa-brands fa-deploydog", "fa-brands fa-hubspot", "fa-brands fa-linkedin", "fa-brands fa-renren", "fa-brands fa-dribbble-square", "fa-brands fa-tiktok", "fa-brands fa-steam-square", "fa-brands fa-searchengin", "fa-brands fa-xbox", "fa-brands fa-resolving", "fa-brands fa-superpowers", "fa-brands fa-palfed", "fa-brands fa-creative-commons-nd", "fa-brands fa-elementor", "fa-brands fa-stack-exchange", "fa-brands fa-42-group", "fa-brands fa-cotton-bureau", "fa-brands fa-erlang", "fa-brands fa-bilibili", "fa-brands fa-think-peaks", "fa-brands fa-audible", "fa-brands fa-facebook-messenger", "fa-brands fa-etsy", "fa-brands fa-maxcdn", "fa-brands fa-symfony", "fa-brands fa-tencent-weibo", "fa-brands fa-digg", "fa-brands fa-viber", "fa-brands fa-flickr", "fa-brands fa-blogger", "fa-brands fa-cuttlefish", "fa-brands fa-itunes", "fa-brands fa-aviato", "fa-brands fa-fly", "fa-brands fa-optin-monster", "fa-brands fa-spotify", "fa-brands fa-magento", "fa-brands fa-megaport", "fa-brands fa-usps", "fa-brands fa-cloudversify", "fa-brands fa-wpforms", "fa-brands fa-bandcamp", "fa-brands fa-schlix", "fa-brands fa-mizuni", "fa-brands fa-forumbee", "fa-brands fa-cloudscale", "fa-brands fa-fulcrum", "fa-brands fa-periscope", "fa-brands fa-d-and-d-beyond", "fa-brands fa-osi", "fa-brands fa-first-order-alt", "fa-brands fa-mandalorian", "fa-brands fa-bimobject", "fa-brands fa-gofore", "fa-brands fa-ello", "fa-brands fa-avianex", "fa-brands fa-patreon", "fa-brands fa-creative-commons-nc-eu", "fa-brands fa-speaker-deck", "fa-brands fa-ethereum", "fa-brands fa-odnoklassniki", "fa-brands fa-bootstrap", "fa-brands fa-pied-piper-pp", "fa-brands fa-affiliatetheme", "fa-brands fa-dailymotion", "fa-brands fa-yahoo", "fa-brands fa-reddit-alien", "fa-brands fa-typo3", "fa-brands fa-gitlab", "fa-brands fa-paypal", "fa-brands fa-vine", "fa-brands fa-opencart", "fa-brands fa-blogger-b", "fa-brands fa-less", "fa-brands fa-quinscape", "fa-brands fa-playstation", "fa-brands fa-creative-commons-pd", "fa-brands fa-blackberry", "fa-brands fa-xing", "fa-brands fa-dhl", "fa-brands fa-gg", "fa-brands fa-houzz", "fa-brands fa-stripe", "fa-brands fa-draft2digital", "fa-brands fa-ubuntu", "fa-brands fa-galactic-senate", "fa-brands fa-umbraco", "fa-brands fa-itch-io", "fa-brands fa-opera", "fa-brands fa-keycdn", "fa-brands fa-bitcoin", "fa-brands fa-xing-square", "fa-brands fa-creative-commons-share", "fa-brands fa-squarespace", "fa-brands fa-cc-paypal", "fa-brands fa-react", "fa-brands fa-hashnode", "fa-brands fa-page4", "fa-brands fa-themeisle", "fa-brands fa-sith", "fa-brands fa-jsfiddle", "fa-brands fa-goodreads", "fa-brands fa-linode", "fa-brands fa-firefox", "fa-brands fa-product-hunt", "fa-brands fa-pied-piper", "fa-brands fa-studiovinari", "fa-brands fa-envira", "fa-brands fa-empire", "fa-brands fa-y-combinator", "fa-brands fa-angrycreative", "fa-brands fa-speakap", "fa-brands fa-angular", "fa-brands fa-swift", "fa-brands fa-researchgate", "fa-brands fa-hackerrank", "fa-brands fa-neos", "fa-brands fa-shopify", "fa-brands fa-phoenix-framework", "fa-brands fa-fedex", "fa-brands fa-stumbleupon", "fa-brands fa-instagram-square", "fa-brands fa-amazon-pay", "fa-brands fa-padlet", "fa-brands fa-apple-pay", "fa-brands fa-keybase", "fa-brands fa-gitkraken", "fa-brands fa-hive", "fa-brands fa-reddit-square", "fa-brands fa-gratipay", "fa-brands fa-font-awesome", "fa-brands fa-asymmetrik", "fa-brands fa-500px", "fa-brands fa-yarn", "fa-brands fa-unsplash", "fa-brands fa-amazon", "fa-brands fa-ebay", "fa-brands fa-accessible-icon", "fa-brands fa-dochub", "fa-brands fa-mdb", "fa-brands fa-confluence", "fa-brands fa-wpbeginner", "fa-brands fa-app-store-ios", "fa-brands fa-chrome", "fa-brands fa-discord", "fa-brands fa-reddit", "fa-brands fa-hips", "fa-brands fa-creative-commons-zero", "fa-brands fa-facebook-square", "fa-brands fa-sticker-mule", "fa-brands fa-bluetooth-b", "fa-brands fa-hotjar", "fa-brands fa-laravel", "fa-brands fa-stripe-s", "fa-brands fa-fedora", "fa-brands fa-joget", "fa-brands fa-whatsapp-square", "fa-brands fa-galactic-republic", "fa-brands fa-angellist", "fa-brands fa-wpressr", "fa-brands fa-square-js", "fa-brands fa-firstdraft", "fa-brands fa-uncharted", "fa-brands fa-weibo", "fa-brands fa-grav", "fa-brands fa-kickstarter", "fa-brands fa-golang", "fa-brands fa-itunes-note", "fa-brands fa-cc-mastercard", "fa-brands fa-app-store", "fa-brands fa-fonticons-fi", "fa-brands fa-ioxhost", "fa-brands fa-accusoft", "fa-brands fa-vuejs", "fa-brands fa-freebsd", "fa-brands fa-delicious", "fa-brands fa-r-project", "fa-brands fa-sellcast", "fa-brands fa-expeditedssl", "fa-brands fa-instalod", "fa-brands fa-openid", "fa-brands fa-scribd", "fa-brands fa-cc-apple-pay", "fa-brands fa-steam", "fa-brands fa-mix", "fa-brands fa-node", "fa-brands fa-tumblr-square", "fa-brands fa-codiepie", "fa-brands fa-cloudsmith", "fa-brands fa-adn", "fa-brands fa-centos", "fa-brands fa-wizards-of-the-coast", "fa-brands fa-rev", "fa-brands fa-lyft", "fa-brands fa-git-alt", "fa-brands fa-shirtsinbulk", "fa-brands fa-weixin", "fa-brands fa-fonticons", "fa-brands fa-watchman-monitoring", "fa-brands fa-creative-commons", "fa-brands fa-viadeo-square", "fa-brands fa-adversal", "fa-brands fa-creative-commons-sampling", "fa-brands fa-hacker-news", "fa-brands fa-evernote", "fa-brands fa-chromecast", "fa-brands fa-nimblr", "fa-brands fa-digital-ocean", "fa-brands fa-google-plus-square", "fa-brands fa-linkedin-in", "fa-brands fa-atlassian", "fa-brands fa-square-font-awesome-stroke", "fa-brands fa-google", "fa-brands fa-safari", "fa-brands fa-creative-commons-sa", "fa-brands fa-red-river", "fa-brands fa-algolia", "fa-brands fa-phoenix-squadron", "fa-brands fa-stack-overflow", "fa-brands fa-foursquare", "fa-brands fa-diaspora", "fa-brands fa-google-plus", "fa-brands fa-sourcetree", "fa-brands fa-markdown", "fa-brands fa-artstation", "fa-brands fa-google-plus-g", "fa-brands fa-napster", "fa-brands fa-edge", "fa-brands fa-hacker-news-square", "fa-brands fa-the-red-yeti", "fa-brands fa-battle-net", "fa-brands fa-sistrix", "fa-brands fa-lastfm-square", "fa-brands fa-deskpro", "fa-brands fa-square-font-awesome", "fa-brands fa-contao", "fa-brands fa-css3-alt", "fa-brands fa-snapchat-square", "fa-brands fa-mailchimp", "fa-brands fa-threads", "fa-brands fa-square-threads", "fa-brands fa-untappd", "fa-brands fa-vk", "fa-brands fa-rocketchat", "fa-brands fa-whmcs", "fa-brands fa-unity", "fa-brands fa-creative-commons-by", "fa-brands fa-hire-a-helper", "fa-brands fa-drupal", "fa-brands fa-centercode", "fa-brands fa-creative-commons-pd-alt", "fa-brands fa-invision", "fa-brands fa-java", "fa-brands fa-orcid", "fa-brands fa-qq", "fa-brands fa-microsoft", "fa-brands fa-vnv", "fa-brands fa-guilded", "fa-brands fa-modx", "fa-brands fa-first-order", "fa-brands fa-buysellads", "fa-brands fa-stackpath", "fa-brands fa-bity", "fa-brands fa-dyalog", "fa-brands fa-wpexplorer", "fa-brands fa-ups", "fa-brands fa-cloudflare", "fa-brands fa-yoast", "fa-brands fa-redhat", "fa-brands fa-aws", "fa-brands fa-creative-commons-nc", "fa-brands fa-shopware", "fa-brands fa-lastfm", "fa-brands fa-cc-visa", "fa-brands fa-hooli", "fa-brands fa-monero", "fa-brands fa-x-twitter", "fa-brands fa-square-x-twitter", "fa-brands fa-pixiv", "fa-brands fa-jxl", "fa-brands fa-brave", "fa-brands fa-opensuse", "fa-brands fa-square-kickstarter", "fa-brands fa-square-letterboxd", "fa-brands fa-shoelace", "fa-brands fa-google-scholar", "fa-brands fa-signal-messenger", "fa-brands fa-mintbit", "fa-brands fa-brave-reverse", "fa-brands fa-web-awesome", "fa-brands fa-letterboxd", "fa-brands fa-square-web-awesome-stroke", "fa-brands fa-upwork", "fa-brands fa-square-upwork", "fa-brands fa-square-web-awesome", "fa-brands fa-bluesky", "fa-brands fa-webflow", "fa-brands fa-dart-lang", "fa-brands fa-flutter", "fa-brands fa-css", "fa-brands fa-files-pinwheel", "fa-brands fa-square-bluesky"];

			$(".fi-code-input").on("click", function () {
				if (!$(".fi-darkwrapper").length) {
					let $input = $(this),
						$inputPreview = $input.next(),
						$legendPreview = $input.closest("fieldset").children("legend").find("[data-icon]"),
						dataIcon = $legendPreview.attr("data-icon");

					$("body").append('<div class="fi-darkwrapper"><div class="fi-wrapper"><div class="fi-picker"><input type="text" id="fi-search" class="fi-search" placeholder="' + searchIconLang + '"><ul class="fi-list"></ul></div><button class="fi-close">' + closeIconsLang + '</button></div></div>');

					icons.forEach(function (icon) {
						$(".fi-list").append('<li class="fi-item" title="' + icon + '"><i class="fa ' + icon + '" data-icode="' + icon + '"></i><span class="sr-only">' + icon + '</span></li>');
					});

					$("#fi-search").focus().on("keyup", function () {
						let filter = $(this).val(),
							i = 0;

						$(this).next().children().each(function () {
							if ($(this).text().search(new RegExp(filter, "i")) < 0) {
								$(this).fadeOut();
							} else {
								$(this).show();
								i++;
							}
						});
					});

					$(".fi-darkwrapper, .fi-close").on("click", function () {
						$(".fi-darkwrapper").remove();
					});

					$(".fi-picker").on("click", function (e) {
						e.stopPropagation();
					});

					$(".fi-item").on("click", function () {
						let iconCode = $(this).children().data("icode");

						$(this).addClass("fi-selected").siblings().removeClass("fi-selected");
						$input.val(iconCode);
						$inputPreview.attr("class", "fi-input-preview fa " + iconCode);
						$legendPreview.attr("data-icon", iconCode).removeClass(dataIcon).addClass(iconCode);
						dataIcon = iconCode;
					});
				}
			});
		};
	}(jQuery));

	$(function ($) {
		$.iconize();
	});
}

// Add new icon
function new_clone() {
	let $lastFieldset = $("#footericons_items").find("fieldset").last();

	$lastFieldset.clone()
		.find("legend").attr("title", "").end()
		.find(".fa-stack").attr("style", "--fi-color: #105289; --fi-bgcolor: transparent; --fi-bgcolor-hover: transparent;").end()
		.find(".fi-row-name-preview").text(defaultLegendLang).end()
		.find(".fi-icon").attr("class", "fi-icon fa fa-caret-right fa-stack-2x").end()
		.find(".fi-icon").attr("data-icon", "fa-caret-right").end()
		.find(".fi-input-preview").attr("class", "fi-input-preview fa fa-caret-right").end()
		.find(".fi-icon-bg").hide().end()
		.find("input:text, .fi-url-input").val("").end()
		.find(".required").prop("required", false).end()
		.find(".fi-input-color").val("transparent").unwrap().end()
		.find(".sp-colorize-container").remove().end()
		.find("[data-default-color]").val("#105289").end()
		.appendTo("#footericons_items");

	spectrumize();
	preview();
}

spectrumize();
preview();

$("#fi-clone-btn").on("click", function () {
	new_clone();
});
