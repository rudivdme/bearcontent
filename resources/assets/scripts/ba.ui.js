(function() {
  window.BearContent.UI = {

    _container: BearContent.container,

    _controls: [],

    init: function() {
        this.controls();
    },

    appendControl: function(control) {
        this._controls.push(control);
    },

    controls: function() {
        var self = BearContent.UI;
        this._controls.forEach(function(control) {
            control(self);
        });
    },

    find: function(selector) {
        return this._container.find(selector);
    },

    element: function() {
        return this._container;
    },

    update: function(callback)
    {
        var self = BearContent.UI;

        self.updateTemplates(function() {

            BearContent.UI.controls();

            if (typeof callback != 'undefined')
            {
                callback();
            }
        });
    },

    updateTemplates: function(callback)
    {
        var self = BearContent.UI;

        self.find("[data-load-route]").each(function() {
            var elem = $(this);
            var targetRoute   = elem.attr('data-load-route');
            var source   = self.find("[data-route-id='" + targetRoute + "']").html();
            var template = Handlebars.compile(source);
            if (typeof elem.attr('data-id') != 'undefined')
            {
                var defaults = {record:{id:elem.attr('data-id')}};
            }
            var html = template( BearContent.Data.get( elem.attr('data-store'), defaults ) );
            elem.html(html);
        });

        if (typeof callback == 'function')
        {
            callback();
        }
    },

    showLoader: function(elem) {
        if (typeof elem != 'undefined' && elem.length > 0)
        {
            // May be a form element passed in
            if (elem.attr('action') != undefined)
            {
                var button = elem.find("[type='submit']");
            }
            else
            {
                var button = elem;
            }
            button.data('html-content', button.html());
            button.html("<div class='three-quarters-loader'></div>");
        }
        BearContent.UI.find(".bear-loader-hide").hide();
        BearContent.UI.find(".bear-loader").show();
    },

    hideLoader: function(elem) {
        if (typeof elem != 'undefined' && elem.length > 0)
        {
            if (elem.attr('action') != undefined)
            {
                var button = elem.find("[type='submit']");
            }
            else
            {
                var button = elem;
            }
            button.html( button.data('html-content') );
        }
        BearContent.UI.find(".bear-loader-hide").show();
        BearContent.UI.find(".bear-loader").hide();
    },

    showOverlay: function(callback) {
        var self = BearContent.UI;
        var content = self.find('#bearContent');
        content.html("");
        self.find('.ba-overlay').show();
        $('body').addClass('has-bear-overlay');
        if (typeof callback == 'function')
        {
            callback();
        }
    },

    closeOverlay: function(callback) {
        var self = BearContent.UI;
        var content = self.find('#bearContent');
        content.html("");
        content.attr('data-load-route', null);
        self.find('.ba-overlay').hide();
        $('body').removeClass('has-bear-overlay');
        if (typeof callback == 'function')
        {
            callback();
        }
    },

    showResponse: function(response, elem)
    {
        var self = BearContent.UI;

        console.log(elem);

        try
        {
            if (response.result)
            {
                self.showNotification("success", response.msg);

                if (typeof response.url != 'undefined')
                {
                    BearContent.Route.loadUrl(response.url);
                }

                if (typeof elem != 'undefined' && typeof elem.attr('data-reload-url') != 'undefined')
                {
                    BearContent.Route.loadUrl(elem.attr('data-reload-url'));
                }

                if (typeof elem != 'undefined' && (typeof elem.attr('data-load-data') != 'undefined' || typeof elem.attr('data-post-url') != 'undefined'))
                {
                    BearContent.Data.update();
                }

                if (typeof elem != 'undefined' && typeof elem.attr('data-done-route') != 'undefined')
                {
                    var path = elem.attr('data-done-route');

                    if (typeof response.record != 'undefined')
                    {
                        path = path.replace('{id}', response.record.id);
                    }

                    if (BearContent.Route.isCurrent(path))
                    {
                        BearContent.Data.update();
                    }
                    else
                    {
                        route(path);
                    }
                }

                if (typeof elem != 'undefined' && typeof elem.attr('data-encourage-refresh') != 'undefined')
                {
                    self.element().addClass('bear-needs-refresh');
                }
            }
            else
            {
                if (typeof response.request_confirmation != 'undefined' && response.request_confirmation)
                {
                    swal({
                        title: "Please Confirm",
                        text: response.msg,
                        showCancelButton: true,
                        confirmButtonColor: "#f71169",
                        confirmButtonText: "Yes, do it!",
                        cancelButtonText: "No, wait.",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            BearContent.Api.post(elem.attr('data-post-url'), {confirmed: true, _token: BearContent.token}, self.showResponse, elem);
                        }
                    });
                }
                else
                {
                    self.showNotification("error", response.msg);
                }
            }
        }
        catch (e) {

            self.showNotification("danger", "An unknown error occured while processing your request.");
        }
    },

    showFormResponse: function(response, form)
    {
        var self = BearContent.UI;

        self.resetForm(form);

        try
        {
            if (response.result) {

                self.showNotification("success", response.msg);

                if (typeof response.url != 'undefined')
                {
                    BearContent.Route.loadUrl(response.url);
                }

                if (typeof form != 'undefined' && typeof form.attr('data-load-data') != 'undefined')
                {
                    BearContent.Data.update();
                }

                if (typeof form != 'undefined' && typeof form.attr('data-done-route') != 'undefined')
                {
                    var path = form.attr('data-done-route');
                    var orig = form.attr('data-done-route');
                    orig = orig.replace('/{id}', '');

                    if (typeof response.record != 'undefined')
                    {
                        path = path.replace('{id}', response.record.id);
                    }

                    if (BearContent.Route.isCurrent(orig))
                    {
                        BearContent.Data.update();
                    }
                    else
                    {
                        route(path);
                    }
                }

                if (typeof form != 'undefined' && typeof form.attr('data-encourage-refresh') != 'undefined')
                {
                    self.element().addClass('bear-needs-refresh');
                }
            }
            else
            {
                if (typeof response.request_confirmation != 'undefined' && response.request_confirmation)
                {
                    swal({
                        title: "Please Confirm",
                        text: response.msg,
                        showCancelButton: true,
                        confirmButtonColor: "#f71169",
                        confirmButtonText: "Yes, do it!",
                        cancelButtonText: "No, wait.",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            form.append("<input type='hidden' name='confirmed' value='true' />");
                            BearContent.Api.postForm(form, self.showFormResponse.bind(self), form);
                        }
                    });
                }
                else
                {
                    self.showNotification("error", response.msg);
                }

                self.find(".on-error-hide").hide();
                self.find(".on-error-show").show();

                if (typeof response.fields != 'undefined')
                {
                    self.showFormErrorFields(form, response.fields);
                }
                else if (typeof response.errors != 'undefined')
                {
                    self.showFormErrors(form, response.errors);
                }
            }
        }
        catch (e) {

            self.showNotification("danger", "An unknown error occured while processing your request.");
        }
    },

    showFormErrorFields: function(form, fields) {

        $.each(fields, function(key, value) {

            var field = form.find("[data-field-name='" + value + "']").parent();
            field.addClass('has-error');
        });

        form.find("[type='submit']").removeClass('btn-primary').addClass('btn-danger');
    },

    showFormErrors: function(form, errors) {

        $.each(errors, function(key, value) {

            var elem = form.find("[data-field-name='" + key + "']");
            var field = elem.parent();
            field.addClass('has-error');

            var list = "<ul class='ba-form-errors-list filled'>";

            $.each(value, function(k, error) {
                list += "<li>"+error+"</li>";
            });

            list += "</ul>";
            field.append(list);
        });

        form.find("[type='submit']").removeClass('blue').addClass('red');
    },

    resetForm: function(form)
    {
        form.find('.has-error').find('.ba-form-errors-list').remove();

        form.find('.has-error').removeClass('has-error');

        form.find("[type='submit']").removeClass('red').addClass('blue');

        form.find(".nav-tabs li").removeClass('has-error');
    },

    showNotification: function(type, message, callback) {
        var self = this;

        BearContent.toast(message, 10000, type);
    },

  };

}).call(this);