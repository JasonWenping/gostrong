/**
 * 网站用JS
 * 
 */

;(function(window, $, undefined){
	$.GosteduSite = function() {
		this._isInited = false;
	};
	
	$.GosteduSite.prototype = {
			/// start
			
			
			/// end
			init: function(core) {
				this.core = core;
				this._isInited = true;
			},
			isInited: function() {
				return this._isInited;
			}
	};
	
	$.extend($.Gostedu.plugins, { site: new $.GosteduSite() });
})(window, jQuery);