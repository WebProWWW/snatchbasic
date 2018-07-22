/*
 * @author Timur Valiyev
 * @link https://webprowww.github.io
 */

// START CLASS Cart
// - - - - - - - - - - - - - - - - -
var $, $cartStore, $showOnScroll, CartStorage, calculateCountPrice, cartStore, delay, jQueryMailer, renderPopupCartItems, renderPopupOrder, showPopupCart, updateStoreCount;

CartStorage = (function() {
  class CartStorage {
    constructor() {
      if (window.localStorage != null) {
        this.hasStorage = true;
        this.storage = window.localStorage;
        this.currentProductsArr = this.getProducts();
      }
    }

    addProduct(newProduct) {
      var currentProduct, hasCurrent, j, len, ref;
      if (!this.hasStorage) {
        return false;
      }
      // newProduct [id, count, size, price]
      hasCurrent = false;
      ref = this.currentProductsArr;
      for (j = 0, len = ref.length; j < len; j++) {
        currentProduct = ref[j];
        if (currentProduct.id === newProduct.id && currentProduct.size === newProduct.size) {
          currentProduct.count = currentProduct.count + newProduct.count;
          hasCurrent = true;
        }
      }
      if (!hasCurrent) {
        this.currentProductsArr.push(newProduct);
      }
      this.updateProducts();
      return true;
    }

    updateProducts() {
      var e, newProductsJsonSrt;
      newProductsJsonSrt = JSON.stringify(this.currentProductsArr);
      try {
        this.storage.setItem('cart', newProductsJsonSrt);
        $(this).trigger('update', this.currentProductsArr.length);
      } catch (error) {
        e = error;
        console.log(e);
        return false;
      }
      return true;
    }

    removeProduct(id) {
      var currentProduct, i, j, len, ref;
      ref = this.currentProductsArr;
      for (i = j = 0, len = ref.length; j < len; i = ++j) {
        currentProduct = ref[i];
        if (currentProduct.id === id) {
          this.currentProductsArr.splice(i, 1);
          break;
        }
      }
      return this.updateProducts();
    }

    clearProducts() {
      if (!this.hasStorage) {
        return false;
      }
      this.storage.setItem('cart', null);
      this.currentProductsArr = [];
      $(this).trigger('update', 0);
      return true;
    }

    getProducts() {
      var e, productsArr, productsJsonStr;
      if (!this.hasStorage) {
        return [];
      }
      productsJsonStr = this.storage.getItem('cart');
      if (productsJsonStr != null) {
        try {
          productsArr = JSON.parse(productsJsonStr);
        } catch (error) {
          e = error;
          console.log(e);
          productsArr = [];
        }
      }
      if (productsArr == null) {
        productsArr = [];
      }
      return productsArr;
    }

    getCount() {
      return this.currentProductsArr.length;
    }

  };

  CartStorage.prototype.currentProductsArr = [];

  CartStorage.prototype.hasStorage = false;

  return CartStorage;

}).call(this);

// typeIsArray: (value) ->
//   value and
//     typeof value is 'object' and
//     value instanceof Array and
//     typeof value.length is 'number' and
//     typeof value.splice is 'function' and
//     not (value.propertyIsEnumerable 'length')

// cart = new Cart
// cart.clearProducts()
// cart.addProduct(13)
// cart.getProducts()

// - - - - - - - - - - - - - - - - -
// END CLASS Cart
$ = jQuery;

