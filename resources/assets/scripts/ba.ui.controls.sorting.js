(function() {

    BearContent.UI.appendControl(function(parent) {

        var sort = parent.find('input[name="filters[sort]"]');
        var order = parent.find('input[name="filters[order]"]');

        if (sort.length > 0 && order.length > 0)
        {
            if (sort.val() != "" && order.val() != "")
            {
                parent.find("[data-sort]").each(function() {
                    $(this).find('i').remove();
                    $(this).removeClass('sorting');
                });

                var current = parent.find("[data-sort='" + sort.val() + "']");

                if (current.length > 0) {
                    current.addClass('sorting');

                    if (order.val() == 'asc') {
                        current.append("<i class='fa fa-sort-up'></i>");
                    }
                    else {
                        current.append("<i class='fa fa-sort-down'></i>");
                    }

                    current.off('click').on('click', function(e){
                        e.preventDefault();
                        order.val(order.val() == 'asc' ? 'desc' : 'asc');
                        BearContent.Data.update();
                    });
                }

                var other = $("[data-sort]").not('.sorting');
                other.append("<i class='ba-fa ba-fa-sort'></i>");

                other.off('click').on('click', function(e){
                    e.preventDefault();
                    sort.val($(this).data('sort'));
                    order.val( typeof $(this).data('order') != 'undefined' ? $(this).data('order') : 'asc');
                    BearContent.Data.update();
                });
            }
        }

    });

}).call(this);