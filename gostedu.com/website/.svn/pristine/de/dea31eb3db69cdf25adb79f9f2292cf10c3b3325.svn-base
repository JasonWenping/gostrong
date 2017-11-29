/**
 * 实用工具
 * 
 */

;(function(window, $, undefined){
	
	// console object port for ie
	window.console = window.console || {
		log: function(){},
		debug: function(){},
		info: function(){},
		warn: function(){},
		error: function(){},
		assert: function(truth,message){},
		dir: function(object){},
		dirxml: function(node){},
		group: function(){},
		groupEnd: function(){},
		time: function(name){},
		timeEnd: function(name){},
		count: function(){},
		trace: function(){},
		profile: function(){},
		profileEnd: function(){},
		clear: function(){},
		open: function(){},
		close: function(){},
		evaled_lines: [],
		evaled_lines_pointer: 0
	};
	
	$.extend($.fn,{
		/**
		 * 属性是否定义
		 * @param name
		 * @returns {Boolean}
		 */
		hasAttr:function(name) {
			return typeof $(this).attr(name) !== 'undefined';
		},
		
		/**
		 * 对象是否隐藏
		 * @returns {Boolean}
		 */
		isHidden: function() {
			return $(this).is(':hidden')
					|| $(this).css('display') == 'none';
		},
		
		/**
		 * 将对象设为禁用
		 */
		disable: function() {
			return $(this).attr('disabled','disabled').addClass('disabled');
		},
		
		/**
		 * 当前是否禁用
		 */
		isDisabled: function() {
			return $(this).hasAttr('disabled') || $(this).hasClass('disabled');
		},
		
		/**
		 * 将对象设为可用
		 */
		enable: function() {
			return $(this).remoteAttr('disable').removeClass('disabled');
		}
	
	});
})(window, jQuery);

if (typeof(Array.prototype.indexOf) === 'undefined'){
	Array.prototype.indexOf = function(elt){
		var len = this.length;
		var from = Number(arguments[1]) || 0;
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);
		if (from < 0)
			from += len;
		for (; from < len; from++){
			if (from in this && this[from] === elt){
				return from;
			}	
		}
		return -1;
	};
}

if (typeof(String.prototype.trim)  == "undefined"){
    String.prototype.trim = function () {
      return this.replace(/^\s*(\S*(\s+\S+)*)\s*$/, "$1");
    };
}