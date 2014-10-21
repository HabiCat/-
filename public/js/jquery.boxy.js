/**
 * Boxy 0.1.4 - Facebook-style dialog, with frills
 *
 * (c) 2008 Jason Frame
 * Licensed under the MIT License (LICENSE)
 */

/*
 * $ plugin
 *
 * Options:
 *   message: confirmation message for form submit hook (default: "Please confirm:")
 * 
 * Any other options - e.g. 'clone' - will be passed onto the boxy constructor (or
 * Boxy.load for AJAX operations)
 */
 
var JSLOADED = [],
evalscripts = [];
var Setting = {};
var OStatus=false;
var currJs = '';
var $PATH_EXTRA=""; //不以目录分隔符号作为结束
var JSPATH = 'http://paiqian.111job.cn/public/js/';

function Fn(func, args, js,mark) {
	currJs = js;
	if(!OStatus){
		OStatus=true;
		var run = function() {
			var argc = args.length,
			s = '';
			for (var i = 0; i < argc; i++) {
				s += ",'"+args[i]+"'";
			}
			eval('var check = typeof Setting_' + js + ' == \'object\'');
			if (check) {
				eval('Setting=Setting_' + js);
				var ev="Box('"+js+"','"+mark+"','"+func+"',"+s.substr(1)+");";
				eval(ev);
			} else {
				setTimeout(function() {
					checkrun();
				},
				50);
			}
		};
		var checkrun = function() {
			if (JSLOADED[src]) {
				run();
			} else {
				setTimeout(function() {
					checkrun();
				},
				50);
			}
		};
		//script = script || 'common_extra';
		//	src = JSPATH + script + '.js?' + VERHASH;
		src = JSPATH + js + '.js';
		if (!JSLOADED[src]) {
			appendscript(src);
		}
		checkrun();
		
	}
}
function in_array(needle, haystack) {
	if (typeof needle == 'string' || typeof needle == 'number') {
		for (var i in haystack) {
			if (haystack[i] == needle) {
				return true;
			}
		}
	}
	return false;
}
function Box(Js,Mark, Func, Title, Max) {
	var ids = $("#" + Mark + "HiddenValue").val();
	eval('Boxy.' + Func + '(Js,Max,ids,function(val){$("#"+Mark+"HiddenValue").val(val);$("#"+Mark+"TextValue").val(Boxy.getSettingText(val,Setting));},{title: Title});');
	return false;
}
function appendscript(src, text, reload, charset) {
	var id = hash(src + text);
	if (!reload && in_array(id, evalscripts)) return;
	if (reload && $(id)) {
		$(id).parentNode.removeChild($(id));
	}

	evalscripts.push(id);
	var scriptNode = document.createElement("script");
	scriptNode.type = "text/javascript";
	scriptNode.id = id;
	scriptNode.charset = charset ? charset: ($.browser.mozilla ? document.characterSet: document.charset);
	try {
		if (src) {
			scriptNode.src = src;
			scriptNode.onloadDone = false;
			scriptNode.onload = function() {
				scriptNode.onloadDone = true;
				JSLOADED[src] = 1;
			};
			scriptNode.onreadystatechange = function() {
				if ((scriptNode.readyState == 'loaded' || scriptNode.readyState == 'complete') && !scriptNode.onloadDone) {
					scriptNode.onloadDone = true;
					JSLOADED[src] = 1;
				}
			};
		} else if (text) {
			scriptNode.text = text;
		}
		document.getElementsByTagName('head')[0].appendChild(scriptNode);
	} catch(e) {}
}

function stripscript(s) {
	return s.replace(/<script.*?>.*?<\/script>/ig, '');
}

