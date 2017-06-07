
linkItemTemplate = CoffeeKup.compile ->
  tr ->
    td ->
      input class:"record-id", name: "links[#{ @id }][id]", type: "hidden", value: @id
      input name: "links[#{ @id }][label]", type: "text", value: @label
    td ->
      input name: "links[#{ @id }][url]", type: "text", size: 60, value: @url
    td ->
      button "data-id": @id, class: "delete-button", -> "刪除"
    td ->
      div class:"handle", style: " border: 1px solid #aaa; background: #d5d5d5; display: block; padding: 1px 5px; ", ->
        span class: "icon fa-sort"

window.ProductLink = {}
ProductLink.render = (data) ->
  return $(linkItemTemplate(data))

ProductLink.append = ($container,data) ->
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

ProductLink.initEditor = ($container) ->
  $table = $container.find('table')
  $container.find('.add-button').click (e) ->
    newLabel = $container.find('.new-link-label').val()
    newUrl = $container.find('.new-link-url').val()

    # clear field values
    $container.find('.new-link-label').val("")
    $container.find('.new-link-url').val("")

    # create new item into the list here
    runAction 'ProductBundle::Action::CreateProductLink', { label: newLabel, url: newUrl }, (resp) ->
      ProductLink.append($container,resp.data)
    return false


