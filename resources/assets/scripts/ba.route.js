(function() {
	BearContent.Route = {

		hasRoute: false,

		init: function() {
			var self = this;

			route.base("#!");

			route.start(true);

			route("/*", function(collection) {
				self.loadRoute(collection);
			});

			route("/*/*", function(collection, id) {
				if (isNumeric(id))
				{
					self.loadRoute(collection, id);
				}
				else
				{
					self.loadRoute(collection+'/'+id);
				}
			});

			route("/*/*/*", function(collection, id, action) {
				self.loadRoute(collection+'/'+action, id);
			});

			self.pageTitle = document.title;
		},

		loadUrl: function (url) {
			window.location.href = url;
		},

		setTitle: function (title)
		{
			document.title = title;
		},

		clearRoute: function (callback)
		{
			document.title = this.pageTitle;
			this.hasRoute = false;
			route("");
			BearContent.UI.closeOverlay(callback);
		},

		loadRoute: function(path, id)
		{
			var content = BearContent.UI.find('#bearContent');
			var routeTemplate = BearContent.UI.find("[data-route-id='" + path + "']");

			if (routeTemplate.length > 0)
			{
				this.hasRoute = true;

				BearContent.UI.showOverlay();

				var store = routeTemplate.attr('data-store') || "";
				var loadStore = routeTemplate.attr('data-load-store') || "";

				if (typeof id != 'undefined' && id != null)
				{
					content.attr('data-id', id);
					store = store.replace('{{id}}', id);
					loadStore = loadStore.replace('{{id}}', id);
				}
				else
				{
					content.attr('data-id', null);
				}

				content.html("");
				content.attr('data-load-route', path);
				content.attr('data-store', store);
				content.attr('data-load-store', loadStore);

				var title = routeTemplate.attr('data-route-title');

				console.log(path);
				console.log(store);
				console.log(loadStore);

				this.setTitle(title);

				BearContent.UI.update(function() {
					BearContent.Data.update();
				});
			}
		}

	};

}).call(this);