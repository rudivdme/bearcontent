(function() {

    BearContent.UI.appendControl(function(parent) {
        parent.find('[data-ba-route]').off('click').on('click', function (e) {
            e.preventDefault();
            if (typeof $(this).attr('href') != 'undefined')
            {
                route($(this).attr('href'));
            }
            else
            {
                route($(this).attr('data-ba-route'));
            }
        });
    });

    BearContent.UI.appendControl(function(parent) {
        parent.find('[data-ba-toggle-route]').attach('click', 'click', function(e) {
			e.preventDefault();

			var elem = $(this);

			if (!$('body').hasClass('has-bear-overlay'))
			{
				if (typeof $(this).attr('href') != 'undefined')
                {
                    route($(this).attr('href'));
                }
                else
                {
                    route($(this).attr('data-ba-toggle-route'));
                }
			}
			else
			{
				BearContent.Route.clearRoute();
			}
		});
	});

    BearContent.UI.appendControl(function(parent) {

        parent.find('.ba-tooltip').each(function() {
            var elem = $(this);
            if (!elem.hasClass('tooltipstered'))
            {
                elem.tooltipster({
                    animation: elem.attr('data-animation') || 'swing',
                    position: elem.attr('data-position') || 'right',
                    theme: elem.attr('data-tooltip-theme') || 'tooltipster-punk',
                    speed: 100,
                    contentAsHTML: true,
                });
            }
        });

    });

    BearContent.UI.appendControl(function(parent) {
        parent.find('[data-auto-submit]').off('change').on('change', function() {
            parent.showLoader();
            BearContent.Data.update();
        });
    });

    BearContent.UI.appendControl(function(parent) {
        parent.find('[data-click-change]').off('click').on('click', function(e) {
            parent.showLoader();
            e.preventDefault();
            parent.find("input[name='"+$(this).data('click-change')+"']").val( $(this).data('value') ).change();
        });
    });

    parent.searchControlTimer = false,

    BearContent.UI.appendControl(function(parent) {
        parent.find('[data-auto-search]').off('keyup').on('keyup', function() {
            clearTimeout(parent.searchControlTimer);
            parent.searchControlTimer = setTimeout(function() {
                BearContent.Data.update();
            }, 500);
        });

        parent.find('[data-auto-search]').each(function(){
            if ($(this).val() != "")
            {
                $(this).focus().val($(this).val());
            }
        });
    });


    BearContent.UI.appendControl(function(parent) {
        parent.find('form').not('.no-ajax').off('submit').on('submit', function(e) {
			e.preventDefault();
			var elem = $(this);

			BearContent.Api.postForm(elem, parent.showFormResponse, elem);

			if (typeof elem.attr('data-clear-store') != 'undefined')
			{
				//localStorage.removeItem(elem.attr('data-store'));
			}
		});
	});

    BearContent.UI.appendControl(function(parent) {
		parent.find('.sk-circle').html('<div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div>');
	});

    BearContent.UI.appendControl(function(parent) {
    	parent.find('.close-and-exit').off('click').on('click', function(e) {
            e.preventDefault();
            var elem = $(this);
            var anim = elem.data('anim') || 'fadeOut';

            $('.bear-content').addClass(anim);

            BearContent.Route.clearRoute();
        });
    });

    BearContent.UI.appendControl(function(parent) {
        parent.find('.close-and-refresh').off('click').on('click', function(e) {
            e.preventDefault();
            var elem = $(this);
            var anim = elem.data('anim') || 'fadeOut';

            parent.find('.bear-content').addClass(anim);

            BearContent.Route.clearRoute(function() {
                if (typeof elem.attr('data-go-to') != 'undefined')
                {
                    location.href = elem.attr('data-go-to');
                }
                else
                {
                    if (typeof $('body').attr('data-no-go') != 'undefined' && $('body').attr('data-no-go') == currentPage)
                    {
                        location.href = BearContent.baseUrl;
                    }
                    else
                    {
                        location.reload();
                    }
                }
            });
        });
    });

    BearContent.UI.appendControl(function(parent) {
        parent.find('[data-post-immediately]').each(function () {
            var container = $(this);
            BearContent.Api.post(container.attr('data-post-immediately'), {_token:BearContent.token}, function(response) {
                BearContent.UI.showResponse(response);
            });
        });
    });

    BearContent.UI.appendControl(function(parent) {
        parent.find('.generate-slug').off('keyup').on('keyup', function(){
            var elem = $(this);
            var value = elem.val().toLowerCase();
            value = value.replace(/\W+/g, '-');
            value = value.replace(/-$/, '');
            parent.find(elem.attr('data-target')).val(value);

        });

        parent.find('.generate-slug').off('change').on('change', function() {
            $(this).keyup();
        });
    });

    BearContent.UI.appendControl(function(parent) {
        //Waves.init();
    });

    BearContent.UI.appendControl(function(parent) {

        parent.find('.ba-image-listing-select').each(function() {

            var container = $(this);
            var input = $(container.attr('data-target'));

            if (input.length > 0 && input.val() != "")
            {
                var selected = container.find("[data-value='"+input.val()+"']");
                selected.addClass('active');
            }

            container.find('a').off('click').on('click', function(e) {
                e.preventDefault();
                var elem = $(this);
                container.find('a').removeClass('active');
                elem.addClass('active');
                input.val(elem.attr('data-value'));
            });
        });
    });

    BearContent.UI.appendControl(function(parent) {

        parent.find("[data-post-url]").off('click').on('click', function(e) {
            e.preventDefault();
            BearContent.Api.post($(this).attr('data-post-url'), {_token:BearContent.token}, parent.showResponse, $(this));
        });

    });

    BearContent.UI.appendControl(function(parent) {

        parent.find('[data-show-modal]').leanModal({
            dismissible: true,
            opacity: .5,
            in_duration: 300,
            out_duration: 200,
        });

    });

    BearContent.UI.appendControl(function(parent) {

        parent.find('.datepicker').each(function() {
            if (typeof $(this).data('datepicker') == 'undefined')
            {
                new Pikaday({ field: $(this)[0], theme: 'bear-theme', format: 'MMM D YYYY', });
                $(this).data('datepicker', true);
            }
        });

    });

}).call(this);