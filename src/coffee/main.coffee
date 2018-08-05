#=include ./lib/CartStorage.coffee
#=include ./lib/jQueryMailer.coffee




# FUNCTIONS
# - - - - - - - - - - - - - - - - -

delay = (ms, callBack) -> setTimeout callBack, ms

calculateCountPrice = ($parent, count) ->
  $price = $parent.find '.js-detail-total'
  onePrice = Number $price.attr 'data'
  newPrice = onePrice * count
  $price.text newPrice


updateStoreCount = (count) ->
  $cnt = $ '.js-store-count'
  $cnt.html count
  if count then $cnt.removeClass 'd-none' else $cnt.addClass 'd-none'



showPopupCart = () ->
  $.fancybox.close on
  $.fancybox.open
    src: '#popup-cart'
    type: 'inline'
    opts:
      modal: on



renderPopupCartItems = (store) ->
  $itemsView = $ '.js-popup-cart-items'
  $inputsGroup = $ '.js-popup-cart-inputs'
  productsArr = store.getProducts()
  totalPrice = 0
  itemsHtmlArr = []
  # inputsHtmlArr = []
  for product in productsArr
    totalPrice += product.count * product.price
    # inputsHtmlArr.push """
    #   <input type="hidden" name="productId[]" value="#{product.id}">
    # """
    itemsHtmlArr.push """
    <div class="popup-cart-item">
      <div class="row align-items-center">
        <div class="col-3">
          <img class="img-fluid" src="#{product.img}">
        </div><!--/.col-->
        <div class="col-7 col-sm">
          <div class="row">
            <div class="col-12 mb-10">
              <div class="em-10 bold">#{product.label}</div>
            </div><!--/.col-->
            <div class="col-12 mb-10">
              <div class="em-10">
                <span class="bold">Цвет:</span> #{product.color}
              </div>
            </div><!--/.col-->
            <div class="col-12 mb-10">
              <div class="em-10">
                <span class="bold">Размер:</span> #{product.size}
              </div>
            </div><!--/.col-->
            <div class="col-12 mb-10">
              <div class="em-10"><span class="bold">Количество:</span> #{product.count} шт</div>
            </div><!--/.col-->
            <div class="col-12 col-sm-auto">
              <div class="em-10 bold">
                Сумма: <span>#{product.count * product.price}</span> <i class="fas fa-ruble-sign"></i>
              </div>
            </div><!--/.col-->
          </div><!--/.row-->
        </div><!--/.col-->
        <div class="col-auto">
          <div class="color-red em-11 em-sm-15 js-cart-item-remove" id-product="#{product.id}">
            <i class="fas fa-trash-alt"></i>
          </div>
        </div><!--/.col-->
      </div><!--/.row-->
    </div><!--/.popup-cart-item-->
    """
  totalPriceHtml = """
  <div class="em-12 bold text-right mb-15">
    Итого: #{totalPrice} <i class="fas fa-ruble-sign"></i>
  </div>
  """
  $itemsView.html ''
  $itemsView.append itemsHtmlArr
  $itemsView.append totalPriceHtml
  # $inputsGroup.html ''
  # $inputsGroup.append inputsHtmlArr
  on



renderPopupOrder = (store, $itemsView) ->
  productsArr = store.getProducts()
  totalPrice = 0
  itemsHtmlArr = for product, i in productsArr
    totalPrice += product.count * product.price
    """
      <input type="hidden" name="order[#{i}][id]" value="#{product.id}">
      <input type="hidden" name="order[#{i}][img]" value="#{product.img}">
      <input type="hidden" name="order[#{i}][label]" value="#{product.label}">
      <input type="hidden" name="order[#{i}][count]" value="#{product.count}">
      <input type="hidden" name="order[#{i}][price]" value="#{product.price}">
      <input type="hidden" name="order[#{i}][summ]" value="#{product.count * product.price}">
      <input type="hidden" name="order[#{i}][size]" value="#{product.size}">
      <input type="hidden" name="order[#{i}][color]" value="#{product.color}">
    """
  totalPriceHtml = """
    <input type="hidden" name="total" value="#{totalPrice}">
  """
  $itemsView.html ''
  $itemsView.append itemsHtmlArr
  $itemsView.append totalPriceHtml






# JQ OBJECTS
# - - - - - - - - - - - - - - - - -

$formOrderItems = $ '.js-form-order-items'


# INIT
# - - - - - - - - - - - - - - - - -

# $.fancybox.open
#   src: '#popup-order'
#   type: 'inline'
#   opts:
#     modal: on
#     smallBtn: 'auto'
#     baseClass: 'popup-menu'
#     toolbar: off

cartStore = new CartStorage
$cartStore = $ cartStore

updateStoreCount cartStore.getCount()


# renderPopupOrder cartStore, $formOrderItems

# $.fancybox.open
#   src: '#popup-order'
#   type: 'inline'


formCallBack = new jQueryMailer '.js-form-callback',
  action: '/api/mail-price.json'
  sendingStr: '<img class="form-loader" src="/img/loader.svg">'
  success: ($form, data) ->
    if data.status? and data.status is 1
      $form.trigger 'reset'
      $.fancybox.close on
      $.fancybox.open src: '#js-form-success'
    else
      $.fancybox.open src: '#js-form-error'
    console.log data
  error: ($form) ->
    $.fancybox.open src: '#js-form-error'
    console.log 'Error: /api/mail-price.json'



