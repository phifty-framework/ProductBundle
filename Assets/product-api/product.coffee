window.ProductAPI = {}

ProductAPI.getType = (id, cb) -> $.getJSON '/restful/product_type/' + id, cb
ProductAPI.getTypeQuantity = (id, cb) -> $.getJSON '/restful/product_type/' + id, (data) -> cb(data.quantity)

ProductAPI.getProductTypes = (productId, cb) ->
  $.getJSON "/restful/product/" + productId, (data) -> cb(data.types)

ProductAPI.getProduct = (productId, cb) -> $.getJSON "/restful/product/" + productId, cb


