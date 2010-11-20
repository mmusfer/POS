(function($) {
	$.widget("ui.combobox", {
		_create: function() {
			var self = this;
			var select = this.element;
			select.hide();
			var opts = new Array();
			$('option',select).each(function(index) {
				var opt = new Object();
				opt.value = $(this).val();
				opt.label = $(this).text();
				opts[opts.length] = opt;
			});
			var input = $("<input>");
			input.insertAfter(select);
			input.autocomplete({
				source: opts,
				delay: 0,
				change: function(event, ui) {
					if (!ui.item) {
						var enteredString = $(this).val();
						var stringMatch = false;
						for (var i=0; i < opts.length; i++){
							if(opts[i].label.toLowerCase() == enteredString.toLowerCase()){
								select.val(opts[i].value);
								$(this).val(opts[i].label);
								stringMatch = true;
								break;
							}
						}
						if(!stringMatch){
							$(this).val($(':selected',select).text());
						}
						return false;
					}
				},
				select: function(event, ui) {
					select.val(ui.item.value);
					$(this).val(ui.item.label);
					return false;
				},
				open: function(event, ui) {
					input.attr("menustatus","open");
				},
				close: function(event, ui) {
					input.attr("menustatus","closed");
				},
				minLength: 0
			});
			input.addClass("ui-widget ui-widget-content ui-corner-left");
			input.val($(':selected',select).text());
			input.click(function(){
				$(this).val("");
			});
			input.attr("menustatus","closed");
			var form = $(input).parents('form:first');
			$(form).submit(function(e){
				return (input.attr('menustatus') == 'closed');
			});
			var btn = $("<button>&nbsp;</button>");
			btn.attr("title", "Show All Items");
			btn.insertAfter(input);
			btn.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			});
			btn.removeClass("ui-corner-all");
			btn.addClass("ui-corner-right ui-button-icon");
			btn.click(function() {
				if (input.autocomplete("widget").is(":visible")) {
					input.autocomplete("close");
					return false;
				}
				input.autocomplete("search", "");
				input.focus();
				return false;
			});
			btn.css("margin-left","-1px");
			input.css("margin",0);
			input.css("padding","3px 5px");
			btn.css("padding","5px 0").css("width","25px");
			$('span.ui-button-text', btn).css("padding",0);
			input.live("blur", function(event) {
				var autocomplete = $(this).data("autocomplete");
				if (autocomplete.selectedItem) { return; }
				var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i");
				autocomplete.widget().children(".ui-menu-item").each(function() {
					var item = $(this).data("item.autocomplete");
					if (matcher.test(item.label || item.value || item)) {
						autocomplete.selectedItem = item;
						return false;
					}
				});
				if (autocomplete.selectedItem) {
					autocomplete._trigger("select", event, { item: autocomplete.selectedItem });
				}
			});
		}
	});
})(jQuery);