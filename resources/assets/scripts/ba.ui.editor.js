(function() {

    BearContent.UI.imageUploader = function imageUploader(dialog) {
        var image, xhr, xhrComplete, xhrProgress;

        dialog.bind('imageUploader.cancelUpload', function () {
            // Cancel the current upload

            // Stop the upload
            if (xhr) {
                xhr.upload.removeEventListener('progress', xhrProgress);
                xhr.removeEventListener('readystatechange', xhrComplete);
                xhr.abort();
            }

            // Set the dialog to empty
            dialog.state('empty');
        });

        dialog.bind('imageUploader.clear', function () {
            // Clear the current image
            dialog.clear();
            image = null;
        });

        dialog.bind('imageUploader.fileReady', function (file) {
            // Upload a file to the server
            var formData;

            // Define functions to handle upload progress and completion
            xhrProgress = function (ev) {
                // Set the progress for the upload
                dialog.progress((ev.loaded / ev.total) * 100);
            }

            xhrComplete = function (ev) {
                var response;

                // Check the request is complete
                if (ev.target.readyState != 4) {
                    return;
                }

                // Clear the request
                xhr = null
                xhrProgress = null
                xhrComplete = null

                // Handle the result of the upload
                if (parseInt(ev.target.status) == 200) {
                    // Unpack the response (from JSON)
                    response = JSON.parse(ev.target.responseText);

                    // Store the image details
                    image = {
                        id: response.record.id,
                        width: response.record.width,
                        height: response.record.height,
                        url: BearContent.baseUrl + '/uploads/'+response.record.filename
                    };

                    // Populate the dialog
                    dialog.populate(image.url, [image.width, image.height]);

                } else {
                    // The request failed, notify the user
                    new ContentTools.FlashUI('no');
                }
            }

            // Set the dialog state to uploading and reset the progress bar to 0
            dialog.state('uploading');
            dialog.progress(0);

            // Build the form data to post to the server
            formData = new FormData();
            formData.append('file', file);
            formData.append('_token', BearContent.token);

            // Make the request
            xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', xhrProgress);
            xhr.addEventListener('readystatechange', xhrComplete);
            xhr.open('POST', BearContent.baseUrl+'/bear/image', true);
            xhr.send(formData);
        });

        function rotateImage(direction) {
            // Request a rotated version of the image from the server
            var formData;

            // Define a function to handle the request completion
            xhrComplete = function (ev) {
                var response;

                // Check the request is complete
                if (ev.target.readyState != 4) {
                    return;
                }

                // Clear the request
                xhr = null
                xhrComplete = null

                // Free the dialog from its busy state
                dialog.busy(false);

                // Handle the result of the rotation
                if (parseInt(ev.target.status) == 200) {
                    // Unpack the response (from JSON)
                    response = JSON.parse(ev.target.responseText);

                    // Store the image details (use fake param to force refresh)
                    image = {
                        id: response.record.id,
                        width: response.record.width,
                        height: response.record.height,
                        url: BearContent.baseUrl + '/uploads/'+ response.record.filename + '?_ignore=' + Date.now()
                    };

                    // Populate the dialog
                    dialog.populate(image.url, [image.width, image.height]);

                } else {
                    // The request failed, notify the user
                    new ContentTools.FlashUI('no');
                }
            }

            // Set the dialog to busy while the rotate is performed
            dialog.busy(true);

            // Build the form data to post to the server
            formData = new FormData();
            formData.append('id', image.id);
            formData.append('direction', direction);
            formData.append('_token', BearContent.token);

            // Make the request
            xhr = new XMLHttpRequest();
            xhr.addEventListener('readystatechange', xhrComplete);
            xhr.open('POST', BearContent.baseUrl+'/bear/image/rotate', true);
            xhr.send(formData);
        }

        dialog.bind('imageUploader.rotateCCW', function () {
            rotateImage('CCW');
        });

        dialog.bind('imageUploader.rotateCW', function () {
            rotateImage('CW');
        });

        dialog.bind('imageUploader.save', function () {
            var crop, cropRegion, formData;

            // Define a function to handle the request completion
            xhrComplete = function (ev) {
                // Check the request is complete
                if (ev.target.readyState !== 4) {
                    return;
                }

                // Clear the request
                xhr = null
                xhrComplete = null

                // Free the dialog from its busy state
                dialog.busy(false);

                // Handle the result of the rotation
                if (parseInt(ev.target.status) === 200) {
                    // Unpack the response (from JSON)
                    var response = JSON.parse(ev.target.responseText);

                    // Trigger the save event against the dialog with details of the
                    // image to be inserted.
                    dialog.save(
                        BearContent.baseUrl + '/uploads/'+ response.record.filename + '?_ignore=' + Date.now(),
                        [response.record.width, response.record.height],
                        {
                            'alt': response.alt,
                            'data-ce-max-width': response.record.width
                        });

                } else {
                    // The request failed, notify the user
                    new ContentTools.FlashUI('no');
                }
            }

            // Set the dialog to busy while the rotate is performed
            dialog.busy(true);

            // Build the form data to post to the server
            formData = new FormData();
            formData.append('id', image.id);
            formData.append('url', image.url);
            formData.append('_token', BearContent.token);

            // Set the width of the image when it's inserted, this is a default
            // the user will be able to resize the image afterwards.
            formData.append('width', 600);

            // Check if a crop region has been defined by the user
            if (dialog.cropRegion()) {
                formData.append('crop', dialog.cropRegion());
            }

            // Make the request
            xhr = new XMLHttpRequest();
            xhr.addEventListener('readystatechange', xhrComplete);
            xhr.open('POST', BearContent.baseUrl+'/bear/image/insert', true);
            xhr.send(formData);
        });
    }

    BearContent.UI.appendControl(function(parent) {

        if (typeof parent.editor == 'undefined')
        {
            var saveUrl = parent.element().attr('data-save-url');

            ContentTools.StylePalette.add([
                new ContentTools.Style('Lead Paragraph', 'lead', ['p']),
                new ContentTools.Style('Video Thumbnail', 'video-thumbnail', ['img']),
                new ContentTools.Style('Button', 'btn', ['a', 'p']),
                new ContentTools.Style('Button Primary', 'btn-primary', ['a', 'p']),
                new ContentTools.Style('Button Large', 'btn-lg', ['a', 'p']),
                new ContentTools.Style('Margin Top', 'margin-top', ['a', 'p']),
            ]);
            ContentTools.IMAGE_UPLOADER = BearContent.UI.imageUploader;
            parent.editor = ContentTools.EditorApp.get();
            parent.editor.init('*[data-editable]', 'data-name');

            var editorCls = ContentTools.EditorApp.getCls();
            parent.editor.start = function () {
                editorCls.prototype.start.call(this);
                parent.editor.trigger('start');
            }

            parent.editor.stop = function () {
                editorCls.prototype.stop.call(this);
                parent.editor.trigger('stop');
            }

            parent.editor.bind('save', function (regions) {
                regions._token = BearContent.token;
                BearContent.Api.post(saveUrl, regions, BearContent.UI.showResponse);
            });

            parent.editor.bind('start', function () {
                parent.find('.bear-tools').hide();
                parent.find('.bear-editing').addClass('active');
                if (typeof App != 'undefined' && typeof App.initEditing == 'function')
                {
                    App.initEditing();
                }
            });

            parent.editor.bind('stop', function () {
                parent.find('.bear-tools').show();
                parent.find('.bear-editing').removeClass('active');
                if (typeof App != 'undefined' && typeof App.init == 'function')
                {
                    App.init();
                }
            });

            parent.find('[data-editor-start]').off('click').on('click', function(e) {
                e.preventDefault();
                parent.editor._ignition.trigger('start');
            });

            parent.find('[data-editor-cancel]').off('click').on('click', function(e) {
                e.preventDefault();
                parent.editor._ignition.trigger('stop', false);
            });

            parent.find('[data-editor-save]').off('click').on('click', function(e) {
                e.preventDefault();
                parent.editor._ignition.trigger('stop', true);
            });

        }
    });
}).call(this);

