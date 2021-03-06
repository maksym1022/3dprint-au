(function ($) {
    vc_reloadTemplateList = function(data) {
        $.ajax({
            type: 'POST',
            url: window.ajaxurl,
            data: data
        }).done(function (html) {
                $('[data-vc-template=list]').html(html);
            });
    };
    $(document).ready(function(){
      $('[data-vc-template=list]').on('click', '[data-templatera_id]', function(e){
        e.preventDefault();
        $.ajax({
          type:'POST',
          url:window.ajaxurl,
          data:{
            action:'templatera_plugin_load',
            template_id:$(this).data('templatera_id')
          },
          dataType: 'html'
        }).done(function (shortcodes) {
            if(_.isEmpty(shortcodes)) return false;
            _.each(vc.filters.templates, function (callback) {
              shortcodes = callback(shortcodes);
            });
            vc.storage.append($.trim(shortcodes));
            vc.shortcodes.fetch({reset: true});
          });
      });
      $('#templatera_save_button').click(function(e){
        e.preventDefault();
        var name = window.prompt(window.VcTemplateI18nLocale.please_enter_templates_name, ''),
          shortcodes = '',
          data;
        if (_.isString(name) && name.length) {
          shortcodes = vc.storage.getContent();
          data = {
            action:'templatera_plugin_save',
            content:shortcodes,
            title:name,
            post_id: $('#post_ID').val()
          };

          vc_reloadTemplateList(data);
        }
      });
    });

    window.VcTemplatera = vc.shortcode_view.extend({
        render: function() {
            window.VcTemplatera.__super__.render.call(this);
            this.$wrapper = this.$el.find('> .wpb_element_wrapper');
            $('<div class="vct_cover"/>').insertBefore(this.$wrapper);
            return this;
        },
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcTextSeparatorView.__super__.changeShortcodeParams.call(this, model);
            if (_.isObject(params) && _.isString(params.id)) {
                this.$wrapper.html('<img src="images/wpspin_light.gif" title="Loading..." class="templatera_loader">');
                $.ajax({
                    type: 'post',
                    url: window.ajaxurl,
                    data: {
                        action: 'wpb_templatera_load_html',
                        id: params.id
                    },
                    context: this
                }).done(function(data_string){
                        this.$wrapper.html('');
                        var data = vc.storage.parseContent({}, data_string);
                        _.each(data, function(shortcode){
                           var model = new Backbone.Model(shortcode);
                           this.appendShortcode(model);
                        }, this);
                    });
            }
        },
        appendShortcode:function (model) {
            var view = this.getView(model),
                position = model.get('order'),
                $element_to_add = model.get('parent_id') !== false ?
                    vc.app.views[model.get('parent_id')].$content
                    :
                    this.$wrapper;
            vc.app.views[model.id] = view;
            if (model.get('parent_id')) {
                var parent_view = vc.app.views[model.get('parent_id')];
                parent_view.unsetEmpty();
            }
            $element_to_add.append(view.render().el);
            view.ready();

            view.changeShortcodeParams(model); // Refactor
            view.checkIsEmpty();
        },
        getView:function (model) {
            var view;
            if (_.isObject(vc.map[model.get('shortcode')]) && _.isString(vc.map[model.get('shortcode')].js_view) && vc.map[model.get('shortcode')].js_view.length) {
                view = new window[window.vc.map[model.get('shortcode')].js_view]({model:model});
            } else {
                view = new vc.shortcode_view({model:model});
            }
            return view;
        },
        changedContent: function() {
            this.$wrapper.find('.templatera_loader').remove();
        }
    });
})(window.jQuery);