jQueryMailer = (function() {
  class jQueryMailer {
    constructor(selector, options) {
      this.onSubmit = this.onSubmit.bind(this);
      this.delay = this.delay.bind(this);
      $.extend(this.settings, options);
      $(selector).bind('submit', this.onSubmit);
    }

    onSubmit(e) {
      var $form;
      e.preventDefault();
      $form = $(e.target);
      if ((this.validate($form.find('[validate]'))) && !this.process) {
        this.send($form);
      }
      return false;
    }

    delay(sec, fun) {
      setTimeout(fun, sec * 1000);
      return true;
    }

    send($form) {
      this.progress($form);
      this.process = true;
      $.ajax({
        method: this.settings.method,
        url: this.settings.action,
        data: $form.serialize(),
        dataType: this.settings.dataType
      }).done((data) => {
        return this.success($form, data);
      }).fail(() => {
        return this.error($form);
      }).always(() => {
        this.process = false;
        return this.always($form);
      });
      return true;
    }

    success($form, data) {
      // $form.trigger 'reset'
      return this.settings.success($form, data);
    }

    error($form) {
      return this.settings.error($form);
    }

    always($form) {
      var $sending;
      $sending = $form.find('.js-form-progress');
      $sending.html(this.sendingCurrentHtml);
      return true;
    }

    progress($form) {
      var $sending;
      $sending = $form.find('.js-form-progress');
      this.sendingCurrentHtml = $sending.html();
      $sending.html(this.settings.sendingStr);
      return true;
    }

    inputError($input) {
      // $parent = $input.parent()
      // $parent.addClass 'has-error'
      $input.addClass('has-error');
      $input.one('focusin', function(e) {
        return $(this).removeClass('has-error');
      });
      return true;
    }

    validate($inputs) {
      var result;
      result = true;
      $inputs.each((i, input) => {
        var $input, inputRes, inputVal, validate;
        $input = $(input);
        validate = $input.attr('validate');
        inputVal = $input.val();
        inputRes = (function() {
          switch (validate) {
            case 'text':
              return inputVal.length > 2;
            case 'email':
              return this.emailRegex.test(inputVal);
            default:
              return true;
          }
        }).call(this);
        if (!inputRes) {
          result = inputRes;
          this.inputError($input);
        }
        return true;
      });
      return result;
    }

  };

  jQueryMailer.prototype.settings = {
    action: '/',
    method: 'POST',
    dataType: 'json',
    sendingStr: 'Sending...',
    success: function($form, data) {},
    error: function($form) {}
  };

  jQueryMailer.prototype.emailRegex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;

  jQueryMailer.prototype.process = false;

  jQueryMailer.prototype.sendingCurrentHtml = '';

  return jQueryMailer;

}).call(this);

// FUNCTIONS
// - - - - - - - - - - - - - - - - -
delay = function(ms, callBack) {
  return setTimeout(callBack, ms);
};

calculateCountPrice = function($parent, count) {
  var $price, newPrice, onePrice;
  $price = $parent.find('.js-detail-total');
  onePrice = Number($price.attr('data'));
  newPrice = onePrice * count;
  return $price.text(newPrice);
};

updateStoreCount = function(count) {
  var $cnt;
  $cnt = $('.js-store-count');
  $cnt.html(count);
  if (count) {
    return $cnt.removeClass('d-none');
  } else {
    return $cnt.addClass('d-none');
  }
};

showPopupCart = function() {
  $.fancybox.close(true);
  return $.fancybox.open({
    src: '#popup-cart',
    type: 'inline',
    opts: {
      modal: true
    }
  });
};

renderPopupCartItems = function(store) {
  var $inputsGroup, $itemsView, itemsHtmlArr, j, len, product, productsArr, totalPrice, totalPriceHtml;
  $itemsView = $('.js-popup-cart-items');
  $inputsGroup = $('.js-popup-cart-inputs');
  productsArr = store.getProducts();
  totalPrice = 0;
  itemsHtmlArr = [];
// inputsHtmlArr = []
  for (j = 0, len = productsArr.length; j < len; j++) {
    product = productsArr[j];
    totalPrice += product.count * product.price;
    // inputsHtmlArr.push """
    //   <input type="hidden" name="productId[]" value="#{product.id}">
    // """
    itemsHtmlArr.push(`<div class="popup-cart-item">\n  <div class="row align-items-center">\n    <div class="col-3">\n      <img class="img-fluid" src="${product.img}">\n    </div><!--/.col-->\n    <div class="col-7 col-sm">\n      <div class="row">\n        <div class="col-12 mb-10">\n          <div class="em-10 bold">${product.label}</div>\n        </div><!--/.col-->\n        <div class="col-12 mb-10">\n          <div class="em-10">\n            <span class="bold">Размер:</span> ${product.size}\n          </div>\n        </div><!--/.col-->\n        <div class="col-12 mb-10">\n          <div class="em-10"><span class="bold">Количество:</span> ${product.count} шт</div>\n        </div><!--/.col-->\n        <div class="col-12 col-sm-auto">\n          <div class="em-10 bold">\n            Сумма: <span>${product.count * product.price}</span> <i class="fas fa-ruble-sign"></i>\n          </div>\n        </div><!--/.col-->\n      </div><!--/.row-->\n    </div><!--/.col-->\n    <div class="col-auto">\n      <div class="color-red em-11 em-sm-15 js-cart-item-remove" id-product="${product.id}">\n        <i class="fas fa-trash-alt"></i>\n      </div>\n    </div><!--/.col-->\n  </div><!--/.row-->\n</div><!--/.popup-cart-item-->`);
  }
  totalPriceHtml = `<div class="em-12 bold text-right mb-15">\n  Итого: ${totalPrice} <i class="fas fa-ruble-sign"></i>\n</div>`;
  $itemsView.html('');
  $itemsView.append(itemsHtmlArr);
  $itemsView.append(totalPriceHtml);
  // $inputsGroup.html ''
  // $inputsGroup.append inputsHtmlArr
  return true;
};

