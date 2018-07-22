# START CLASS Cart
# - - - - - - - - - - - - - - - - -
class CartStorage
  currentProductsArr: []
  hasStorage: off


  constructor: () ->
    if window.localStorage?
      @hasStorage = on
      @storage = window.localStorage
      @currentProductsArr = @getProducts()


  addProduct: (newProduct) ->
    return off unless @hasStorage
    # newProduct [id, count, size, price]
    hasCurrent = off
    for currentProduct in @currentProductsArr
      if currentProduct.id is newProduct.id and currentProduct.size is newProduct.size
        currentProduct.count = currentProduct.count + newProduct.count
        hasCurrent = on
    @currentProductsArr.push newProduct unless hasCurrent
    @updateProducts()
    on


  updateProducts: () ->
    newProductsJsonSrt = JSON.stringify @currentProductsArr
    try
      @storage.setItem 'cart', newProductsJsonSrt
      $(@).trigger 'update', @currentProductsArr.length
    catch e
      console.log e
      return off
    on


  removeProduct: (id) ->
    for currentProduct, i in @currentProductsArr
      if currentProduct.id is id
        @currentProductsArr.splice i, 1
        break
    @updateProducts()


  clearProducts: () ->
    return off unless @hasStorage
    @storage.setItem 'cart', null
    @currentProductsArr = []
    $(@).trigger 'update', 0
    on


  getProducts: () ->
    return [] unless @hasStorage
    productsJsonStr =  @storage.getItem('cart')
    if productsJsonStr?
      try
        productsArr = JSON.parse productsJsonStr
      catch e
        console.log e
        productsArr = []
    productsArr ?= []
    productsArr


  getCount: () ->
    @currentProductsArr.length

  # typeIsArray: (value) ->
  #   value and
  #     typeof value is 'object' and
  #     value instanceof Array and
  #     typeof value.length is 'number' and
  #     typeof value.splice is 'function' and
  #     not (value.propertyIsEnumerable 'length')

# cart = new Cart
# cart.clearProducts()
# cart.addProduct(13)
# cart.getProducts()

# - - - - - - - - - - - - - - - - -
# END CLASS Cart