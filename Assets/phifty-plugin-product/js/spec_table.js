// Generated by CoffeeScript 1.6.3
(function() {
  var ProductSpecTableItemView, specTableItemTemplate, _ref,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  specTableItemTemplate = CoffeeKup.compile(function() {
    return div({
      "class": "row clearfix",
      style: "margin-bottom: 20px;"
    }, function() {
      input({
        "class": "record-id",
        name: "spec_tables[" + this.id + "][id]",
        type: "hidden",
        value: this.id
      });
      div({
        "class": "col-md-6"
      }, function() {
        return h3(function() {
          return this.title;
        });
      });
      return div({
        "class": "col-md-3"
      }, function() {
        return div({
          "class": "controls"
        }, function() {
          button({
            "data-id": this.id,
            "class": "edit-btn"
          }, function() {
            return "編輯";
          });
          button({
            "data-id": this.id,
            "class": "delete-btn"
          }, function() {
            return "刪除";
          });
          return div({
            "class": "handle",
            style: "border: 1px solid #aaa; background: #d5d5d5; display: inline-block; padding: 1px 5px; "
          }, function() {
            return span({
              "class": "fa fa-sort"
            });
          });
        });
      });
    });
  });

  ProductSpecTableItemView = (function(_super) {
    __extends(ProductSpecTableItemView, _super);

    function ProductSpecTableItemView() {
      _ref = ProductSpecTableItemView.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    ProductSpecTableItemView.prototype.render = function() {
      var $el, config, crudConfig, self;
      self = this;
      config = this.config;
      crudConfig = this.crudConfig;
      console.log(crudConfig);
      $el = $(specTableItemTemplate(this.data));
      $el.find('.edit-btn').click(function(e) {
        var dialog, id;
        id = $(this).data('id');
        dialog = new CRUDDialog('/bs/product_spec_table/crud/dialog', {
          id: id
        }, {
          dialogOptions: {
            width: 850,
            height: 600
          },
          init: crudConfig.init,
          onSuccess: function(resp) {
            var $parent, itemViewClass, newItem;
            $parent = $el.parent();
            $el.remove();
            itemViewClass = ProductSpecTable.ItemView;
            newItem = new itemViewClass(config, resp.data, crudConfig);
            return newItem.appendTo($parent);
          }
        });
        return false;
      });
      $el.find('.delete-btn').click(function(e) {
        runAction(config.deleteAction, {
          id: self.data[config.primaryKey]
        }, {
          confirm: '確認刪除? ',
          remove: $el
        });
        return false;
      });
      return $el;
    };

    return ProductSpecTableItemView;

  })(CRUDList.BaseItemView);

  window.ProductSpecTable = {};

  ProductSpecTable.append = function(data) {};

  ProductSpecTable.ItemView = ProductSpecTableItemView;

}).call(this);