renderPopupOrder = function(store) {};

// INIT
// - - - - - - - - - - - - - - - - -
$.fancybox.open({
  src: '#popup-order',
  type: 'inline'
});

//   opts:
//     modal: on
//     smallBtn: 'auto'
//     baseClass: 'popup-menu'
//     toolbar: off
cartStore = new CartStorage;

$cartStore = $(cartStore);

updateStoreCount(cartStore.getCount());

// cartStore.clearProducts()
// cartStore.addProduct(5, 'XXL', 1)
// cartStore.getProducts()
new jQueryMailer('.js-form-callback', {
  action: '/api/mail-price.json',
  sendingStr: '<img class="form-loader" src="/img/loader.svg">',
  success: function($form, data) {
    if ((data.status != null) && data.status === 1) {
      $form.trigger('reset');
      $.fancybox.close(true);
      $.fancybox.open({
        src: '#js-form-success'
      });
    } else {
      $.fancybox.open({
        src: '#js-form-error'
      });
    }
    return console.log(data);
  },
  error: function($form) {
    $.fancybox.open({
      src: '#js-form-error'
    });
    return console.log('Error: /api/mail-price.json');
  }
});

new jQueryMailer('.js-form-order', {
  action: '/api/order.json',
  sendingStr: '<img class="form-loader" src="/img/loader.svg">',
  success: function($form, data) {
    $form.trigger('reset');
    $.fancybox.close(true);
    $.fancybox.open({
      src: '#js-form-success'
    });
    // if data.status? and data.status is 1
    //   $form.trigger 'reset'
    //   $.fancybox.close on
    //   $.fancybox.open src: '#js-form-success'
    // else
    //   $.fancybox.open src: '#js-form-error'
    return console.log(data);
  },
  error: function($form) {
    $.fancybox.open({
      src: '#js-form-error'
    });
    return console.log('Error: /api/order.json');
  }
});

$('.js-mask').each(function(i, input) {
  var $input;
  $input = $(input);
  return $input.mask($input.attr('mask'));
});

$('.js-bxslider').bxSlider({
  wrapperClass: 'slider',
  pager: false,
  controls: false,
  auto: true,
  pause: 4000,
  speed: 500,
  minSlides: 1,
  maxSlides: 5,
  moveSlides: 1,
  slideWidth: 222,
  adaptiveHeight: true
});

// BIND EVENTS
// - - - - - - - - - - - - - - - - -
$cartStore.on('update', function(e, storeCount) {
  return updateStoreCount(storeCount);
});

$('.js-prevent').on('click', function(e) {
  e.preventDefault();
  return false;
});

$('.js-popup-cart').on('click', function(e) {
  e.preventDefault();
  if (cartStore.getCount()) {
    renderPopupCartItems(cartStore);
    showPopupCart();
  } else {
    $.fancybox.open({
      src: '#popup-cart-empty'
    });
  }
  return false;
});

$('.js-popup-order').on('click', function(e) {
  e.preventDefault();
  if (cartStore.getCount()) {
    renderPopupOrder(cartStore);
    $.fancybox.close(true);
    $.fancybox.open({
      src: '#popup-order',
      type: 'inline'
    });
  } else {
    $.fancybox.close(true);
    $.fancybox.open({
      src: '#popup-cart-empty'
    });
  }
  return false;
});

