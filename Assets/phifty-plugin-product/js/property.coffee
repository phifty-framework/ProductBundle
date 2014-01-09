
Product = window.Product

class BaseWidget
  bind: (el) ->

  render: () ->
    @el = CoffeeKup.compile(@template()).render()
    @bind(@el)
    return @el

class InputWidget extends BaseWidget
  template: () ->
    input class: @config.class, name: @config.name, type: @config.type, value: @config.value

class ButtonWidget extends BaseWidget
  contruct: (@config) ->
    @config.class = @config.class or "btn"
  template: ->
    button class: @config.class =>
      @config.label

class TextInputWidget extends InputWidget
  construct: (@config) ->
    super(@config)
    @config.type = "text"

class RadioInputWidget extends InputWidget
  construct: (@config) ->
    super(@config)
    @config.type = "radio"

class CheckboxInputWidget extends InputWidget
  construct: (@config) ->
    super(@config)
    @config.type = "checkbox"

class PasswordInputWidget extends InputWidget
  construct: (@config) ->
    super(@config)
    @config.type = "password"

class HiddenInputWidget extends InputWidget
  construct: (@config) ->
    super(@config)
    @config.type = "hidden"

class SelectWidget extends BaseWidget
  template: () ->


propertyItemTemplate = CoffeeKup.compile ->
  tr ->
    td ->
      input class:"record-id", name: "properties[#{ @id }][id]", type: "hidden", value: @id
      input name: "properties[#{ @id }][name]", type: "text", value: @name
    td ->
      input name: "properties[#{ @id }][value]", type: "text", size: 60, value: @value
    td ->
      button "data-id": @id, class: "delete-button", -> "刪除"
    td ->
      div class:"handle", style: " border: 1px solid #aaa; background: #d5d5d5; display: block; padding: 1px 5px; ", ->
        span class: "icon icon-sort"

Product.renderProperty = (data) ->
  return $(propertyItemTemplate(data))

Product.appendProperty = ($container,data) ->
  $table = $container.find('table')
  $tr = $(propertyItemTemplate(data))

  # bind delete button
  $tr.find('.delete-button').click (e) ->
    if confirm('確定刪除?')
      id = $(this).data('id')
      $selfRow = $(this).parents('tr').get(0)
      runAction 'ProductBundle::Action::DeleteProductProperty', { id: id }, (resp) ->
        $selfRow.remove()
    return false
  $table.find('tbody').append($tr)

Product.initPropertyEditor = ($container) ->
  $table = $container.find('table')
  $container.find('.add-button').click (e) ->
    newName = $container.find('.new-property-name').val()
    newValue = $container.find('.new-property-value').val()

    # clear field values
    $container.find('.new-property-name').val("")
    $container.find('.new-property-value').val("")

    # create new item into the list here
    runAction 'ProductBundle::Action::CreateProductProperty', { name: newName, value: newValue }, (resp) ->
      Product.appendProperty($container,resp.data)
    return false


