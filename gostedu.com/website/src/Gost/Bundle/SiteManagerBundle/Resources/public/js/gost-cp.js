/**
 * 后台管理
 * 
 */

;(function(window, $, undefined){
	$.GosteduCP = function() {
		this._isInited = false;
	};
	
	$.GosteduCP.prototype = {
			/// start

			/**
			 * 主导航
			 */
			leftmenu: function(dispatcher, args) {
				$(dispatcher).find('.menu-group').each(function(i){
					var $submenu = $(this).find('.menu-func').toggle();
					$(this).find('.header').click(function(e){
						$submenu.toggle();
						e.preventDefault();
					});
				});
			},

			/**
			 * 表单对话框
			 */
			form_dialog: function(dispatcher, args) {
				var $dispatcher = $(dispatcher), instance = this, notify = null, options = $.extend({
	                width : 450,// height: 500,
					url: $dispatcher.attr('href'),
					close: function(event, ui) {
						$(this).dialog('destroy');
						if (args.refresh && args.srcurl) {
							instance.core.ajax(args.srcurl, {}, {
								type: 'GET', dataType: 'html', success: function(html) {
									try {
										var $html = $(html),
											$content = $html.is(args.refresh) ? $html : $html.find(args.refresh);
										$(args.refresh).replaceWith($content).remove();
										instance.core.reload($content);
									} catch (ex) {
										console.log(ex);
									}
									instance.core.plugins['ui'].close_notify(notify);
								}, error: function(xhr, status, error) {
									instance.core.plugins['ui'].close_notify(notify);
								}, beforeSend: function(xhr, settings){
									notify = instance.core.plugins['ui'].notify({text: '稍候片刻...'});
								}
							});
						}
					}
				}, args);
				this.core.plugins['ui'].modal_dialog(dispatcher, options);
			},

			/**
			 * 异步操作
			 */
			call_action: function(dispatcher, args) {
				var instance = this, $dispatcher = $(dispatcher), notify = null, action = '';
				
				if (args.action)
					action = args.action;
				else if ($dispatcher.is('a'))
					action = $dispatcher.attr('href');
				
				$dispatcher.click(function(e){
					if (args.confirm) {
						if (!confirm(args.confirm))
							return false;
					}
					instance.core.ajax(action, {}, {
						type: 'POST', dataType: 'json', success: function(resp, status, xhr) {
							if (resp.error) {
								instance.core.plugins['ui'].close_notify(notify);
								instance.core.plugins['ui'].notify({text: resp.message, type: 'error', timeout: 3000});
							} else {
								if (args.close_dialog) {
									instance.core.plugins['ui'].close_dialog(dispatcher, {});	
								}
								instance.core.plugins['ui'].close_notify(notify);
							}
							if (args.refresh && args.srcurl) {
								instance.core.ajax(args.srcurl, {}, {
									type: 'GET', dataType: 'html', success: function(html) {
										try {
											var $html = $(html),
												$content = $html.is(args.refresh) ? $html : $html.find(args.refresh);
											$(args.refresh).replaceWith($content).remove();
											instance.core.reload($content);
										} catch (ex) {
											console.log(ex);
										}
										instance.core.plugins['ui'].close_notify(notify);
									}, error: function(xhr, status, error) {
										instance.core.plugins['ui'].close_notify(notify);
									}, beforeSend: function(xhr, settings){
										notify = instance.core.plugins['ui'].notify({text: '稍候片刻...'});
									}
								});
							}
						}, error: function(xhr, status, error) {
							instance.core.plugins['ui'].close_notify(notify);
						}, beforeSend: function(xhr, settings){
							notify = instance.core.plugins['ui'].notify({text: '操作中, 请稍候...'});
						}
					});
					e.preventDefault();
				});
			},
			
			/**
			 * 动态增删表格行。
			 * 
			 * @param dispatcher
			 * @param args
			 */
			dynamic_table : function(dispatcher, args){
				var instance = this, $dispatcher = $(dispatcher), notify = null;
				$dispatcher.click(function(e){
					if('add' == args.action){
						$dispatcher.replaceWith($('<input type="button" class="gostedu-api" value="删除" gostedu-api="{api:' + "'cp.dynamic_table',args:{table:'" + args.table + "',action:'delete'}}" + '"/>'));
						var table = $(args.table);
						var row = $('<tr>');
						var td1 = $('<td align="center">');
						td1.append($('<input name="para_name[]" type="text" />'));
						row.append(td1);
						var td2 = $('<td align="left">');
						td2.append($('<input name="para_value[]" type="text"/>'));
						row.append(td2);
						var td3 = $('<td align="right">');
						td3.append($('<input type="button" value="新增" class="gostedu-api" gostedu-api="{api:' + "'cp.dynamic_table',args:{table:'" + args.table + "',action:'add'}}" + '"/>'));
						row.append(td3);
						table.append(row);
					}
					if('delete' == args.action){
						$dispatcher.parent().parent().remove();
					}
					instance.core.reload(table);
				});
			},
			
			/// end
			init: function(core) {
				this.core = core;
				this._isInited = true;
			},
			isInited: function() {
				return this._isInited;
			}
	};
	
	$.extend($.Gostedu.plugins, { cp: new $.GosteduCP() });
})(window, jQuery);