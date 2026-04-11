   <!-- OffCanvas Wishlist Start -->
   <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
       <div class="inner">
           <div class="head">
               <span class="title">Wishlist</span>
               <button class="offcanvas-close">×</button>
           </div>
           <div class="body customScroll">
               <ul class="minicart-product-list">
               </ul>
           </div>
           <div class="foot">
               <div class="buttons">
                   <a href="{{ route('wishlist') }}" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
               </div>
           </div>
       </div>
   </div>
   <!-- OffCanvas Wishlist End -->
   <script>
       const AllWishlist = async () => {
           try {
               const response = await fetch('{{ url('product/all/wishlist') }}', {
                   headers: { 'Accept': 'application/json' },
               });
               if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

               const data = await response.json();

               const wishlistEl = document.querySelector('#offcanvas-wishlist .minicart-product-list');
               if (!wishlistEl) return;

               wishlistEl.innerHTML = '';

               if (!data.status || !data.wishlist || Object.keys(data.wishlist).length === 0) {
                   wishlistEl.innerHTML = '<li class="text-center p-3">Your wishlist is empty.</li>';
                   return;
               }

               Object.values(data.wishlist).forEach((item) => {
                   const itemTotal = Number(item.price) * Number(item.quantity);
                   wishlistEl.innerHTML += `
                    <li>
                        <a href="/product/detail/${item.product_id}" class="image">
                            <img src="{{ asset('images/products/thumbnail') }}/${item.image}" alt="${item.product_name}" />
                        </a>
                        <div class="content">
                            <a href="/product/detail/${item.product_id}" class="title">${item.product_name}</a>
                            <span class="quantity-price">${item.quantity} x <span class="amount">$${itemTotal.toFixed(2)}</span></span>
                            <button type="button" onclick="RemoveFromWishlist(${item.product_id})" class="remove">×</button>
                        </div>
                    </li>
                `;
               });

           } catch (error) {
               console.error('Wishlist fetch error:', error.message);
           }
       };

       document.addEventListener('DOMContentLoaded', AllWishlist);

       const offcanvasWishlist = document.getElementById('offcanvas-wishlist');
       if (offcanvasWishlist) {
           offcanvasWishlist.addEventListener('shown.bs.offcanvas', () => {
               AllWishlist();
           });
       }

       const RemoveFromWishlist = async (id) => {
           try {
               const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
               const response = await fetch(`{{ url('product/wishlist/remove') }}/${id}`, {
                   method: 'DELETE',
                   headers: {
                       'X-CSRF-TOKEN': token || '',
                       'Accept': 'application/json',
                       'X-Requested-With': 'XMLHttpRequest',
                   },
               });

               if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

               const data = await response.json();

               if (data.status) {
                   await AllWishlist();
                   const countEl = document.getElementById('wishlist-count');
                   const countMobileEl = document.getElementById('wishlist-count-mobile');
                   const n = typeof data.wishlist_count === 'number' ? data.wishlist_count : 0;
                   if (countEl) countEl.textContent = n;
                   if (countMobileEl) countMobileEl.textContent = n;
                   if (/\/product\/wishlist\/?$/.test(window.location.pathname)) {
                       window.location.reload();
                   }
               }

           } catch (error) {
               console.error('Remove wishlist error:', error.message);
           }
       };
   </script>