function hash(string, length) {
	var length = length ? length: 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for (i = 0; i < filllen; i++) {
		string += "0";
	}
	while (start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for (var i = 0; i < max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}

;
(function($) {
	$.fn.extend({
		boxy: function(options) {
			options = options || {};
			return this.each(function() {
				var node = this.nodeName.toLowerCase(),
				self = this;
				if (node == 'a') {
					$(this).click(function() {
						var active = Boxy.linkedTo(this),
						href = this.getAttribute('href'),
						localOptions = $.extend({
							actuator: this,
							title: this.title
						},
						options);

						if (active) {
							active.show();
						} else if (href.indexOf('#') >= 0) {
							var content = $(href.substr(href.indexOf('#'))),
							newContent = content.clone(true);
							content.remove();
							localOptions.unloadOnHide = false;
							new Boxy(newContent, localOptions);
						} else { // fall back to AJAX; could do with a same-origin check
							if (!localOptions.cache) localOptions.unloadOnHide = true;
							Boxy.load(this.href, localOptions);
						}

						return false;
					});
				} else if (node == 'form') {
					$(this).bind('submit.boxy',
					function() {
						Boxy.confirm(options.message || 'Please confirm:',
						function() {
							$(self).unbind('submit.boxy').submit();
						});
						return false;
					});
				}
			});
		}
	});
	Boxy.EF = function() {};
	$.extend(Boxy, {

		WRAPPER: "<table cellspacing='0' cellpadding='0' border='0' class='boxy-wrapper'>" + "<tr><td class='top-left'></td><td class='top'></td><td class='top-right'></td></tr>" + "<tr><td class='boxy-left'></td><td class='boxy-inner'></td><td class='boxy-right'></td></tr>" + "<tr><td class='bottom-left'></td><td class='bottom'></td><td class='bottom-right'></td></tr>" + "</table>",

		DEFAULTS: {
			title: null,
			// titlebar text. titlebar will not be visible if not set.
			closeable: true,
			// display close link in titlebar?
			draggable: true,
			// can this dialog be dragged?
			clone: false,
			// clone content prior to insertion into dialog?
			actuator: null,
			// element which opened this dialog
			center: true,
			// center dialog in viewport?
			show: true,
			// show dialog immediately?
			modal: false,
			// make dialog modal?
			fixed: false,
			// use fixed positioning, if supported? absolute positioning used otherwise
			closeText: '[关闭]',
			// text to use for default close link
			unloadOnHide: false,
			// should this dialog be removed from the DOM after being hidden?
			clickToFront: false,
			// bring dialog to foreground on any click (not just titlebar)?
			behaviours: Boxy.EF,
			// function used to apply behaviours to all content embedded in dialog.
			afterDrop: Boxy.EF,
			// callback fired after dialog is dropped. executes in context of Boxy instance.
			afterShow: Boxy.EF,
			// callback fired after dialog becomes visible. executes in context of Boxy instance.
			afterHide: Boxy.EF,
			// callback fired after dialog is hidden. executed in context of Boxy instance.
			beforeUnload: Boxy.EF // callback fired after dialog is unloaded. executed in context of Boxy instance.
		},

		DEFAULT_X: 50,
		DEFAULT_Y: 50,
		zIndex: 1337,
		dragConfigured: false,
		// only set up one drag handler for all boxys
		resizeConfigured: false,
		dragging: null,

		// load a URL and display in boxy
		// url - url to load
		// options keys (any not listed below are passed to boxy constructor)
		//   type: HTTP method, default: GET
		//   cache: cache retrieved content? default: false
		//   filter: $ selector used to filter remote content
		load: function(url, options) {

			options = options || {};

			var ajax = {
				url: url,
				type: 'GET',
				dataType: 'html',
				cache: false,
				success: function(html) {
					html = $(html);
					if (options.filter) html = $(options.filter, html);
					new Boxy(html, options);
				}
			};

			$.each(['type', 'cache'],
			function() {
				if (this in options) {
					ajax[this] = options[this];
					delete options[this];
				}
			});

			$.ajax(ajax);

		},

		// allows you to get a handle to the containing boxy instance of any element
		// e.g. <a href='#' onclick='alert(Boxy.get(this));'>inspect!</a>.
		// this returns the actual instance of the boxy 'class', not just a DOM element.
		// Boxy.get(this).hide() would be valid, for instance.
		get: function(ele) {
			var p = $(ele).parents('.boxy-wrapper');
			return p.length ? $.data(p[0], 'boxy') : null;
		},

		// returns the boxy instance which has been linked to a given element via the
		// 'actuator' constructor option.
		linkedTo: function(ele) {
			return $.data(ele, 'active.boxy');
		},

		// displays an alert box with a given message, calling optional callback
		// after dismissal.
		alert: function(message, callback, options) {
			return Boxy.ask(message, ['OK'], callback, options);
		},

		// displays an alert box with a given message, calling after callback iff
		// user selects OK.
		confirm: function(message, after, options) {
			return Boxy.ask(message, ['OK', 'Cancel'],
			function(response) {
				if (response == 'OK') after();
			},
			options);
		},

		// asks a question with multiple responses presented as buttons
		// selected item is returned to a callback method.
		// answers may be either an array or a hash. if it's an array, the
		// the callback will received the selected value. if it's a hash,
		// you'll get the corresponding key.
		ask: function(question, answers, callback, options) {

			options = $.extend({
				modal: true,
				closeable: false
			},
			options || {},
			{
				show: true,
				unloadOnHide: true
			});

			var body = $('<div></div>').append($('<div class="question"></div>').html(question));

			// ick
			var map = {},
			answerStrings = [];
			if (answers instanceof Array) {
				for (var i = 0; i < answers.length; i++) {
					map[answers[i]] = answers[i];
					answerStrings.push(answers[i]);
				}
			} else {
				for (var k in answers) {
					map[answers[k]] = k;
					answerStrings.push(answers[k]);
				}
			}

			var buttons = $('<form class="answers"></form>');
			buttons.html($.map(answerStrings,
			function(v) {
				return "<input type='button' value='" + v + "' />";
			}).join(' '));

			$('input[type=button]', buttons).click(function() {
				var clicked = this;
				Boxy.get(this).hide(function() {
					if (callback) callback(map[clicked.value]);
				});
			});

			body.append(buttons);

			new Boxy(body, options);

		},

		radio: function(mark, maxSelected, value, callback, options) {
			options = $.extend({
				modal: true,
				closeable: true
			},
			options || {},
			{
				show: true,
				unloadOnHide: true
			});
			var html = '';
			(function setDateOption() {
				$.each(Setting,
				function(k, v) {
					html += '<a class="item" href="javascript:;" id="' + mark + 'Item' + k + '">' + v + '</a>';
				})
			})();

			var box = $('<div></div>').append('<div id="' + mark + '-main" class="mark-main"></div>').css("padding-bottom", "0");
			var main = $("#" + mark + "-main", box);
			var body = $('<div id="' + mark + '-body" class="cl mark-body"></div>').html(html);
			var head = $('<div id="' + mark + '-head" class="mark-head cl" style="display:none;"></div>').html('<div class="head-title" style="font-weight:bold;height:16px;line-height:16px;">你的选择结果</div><ul id="' + mark + '-result" class="mark-result"></ul>');
			var foot = $('<div id="' + mark + '-foot" class="mark-foot cl"><span class="boxy-btn" id="' + mark + '-cancel">取消</span><span class="boxy-btn" id="' + mark + '-submit">确定</span></div>');
			main.append(head).append(body).append(foot);
			$(".item", body).click(function() {
				var id = $(this).attr("id").split("Item")[1];
				$(this).addClass('checked').siblings().removeClass('checked');
				head.show();
				value = id.replace(/key_/, "");
				$('#' + mark + '-result').html('<li><a href="javascript:;">' + Setting[id] + '</a></li>');
			});

			$('#' + mark + '-result a').live('click',
			function() {
				head.slideUp(500,
				function() {
					$('#' + mark + '-result').empty();
				});
			})
			//提交事件
			$("#" + mark + "-submit", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide(function() {
					//alert(value);
					if (callback) callback(value == -1 ? "": value);
				});
			});
			$("#" + mark + "-cancel", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide();
			});

			var selector = new Boxy(box, options);
			//重置日期选择器位置，使其垂直居中
			selector.center();

			if (!value) {
				$('.item:eq(0)').click();
			} else {
				$('#' + mark + 'Itemkey_' + value).click();
			}
			return false;

		},
		checkbox: function(mark, maxSelected, value, callback, options) {
			options = $.extend({
				modal: true,
				closeable: true
			},
			options || {},
			{
				show: true,
				unloadOnHide: true
			});
			var html = '';
			//设置日期选项
			(function setDateOption() {
				$.each(Setting,
				function(k, v) {
					html += '<a class="item" href="javascript:;" id="' + mark + 'Item' + k + '">' + v + '</a>';
				})
			})();

			var box = $('<div></div>').append('<div id="' + mark + '-main" class="mark-main"></div>').css("padding-bottom", "0");
			var main = $("#" + mark + "-main", box);
			var body = $('<div id="' + mark + '-body" class="cl mark-body"></div>').html(html);
			var head = $('<div id="' + mark + '-head" class="mark-head cl" style="display:none;"></div>').html('<div class="head-title" style="font-weight:bold;height:16px;line-height:16px;">你的选择结果</div><ul id="' + mark + '-result" class="mark-result cl"></ul>');
			var foot = $('<div id="' + mark + '-foot" class="mark-foot cl"><span class="boxy-btn" id="' + mark + '-cancel">取消</span><span class="boxy-btn" id="' + mark + '-submit">确定</span></div>');

			//获取日期主体句柄
			//body.html(html);
			main.append(head).append(body).append(foot);
			var selecteValue = [];
			$(".item", body).click(function() {
				//清空
				//$('#"+mark+"-result').empty();
				var id = $(this).attr("id").split("Item")[1];
				if ($(this).hasClass('checked')) {
					$(this).removeClass('checked');
					$('#' + id).hide().remove();
					if ($('#' + mark + '-result li').length == 0) {
						head.slideUp(500);
					}
				} else {
					//alert($('#'+mark+'-result li').length);
					if ($('#' + mark + '-result li').length < maxSelected) {
						$('#' + mark + '-result').append('<li id="' + id + '"><a href="javascript:;">' + Setting[id] + '</a></li>');
						head.slideDown(500).show();
						$(this).addClass('checked');
					} else {
						alert('最多只能'+maxSelected+'项，若需更换其他选项，请先取消部分选择结果');
					}
				}
			});
			$('#' + mark + '-result a').live('click',
			function() {
				$('#' + mark + 'Item' + $(this).parent('li').attr('id')).removeClass('checked');
				$(this).parent('li').hide().remove();
				if ($('#' + mark + '-result li').length == 0) {
					head.slideUp(500);
				}
			})

			//提交事件
			$("#" + mark + "-submit", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide(function() {
					if (callback) callback(Boxy.submitValue(mark));
					return false;
				});
			});

			$("#" + mark + "-cancel", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide();
			});
			var selector = new Boxy(box, options);
			//重置日期选择器位置，使其垂直居中
			selector.center();
			$.each(value.split(','),
			function(k, v) {
				$('#' + mark + 'Itemkey_' + v).click();
			})
		},
		lv2: function(mark, maxSelected, value, callback, options) {
			options = $.extend({
				modal: true,
				closeable: true
			},
			options || {},
			{
				show: true,
				unloadOnHide: true
			});
			var html = '';
			//设置日期选项
			(function setDateOption() {
				$.each(Setting,
				function(k, v) {
					if (k.split('_')[1].length == 3) {
						html += '<a class="item" href="javascript:;" id="' + mark + 'Item' + k + '"><input type="checkbox" value="' + k + '" style="display:none;" /><span>' + v + '</span></a>';
					}
				})
			})();

			var box = $('<div></div>').append('<div id="' + mark + '-main" class="mark-main"></div>').css("padding-bottom", "0");
			var main = $("#" + mark + "-main", box);
			var body = $('<div id="' + mark + '-body" class="cl mark-body"></div>').html(html);
			var head = $('<div id="' + mark + '-head" class="mark-head cl" style="display:none;"></div>').html('<div class="head-title" style="font-weight:bold;height:16px;line-height:16px;">你的选择结果</div><ul id="' + mark + '-result" class="mark-result"></ul>');
			var foot = $('<div id="' + mark + '-foot" class="mark-foot cl"><span class="boxy-btn" id="' + mark + '-cancel">取消</span><span class="boxy-btn" id="' + mark + '-submit">确定</span></div>');
			main.append(head).append(body).append(foot);
			$(".item span", body).click(function() {
				$(".item input").attr('style','display:none;');
				$('#childrenLayer').remove();
				$(this).prev().attr('style','display:block;');
				var a = $(this).parent().index();
				var d = a + (3 - (a + 1) % 3) % 3;
				$(this).parent().addClass('click').siblings().removeClass('click');
				setChildrenLayer(d, $(this).parent().attr('id'));
				var checkStatus = $(this).siblings(':checkbox')[0].checked;
				if (checkStatus) {
					$('#childrenLayer :checkbox').attr({
						checked: 1,
						disabled: 1
					});
				}

			});
			$(".item :checkbox", body).click(function() {
				updateSelection(this, this.checked);
				$('#childrenLayer :checkbox').attr({
					checked: this.checked,
					disabled: this.checked
				});
			});
			$('#childrenLayer :checkbox').live('click',
			function() {
				updateSelection(this, this.checked);
			})
			function updateSelection(t, status) {
				if (status) {
					$('#' + mark + '-result li[id^=' + t.value + ']').remove();
					if ($('#' + mark + '-result li').length < maxSelected) {
						$('#' + mark + '-result').append('<li id="' + t.value + '"><a href="javascript:;">' + Setting[t.value] + '</a></li>');
					} else {
						alert('最多只能'+maxSelected+'项，若需更换其他选项，请先取消部分选择结果');
						t.checked = false;
						return false;
					}
				} else {
					$('#' + t.value).remove();
				}
				updateClass();
				head.slideDown(500);
			}
			function updateClass() { //更新样式
				$('.item').removeClass('sel'); //移除所有的样式
				$.each($('#' + mark + '-result li'),
				function(k, v) {
					$('#' + mark + 'Item' + this.id.substr(0, 7)).addClass('sel'); //选择项增加样式
				})
			}

			function setChildrenLayer(d, id) {
				var layerContent = "<div id='childrenLayer' class='childrenLayer cl'></div>";
				if (d == $(".item", body).length) {
					$('#' + mark + '-body').append(layerContent);
				} else {
					$(".item:eq(" + d + ")", body).after(layerContent);
				}
				var html = '';

				var m = mark.length; //job  3
				var mm = m + 4; //7
				var mmm = id.length; //jobItemkey_301	//14
				var mmmm = id.substr(mm, mmm - mm); //key_301
				var html = '';
				$.each(Setting,
				function(k, v) {
					if (k.indexOf(mmmm) != -1 && k.length > 7) {
						var c = document.getElementById(k) != null ? 'checked="checked"': "";
						html += '<a class="item children" href="javascript:;" id="' + mark + 'Item' + k + '"><input type="checkbox" value="' + k + '" ' + c + ' id="' + mark + 'checkbox' + k + '" /><label for="' + mark + 'checkbox' + k + '">' + v + '</label></a>';
					}
				})
				$('#childrenLayer').html(html);
			}

			$('#' + mark + '-result li').live('click',
			function() {
				$(':checkbox[value="' + this.id + '"]').attr("checked", false);
				$(this).remove();
				updateClass();
			})
			//提交事件
			$("#" + mark + "-submit", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide(function() {

					if (callback) callback(Boxy.submitValue(mark));
					return false;
				});
				
			});
			$("#" + mark + "-cancel", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide();
			});

			var selector = new Boxy(box, options);
			//重置日期选择器位置，使其垂直居中
			selector.center();
			if (value != '' && value != '-1') {
				head.slideDown(500);
				$.each(value.split(','),
				function(k, v) {
					$('#' + mark + '-result').append('<li id="key_' + v + '"><a href="javascript:;">' + Setting['key_' + v] + '</a></li>');
					$('#' + mark + 'Itemkey_' + v.substr(0, 3)).addClass('sel'); //选择项增加样式
					$(':checkbox[value=key_' + v + ']').attr("checked", "checked");
				})
			}
		},
		lv3: function(mark, maxSelected, value, callback, options) {
			options = $.extend({
				modal: true,
				closeable: true
			},
			options || {},
			{
				show: true,
				unloadOnHide: true
			});
			var html = '';
			//设置日期选项
			(function setDateOption() {
				$.each(Setting,
				function(k, v) {
					if (k.split('_')[1].length == 2 || (k.split('_')[1].length == 3 && currJs == 'specialty')) {
						if (haschild(k, Setting, 1)) {
							html += '<a class="item lv1 hasChild" href="javascript:;" id="' + mark + 'Item' + k + '"><span>' + v + '</span></a>';
						} else {
							html += '<a class="item lv1" href="javascript:;" id="' + mark + 'Item' + k + '"><input type="checkbox" value="' + k + '" id="' + mark + 'checkbox' + k + '" /><label for="' + mark + 'checkbox' + k + '">' + v + '</label></a>';
						}
					}
				})
			})();

			var box = $('<div></div>').append('<div id="' + mark + '-main" class="mark-main"></div>').css("padding-bottom", "0");
			var main = $("#" + mark + "-main", box);
			var body = $('<div id="' + mark + '-lv1" class="cl mark-lv1"></div>').html("<div id='" + mark + "-lv1-title'></div><div id='" + mark + "-lv1-c' class='cl'>" + html + "</div>");
			var head = $('<div id="' + mark + '-head" class="mark-head cl" style="display:none;"></div>').html('<div class="head-title" style="font-weight:bold;height:16px;line-height:16px;">你的选择结果</div><ul id="' + mark + '-result" class="mark-result"></ul>');
			var lv2  = $('<div id="' + mark + '-lv2" class="cl hide"><div id="' + mark + '-lv2-title"><span></span></div><div id="' + mark + '-lv2-body" class="cl"></div></div>');
			var foot = $('<div id="' + mark + '-foot" class="mark-foot cl"><span class="boxy-btn" id="' + mark + '-cancel">取消</span><span class="boxy-btn" id="' + mark + '-submit">确定</span></div>');
			main.append(head).append(lv2).append(body).append(foot);

			$('.lv1 span').live('click',
			function() {
				if ($(this).parent().hasClass('hasChild')) {
					$('#' + mark + '-lv2').show();
					setLv2Layer($(this).parent().attr('id'));
				} else {
					$('#' + mark + '-lv2').hide();
					$(this).siblings(':checkbox')[0].checked = !$(this).siblings(':checkbox')[0].checked;
					updateSelection($(this).siblings(':checkbox')[0], $(this).siblings(':checkbox')[0].checked);
				}
				$('#' + mark + '-lv2-title span').html('<b>' + $(this).text() + '</b>下属');
				$(this).parent().addClass('click').siblings().removeClass('click');
				updateClass();
			});
			$('.lv1 :checkbox').live('click',
			function() {
				$(this).siblings('span').click();
				if ($(this).parent().hasClass('hasChild')) {
					updateSelection(this, this.checked);
					$('#' + mark + '-lv2 :checkbox').attr({
						checked: this.checked,
						disabled: this.checked
					});
				} else {
					updateSelection(this, this.checked);
					//this.checked=!this.checked;
				}
			});

			$('.lv2 span').live('click',
			function() {
				$(".item input").attr('style','display:none;');
				$(this).prev().attr('style','display:block;');
				$('#' + mark + '-lv3').remove();
				if ($(this).parent().hasClass('hasChild')) {
					var a = $(this).parent().index();
					var d = a + (4 - (a + 1) % 4) % 4;
					setLv3Layer(d, $(this).parent().attr('id'));
				} else {
					$(this).siblings(':checkbox')[0].checked = !$(this).siblings(':checkbox')[0].checked;
					updateSelection($(this).siblings(':checkbox')[0], $(this).siblings(':checkbox')[0].checked);
				}
			});
			$('.lv2 :checkbox').live('click',
			function() {
				$(this).siblings('span').click();
				if ($(this).parent().hasClass('hasChild')) {
					updateSelection(this, this.checked);
					$('#' + mark + '-lv3 :checkbox').attr({
						checked: this.checked,
						disabled: this.checked
					});
				} else {
					updateSelection(this, this.checked);
				}
			});

			$('.lv3 :checkbox').live('click',
			function() {
				updateSelection(this, this.checked);
			});

			function haschild(value, data, lv) {
				len = (lv == 1) ? 8 : 9;
				for (var i in Setting) {
					if (i.indexOf(value) != -1 && i.length > len) {
						return true;
					}
				}
				return false;
			}
			function setLv2Layer(id) {
				var m = mark.length; //job  3
				var mm = m + 4; //7
				var mmm = id.length; //jobItemkey_301	//14
				var mmmm = id.substr(mm, mmm - mm); //key_301
				var html = '';
				$.each(Setting,
				function(k, v) {
					if (k.indexOf(mmmm) != -1 && k.length == 9) {
						var c = document.getElementById(k) != null ? 'checked="checked"': "";
						if (haschild(k, Setting, 2)) {
							html += '<a class="item lv2 hasChild" href="javascript:;" id="' + mark + 'Item' + k + '"><input type="checkbox" value="' + k + '" ' + c + ' style="display:none;" /><span>' + v + '</span></a>';
						} else {
							html += '<a class="item lv2" href="javascript:;" id="' + mark + 'Item' + k + '"><input type="checkbox" value="' + k + '" ' + c + ' id="' + mark + 'checkbox' + k + '" /><label label for="' + mark + 'checkbox' + k + '">' + v + '</label></a>';
						}
					}
				})

				$('#' + mark + '-lv2-body').html(html);
				
			}
			function setLv3Layer(d, id) {
				var layerContent = "<div id='" + mark + "-lv3' class='" + mark + "-lv3 cl'></div>";
				var html = '';
				var m = mark.length; //job  3
				var mm = m + 4; //7
				var mmm = id.length; //jobItemkey_301	//14
				var mmmm = id.substr(mm, mmm - mm); //key_301
				$.each(Setting,
				function(k, v) {
					if (k.indexOf(mmmm) != -1 && k.length > 9) {
						var c = document.getElementById(k) != null ? 'checked="checked"': "";
						html += '<a class="item lv3" href="javascript:;" id="' + mark + 'Item' + k + '"><input type="checkbox" value="' + k + '" ' + c + ' id="' + mark + 'checkbox' + k + '" /><label for="' + mark + 'checkbox' + k + '">' + v + '</label></a>';
					}
				})
				if (d >= $(".lv2").length) {
					$('#' + mark + '-lv2-body').append(layerContent);
				} else {
					$(".lv2:eq(" + d + ")").after(layerContent);
				}
				//更新子选项状态
				$('#' + id).addClass('click').siblings().removeClass('click');
				$('#' + mark + '-lv3').html(html);
				if ($(":checkbox", '#' + id)[0].checked) {
					$('.lv3 :checkbox').attr({
						checked: true,
						disabled: true
					});
				}
			}
			function updateSelection(t, status) {
				if (status) {
					$('#' + mark + '-result li[id^=' + t.value + ']').remove();
					if ($('#' + mark + '-result li').length < maxSelected) {
						$('#' + mark + '-result').append('<li id="' + t.value + '"><a href="javascript:;">' + Setting[t.value] + '</a></li>');
					} else {
						alert('最多只能'+maxSelected+'项，若需更换其他选项，请先取消部分选择结果');
						t.checked = false;
						updateClass();
						return false;
					}
				} else {
					$('#' + t.value).remove();
				}
				updateClass();
				head.slideDown(500);
			}
			function updateClass() { //更新样式
				$('.item').removeClass('sel'); //移除所有的样式
				$.each($('#' + mark + '-result li'),
				function(k, v) {
					$('#' + mark + 'Item' + this.id).addClass('sel'); //选择项增加样式
					$('#' + mark + 'Item' + this.id.substr(0, 6)).addClass('sel'); //选择项增加样式
					$('#' + mark + 'Item' + this.id.substr(0, 9)).addClass('sel'); //选择项增加样式
				})
			}
			//								
			$('#' + mark + '-result li').live('click',
			function() {
				$(':checkbox[value^="' + this.id + '"]').attr({
					"checked": false,
					"disabled": false
				});

				$(this).remove();
				updateClass();
			})
			//提交事件
			$("#" + mark + "-submit", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide(function() {
					if (callback) callback(Boxy.submitValue(mark));
					return false;
				});
			});
			$("#" + mark + "-cancel", foot).click(function() {
				OStatus=false;
				Boxy.get(this).hide();
			});

			var selector = new Boxy(box, options);
			//重置日期选择器位置，使其垂直居中
			selector.center();
			if (value != '' && value != '-1') {

				head.slideDown(500);
				$.each(value.split(','),
				function(k, v) {
					if(typeof Setting['key_' + v] !='undefined'){
						$('#' + mark + '-result').append('<li id="key_' + v + '"><a href="javascript:;">' + Setting['key_' + v] + '</a></li>');
						$('#' + mark + 'Itemkey_' + v.substr(0, 3)).addClass('sel'); //选择项增加样式
						$(':checkbox[value=key_' + v + ']').attr("checked", "checked");
					}
				})
				updateClass();
			}

			//$.getScript("http://localhost/huazhongrencai/www.111job.cn/"+"js/"+mark+".js",function(){});
		},
		mapcenter: function(mark, maxSelected, value, callback, options) {
			options = $.extend({
				modal: true,
				closeable: true
			},
			options || {},
			{
				show: true,
				unloadOnHide: true
			});
			var html = '';
			(function setDateOption() {
				$.each(Setting,
				function(k, v) {
					if(typeof v !='object'){
						html += '<a class="item" href="javascript:;" id="' + mark + 'Item' + k + '">' + v + '</a>';
					}
				})
				html+='<div class="maplv2 cl" id="maplv2">';
				$.each(Setting,
				function(k, v) {
					if(typeof v =='object'){
						html += '<a class="maplv2item" href="javascript:;" id="' + mark + 'Item' + k + '">' + v[0] + '</a>';
					}
				})
				html+='</div>';
			})();

			var box = $('<div></div>').append('<div id="' + mark + '-main" class="mark-main"></div>').css("padding-bottom", "0");
			var main = $("#" + mark + "-main", box);
			var body = $('<div id="' + mark + '-body" class="cl mark-body"></div>').html(html);
			main.append(body);
			
			$(".item", body).click(function() {
				OStatus=false;
				var v=$(this).html();
				Boxy.get(this).hide(function() {
					//if (callback) callback([-1]);
					$('#mapcenterTextValue').val(v);
					return false;
				});
			});
			
			$(".maplv2item", body).click(function() {
				//OStatus=false;
				//Boxy.get(this).hide();
				//alert(this.id);
				$(this).addClass('checked').siblings().removeClass('checked');
				setLv3Layer($(this).index,this.id.split(mark+"Item")[1]);
			});
			$(".maplv3item").live('click',function(){
				OStatus=false;
				var v=$(this).html();
				Boxy.get(this).hide(function() {
					$('#mapcenterTextValue').val(v);
					return false;
				});
			});
			function setLv3Layer(i,d) {
				$('#maplv3').remove();
				var html = "<div id='maplv3' class='" + mark + "-lv3 cl'>";
				$.each(Setting[d][1],
				function(k, v) {
						html += '<a class="maplv3item" href="javascript:;">' + v + '</a>';
				});
				html+="</div>";
				//alert(layerContent);
				//if (i >= $(".maplv2item").length) {
					$('#maplv2').append(html);
				//} else {
					//$(".maplv2item:eq(" + i + ")").after(layerContent);
				//}
			}

			var selector = new Boxy(box, options);
			//重置日期选择器位置，使其垂直居中
			selector.center();

			return false;

		},
		submitValue: function(mark) {
			var value = [];
			$.each($('#' + mark + '-result li'),
			function() {
				value.push(this.id.replace(/key_/, ""));
			});
			if (!value.length) {
				return "-1";
			}
			return value;
		},
		getSettingText: function(val, Setting) {
			var text = '';
			if ((typeof val) == "string") {
				if (val == "-1"||val == 0||val == "") {
					text = '不限';
				} else {
					text = Setting['key_' + val];
				}
			} else {
				$.each(val,
				function(k) {
					text += Setting['key_' + val[k]] + '|';
				})
				text = text.substr(0, text.length - 1);
			}
			return text;
		},
		isModalVisible: function() {
			return $('.boxy-modal-blackout').length > 0;
		},
		_u: function() {
			for (var i = 0; i < arguments.length; i++)
			if (typeof arguments[i] != 'undefined') return false;
			return true;
		},

		_handleResize: function(evt) {
			var d = $(document);
			$('.boxy-modal-blackout').css('display', 'none').css({
				width: d.width() - 130 + 'px',
				height: d.height()
			}).css('display', 'block');
		},

		_handleDrag: function(evt) {
			var d;
			if (d = Boxy.dragging) {
				d[0].boxy.css({
					left: evt.pageX - d[1],
					top: evt.pageY - d[2]
				});
			}
		},

		_nextZ: function() {
			return Boxy.zIndex++;
		},

		_viewport: function() {
			var d = document.documentElement,
			b = document.body,
			w = window;
			return $.extend(
			$.browser.msie ? {
				left: b.scrollLeft || d.scrollLeft,
				top: b.scrollTop || d.scrollTop
			}: {
				left: w.pageXOffset,
				top: w.pageYOffset
			},
			!Boxy._u(w.innerWidth) ? {
				width: w.innerWidth,
				height: w.innerHeight
			}: (!Boxy._u(d) && !Boxy._u(d.clientWidth) && d.clientWidth != 0 ? {
				width: d.clientWidth,
				height: d.clientHeight
			}: {
				width: b.clientWidth,
				height: b.clientHeight
			}));
		},
		getclientWidth: function() {
			var clientWidth = 0;
			if (document.body.clientWidth && document.documentElement.clientWidth) {
				var clientWidth = (document.body.clientWidth < document.documentElement.clientWidth) ? document.body.clientWidth: document.documentElement.clientWidth;
			}
			else {
				var clientWidth = (document.body.clientWidth > document.documentElement.clientWidth) ? document.body.clientWidth: document.documentElement.clientWidth;
			}
			return clientWidth;
		}
	});
})(jQuery);

