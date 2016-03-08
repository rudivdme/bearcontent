(function() {

    BearContent.UI.appendControl(function(parent) {

        BearContent.UI.appendControl(function(parent) {

            parent.find('.dd').each(function() {
                var list = $(this);
                var group = list.attr('data-group');
                list.nestable({
                    maxDepth: 2,
                    group: group,
                    expandBtnHTML: '<button data-action="expand" type="button" class="btn default collapse-toggle dd-control"><i class="fa fa-plus"></i></button>',
                    collapseBtnHTML: '<button data-action="collapse" type="button" class="btn default collapse-toggle dd-control"><i class="fa fa-minus"></i></button>',
                });
                list.nestable('collapseAll');
                parent.find(list.attr('data-target')).val(JSON.stringify(list.nestable('serialize')));
            });

            parent.find('.dd').on('change', function() {
                var list = $(this);
                parent.find(list.attr('data-target')).val(JSON.stringify(list.nestable('serialize')));
            });
        });

        BearContent.UI.appendControl(function(parent) {

            parent.find('.modal [data-save]').off('click').on('click', function(e) {
                e.preventDefault();
                var elem = $(this);
                var title = elem.parent().find("input[name='title']");
                var url = elem.parent().find("input[name='url']");
                var target = parent.find(elem.attr('data-target'));
                target.data('title', title.val());
                target.data('url', url.val());
                target.find('.dd-title span').html(title.val());
                var list = parent.find(target.attr('data-list'));
                parent.find(list.attr('data-target')).val(JSON.stringify(list.nestable('serialize')));
            });
        });

    });

}).call(this);