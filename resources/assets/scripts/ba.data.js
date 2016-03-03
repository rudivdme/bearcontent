(function() {
  window.BearContent.Data = {

    init: function() {
        this.clear();
    },

  	update: function(callback)
    {
        var self = this;

        BearContent.UI.find("#bearContent[data-load-store]").each(function() {

            var container = $(this);

            if (container.attr('data-load-store') != "")
            {
                var data = defaults( container.find(".filter") );
                data._token = BearContent.token;

                BearContent.Api.post(container.attr('data-load-store'), data, function(response) {

                    BearContent.Data.set(container.attr('data-store'), response, container.data('key'));

                    if (typeof callback != 'undefined')
                    {
                        callback();
                    }

                    BearContent.UI.update();
                });
            }
        });
    },

    clear: function() {
        Object.keys(localStorage)
          .forEach(function(key){
               if (/^beardata./.test(key)) {
                   localStorage.removeItem(key);
               }
           });
    },

    get: function(key, defaults)
    {
    	var self = this;

        if (typeof defaults != 'undefined')
        {
            var dataDefaults = defaults;
        }

        if (localStorage.getItem(key))
        {
            var dt = JSON.parse(localStorage.getItem(key));

            if (typeof dataDefaults != 'undefined')
            {
                var uptodate = true;

                for (k in dataDefaults)
                {
                    // Bit of a hacky solution but works for now.
                    if (k == 'record')
                    {
                        if (typeof dt[k] != 'undefined')
                        {
                            var record = dt[k];
                            var dfk = dataDefaults[k];

                            for (i in dfk)
                            {
                                if (typeof record[i] == 'undefined' || record[i] == "" || record[i].length == 0)
                                {
                                    record[i] = dfk[i];
                                    uptodate = false;
                                }
                            }
                        }
                        else
                        {
                            dt[k] = dataDefaults[k];
                            uptodate = false;
                        }
                    }
                    else
                    {
                        if (!dt[k])
                        {
                            dt[k] = dataDefaults[k];
                            uptodate = false;
                        }
                    }
                }

                if (!uptodate)
                {
                    self.set(key, dt);
                }
            }

            return dt;
        }
        else
        {
            if (typeof dataDefaults != 'undefined')
            {
                self.set(key, dataDefaults);
                return dataDefaults;
            }
        }

        return {};
    },

    set: function(key, value, subkey)
    {
        if (typeof subkey != 'undefined')
        {
            if (localStorage.getItem(key))
            {
                var dt = JSON.parse(localStorage.getItem(key));
                var skeys = subkey.split('.');

                if (skeys.length == 1) dt[skeys[0]] = value;
                if (skeys.length == 2) dt[skeys[0]][skeys[1]] = value;
                if (skeys.length == 3) dt[skeys[0]][skeys[1]][skeys[2]] = value;

                localStorage.setItem(key, JSON.stringify(dt));
            }
        }
        else
        {
            localStorage.setItem(key, JSON.stringify(value));
        }
    },
  };

  BearContent.Data.init();

}).call(this);