//
// Boxy Class
function Boxy(element, options) {

	this.boxy = $(Boxy.WRAPPER);
	
	$.data(this.boxy[0], 'boxy', this);

	this.visible = false;
	this.options = $.extend({},
	Boxy.DEFAULTS, options || {});

	if (this.options.modal) {
		this.options = $.extend(this.options, {
			center: true,
			draggable: true
		});
	}

	// options.actuator == DOM element that opened this boxy
	// association will be automatically deleted when this boxy is remove()d
	if (this.options.actuator) {
		$.data(this.options.actuator, 'active.boxy', this);
	}

	this.setContent(element || "<div></div>");
	this._setupTitleBar();

	this.boxy.css('display', 'none').appendTo(document.body);
	this.toTop();

	if (this.options.fixed) {
		if ($.browser.msie && $.browser.version < 7) {
			this.options.fixed = false; // IE6 doesn't support fixed positioning
		} else {
			this.boxy.addClass('fixed');
		}
	}

	if (this.options.center && Boxy._u(this.options.x, this.options.y)) {
		this.center();
	} else {
		this.moveTo(
		Boxy._u(this.options.x) ? this.options.x: Boxy.DEFAULT_X, Boxy._u(this.options.y) ? this.options.y: Boxy.DEFAULT_Y);
	}

	if (this.options.show) this.show();

};

