var ApplicationBase = function()
{
    
    var _self;
    
    var _bindEvents = function()
    {
	
	};
    
    var _buildCorners = function() {
        jQuery('.corners15').corner("round 15px").parent().css('padding', '5px 5px 5px 5px').corner("round 15px");
		jQuery('.corners10').corner("round 10px").parent().css('padding', '5px 5px 5px 5px').corner("round 15px");
		jQuery('.corners5').corner("round 5px").parent().css('padding', '5px 5px 5px 5px').corner("round 15px");
    };

    return {
        init: function()
        {
            _buildCorners();
			
            _self = this;
        },

    };
};

jQuery.application = new ApplicationBase();