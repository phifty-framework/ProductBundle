// Generated by CoffeeScript 1.6.3
(function() {
  window.ProductAPI = {};

  ProductAPI.getType = function(id, cb) {
    return $.getJSON('/restful/product_type/' + id, cb);
  };

  ProductAPI.getTypeQuantity = function(id, cb) {
    return $.getJSON('/restful/product_type/' + id, function(data) {
      return cb(data.quantity);
    });
  };

  ProductAPI.getProductTypes = function(productId, cb) {
    return $.getJSON("/restful/product/" + productId, function(data) {
      return cb(data.types);
    });
  };

  ProductAPI.getProduct = function(productId, cb) {
    return $.getJSON("/restful/product/" + productId, cb);
  };

}).call(this);
