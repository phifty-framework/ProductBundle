subsectionItemTemplate = CoffeeKup.compile ->
  div class: "row clearfix", style: "margin-bottom: 20px;" , ->
    input class:"record-id", name: "subsections[#{ @id }][id]", type: "hidden", value: @id

    div class: "col-md-3", ->
      if @cover_image
        div class: "image-cover", ->
          img src: "/" + @cover_image

    div class: "col-md-5", ->
      h3 -> @title
      div style:"height: 100px; overflow: hidden; " , -> @content

    div class: "col-md-2", ->
      div class: "controls", ->
        button "data-id": @id, class: "edit-btn", -> "編輯"
        button "data-id": @id, class: "delete-btn", -> "刪除"
        div class:"handle", style: "border: 1px solid #aaa; background: #d5d5d5; display: inline-block; padding: 1px 5px; ", ->
          span class: "icon icon-sort"

class ProductSubsectionItemView extends CRUDList.BaseItemView
  render: ->
    self = this
    config = @config
    $el = $(subsectionItemTemplate(@data))

    $el.find('.edit-btn').click (e) ->
      id = $(this).data('id')
      dialog = new CRUDDialog '/bs/product_subsection/crud/dialog', { id: id },
        dialogOptions: { width: 650, height: 500 }
        onSuccess: (resp) ->
          $parent = $el.parent()
          $el.remove()
          itemViewClass = ProductSubsection.ItemView
          newItem = (new itemViewClass(config, resp.data))
          newItem.appendTo($parent)
      return false

    $el.find('.delete-btn').click (e) ->
      runAction config.deleteAction,
        { id: self.data[config.primaryKey] },
        { confirm: '確認刪除? ', remove: $el }
      return false
    return $el

window.ProductSubsection = {}
ProductSubsection.append = (data) ->
ProductSubsection.ItemView = ProductSubsectionItemView