$('body').on('click', '.js-cart-item-remove', function(e) {
  var $this, id;
  e.preventDefault();
  $this = $(this);
  id = Number($this.attr('id-product'));
  if (cartStore.removeProduct(id)) {
    if (cartStore.getCount()) {
      renderPopupCartItems(cartStore);
    } else {
      $.fancybox.close(true);
      $.fancybox.open({
        src: '#popup-cart-empty'
      });
    }
  }
  return false;
});

$('.js-popup-menu').on('click', function(e) {
  e.preventDefault();
  $.fancybox.open({
    src: '#popup-menu',
    type: 'inline',
    opts: {
      modal: true,
      smallBtn: 'auto',
      baseClass: 'popup-menu',
      toolbar: false
    }
  });
  return false;
});

$('.js-product-btn').on('click', function(e) {
  var $this, cartUrl;
  e.preventDefault();
  $this = $(this);
  cartUrl = $this.attr('href');
  $.fancybox.open({
    src: cartUrl,
    type: 'ajax'
  });
  return false;
});

$('body').on('click', '.js-sitem', function(e) {
  var $parent, $this;
  e.preventDefault();
  $this = $(this);
  if (!$this.hasClass('active')) {
    $parent = $this.closest('.js-select');
    $parent.find('.js-sitem').removeClass('active');
    $this.addClass('active');
    $parent.attr('data', $this.attr('data'));
  }
  return false;
});

$('body').on('click', '.js-counter-btn', function(e) {
  var $input, $parent, $parentDetail, $this, dataNum, inputNum, newVal;
  e.preventDefault();
  $this = $(this);
  $parent = $this.closest('.js-counter');
  $parentDetail = $this.closest('.js-detail');
  $input = $parent.find('.js-counter-input');
  dataNum = Number($this.attr('data'));
  inputNum = Number($input.val());
  newVal = inputNum + dataNum;
  if (newVal < 1 || isNaN(newVal)) {
    newVal = 1;
  }
  $input.val(newVal);
  calculateCountPrice($parentDetail, newVal);
  return false;
});

$('body').on('focusout', '.js-counter-input', function(e) {
  var $parentDetail, $this, val;
  $this = $(this);
  val = $this.val();
  $parentDetail = $this.closest('.js-detail');
  if (val.length < 1 || val < 1 || isNaN(val)) {
    $this.val(1);
  }
  return calculateCountPrice($parentDetail, Number($this.val()));
});

$('body').on('keyup', '.js-counter-input', function(e) {
  var $parentDetail, $this, val;
  $this = $(this);
  val = $this.val();
  $parentDetail = $this.closest('.js-detail');
  if (val.length < 1 || val < 1 || isNaN(val)) {
    $this.val(1);
  }
  return calculateCountPrice($parentDetail, Number($this.val()));
});

$('body').on('click', '.js-add-btn', function(e) {
  var $detail, newProduct;
  e.preventDefault();
  $detail = $(this).closest('.js-detail');
  $detail.addClass('tocart');
  newProduct = {
    price: Number($detail.find('.js-detail-total').attr('data')),
    count: Number($detail.find('.js-counter-input').val()),
    size: String($detail.find('.js-select').attr('data')),
    img: String($detail.find('.js-detail-img').attr('src')),
    id: Number($detail.attr('id-product')),
    label: String($detail.find('.js-detail-label').html())
  };
  cartStore.addProduct(newProduct);
  delay(300, function() {
    return $.fancybox.close(true);
  });
  return false;
});

$('.js-scrollto').on('click', function(e) {
  var id, offsetTop;
  e.preventDefault();
  id = $(this).attr('href');
  if (id === '#') {
    offsetTop = 0;
  } else {
    offsetTop = $(id).offset().top;
  }
  $('html:not(:animated),body:not(:animated)').animate({
    scrollTop: offsetTop
  });
  return false;
});

$showOnScroll = $('.js-showonscroll');

$(window).on('scroll', function(e) {
  var offset, scrollTopNum;
  offset = 150;
  scrollTopNum = $(this).scrollTop();
  if (scrollTopNum > offset) {
    $showOnScroll.addClass('active');
  }
  if (scrollTopNum < offset) {
    return $showOnScroll.removeClass('active');
  }
});
