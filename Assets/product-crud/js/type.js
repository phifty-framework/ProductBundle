// Generated by CoffeeScript 1.6.3
(function() {
  window.ProductType = {};

  ProductType.newItem = function(data) {
    var $controls, $el;
    $el = $("<li/>").addClass("product-type").css({
      "lineHeight": "200%",
      "white-space": "nowrap",
      "text-overflow": "ellipsis",
      "overflow": "hidden",
      "vertical-align": "middle"
    });
    $el.data("typeId", data.id);
    if (data.icon) {
      $el.append($("<img/>").attr({
        "src": "/" + data.icon,
        "width": 24,
        "height": 24
      }).css({
        "vertical-align": "middle",
        "margin-right": "3px"
      }));
    }
    $el.append($("<span/>").text(data.name).attr("title", data.comment));
    if (data.quantity) {
      $el.append($("<span/>").text(" (剩餘數量:" + data.quantity + ")"));
    }
    if (data.comment) {
      $el.append($("<span/>").text("(" + data.comment + ")"));
    }
    $el.append($("<input/>").attr({
      type: "hidden",
      name: "types[" + data.id + "][id]",
      value: data.id
    }));
    $controls = $("<div/>").addClass("pull-right");
    $controls.append($("<button/>").text("編輯").click(function() {
      ProductType.editItem($el);
      return false;
    }));
    $controls.append($("<button/>").text("刪除").click(function() {
      ProductType.deleteItem($el);
      return false;
    }));
    $el.append($controls);
    return $el;
  };

  ProductType.editItem = function($el) {
    var $wrapper, val;
    $wrapper = $el.parent();
    val = $el.data("typeId");
    return new CRUDDialog("/bs/product_type/crud/dialog", {
      id: val
    }, {
      onSuccess: function(resp) {}
    });
  };

  ProductType.deleteItem = function($el) {
    var val;
    val = $el.data("typeId");
    if (val && confirm("確定要刪除這個類型嗎?")) {
      return runAction("ProductBundle::Action::DeleteProductType", {
        id: val
      }, function(resp) {
        if (resp.success) {
          return $el.remove();
        }
      });
    }
  };

}).call(this);