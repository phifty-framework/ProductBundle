###
vim:sw=2:ts=2:sts=2:
###


window.Product = {}

Product.initEdit = ->
    if $('form#product-resource').get(0)
        Action.form( 'form#product-resource', {
            clear: true,
            plugins: [ ActionMsgbox ],
            onSuccess: (result) -> return false
        })

Product.createResourcePreview = (data) ->
  $tag = Phifty.AdminUI.createResourceCover data,
    onClose: (e) ->
      runAction('ProductBundle::Action::DeleteResource',
          { id: data.id },
          { confirm: '確認刪除? ', remove: this })

  $id = $('<input/>').attr({
      type: 'hidden',
      name: 'resources[' + data.id + '][id]',
      value: data.id
  }).appendTo($tag)
  return $tag

Product.createRecipePreview = (data,rel) ->
  $cover = $('<li/>').addClass('product-recipe')
  if rel and rel.id
    $id = $('<input/>').attr(
      type: 'hidden'
      name: 'product_recipes[' + rel.id + '][id]',
      value: rel.id
    ).appendTo($cover)

  $id = $('<input/>').attr(
    type: 'hidden'
    name: 'product_recipes[' + ((rel and rel.id) or data.id) + '][recipe_id]',
    value: data.id
  ).appendTo($cover)

  if data.image
    $img = $('<img/>').attr({ src: '/' + data.image, alt: data.title, title: data.title }).appendTo($cover)

  $title = $('<span/>').text(data.title).appendTo($cover)
  $close = $('<div/>').addClass('close').appendTo($cover)

  if rel and rel.id
    $close.click ->
      runAction('ProductBundle::Action::DeleteProductRecipe',
        { id: rel.id },
        { confirm: '確認刪除? ', remove: $cover }
      )
  else
    $close.click -> $cover.remove()
  return $cover

#
# create feature preview image
#
Product.createFeaturePreview = (data,rel) ->
  $cover = $('<div/>').addClass('feature-cover')
  if rel and rel.id
    $id = $('<input/>').attr(
      type: 'hidden'
      name: 'product_features[' + rel.id + '][id]',
      value: rel.id
    ).appendTo($cover)

  $featureId = $('<input/>').attr
    type: 'hidden'
    name: 'product_features[' + ((rel and rel.id) or data.id) + '][feature_id]',
    value: data.id
  $img = $('<img/>').attr({ src: '/' + data.image, alt: data.name, title: data.name });   # name = feature name
  $close = $('<div/>').addClass('close')

  if rel and rel.id
    $close.click ->
      runAction('ProductBundle::Action::DeleteFeatureRel',
        { id: rel.id },
        { confirm: '確認刪除? ', remove: $cover }
      )
  else
    $close.click -> $cover.remove()
  return $cover.append($img).append($close).append($featureId)

Product.createTypeBox = (data) ->
    $tag = $('<div/>').addClass( 'text-tag' )
    $name = $('<div/>').addClass( 'name' ).html( data.name ).appendTo($tag)
    $close = $('<div/>').addClass('close').click ->
      runAction 'ProductBundle::Action::DeleteProductType',
        { id: data.id },
        { confirm: '確認刪除? ', remove: $tag }
    $tag.append($close)

    # hidden id field for subaction
    $id = $('<input/>').attr({
        type: 'hidden',
        name: 'types[' + data.id + '][id]',
        value: data.id
    }).appendTo($tag)
    return $tag

Product.createFileCover = (data) ->
  $tag = Phifty.AdminUI.createFileCover(data)
  $close = $('<div/>').addClass('close').click ->
      runAction 'ProductBundle::Action::DeleteProductFile',
          { id: data.id },
          { confirm: '確認刪除? ', remove: $tag }
  $close.appendTo($tag)

  # hidden id field for subaction
  $id = $('<input/>').attr({
      type: 'hidden',
      name: 'files[' + data.id + '][id]',
      value: data.id
  }).appendTo($tag)
  return $tag


productItemTemplate = CoffeeKup.compile ->
  div class: "product-cover col-md-3", ->
    index = @related_product_id
    if @id
      input class:"record-id", name: "product_products[#{ index }][id]", type: "hidden", value: @id
    input name: "product_products[#{ index }][related_product_id]", type: "hidden", value: @related_product_id
    if @product_id
      input name: "product_products[#{ index }][product_id]", type: "hidden", value: @product_id
    div class: "image-cover", ->
      if @thumb
        div class: "cut", ->
          img src: "/" + @thumb
      div class: "title", -> @name
      div class: "close", ->

class Product.ProductProductItemView extends CRUDList.BaseItemView
  render: ->
    self = this
    config = @config
    $el = $(productItemTemplate(@data))
    $el.find('.close').click (e) ->
      if self.data.id
        runAction "ProductBundle::Action::DeleteProductProduct",
          { id: self.data.id },
          { confirm: '確認刪除? ', remove: $el }
      else
        $el.remove()
      return false
    return $el




#
# Create product image preview thumb element from record data.
#
Product.createProductImageThumb = (data) ->
  $imageCover = Phifty.AdminUI.createImageCover data,
    onClose: (e) ->
      runAction 'ProductBundle::Action::DeleteProductImage',
        { id: data.id },
        { confirm: '確認刪除? ', remove: this }

  # hidden id field for subaction
  $id = $('<input/>').attr({
      type: 'hidden',
      name: 'images[' + data.id + '][id]',
      value: data.id
  }).appendTo($imageCover)
  return $imageCover

