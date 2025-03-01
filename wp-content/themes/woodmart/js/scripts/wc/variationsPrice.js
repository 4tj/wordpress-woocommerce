/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdQuickViewOpen', function () {
		woodmartThemeModule.variationsPrice();
	});

	$.each([
		'frontend/element_ready/wd_single_product_add_to_cart.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.variationsPrice();
		});
	});

	woodmartThemeModule.variationsPrice = function() {
		if ('no' === woodmart_settings.single_product_variations_price) {
			return;
		}

		$('.variations_form').each(function() {
			var $form = $(this);
			var $price = $form.parent().find('> .price, > div > .price, > .price > .price');
			var isQuickView = $form.parents('.product-quick-view').length;

			if ( $('.wd-content-layout').hasClass('wd-builder-on') && ! isQuickView ) {
				$price = $form.parents('.single-product-page').find('.wd-single-price .price');
			}

			var priceOriginalHtml = $price.html();

			$form.on('show_variation', function(e, variation) {
				if (variation.price_html.length > 1) {
					$price.html(variation.price_html);
				}
			});

			$form.on('click', '.reset_variations', function() {
				$price.html(priceOriginalHtml);
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.variationsPrice();
	});
})(jQuery);
