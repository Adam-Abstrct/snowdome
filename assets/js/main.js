$(function(){

	var jsonResponse;
    var df;
    var dt;

	$.ajax({
		url: "../../app/Src/AjaxResponse.php",
		type: "POST",
		success: function(data) {

			jsonResponse = JSON.parse(data)

            df = jsonResponse.df;
            dt = jsonResponse.dt;
			
			outputChartData(jsonResponse.chart);
			outputC02Data(jsonResponse.C02);
			outputTreeData(jsonResponse.trees);
			outputHousesData(jsonResponse.houses);
			outputGreenData(jsonResponse.green);

		},
		error: function(data) {

		},
		complete: function() {
 		
		} 
	});


	function outputChartData(data)
	{
		$('.chart__main').highcharts({
		chart: {
			backgroundColor: '#f9f9f9'
		},	
        title: {
            text: 'Energy Output - 28.06.16 > 05.07.16',
            useHTML: true,
            style: {
            	'background-color': '#00afeb',
            	color: '#F0F0F0',
            	'font-size': '11px',
            	'padding': '5px',
            	'border-radius': '2px'
            },
            x: -20 //center
        },
        xAxis: {
            categories: []
        },
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value} KWh',
                style: {
                    color: '#00afeb'
                }
            },
            title: {
                text: 'Generation',
                align: 'high',
        		offset: 0,
        		rotation: 0,
        		y: -10,
                style: {
                    color: '#00afeb'

                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Consumption',
                align: 'high',
        		offset: 0,
        		rotation: 0,
        		y: -10,
                style: {
                    color: '#004a8d'

                }
            },
            labels: {
                format: '{value} KWh',
                style: {
                    color: '#004a8d'
                }
            },
            opposite: true
        }],
        tooltip: {
            valueSuffix: 'KWh'
        },
        legend: {
          	enabled: false
        },
       series: [{
            name: 'Generation',
            type: 'spline',
            yAxis: 0,
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
            tooltip: {
                valueSuffix: ' KWh'
            }

        }, {
            name: 'Consumption',
            type: 'spline',
            data: [45.1, 65.9, 45.5, 51.5, 47.2, 144.5, 75.2, 122.5, 100.3, 80.3, 44.9, 44.6],
            yAxis: 1,
            tooltip: {
                valueSuffix: ' KWh'
            }
        }]
        });

        var generated = data.generated;
        var chart = $('.chart__main').highcharts();
        var temp = new Array();
        var consumption = data.consumption;
        var temp2 = new Array();

        for (var i = 0; i < generated.length ; i++) { //loops 6 times
            temp.push(generated[i]);
        }
    
        for (var i = 0; i < consumption.length ; i++) { //loops 6 times
            temp2.push(consumption[i]);
        }

        chart.series[0].setData(temp);
        chart.series[1].setData(temp2);
        chart.xAxis[0].update({categories: data.legend });
        chart.setTitle({text: 'Energy Output- '+ df + ' > '+ dt})


	}
	

	function outputC02Data(data)
	{
	
		var $c02 = $('#cO2 p');
		$c02.html(data+' C\'s');

	}

	function outputTreeData(data)
	{
		var $tree = $('#trees p');
		$tree.html(data);
	}

	function outputHousesData(data)
	{
		var $houses = $('#houses p');
		$houses.html(data);
	}

	function outputGreenData(data)
	{
		var $green = $('#green');
		$green.html(data+' MWh');
	}

})
$(function(){

	$('.module').matchHeight();


});
$(function(){

	sizeGraph();


	$( window , document ).resize(function(){
		console.log('resized');
		sizeGraph();

	});


	function sizeGraph()
	{
		var documentHeight = $('body').height();
		var chart = $('.chart__main');
		var footer = $('footer').height();
		var header = $('header').height();
		var moduleHeight = $('.module__co2').height();
		var totalElements = header + footer + moduleHeight;
		var chartHeight = documentHeight - totalElements

		chart.css('min-height' , chartHeight+'px');
	}

	

});
$(function(){

	var tip = $('.tips__container').children();
	var index = 0;
	tipFunction()


	function tipFunction(){
		tip.filter('.active').fadeOut(500).removeClass('active');
		tip.eq(index).fadeIn(500).addClass('active');
		index = (index + 1) % tip.length;
		setTimeout(tipFunction, 8000);
	}



});
/**
* jquery-match-height master by @liabru
* http://brm.io/jquery-match-height/
* License: MIT
*/

