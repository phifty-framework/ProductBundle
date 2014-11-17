specTableItemTemplate = CoffeeKup.compile ->
  div class: "row clearfix", style: "margin-bottom: 20px;" , ->
    input class:"record-id", name: "spec_tables[#{ @id }][id]", type: "hidden", value: @id

    div class: "col-md-6", ->
      h3 -> @title

    div class: "col-md-3", ->
      div class: "controls", ->
        button "data-id": @id, class: "edit-btn", -> "編輯"
        button "data-id": @id, class: "delete-btn", -> "刪除"
        div class:"handle", style: "border: 1px solid #aaa; background: #d5d5d5; display: inline-block; padding: 1px 5px; ", ->
          span class: "fa fa-sort"

class ProductSpecTableItemView extends CRUDList.BaseItemView
  render: ->
    self = this
    config = @config
    crudConfig = @crudConfig
    console.log(crudConfig)

    $el = $(specTableItemTemplate(@data))

    $el.find('.edit-btn').click (e) ->
      id = $(this).data('id')
      dialog = new CRUDDialog '/bs/product_spec_table/crud/dialog', { id: id },
        dialogOptions: { width: 850, height: 600 }
        init: crudConfig.init
        onSuccess: (resp) ->
          $parent = $el.parent()
          $el.remove()
          itemViewClass = ProductSpecTable.ItemView
          newItem = (new itemViewClass(config, resp.data, crudConfig))
          newItem.appendTo($parent)
      return false

    $el.find('.delete-btn').click (e) ->
      runAction config.deleteAction,
        { id: self.data[config.primaryKey] },
        { confirm: '確認刪除? ', remove: $el }
      return false
    return $el

window.ProductSpecTable = {}
ProductSpecTable.append = (data) ->
ProductSpecTable.ItemView = ProductSpecTableItemView
