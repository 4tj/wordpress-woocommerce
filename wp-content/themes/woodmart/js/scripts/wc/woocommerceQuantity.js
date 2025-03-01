/* global woodmart_settings */
(function($) {
	woodmartThemeModule.woocommerceQuantity = function() {
		if (!String.prototype.getDecimals) {
			Object.defineProperty(String.prototype, 'getDecimals', {
				value: function() {
					var num = this,
						match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);

					if (!match) {
						return 0;
					}

					return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
				},
				enumerable: false
			});
		}

		woodmartThemeModule.$document.on('click', '.plus, .minus', function() {
			var $this      = $(this),
			    $qty       = $this.closest('.quantity').find('.qty'),
			    currentVal = parseFloat($qty.val()),
			    max        = parseFloat($qty.attr('max')),
			    min        = parseFloat($qty.attr('min')),
			    step       = $qty.attr('step');

			if (!currentVal || currentVal === '' || currentVal === 'NaN') {
				currentVal = 0;
			}
			if (max === '' || max === 'NaN') {
				max = '';
			}
			if (min === '' || min === 'NaN') {
				min = 0;
			}
			if (step === 'any' || step === '' || step === undefined || parseFloat(step) == 'NaN') {
				step = '1';
			}

			if ($this.is('.plus')) {
				if (max && ((currentVal + parseFloat(step)).toFixed(step.getDecimals()) >= max)) {
					$qty.val(max);
				} else {
					$qty.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
				}
			} else {
				if (min && ((currentVal - parseFloat(step)).toFixed(step.getDecimals()) <= min)) {
					$qty.val(min);
				} else if (currentVal > 0) {
					$qty.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
				}
			}

			$qty.trigger('change');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.woocommerceQuantity();
	});
})(jQuery);
