(function() {

    BearContent.UI.appendControl(function(parent) {

        parent.find('.ba-dropdown a').off('click').on('click', function(e) {
            e.preventDefault();

            var elem = $(this);
            var container = elem.parent().parent().parent();
            var display = container.find("[data-display]");
            var input = container.find("input[type='hidden']");

            if (typeof elem.attr('data-clear') != 'undefined')
            {
                container.find('li').removeClass('active');
                display.html(display.data('placeholder'));
                input.val("").trigger('change');
            }
            else
            {
                container.find('li').removeClass('active');
                elem.parent().addClass('active');
                display.html(elem.html());
                input.val(elem.data('value')).trigger('change');
            }
        });

        parent.find('.ba-dropdown').each(function() {
            var container = $(this);
            var display = container.find("[data-display]");
            var input = container.find("input[type='hidden']");
            var search = container.find("input.search");
            display.data('placeholder', display.html())

            if (input.val())
            {
                container.find('li').removeClass('active');
                var elem = container.find("a[data-value='"+input.val()+"']");
                if (elem.length > 0)
                {
                    elem.parent().addClass('active');
                    display.html(elem.html());
                }
            }
            else
            {
                container.find('li').removeClass('active');
                display.html(display.data('placeholder'));
            }

            if (search.length > 0)
            {
                $.searchDropdown(container, "");
            }
        });

        /*
        parent.find('.js-dropdown .dropdown-search-input input').each(function() {

            var elem = $(this);

            elem.off('keyup').on('keyup', function(e) {
                e.preventDefault();
                var dropdown = elem.parent().parent();
                var search = $.searchDropdown(dropdown, elem.val());
            });
        });
        */

    });

}).call(this);