formOrder = new jQueryMailer '.js-form-order',
  action: '/api/order.json'
  sendingStr: '<img class="form-loader" src="/img/loader.svg">'
  success: ($form, data) ->
    if data.status? and data.status is 1
      $form.trigger 'reset'
      $.fancybox.close on
      $.fancybox.open src: '#js-form-success'
      cartStore.clearProducts()
    else
      $.fancybox.open src: '#js-form-error'
    console.log data
  error: ($form) ->
    $.fancybox.open src: '#js-form-error'
    console.log 'Error: /api/order.json'



$('.js-mask').each (i, input) ->
  $input = $ input
  $input.mask $input.attr 'mask'


$('.js-bxslider').bxSlider
  wrapperClass: 'slider'
  pager: off
  controls: off
  auto: on
  pause: 4000
  speed: 500
  minSlides: 1
  maxSlides: 5
  moveSlides: 1
  slideWidth: 222
  adaptiveHeight: on


# BIND EVENTS
# - - - - - - - - - - - - - - - - -


$cartStore.on 'update', (e, storeCount) ->
  updateStoreCount storeCount


$('.js-prevent').on 'click', (e) ->
  e.preventDefault()
  off



$('.js-popup-cart').on 'click', (e) ->
  e.preventDefault()
  if cartStore.getCount()
    renderPopupCartItems cartStore
    showPopupCart()
  else
    $.fancybox.open src: '#popup-cart-empty'
  off



$('.js-popup-order').on 'click', (e) ->
  e.preventDefault()
  if cartStore.getCount()
    renderPopupOrder cartStore, $formOrderItems
    $.fancybox.close on
    $.fancybox.open
      src: '#popup-order'
      type: 'inline'
  else
    $.fancybox.close on
    $.fancybox.open src: '#popup-cart-empty'
  off



$('body').on 'click', '.js-cart-item-remove', (e) ->
  e.preventDefault()
  $this = $ this
  id = Number $this.attr 'id-product'
  if cartStore.removeProduct id
    if cartStore.getCount()
      renderPopupCartItems cartStore
    else
      $.fancybox.close on
      $.fancybox.open src: '#popup-cart-empty'
  off



$('.js-popup-menu').on 'click', (e) ->
  e.preventDefault()
  $.fancybox.open
    src: '#popup-menu'
    type: 'inline'
    opts:
      modal: on
      smallBtn: 'auto'
      baseClass: 'popup-menu'
      toolbar: off
  off


$('.js-product-btn').on 'click', (e) ->
  e.preventDefault()
  $this = $ this
  cartUrl = $this.attr 'href'
  $.fancybox.open
    src: cartUrl
    type: 'ajax'
  off


$('body').on 'click', '.js-sitem', (e) ->
  e.preventDefault()
  $this = $ this
  unless $this.hasClass 'active'
    $parent = $this.closest '.js-select'
    $parent.find('.js-sitem').removeClass 'active'
    $this.addClass 'active'
    $parent.attr 'data', $this.attr 'data'
  off


$('body').on 'click', '.js-counter-btn', (e) ->
  e.preventDefault()
  $this = $ this
  $parent = $this.closest '.js-counter'
  $parentDetail = $this.closest '.js-detail'
  $input = $parent.find '.js-counter-input'
  dataNum = Number $this.attr 'data'
  inputNum = Number $input.val()
  newVal = inputNum + dataNum
  newVal = 50 if newVal < 50 or isNaN newVal
  $input.val newVal
  calculateCountPrice $parentDetail, newVal
  off


$('body').on 'focusout keyup', '.js-counter-input', (e) ->
  $this = $ this
  val = $this.val()
  $parentDetail = $this.closest '.js-detail'
  if val.length < 1 or val < 50 or isNaN val
    $this.val 50
  calculateCountPrice $parentDetail, Number $this.val()



# $('body').on 'keyup', '.js-counter-input', (e) ->
#   $this = $ this
#   val = $this.val()
#   $parentDetail = $this.closest '.js-detail'
#   if val.length < 1 or val < 1 or isNaN val
#     $this.val 1
#   calculateCountPrice $parentDetail, Number $this.val()



$('body').on 'click', '.js-add-btn', (e) ->
  e.preventDefault()
  $detail = $(this).closest '.js-detail'
  $detail.addClass 'tocart'
  newProduct =
    price : Number $detail.find('.js-detail-total').attr 'data'
    count : Number $detail.find('.js-counter-input').val()
    size : String $detail.find('.js-select').attr 'data'
    color: String $detail.find('.js-detail-color').html()
    img : String $detail.find('.js-detail-img').attr 'src'
    id : Number $detail.attr 'id-product'
    label: String $detail.find('.js-detail-label').html()
  cartStore.addProduct newProduct
  delay 300, () -> $.fancybox.close on
  off


$('.js-scrollto').on 'click', (e) ->
  e.preventDefault()
  id = $(this).attr 'href'
  if id is '#' then offsetTop = 0 else offsetTop = $(id).offset().top
  $('html:not(:animated),body:not(:animated)').animate scrollTop: offsetTop
  off


$showOnScroll = $ '.js-showonscroll'


$(window).on 'scroll', (e) ->
  offset = 150
  scrollTopNum = $(this).scrollTop()
  $showOnScroll.addClass 'active' if scrollTopNum > offset
  $showOnScroll.removeClass 'active' if scrollTopNum < offset
