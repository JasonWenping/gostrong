/**
 * JS框架
 * 
 */

;(function(window, $, undefined){
	
	/**
	 * 构造函数
	 * 
	 * @param object options
	 * @param object element
	 * @returns {$.Gostedu}
	 */
	$.Gostedu = function(options, element) {
		this.element = element;
		this._create(options);
		this._init();
	};
	
	/**
	 * 默认设置
	 */
	$.Gostedu.settings = {selector:'.gostedu-api'};
	
	/**
	 * 插件
	 */
	$.Gostedu.plugins = {};
	
	/**
	 * 接口定义
	 */
	$.Gostedu.prototype = {
			
			/// common api start
			
			/**
			 * AJAX请求
			 */
			ajax: function(url, data, options) {
				data = $.extend({
					__timestamp: (new Date()).getTime(),
					__requestmode: 'ajax'
				}, data);
				options = $.extend({
					cache: false,
					type: 'GET',
					dataType: 'html',
					url: url,
					data: data
				}, options);
				return $.ajax(options);
			},
			
			/**
			 * 页面嵌入检查
			 */
			nonembed: function() {
				window.location.href = window.location.href;
			},
			
			/// common api end
			
			/// base api
			reload: function(elements) {
				return this._loaditems(elements);
			},
			
			option: function(key, value) {
				if ($.isPlainObject(key))
					this.options = $.extend(true, this.options, key);
				else if (key && typeof value === 'undefined')
					return this.options[key];
				else
					this.options[key] = value;
				return this;
			},
			
			_create: function(options) {
				this.options = $.extend(true, {}, $.Gostedu.settings, options);
				var instance = this, 
					instance_id = $(this.element).attr('id'),
					instance_key = 'gostedu' + this.options.selector.replace(/([^\w\d])/ig, '_');
				if ($.data(window, instance_key) == undefined) {
					$.data(window, instance_key, instance_id);
				} else { // 页面重载
					this.nonembed();
				}
				this.plugins = $.extend(true, {}, $.Gostedu.plugins);
				$.each(this.plugins, function(){ if (!this.isInited()) this.init(instance); });
			},
			
			_init: function(callback) {
				this.$items = this._loaditems(this.element);
				if (callback) callback.call(this);
			},
			
			_loaditems: function(elements) {
				var instance = this,
					$items = $(elements).find(instance.options.selector);
				$items.each(function(){
					try {
						var dispatcher = this,
							$dispatcher = $(dispatcher),
							meta = $dispatcher.hasAttr('data-gostedu-api')
										? $dispatcher.attr('data-gostedu-api')
										: $dispatcher.attr('gostedu-api'),
							cmds = meta ? eval('([' + meta.replace(/[\r\n]/, '') + '])') : null;
						if (cmds && !$dispatcher.data('gostedu_api_bounded')) {
							$.each(cmds, function(){
								try {
									if ($.isFunction(instance[this.api]))
										instance[this.api].apply(instance, [dispatcher, this.args ? this.args : {}]);
									else
										instance._exec(this.api, this.args ? this.args : {}, dispatcher);
								} catch (ex) {
									console.log(ex);
								}
							});
							$dispatcher.data('gostedu_api_bounded', true);
						}
					} catch (e) {
						console.error('can not parse the api annotation.');
						console.log(e);
						console.log(this);
					}
				});
				return $items;
			},
			
			_exec: function(api, args, dispatcher) {
				api = api.split(/[\.]/i);
				var plugin = this.plugins[api[0]],
					func = plugin[api[1]];
				
				if (($.type(plugin) !== 'undefined')
						&& !($.isPlainObject(plugin))) {
					try {
						if ($.isFunction(func))
							func.apply(plugin, [dispatcher, args]);
					} catch (e) {
						console.error('can not execute api: ' + api);
						console.log(e);
					}
				}
			}
			
			/// base api end
			
	};
	
	/**
	 * 入口方法
	 * 
	 * @param mixed options
	 */
	$.fn.extend({
		gostedu: function(options) {
			if (typeof options === 'string') {
				var args = Array.prototype.slice.call(arguments, 1);
				this.each(function(){
					var instance = $.data(this, 'gostedu');
					if (!instance) {
						console.error('can not initialize gostedu api: ' + options);
						return;
					}
					if (!$.isFunction(instance[options])
							|| options.charAt(0) === '_') {
						console.error('the api does not exists: ' + options);
						return;
					}
					instance[options].apply(instance, args);
				});
			} else {
				this.each(function(){
					var instance = $.data(this, 'gostedu');
					if (instance) {
						instance.option(options || {});
					} else {
						try {
							$.data(this, 'gostedu', new $.Gostedu(options, this));
						} catch(e) {
							console.log(e);
						}
					}
				});
			}
		}
	});
	
})(window, jQuery);