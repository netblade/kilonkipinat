jQuery.fn.formToDict = function() {
    var fields = this.serializeArray();
    var json = {}
    for (var i = 0; i < fields.length; i++) {
        json[fields[i].name] = fields[i].value;
    }
    if (json.next) delete json.next;
    return json;
};

jQuery.fn.disable = function() {
    this.enable(false);
    return this;
};

jQuery.fn.enable = function(opt_enable) {
    if (arguments.length && !opt_enable) {
        this.attr("disabled", "disabled");
    } else {
        this.removeAttr("disabled");
    }
    return this;
};

jQuery.postJSON = function(url, args, callback, error_callback) {
    jQuery.ajax({url: url, data: jQuery.param(args), dataType: "text", type: "POST",
        success: function(response) {
            callback(response);
    }, error: error_callback});
}

var ApplicationBase = function()
{
    var _config = {
		todoitem_show_url: '/midcom-exec-fi.kilonkipinat.todos/show_item.php',
		todoitem_change_status_url: '/midcom-exec-fi.kilonkipinat.todos/change_status.php',
		todoitem_comment_url: '/midcom-exec-fi.kilonkipinat.todos/comment_item.php',
		todoitem_subscribe_url: '/midcom-exec-fi.kilonkipinat.todos/subscribe.php'
	};

    var _self;
    
    var _bindEvents = function()
    {
	
	};
    
    var _buildCorners = function() {
        jQuery('.corners15').corner("round 15px").parent().css('padding', '5px 5px 5px 5px').corner("round 15px");
		jQuery('.corners10').corner("round 10px").parent().css('padding', '5px 5px 5px 5px').corner("round 10px");
		jQuery('.corners5').corner("round 5px").parent().css('padding', '5px 5px 5px 5px').corner("round 5px");
    };
    
    var _buildTableSorters = function() {
        jQuery.tablesorter.defaults.widgets = ['zebra'];
        jQuery.tablesorter.addParser({
                // set a unique id
                id: 'fiDate',
                is: function(s) {
                    // return false so this parser is not auto detected
                    return false;
                },
                format: function(s) {
                    // format your data for normalization
                    s = s.replace(/\./g,"_");
                    s = s.replace(/(\d{1,2})[\_](\d{1,2})[\_](\d{4})/, "$3/$2/$1");
                    date = new Date(s).getTime();
                    return jQuery.tablesorter.formatFloat(date);
                },
                // set type, either numeric or text
                type: 'numeric'
            });
        jQuery('.tablesorter').tablesorter({dateFormat: "fi", sortMultiSortKey: 'altKey'});
    };

    return {
        init: function()
        {
            _buildCorners();

            _buildTableSorters();
			
            _self = this;
            
            this._load_togglers();

			this._load_todo_modals();
        },
        _load_togglers: function() {
            jQuery('.fi_kilonkipinat_website_toggler_container').each(function() {
                var tmp_parent = this;
                jQuery('.fi_kilonkipinat_website_toggler_trigger', this).click(function() {
                    jQuery('.fi_kilonkipinat_website_toggler_content', tmp_parent).toggle('slow');
                });
            });
        },
		_load_todo_modals: function() {
			jQuery('.fi_kilonkipinat_todos_todoitem_modal_link').click(function() {
				var tmp = jQuery(this).attr('href');
				var tmp2 = tmp.split('#');
				var guid = tmp2[1];
				
				var json = {};
                json['todoitem_guid'] = guid;

                jQuery.postJSON(_config.todoitem_show_url, json, function(response) {
                    _self._showTodoContent(guid, response);
                });

				return false;
			});
		},
		_showTodoContent: function(guid, response) {
			var self = this;

			jQuery("#fi_kilonkipinat_todos_info_container").html(response);

            jQuery("#fi_kilonkipinat_todos_info_container").modal({
                overlayClose:true,
                minHeight: 500,
                minWidth: 700,
                maxHeight: 500,
                maxWidth: 700,
                height: 500,
                width: 700
            });

			var comment_form = jQuery("#n_n_comments_comment_form form");

			jQuery(comment_form).attr({'action':_config.todoitem_comment_url});
			jQuery(comment_form).append('<input type="hidden" name="todoitem_guid" value="'+guid+'" />');
			jQuery(comment_form).append('<input type="hidden" name="return_url" value="'+document.location.href+'" />');

		},
		changeTodoStatus: function(new_status, guid) {
			var json = {};
            json['todoitem_guid'] = guid;
            json['new_status'] = new_status;

            jQuery.postJSON(_config.todoitem_change_status_url, json, function(null_response) {
                jQuery.postJSON(_config.todoitem_show_url, json, function(response) {
                    _self._showTodoContent(guid, response);
                });
            });
			return false;
		},
		subscribeToTodo: function(guid, action) {
			var json = {};
            json['todoitem_guid'] = guid;
            json['action'] = action;

            jQuery.postJSON(_config.todoitem_subscribe_url, json, function(null_response) {
                jQuery.postJSON(_config.todoitem_show_url, json, function(response) {
                    _self._showTodoContent(guid, response);
                });
            });
			return false;
		}
    };
};

jQuery.application = new ApplicationBase();
