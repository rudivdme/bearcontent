(function() {
  window.BearContent.Api = {

  	post: function(url, data, callback, param) {

  		var self = this;

		BearContent.UI.showLoader(param);
		
		$.ajax({
			type    : "POST",
			url     : url,
			data    : data,
			success : function(response)
			{
				BearContent.UI.hideLoader(param);

				if (typeof callback == 'function') {
					callback(response, param);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {

				BearContent.UI.hideLoader(param);

				if (XMLHttpRequest.responseJSON)
				{
					callback(XMLHttpRequest.responseJSON, param);
				}
				else
				{
					callback({result: false, msg: errorThrown}, param);
				}
			}
		});
	},

	postForm: function(form, callback, param)
	{
		var self = this;

		BearContent.UI.showLoader(param);

		form.ajaxSubmit({
			success : function(response)
			{
				BearContent.UI.hideLoader(param);

				if (typeof callback == 'function') {
					callback(response, param);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {

				BearContent.UI.hideLoader(param);

				if (XMLHttpRequest.responseJSON)
				{
					callback(XMLHttpRequest.responseJSON, param);
				}
				else
				{
					callback({result: false, msg: errorThrown}, param);
				}
			}
		});
	},

  };

}).call(this);