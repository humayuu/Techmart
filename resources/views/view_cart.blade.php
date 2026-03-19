  <!-- OffCanvas Cart Start -->
  <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
      <div class="inner">
          <div class="head">
              <span class="title">Cart</span>
              <button class="offcanvas-close">×</button>
          </div>
          <div class="body customScroll">
              <ul class="minicart-product-list">
              </ul>
          </div>
          <div class="foot">
              <div class="buttons mt-30px">
                  <a href="{{ route('cart') }}" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
              </div>
          </div>
      </div>
  </div>
  <!-- OffCanvas Cart End -->
  <script>
      const AllCarts = async () => {
          const response = await fetch('{{ url('product/all/carts') }}');
          const data = await response.json();

          const cartList = document.querySelector('#offcanvas-cart .minicart-product-list');
          cartList.innerHTML = '';

          let subTotal = 0;
          Object.values(data.carts).forEach((cart, key) => {
              subTotal += cart.price * cart.quantity;
              cartList.innerHTML += `
                <li>
                    <a href="/product/detail/${cart.product_id}" class="image">
                        <img src="{{ asset('images/products') }}/${cart.image}" alt="Cart product Image" />
                    </a>
                    <div class="content">
                        <a href="/product/detail/${cart.product_id}" class="title">${cart.product_name}</a>
                        <span class="quantity-price">${cart.quantity} x <span class="amount">$${subTotal}</span></span>
                        <button onclick="Remove(${cart.product_id})" class="remove">×</button>
                    </div>
                </li>
            `;
          });
      }
      const Remove = async (id) => {
          const response = await fetch(`{{ url('product/cart/remove/') }}/${id}`, {
              method: 'DELETE',
              headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                      'content'),
                  'Content-Type': 'application/json',
              }
          });

          const data = await response.json();

          if (data.status) {
              AllCarts();

              const countEl = document.getElementById('count');
              const countMobileEl = document.getElementById('count-mobile');
              if (countEl) countEl.innerHTML = data.cart_count;
              if (countMobileEl) countMobileEl.innerHTML = data.cart_count;
          }
      }
  </script>