(function() {
  var _Root, _TagNames, _mergers,
    __slice = [].slice,
    __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

    ContentTools.Tools.Heading1 = (function(_super) {
        __extends(Heading1, _super);

        function Heading1() {
          return Heading1.__super__.constructor.apply(this, arguments);
        }

        ContentTools.ToolShelf.stow(Heading1, 'heading1');

        Heading1.label = 'Heading Size 1';

        Heading1.icon = 'heading1';

        Heading1.tagName = 'h1';

        Heading1.canApply = function(element, selection) {
          return element.content !== void 0 && element.parent().type() === 'Region';
        };

        Heading1.apply = function(element, selection, callback) {
          var content, insertAt, parent, textElement;
          element.storeState();
          if (element.type() === 'PreText') {
            content = element.content.html().replace(/&nbsp;/g, ' ');
            textElement = new ContentEdit.Text(this.tagName, {}, content);
            parent = element.parent();
            insertAt = parent.children.indexOf(element);
            parent.detach(element);
            parent.attach(textElement, insertAt);
            element.blur();
            textElement.focus();
            textElement.selection(selection);
          } else {
            element.tagName(this.tagName);
            element.restoreState();
          }
          return callback(true);
        };

        return Heading1;

    })(ContentTools.Tool);

    ContentTools.Tools.Heading2 = (function(_super) {
        __extends(Heading2, _super);

        function Heading2() {
          return Heading2.__super__.constructor.apply(this, arguments);
        }

        ContentTools.ToolShelf.stow(Heading2, 'heading2');

        Heading2.label = 'Heading Size 2';

        Heading2.icon = 'heading2';

        Heading2.tagName = 'h2';

        Heading2.canApply = function(element, selection) {
          return element.content !== void 0 && element.parent().type() === 'Region';
        };

        Heading2.apply = function(element, selection, callback) {
          var content, insertAt, parent, textElement;
          element.storeState();
          if (element.type() === 'PreText') {
            content = element.content.html().replace(/&nbsp;/g, ' ');
            textElement = new ContentEdit.Text(this.tagName, {}, content);
            parent = element.parent();
            insertAt = parent.children.indexOf(element);
            parent.detach(element);
            parent.attach(textElement, insertAt);
            element.blur();
            textElement.focus();
            textElement.selection(selection);
          } else {
            element.tagName(this.tagName);
            element.restoreState();
          }
          return callback(true);
        };

        return Heading2;

    })(ContentTools.Tool);

    ContentTools.Tools.Heading3 = (function(_super) {
        __extends(Heading3, _super);

        function Heading3() {
          return Heading3.__super__.constructor.apply(this, arguments);
        }

        ContentTools.ToolShelf.stow(Heading3, 'heading3');

        Heading3.label = 'Heading Size 3';

        Heading3.icon = 'heading3';

        Heading3.tagName = 'h3';

        Heading3.canApply = function(element, selection) {
          return element.content !== void 0 && element.parent().type() === 'Region';
        };

        Heading3.apply = function(element, selection, callback) {
          var content, insertAt, parent, textElement;
          element.storeState();
          if (element.type() === 'PreText') {
            content = element.content.html().replace(/&nbsp;/g, ' ');
            textElement = new ContentEdit.Text(this.tagName, {}, content);
            parent = element.parent();
            insertAt = parent.children.indexOf(element);
            parent.detach(element);
            parent.attach(textElement, insertAt);
            element.blur();
            textElement.focus();
            textElement.selection(selection);
          } else {
            element.tagName(this.tagName);
            element.restoreState();
          }
          return callback(true);
        };

        return Heading3;

    })(ContentTools.Tool);

    ContentTools.DEFAULT_TOOLS[1].remove('heading');
    ContentTools.DEFAULT_TOOLS[1].remove('subheading');

    ContentTools.DEFAULT_TOOLS[1].unshift('heading3');
    ContentTools.DEFAULT_TOOLS[1].unshift('heading2');
    ContentTools.DEFAULT_TOOLS[1].unshift('heading1');

}).call(this);