Boxy.prototype = {

	// Returns the size of this boxy instance without displaying it.
	// Do not use this method if boxy is already visible, use getSize() instead.
	estimateSize: function() {
		this.boxy.css({
			visibility: 'hidden',
			display: 'block'
		});
		var dims = this.getSize();
		this.boxy.css('display', 'none').css('visibility', 'visible');
		return dims;
	},

	// Returns the dimensions of the entire boxy dialog as [width,height]
	getSize: function() {
		return [this.boxy.width(), this.boxy.height()];
	},

	// Returns the dimensions of the content region as [width,height]
	getContentSize: function() {
		var c = this.getContent();
		return [c.width(), c.height()];
	},

	// Returns the position of this dialog as [x,y]
	getPosition: function() {
		var b = this.boxy[0];
		return [b.offsetLeft, b.offsetTop];
	},

	// Returns the center point of this dialog as [x,y]
	getCenter: function() {
		var p = this.getPosition();
		var s = this.getSize();
		return [Math.floor(p[0] + s[0] / 2), Math.floor(p[1] + s[1] / 2)];
	},

	// Returns a $ object wrapping the inner boxy region.
	// Not much reason to use this, you're probably more interested in getContent()
	getInner: function() {
		return $('.boxy-inner', this.boxy);
	},

	// Returns a $ object wrapping the boxy content region.
	// This is the user-editable content area (i.e. excludes titlebar)
	getContent: function() {
		return $('.boxy-content', this.boxy);
	},

	// Replace dialog content
	setContent: function(newContent) {
		newContent = $(newContent).css({
			display: 'block'
		}).addClass('boxy-content');
		if (this.options.clone) newContent = newContent.clone(true);
		this.getContent().remove();
		this.getInner().append(newContent);
		this._setupDefaultBehaviours(newContent);
		this.options.behaviours.call(this, newContent);
		return this;
	},

	// Move this dialog to some position, funnily enough
	moveTo: function(x, y) {
		this.moveToX(x).moveToY(y);
		return this;
	},

	// Move this dialog (x-coord only)
	moveToX: function(x) {
		if (typeof x == 'number') this.boxy.css({
			left: x
		});
		else this.centerX();
		return this;
	},

	// Move this dialog (y-coord only)
	moveToY: function(y) {
		if (typeof y == 'number') this.boxy.css({
			top: y
		});
		else this.centerY();
		return this;
	},

	// Move this dialog so that it is centered at (x,y)
	centerAt: function(x, y) {
		var s = this[this.visible ? 'getSize': 'estimateSize']();
		if (typeof x == 'number') this.moveToX(x - s[0] / 2);
		if (typeof y == 'number') this.moveToY(y - s[1] / 2);
		return this;
	},

	centerAtX: function(x) {
		return this.centerAt(x, null);
	},

	centerAtY: function(y) {
		return this.centerAt(null, y);
	},

	// Center this dialog in the viewport
	// axis is optional, can be 'x', 'y'.
	center: function(axis) {
		var v = Boxy._viewport();
		var o = this.options.fixed ? [0, 0] : [v.left, v.top];
		if (!axis || axis == 'x') this.centerAt(o[0] + v.width / 2, null);
		if (!axis || axis == 'y') this.centerAt(null, o[1] + v.height / 2);
		return this;
	},

	// Center this dialog in the viewport (x-coord only)
	centerX: function() {
		return this.center('x');
	},

	// Center this dialog in the viewport (y-coord only)
	centerY: function() {
		return this.center('y');
	},

	// Resize the content region to a specific size
	resize: function(width, height, after) {
		if (!this.visible) return;
		var bounds = this._getBoundsForResize(width, height);
		this.boxy.css({
			left: bounds[0],
			top: bounds[1]
		});
		this.getContent().css({
			width: bounds[2],
			height: bounds[3]
		});
		if (after) after(this);
		return this;
	},

	// Tween the content region to a specific size
	tween: function(width, height, after) {
		if (!this.visible) return;
		var bounds = this._getBoundsForResize(width, height);
		var self = this;
		this.boxy.stop().animate({
			left: bounds[0],
			top: bounds[1]
		});
		this.getContent().stop().animate({
			width: bounds[2],
			height: bounds[3]
		},
		function() {
			if (after) after(self);
		});
		return this;
	},

	// Returns true if this dialog is visible, false otherwise
	isVisible: function() {
		return this.visible;
	},

	// Make this boxy instance visible
	show: function() {
		if (this.visible) return;
		if (this.options.modal) {
			var self = this;
			if (!Boxy.resizeConfigured) {
				Boxy.resizeConfigured = true;
				$(window).resize(function() {
					Boxy._handleResize();
				});
			}
			this.modalBlackout = $('<div class="boxy-modal-blackout"></div>').css({
				zIndex: Boxy._nextZ(),
				opacity: 0.5,
				width: Boxy.getclientWidth(),
				height: $(document).height()
			}).appendTo(document.body).bgiframe();
			this.toTop();
			if (this.options.closeable) {
				$(document.body).bind('keypress.boxy',
				function(evt) {
					var key = evt.which || evt.keyCode;
					if (key == 27) {
						OStatus=false;
						self.hide();
						$(document.body).unbind('keypress.boxy');
					}
				});
			}
		}
		this.boxy.stop().css({
			opacity: 1
		}).show();
		this.visible = true;
		this._fire('afterShow');
		return this;
	},

	// Hide this boxy instance
	hide: function(after) {
		if (!this.visible) return;
		var self = this;
		if (this.options.modal) {
			$(document.body).unbind('keypress.boxy');
			this.modalBlackout.animate({
				opacity: 0
			},
			function() {
				$(this).remove();
			});
		}
		this.boxy.stop().animate({
			opacity: 0
		},
		300,
		function() {
			self.boxy.css({
				display: 'none'
			});
			self.visible = false;
			self._fire('afterHide');
			if (after) after(self);
			if (self.options.unloadOnHide) self.unload();
		});
		return this;
	},

	toggle: function() {
		this[this.visible ? 'hide': 'show']();
		return this;
	},

	hideAndUnload: function(after) {
		this.options.unloadOnHide = true;
		this.hide(after);
		return this;
	},

	unload: function() {
		this._fire('beforeUnload');
		this.boxy.remove();
		if (this.options.actuator) {
			$.data(this.options.actuator, 'active.boxy', false);
		}
	},

	// Move this dialog box above all other boxy instances
	toTop: function() {
		this.boxy.css({
			zIndex: Boxy._nextZ()
		});
		return this;
	},

	// Returns the title of this dialog
	getTitle: function() {
		return $('> .title-bar h2', this.getInner()).html();
	},

	// Sets the title of this dialog
	setTitle: function(t) {
		$('> .title-bar h2', this.getInner()).html(t);
		return this;
	},

	//
	// Don't touch these privates
	_getBoundsForResize: function(width, height) {
		var csize = this.getContentSize();
		var delta = [width - csize[0], height - csize[1]];
		var p = this.getPosition();
		return [Math.max(p[0] - delta[0] / 2, 0), Math.max(p[1] - delta[1] / 2, 0), width, height];
	},

	_setupTitleBar: function() {
		if (this.options.title) {
			var self = this;
			var tb = $("<div class='title-bar'></div>").html("<h2>" + this.options.title + "</h2>");
			if (this.options.closeable) {
				tb.append($("<a href='#' class='close'></a>").html(this.options.closeText));
			}
			if (this.options.draggable) {

				tb[0].onselectstart = function() {
					return false;
				}
				tb[0].unselectable = 'on';
				tb[0].style.MozUserSelect = 'none';
				if (!Boxy.dragConfigured) {
					$(document).mousemove(Boxy._handleDrag);
					Boxy.dragConfigured = true;
				}
				tb.mousedown(function(evt) {
					self.toTop();
					Boxy.dragging = [self, evt.pageX - self.boxy[0].offsetLeft, evt.pageY - self.boxy[0].offsetTop];
					$(this).addClass('dragging');
				}).mouseup(function() {
					$(this).removeClass('dragging');
					Boxy.dragging = null;
					self._fire('afterDrop');
				});
			}
			this.getInner().prepend(tb);
			this._setupDefaultBehaviours(tb);
		}
	},

	_setupDefaultBehaviours: function(root) {
		var self = this;
		if (this.options.clickToFront) {
			root.click(function() {
				self.toTop();
			});
		}
		$('.close', root).click(function() {
			OStatus=false;
			self.hide();
			return false;
		}).mousedown(function(evt) {
			evt.stopPropagation();
		});
	},

	_fire: function(event) {
		this.options[event].call(this);
	}

};
;(function($){

$.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? function(s) {
    s = $.extend({
        top     : 'auto', // auto == .currentStyle.borderTopWidth
        left    : 'auto', // auto == .currentStyle.borderLeftWidth
        width   : 'auto', // auto == offsetWidth
        height  : 'auto', // auto == offsetHeight
        opacity : true,
        src     : 'javascript:false;'
    }, s);
    var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+
                   'style="display:block;position:absolute;z-index:-1;'+
                       (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
                       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
                       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
                       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
                       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
                '"/>';
    return this.each(function() {
        if ( $(this).children('iframe.bgiframe').length === 0 )
            this.insertBefore( document.createElement(html), this.firstChild );
    });
} : function() { return this; });

// old alias
$.fn.bgIframe = $.fn.bgiframe;

function prop(n) {
    return n && n.constructor === Number ? n + 'px' : n;
}

})(jQuery);