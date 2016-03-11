(function() {

	if (typeof BearContent != 'undefined')
	{

		Handlebars.registerPartial('baControls', '<button class="btn-floating btn-medium default pull-right close-and-exit ml8 ba-tooltip waves-effect" title="I\'m done here." data-position="bottom"><i class="fa fa-close"></i></button><button class="btn-floating btn-medium pink pull-right close-and-refresh ml8 ba-tooltip  waves-effect" title="Close & Refresh!" data-position="bottom"><i class="fa fa-refresh"></i></button>');

		if ($("#menu-item-form-template").length > 0)
		{
			Handlebars.registerPartial("menuItemForm", $("#menu-item-form-template").html());
		}

		if ($("#menu-item-template").length > 0)
		{
			Handlebars.registerPartial("menuItem", $("#menu-item-template").html());
		}

		if ($("#pagination-template").length > 0)
		{
			Handlebars.registerPartial("paginator", $("#pagination-template").html());

			Handlebars.registerHelper('pagination', function(currentPage, totalPage, size, options) {
			    var startPage, endPage, context;

			    if (arguments.length === 3) {
			            options = size;
			            size = 5;
			    }

			    startPage = currentPage - Math.floor(size / 2);
			    endPage = currentPage + Math.floor(size / 2);

			    if (startPage <= 0) {
			            endPage -= (startPage - 1);
			            startPage = 1;
			    }

			    if (endPage > totalPage) {
			            endPage = totalPage;
			            if (endPage - size + 1 > 0) {
			                    startPage = endPage - size + 1;
			            } else {
			                    startPage = 1;
			            }
			    }

			    context = {
			            startFromFirstPage: false,
			            pages: [],
			            endAtLastPage: false,
			    };
			    if (startPage === 1) {
			            context.startFromFirstPage = true;
			    }

			    if (currentPage === 1) {
			            context.isFirstPage = true;
			    }
			    else
			    {
			            context.prevPage = currentPage - 1;
			    }
			    for (var i = startPage; i <= endPage; i++) {
			            context.pages.push({
			                    page: i,
			                    isCurrent: i === currentPage,
			            });
			    }
			    if (endPage === totalPage) {
			            context.endAtLastPage = true;
			    }

			    if (currentPage === totalPage) {
			            context.isLastPage = true;
			    }
			    else
			    {
			            context.nextPage = currentPage + 1;
			    }

			    return options.fn(context);
			});
		}
	}

}).call(this);