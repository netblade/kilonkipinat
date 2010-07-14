var ApplicationBase = function()
{
    
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
        }

    };
};

jQuery.application = new ApplicationBase();