;(function(factory) { // eslint-disable-line no-extra-semi
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof module !== 'undefined' && module.exports) {
        // CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Global
        factory(jQuery);
    }
})(function($) {
    /*
    *  internal
    */

    var _previousResizeWidth = -1,
        _updateTimeout = -1;

    /*
    *  _parse
    *  value parse utility function
    */

    var _parse = function(value) {
        // parse value and convert NaN to 0
        return parseFloat(value) || 0;
    };

    /*
    *  _rows
    *  utility function returns array of jQuery selections representing each row
    *  (as displayed after float wrapping applied by browser)
    */

    var _rows = function(elements) {
        var tolerance = 1,
            $elements = $(elements),
            lastTop = null,
            rows = [];

        // group elements by their top position
        $elements.each(function(){
            var $that = $(this),
                top = $that.offset().top - _parse($that.css('margin-top')),
                lastRow = rows.length > 0 ? rows[rows.length - 1] : null;

            if (lastRow === null) {
                // first item on the row, so just push it
                rows.push($that);
            } else {
                // if the row top is the same, add to the row group
                if (Math.floor(Math.abs(lastTop - top)) <= tolerance) {
                    rows[rows.length - 1] = lastRow.add($that);
                } else {
                    // otherwise start a new row group
                    rows.push($that);
                }
            }

            // keep track of the last row top
            lastTop = top;
        });

        return rows;
    };

    /*
    *  _parseOptions
    *  handle plugin options
    */

    var _parseOptions = function(options) {
        var opts = {
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        };

        if (typeof options === 'object') {
            return $.extend(opts, options);
        }

        if (typeof options === 'boolean') {
            opts.byRow = options;
        } else if (options === 'remove') {
            opts.remove = true;
        }

        return opts;
    };

    /*
    *  matchHeight
    *  plugin definition
    */

    var matchHeight = $.fn.matchHeight = function(options) {
        var opts = _parseOptions(options);

        // handle remove
        if (opts.remove) {
            var that = this;

            // remove fixed height from all selected elements
            this.css(opts.property, '');

            // remove selected elements from all groups
            $.each(matchHeight._groups, function(key, group) {
                group.elements = group.elements.not(that);
            });

            // TODO: cleanup empty groups

            return this;
        }

        if (this.length <= 1 && !opts.target) {
            return this;
        }

        // keep track of this group so we can re-apply later on load and resize events
        matchHeight._groups.push({
            elements: this,
            options: opts
        });

        // match each element's height to the tallest element in the selection
        matchHeight._apply(this, opts);

        return this;
    };

    /*
    *  plugin global options
    */

    matchHeight.version = 'master';
    matchHeight._groups = [];
    matchHeight._throttle = 80;
    matchHeight._maintainScroll = false;
    matchHeight._beforeUpdate = null;
    matchHeight._afterUpdate = null;
    matchHeight._rows = _rows;
    matchHeight._parse = _parse;
    matchHeight._parseOptions = _parseOptions;

    /*
    *  matchHeight._apply
    *  apply matchHeight to given elements
    */

    matchHeight._apply = function(elements, options) {
        var opts = _parseOptions(options),
            $elements = $(elements),
            rows = [$elements];

        // take note of scroll position
        var scrollTop = $(window).scrollTop(),
            htmlHeight = $('html').outerHeight(true);

        // get hidden parents
        var $hiddenParents = $elements.parents().filter(':hidden');

        // cache the original inline style
        $hiddenParents.each(function() {
            var $that = $(this);
            $that.data('style-cache', $that.attr('style'));
        });

        // temporarily must force hidden parents visible
        $hiddenParents.css('display', 'block');

        // get rows if using byRow, otherwise assume one row
        if (opts.byRow && !opts.target) {

            // must first force an arbitrary equal height so floating elements break evenly
            $elements.each(function() {
                var $that = $(this),
                    display = $that.css('display');

                // temporarily force a usable display value
                if (display !== 'inline-block' && display !== 'flex' && display !== 'inline-flex') {
                    display = 'block';
                }

                // cache the original inline style
                $that.data('style-cache', $that.attr('style'));

                $that.css({
                    'display': display,
                    'padding-top': '0',
                    'padding-bottom': '0',
                    'margin-top': '0',
                    'margin-bottom': '0',
                    'border-top-width': '0',
                    'border-bottom-width': '0',
                    'height': '100px',
                    'overflow': 'hidden'
                });
            });

            // get the array of rows (based on element top position)
            rows = _rows($elements);

            // revert original inline styles
            $elements.each(function() {
                var $that = $(this);
                $that.attr('style', $that.data('style-cache') || '');
            });
        }

        $.each(rows, function(key, row) {
            var $row = $(row),
                targetHeight = 0;

            if (!opts.target) {
                // skip apply to rows with only one item
                if (opts.byRow && $row.length <= 1) {
                    $row.css(opts.property, '');
                    return;
                }

                // iterate the row and find the max height
                $row.each(function(){
                    var $that = $(this),
                        style = $that.attr('style'),
                        display = $that.css('display');

                    // temporarily force a usable display value
                    if (display !== 'inline-block' && display !== 'flex' && display !== 'inline-flex') {
                        display = 'block';
                    }

                    // ensure we get the correct actual height (and not a previously set height value)
                    var css = { 'display': display };
                    css[opts.property] = '';
                    $that.css(css);

                    // find the max height (including padding, but not margin)
                    if ($that.outerHeight(false) > targetHeight) {
                        targetHeight = $that.outerHeight(false);
                    }

                    // revert styles
                    if (style) {
                        $that.attr('style', style);
                    } else {
                        $that.css('display', '');
                    }
                });
            } else {
                // if target set, use the height of the target element
                targetHeight = opts.target.outerHeight(false);
            }

            // iterate the row and apply the height to all elements
            $row.each(function(){
                var $that = $(this),
                    verticalPadding = 0;

                // don't apply to a target
                if (opts.target && $that.is(opts.target)) {
                    return;
                }

                // handle padding and border correctly (required when not using border-box)
                if ($that.css('box-sizing') !== 'border-box') {
                    verticalPadding += _parse($that.css('border-top-width')) + _parse($that.css('border-bottom-width'));
                    verticalPadding += _parse($that.css('padding-top')) + _parse($that.css('padding-bottom'));
                }

                // set the height (accounting for padding and border)
                $that.css(opts.property, (targetHeight - verticalPadding) + 'px');
            });
        });

        // revert hidden parents
        $hiddenParents.each(function() {
            var $that = $(this);
            $that.attr('style', $that.data('style-cache') || null);
        });

        // restore scroll position if enabled
        if (matchHeight._maintainScroll) {
            $(window).scrollTop((scrollTop / htmlHeight) * $('html').outerHeight(true));
        }

        return this;
    };

    /*
    *  matchHeight._applyDataApi
    *  applies matchHeight to all elements with a data-match-height attribute
    */

    matchHeight._applyDataApi = function() {
        var groups = {};

        // generate groups by their groupId set by elements using data-match-height
        $('[data-match-height], [data-mh]').each(function() {
            var $this = $(this),
                groupId = $this.attr('data-mh') || $this.attr('data-match-height');

            if (groupId in groups) {
                groups[groupId] = groups[groupId].add($this);
            } else {
                groups[groupId] = $this;
            }
        });

        // apply matchHeight to each group
        $.each(groups, function() {
            this.matchHeight(true);
        });
    };

    /*
    *  matchHeight._update
    *  updates matchHeight on all current groups with their correct options
    */

    var _update = function(event) {
        if (matchHeight._beforeUpdate) {
            matchHeight._beforeUpdate(event, matchHeight._groups);
        }

        $.each(matchHeight._groups, function() {
            matchHeight._apply(this.elements, this.options);
        });

        if (matchHeight._afterUpdate) {
            matchHeight._afterUpdate(event, matchHeight._groups);
        }
    };

    matchHeight._update = function(throttle, event) {
        // prevent update if fired from a resize event
        // where the viewport width hasn't actually changed
        // fixes an event looping bug in IE8
        if (event && event.type === 'resize') {
            var windowWidth = $(window).width();
            if (windowWidth === _previousResizeWidth) {
                return;
            }
            _previousResizeWidth = windowWidth;
        }

        // throttle updates
        if (!throttle) {
            _update(event);
        } else if (_updateTimeout === -1) {
            _updateTimeout = setTimeout(function() {
                _update(event);
                _updateTimeout = -1;
            }, matchHeight._throttle);
        }
    };

    /*
    *  bind events
    */

    // apply on DOM ready event
    $(matchHeight._applyDataApi);

    // update heights on load and resize events
    $(window).bind('load', function(event) {
        matchHeight._update(false, event);
    });

    // throttled update heights on resize events
    $(window).bind('resize orientationchange', function(event) {
        matchHeight._update(true, event);
    });

});
