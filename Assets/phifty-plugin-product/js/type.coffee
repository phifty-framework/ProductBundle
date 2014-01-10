
window.ProductType = {}
ProductType.newItem = (data) ->
  $el = $("<li/>").addClass("product-type").css(lineHeight: "200%")
  $el.data "typeId", data.id
  $el.append $("<span/>").text(data.name).attr("title", data.comment)
  $el.append $("<span/>").text(" (剩餘數量:" + data.quantity + ")")  if data.quantity
  $el.append $("<span/>").text("(" + data.comment + ")")  if data.comment
  $el.append $("<input/>").attr(
    type: "hidden"
    name: "types[" + data.id + "][id]"
    value: data.id
  )
  $controls = $("<div/>").addClass("pull-right")
  $controls.append $("<button/>").text("編輯").click(->
    ProductType.editItem $el
    false
  )
  $controls.append $("<button/>").text("刪除").click(->
    ProductType.deleteItem $el
    false
  )
  $el.append $controls
  $el

ProductType.editItem = ($el) ->
  $wrapper = $el.parent()
  val = $el.data("typeId")
  new CRUDDialog("/bs/product_type/crud/dialog",
    id: val
  ,
    onSuccess: (resp) ->
  )


#
#            $el.remove();
#            var $newEl = ProductType.newItem(resp.data);
#            $wrapper.prepend($newEl);

ProductType.deleteItem = ($el) ->
  val = $el.data("typeId")
  if val and confirm("確定要刪除這個類型嗎?")
    runAction "ProductBundle::Action::DeleteProductType",
      id: val
    , (resp) ->
      $el.remove()  if resp.success