Product.Category = {}
Product.Category.createFileCover = (data) ->
  $tag = Phifty.AdminUI.createFileCover(data)
  $close = $('<div/>').addClass('close').click ->
    runAction 'ProductBundle::Action::DeleteCategoryFile',
        { id: data.id },
        { confirm: '確認刪除? ', remove: $tag }
  $close.appendTo($tag)

  # hidden id field for subaction
  $id = $('<input/>').attr({
      type: 'hidden',
      name: 'files[' + data.id + '][id]',
      value: data.id
  }).appendTo($tag)
  return $tag

Product.Category.init = () ->
  $('#add-category-file').click (e) ->
    dialog = new CRUDDialog '/bs/product_category_file/crud/dialog',{ } ,
      onSuccess: (resp) -> Product.Category.createFileCover(resp.data).appendTo('#category-files')

###
###

class window.ProductBulkConvertPlugin
  register: (bulk) ->
    bulk.addMenuItem 'zh_convert','簡繁轉換', (btn) ->
      content = $('<div/>')
      options =
        '':'--請選擇--',
        to_tw: '簡體轉繁體',
        to_cn: '繁體轉簡體'
      $select = $('<select/>')
      for lang,label of options
        $select.append new Option(label,lang)

      runbtn = $('<input/>').attr( type: 'button' ).val('開始轉換').click ->
        bulk.runBulkAction 'ZhConvert', { convertion: $select.val() }, (resp) ->
          if resp.success
            $.jGrowl resp.message
            setTimeout ( ->
                Region.of(bulk.table).refreshWith page: 1
                content.dialog 'close'
            ) , 800
          else
            $.jGrowl resp.message, theme: 'error'
      content.append($select).append(runbtn).dialog()

class window.ProductBulkCopyPlugin
  register: (bulk) ->
    bulk.addMenuItem 'copy', '複製...', (btn) ->
      content = $('<div/>')
      $langsel = $('<select/>')

      option = document.createElement("option")
      option.innerHTML = "--語言--"
      $langsel.append option
      for lang,label of Languages
          option = document.createElement("option")
          option.innerHTML = label
          option.value = lang
          $langsel.append option

      $productCateSel = $('<select/>')
      for cate in window.Product.categories
          option = document.createElement("option")
          option.innerHTML = cate.name
          option.value = cate.id
          $productCateSel.append option

      runbtn = $('<input/>').attr( type: 'button' ).val('複製').click ->
          bulk.runBulkAction 'Copy', {
              lang: $langsel.val(),
              category_id: $productCateSel.val()
          }, (result) ->
              if result.success
                  $.jGrowl(result.message)
                  setTimeout ( ->
                      Region.of(bulk.table).refreshWith page: 1
                      content.dialog('close')
                  ) , 800
              else
                  $.jGrowl(result.message,{ theme: 'error' })

      content.attr( title: '複製' )
          .append($langsel)
          .append($productCateSel)
          .append(runbtn).dialog()


class Pager
  constructor: (@config) ->
    @container = $('<div/>').addClass('pager')
    @page  = @config.page || 1
    @pages = @config.pages || Math.ceil(@config.totalItems / @config.pageSize)

  next: () -> if @page < @pages then @page++ else @page
  prev: () -> if @page > 1 then @page-- else @page

  render: (el) ->
    @updateUI()
    @container.appendTo(el)

  updateUI: () ->
    @container.empty()

    if @page > 1
      $prevPage = $('<a/>').text('上一頁')
        .appendTo(@container)
        .click (e) =>
          @prev()
          @config.onPage(@) if @config.onPage
          @updateUI()
    if @page < @pages
      $nextPage = $('<a/>').text('下一頁')
        .appendTo(@container)
        .click (e) =>
          @next()
          @config.onPage(@) if @config.onPage
          @updateUI()


class Product.Chooser
  constructor: (@container, @onChoose) ->
    @dialog = $('<div/>').dialog({ width: 900, height: 500, modal: true })
    @update 1, (resp) =>
      @pager = new Pager({
        pages: resp.pages
        page: @page
        onPage: (pager) =>
          @update(pager.page)
      })
      @pager.render(@dialog)
      @itemlist = $('<div/>').addClass('items').appendTo(@dialog)


  update: (page, cb) ->
    $.getJSON "/=/product/search", { page: page }, (resp) =>
      cb(resp) if cb
      @itemlist.empty()
      for product in resp.products
        do (product) =>
          $cover = Phifty.AdminUI.createImageCover
            thumb: product.thumb
            image: product.image
            title: product.name
          $btn = $('<button/>').text('選擇')
          $btn.appendTo( $cover )
          $btn.click (e) =>
            @onChoose(product) if @onChoose
            runAction "ProductBundle::Action::CreateProductProduct", { related_product_id: product.id }, (resp) =>
              console.log resp
              coverView = new CRUDList.ImageItemView {
                  deleteAction: "ProductBundle::Action::DeleteProductProduct"
                  relation: "product_products"
                }, {
                  id: resp.data.id
                  thumb: product.thumb
                  image: product.image
                  title: product.name
                }
              coverView.appendTo(@container)
            @dialog.dialog('close')


          $cover.appendTo(@itemlist)

Product.init = ->

