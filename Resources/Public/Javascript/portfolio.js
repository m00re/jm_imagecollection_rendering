(function ( $ ) {

    $.fn.portfolioize = function(options) {

        var settings = $.extend({
            containerOuter: '.csc-textpic-center-outer',
            containerInner: '.csc-textpic-center-inner',
			itemContainer: '.csc-textpic-imagerow'
        }, options);

        return this.each(function() {

			// Store reference to elements in local variables for easier access
			var node = $(this);
			var outer = node.find(settings.containerOuter);
			var inner = node.find(settings.containerInner);
			var items = node.find(settings.itemContainer);

			// Calculate cumulative width of all images
			var cumulativeWidth = 0;
			for (var i = 0; i < items.length; i++) {
				var item = $(items[i]);
				var paddingLeft = parseInt(item.css('padding-left'), 10);
				var paddingRight = parseInt(item.css('padding-right'), 10);
				var marginLeft = parseInt(item.css('margin-left'), 10);
				var marginRight = parseInt(item.css('margin-right'), 10);
				cumulativeWidth += item.width() + paddingLeft + paddingRight + marginLeft + marginRight;
			}

			// Setting width of inner and outer container
			inner.width(cumulativeWidth + 2);

			// Add left arrow...
			var leftArrow = $(document.createElement('div'));
			leftArrow.append($(document.createElement('i')).addClass('glyphicon glyphicon-chevron-left'));
			leftArrow.addClass('jm-portfolio-arrow jm-portfolio-arrow-left');
			leftArrow.click(function() {
				var cW = 0 - inner.width();
				var current = parseInt(inner.css('left'), 10);
				for (var i = (items.length - 1); i >= 0 && cW < 0; i--) {
					var item = $(items[i]);
					var paddingLeft = parseInt(item.css('padding-left'), 10);
					var paddingRight = parseInt(item.css('padding-right'), 10);
					var marginLeft = parseInt(item.css('margin-left'), 10);
					var marginRight = parseInt(item.css('margin-right'), 10);
					cW += item.width() + paddingLeft + paddingRight + marginLeft + marginRight;
					if (cW > current) {
						inner.css('left', cW + 'px');
						return;
					}
				}
			});
			outer.prepend(leftArrow);

			// ...and right arrow for easy navigation through the slider
			var rightArrow = $(document.createElement('div'));
			rightArrow.append($(document.createElement('i')).addClass('glyphicon glyphicon-chevron-right'));
			rightArrow.addClass('jm-portfolio-arrow jm-portfolio-arrow-right');
			rightArrow.click(function() {
				var cW = 0;
				var maxLeft = outer.width() - inner.width();
				var current = parseInt(inner.css('left'), 10);
				for (var i = 0; i < items.length && cW > maxLeft; i++) {
					var item = $(items[i]);
					var paddingLeft = parseInt(item.css('padding-left'), 10);
					var paddingRight = parseInt(item.css('padding-right'), 10);
					var marginLeft = parseInt(item.css('margin-left'), 10);
					var marginRight = parseInt(item.css('margin-right'), 10);
					cW -= (item.width() + paddingLeft + paddingRight + marginLeft + marginRight);
					if (cW < current) {
						var target = (cW < maxLeft) ? maxLeft : cW;
						inner.css('left', target + 'px');
						return;
					}
				}
			});
			outer.append(rightArrow);
		});
    };

	$('.csc-textpic-imagewrap').portfolioize();

}( jQuery ));