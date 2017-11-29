/**
 * 用户界面
 * 
 */

;(function(window, $, undefined){
	$.GosteduUI = function() {
		this._isInited = false;
	};
	
	$.GosteduUI.prototype = {
			/// start

			/**
			 * 异步重载
			 */
			ajax_reload: function(dispatcher, args) {
				var instance = this,
					$dispatcher = $(dispatcher),
					srcurl = args.srcurl;
				
				$dispatcher.click(function(e){
					if (args.holder && args.srcurl) {
						instance.core.ajax(args.srcurl, {}, {
							type: 'GET', dataType: 'html', success: function(html) {
								try {
									var $html = $(html),
										$content = $html.is(args.holder) ? $html : $html.find(args.holder);
									$(args.holder).replaceWith($content).remove();
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
					e.preventDefault();
				});
			},

			/**
			 * AJAX表单
			 * 
			 * @param dispatcher
			 * @param args
			 */
			ajax_form: function(dispatcher, args) {
				var $form = $(dispatcher),
					$holder = args.holder ? $(args.holder) : $form.parent(),
					instance = this,
					form_selector = args.form ? args.form 
							: ($form.attr('name') ? 'form[name="' + $form.attr('name') + '"]'
									: ($form.attr('id') ? '#' + $form.attr('id') : 'form')),
					n = null;
				$form.ajaxForm({
					dataType: args.datatype ? args.datatype: 'html',
					beforeSubmit: function(data, form) {
						if ($form.validationEngine('validate')) {
							n = instance.notify({text: '操作中, 请稍候...'});
						} else {
							return false;
						}
					},
					success: function(html) {
						instance.close_notify(n);
						var $new_form = $(html).find(form_selector);
						$form.replaceWith($new_form).remove();
						instance.core.reload($holder);
					}
				}).validationEngine({scroll: false});
			},

			/**
			 * AJAX分页
			 * 
			 * @param dispatcher
			 * @param args
			 */
			ajax_paging: function(dispatcher, args) {
				var $dispatcher = $(dispatcher),
					$holder = args.holder ? $(args.holder) : $dispatcher.parent(),
					current_page_index = 0,
					$pages = $dispatcher.find('li').each(function(i){
						if ($(this).is('.current_page'))
							current_page_index = i;
					}),
					instance = this,
					n = null,
					max_pages = args.maxpages ? args.maxpages : 20;
				if ($pages.length > max_pages) {
					var total_pages = $pages.length,
						show_pages = [0, total_pages - 1],
						page_cursor = (current_page_index + 1) > (max_pages / 2) 
								? (current_page_index - Math.floor(max_pages / 2) + 1) 
										: 1;
					if (page_cursor > total_pages - (max_pages - 2))
						page_cursor = total_pages - (max_pages - 2);
					for (; page_cursor < total_pages && show_pages.length < max_pages; page_cursor ++) {
						if (show_pages.indexOf(page_cursor) === -1)
							show_pages.push(page_cursor);
					}
					show_pages.sort(function(a, b){ return a - b; });
					$dispatcher.empty();
					$pages.each(function(i){
						var current_cursor = show_pages.indexOf(i);
						if (current_cursor !== -1) {
							if (current_cursor === 1 && show_pages[current_cursor] > 1)
								$('<li><em>...</em></li>').appendTo($dispatcher);
							$(this).appendTo($dispatcher);
							if (current_cursor === (max_pages - 2) && show_pages[current_cursor] < total_pages - 2)
								$('<li><em>...</em></li>').appendTo($dispatcher);
						}
					});
				}
				$dispatcher.find('a').each(function(){
					var $page = $(this);
					$page.click(function(e){
						instance.core.ajax($page.attr('href'), {}, { success: function(html){
							try {
								n.close();
							} catch(err){ 
								console.log(err); 
							}
							$holder.html(html);
							instance.core.reload($holder);
						}, error: function(jqXHR, textStatus, errorThrown) {
							instance.close_notify(n);
							n = instance.notify({text: 'error: ' + textStatus, type: 'error', modal: true, timeout: 3000});
						}, beforeSend: function(jqXHR, settings){
							n = instance.notify({text: '加载中, 请稍候...'});
						} });
						e.preventDefault();
					});
				});
			},
			
			/**
			 * 表格树
			 * @param dispatcher
			 * @param args
			 */
			tree_table: function(dispatcher, args) {
				var options = $.extend({
					expandable: true 
				}, args);
				$(dispatcher).treetable(options);
			},
			
			/**
			 * 弹出模式对话框
			 * @param dispatcher
			 * @param options
			 */
			modal_dialog: function(dispatcher, args) {
				var instance = this, $dispatcher = $(dispatcher), options = $.extend({
					modal : true,
	                resizable : true,
	                //position: ['center','middle'],
					bind: 'click',
					closeText: '关闭',
					close: function(event, ui) {
						$(this).dialog('destroy');
					}
				}, args);
				
				$dispatcher.bind(options.bind, function(e){
					options.dialogid ? id = options.dialogid : id = null;
					var $dialog = $('<div class="gostedu_dialog" id="'+id+'"">加载中...</div>');
					$dialog.dialog(options);
					if (options.url) {
						instance.core.ajax(options.url, {}, {
							type: 'GET', dataType: 'html', success: function(html) {
								try {
									var $content = $(html).appendTo($dialog.empty());
									$dialog.dialog("option", "position", ['center','middle']);
									instance.core.reload($content);
								} catch (ex) {
									console.log(ex);
								}
							}
						});
					}
					e.preventDefault();
				});
			},
			
			/**
			 * 操作提示
			 * @param dispatcher
			 * @param options
			 */
			notify: function(options) {
				options = $.extend({layout: 'center', modal: true, buttons: false, 
					animation: { open: { height:'toggle' }, close: { height:'toggle' }, easing: 'swing', speed: 50 }}, options);
				return noty(options);
			},
			/**
			 * 关闭操作提示
			 */
			close_notify: function(n) {
				try {
					if (n) {
						n.close();
					} else {
						$.noty.closeAll();
					}
				} catch(e) {
					if (notify != undefined)
						console.log(n);
					console.log(e);
				}
			},
			
			/**
			 * 关闭对话框
			 */
			close_dialog: function(dispatcher, args) {
				if (args.bind != undefined) {
					$(dispatcher).bind(args.bind, function(e) {
						$(args.selector != undefined ? args.selector : '.gostedu_dialog').dialog('close');
						e.preventDefault();
					});
				} else {
					$(args.selector != undefined ? args.selector : '.gostedu_dialog').dialog('close');
				}
			},
			
			/**
			 * 标签页效果容器
			 */
			tabs: function(dispatcher, args) {
				var $tabs = $(dispatcher);
				$tabs.tabs({
					//collapsible: true,
					activate: function(event, ui) {
						//console.log(ui);
					}
				}).delegate('span.ui-icon-close', 'click', function(e) {
					var panelId = $(this).closest('li').remove().attr('aria-controls');
					$('#' + panelId).remove();
					$tabs.tabs('refresh');
				}).bind('keyup', function(e) {
					if (e.altKey && e.keyCode === $.ui.keyCode.BACKSPACE ) {
						var panelId = $tabs.find('.ui-tabs-active').remove().attr('aria-controls');
				        $('#' + panelId ).remove();
				        $tabs.tabs('refresh');
					}
				});
				if (args.active) {
					$tabs.tabs('refresh');
					$tabs.tabs('option', 'active', args.active);
				}
			},
			
			/**
			 * 新建标签页
			 */
			tab_create: function(dispatcher, args) {
				var $dispatcher = $(dispatcher),
					$holder = $(args.holder),
					instance = this,
					tab_id = 'tab_' + args.id,
					panel_id = 'panel_' + args.id,
					tab_tpl = '<li id="#{id}"><a href="#{href}">#{label}</a></li>',
					close_tpl = '<span class="ui-icon ui-icon-close" role="presentation">关闭</span>',
					url = args.url ? args.url : ($dispatcher.is('a') ? $dispatcher.attr('href') : $dispatcher.find('a:first').attr('href')),
					n = null;
				$dispatcher.click(function(e){
					var $tab, $tab_panel;
					if (!$('#'+tab_id).is('#'+tab_id)) {
						var label = args.title ? args.title : $dispatcher.text();
						$tab = $(tab_tpl
								.replace(/#\{id\}/g, tab_id)
								.replace(/#\{href\}/g, "#" + panel_id)
								.replace(/#\{label\}/g, label ));
						$tab_panel = $('<div id="' + panel_id + '">加载中...</div>');
						var idx = $holder.find('.ui-tabs-nav:first').find('li').length;
						if (args.closeable) {
							$(close_tpl).appendTo($tab);
						}
						$holder.find('.ui-tabs-nav:first').append($tab);
						$holder.append($tab_panel);
						$holder.tabs('refresh');
						$holder.tabs('option', 'active', idx);
					} else { // 已经创建
						$tab = $('#'+tab_id);
						$tab_panel = $('#'+panel_id);
						$holder.find('.ui-tabs-nav:first').find('li').each(function(i){
							if ($(this).is('#'+tab_id)) {
								$holder.tabs('option', 'active', i);
							}
						});
					}
					instance.core.ajax(url, {}, { success: function(html){
						try {
							n.close();
						} catch(err){ 
							console.log(err); 
						}
						$tab_panel.html(html);
						instance.core.reload($tab_panel);
					}, error: function(jqXHR, textStatus, errorThrown) {
						instance.close_notify(n);
						n = instance.notify({text: 'error: ' + textStatus, type: 'error', modal: true, timeout: 2000});
						$tab.remove();
						$tab_panel.remove();
						$holder.tabs('refresh');
					}, beforeSend: function(jqXHR, settings){
						n = instance.notify({text: '加载中, 请稍候...'});
					} });
					e.preventDefault();
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
	
	$.extend($.Gostedu.plugins, { ui: new $.GosteduUI() });
})(window, jQuery);