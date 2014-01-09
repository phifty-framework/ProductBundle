
linkItemTemplate = CoffeeKup.compile ->
  tr ->
    td ->
      input class:"record-id", name: "links[#{ @id }][id]", type: "hidden", value: @id
      input name: "links[#{ @id }][name]", type: "text", value: @name
    td ->
      input name: "links[#{ @id }][value]", type: "text", size: 60, value: @value
    td ->
      button "data-id": @id, class: "delete-button", -> "刪除"
    td ->
      div class:"handle", style: " border: 1px solid #aaa; background: #d5d5d5; display: block; padding: 1px 5px; ", ->
        span class: "icon icon-sort"

window.ProductLink = {}
ProductLink.renderLink = (data) ->
  return $(linkItemTemplate(data))

Product.appendLink = ($container,data) ->
  $table = $container.find('table')
  $tr = $(linkItemTemplate(data))

  # bind delete button
  $tr.find('.delete-button').click (e) ->
    if confirm('確定刪除?')
      id = $(this).data('id')
      $selfRow = $(this).parents('tr').get(0)
      runAction 'ProductBundle::Action::DeleteProductLink', { id: id }, (resp) ->
        $selfRow.remove()
    return false
  $table.find('tbody').append($tr)

Product.initLinkEditor = ($container) ->
  $table = $container.find('table')
  $container.find('.add-button').click (e) ->
    newName = $container.find('.new-link-name').val()
    newValue = $container.find('.new-link-value').val()

    # clear field values
    $container.find('.new-link-name').val("")
    $container.find('.new-link-value').val("")

    # create new item into the list here
    runAction 'ProductBundle::Action::CreateProductLink', { name: newName, value: newValue }, (resp) ->
      Product.appendLink($container,resp.data)
    return false


