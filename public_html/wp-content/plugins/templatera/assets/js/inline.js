var templatera_editor;
(function ($) {
  var TemplateraEditorView = vc.TemplatesEditorPanelView.extend({
    events: {
      'click [data-dismiss=panel]': 'hide',
      'mouseover [data-transparent=panel]': 'addOpacity',
      'mouseout [data-transparent=panel]': 'removeOpacity',
      'click .wpb_remove_template':'removeTemplate',
      'click [data-templatera_id]':'loadTemplate',
      'click #vc-template-save':'saveTemplate'
    },
    render: function() {
      this.$name = $('#vc-templatera-name');
      this.$list = $('#vc-templatera-list');
      return this;
    },
    /**
     * Load saved template from server.
     * @param e - Event object
     */
    loadTemplate:function (e) {
      e && e.preventDefault();
      var $button = $(e.currentTarget);
      $.ajax({
        type:'POST',
        url:window.ajaxurl,
        data:{
          action:'templatera_plugin_load_inline',
          template_id: $button.data('templatera_id'),
          post_id: vc.post_id
        },
        context: this
      }).done(function (html) {
          var $html = $(html),
            template = $($html.get(0)).html(),
            data = JSON.parse($($html.get(1)).text());
          vc.builder.buildFromTemplate(template, data);
          this.showMessage(window.i18nLocale.template_added, 'success');
        });
    },
    /**
     * Save current shortcode design as template with title.
     * @param e - Event object
     */
    saveTemplate:function (e) {
      e.preventDefault();
      var name = this.$name.val(),
        data, shortcodes;
      if (_.isString(name) && name.length) {
        shortcodes = vc.builder.getContent();
        if(!shortcodes.trim().length) {
          this.showMessage(window.i18nLocale.template_is_empty, 'error');
          return false;
        }
        data = {
          action:'templatera_plugin_save',
          content:shortcodes,
          title:name,
          post_id: vc.post_id
        };
        this.$name.val('');
        this.showMessage(window.i18nLocale.template_save, 'success');
        this.reloadTemplateList(data);
      } else {
        this.showMessage(window.i18nLocale.please_enter_templates_name, 'error');
      }
    },
    /**
     * Remove template from server database.
     * @param e - Event object
     */
    removeTemplate:function (e) {
      e && e.preventDefault();
      var $button = $(e.currentTarget);
      var template_name = $button.closest('.wpb_template_li').find('a').text();
      var answer = confirm(window.i18nLocale.confirm_deleting_template.replace('{template_name}', template_name));
      if (answer) {
        // this.reloadTemplateList(data);
        $.post(window.ajaxurl, {
          action:'templatera_plugin_delete',
          template_id:$button.attr('rel')
        });
        $button.closest('.wpb_template_li').remove();
      }
    }
  });
  $(document).ready(function(){
    console.log('test');
    templatera_editor = new TemplateraEditorView({el: $('#vc-templatera-editor')});
    $('#vc-templatera-editor-button').click(function(e){
      e && e.preventDefault && e.preventDefault();
      templatera_editor.render().show();
    });
  });
})(window.jQuery);