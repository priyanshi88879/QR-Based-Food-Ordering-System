<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Smart QR — Restaurant Ordering UI</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Tailwind theme config -->
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f2f7ff',
              100: '#e6f0ff',
              300: '#8fb3ff',
              500: '#2e6bea',
              700: '#2349a8'
            },
            accent: '#0ea5a4'
          },
          keyframes: {
            float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-6px)' } }
          },
          animation: { float: 'float 3s ease-in-out infinite' }
        }
      }
    }
  </script>

  <style>
    /* Small custom CSS for polish */
    :root { color-scheme: light dark; }
    body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    .glass { background: rgba(255,255,255,0.55); backdrop-filter: blur(6px); }
    .glass-dark { background: rgba(17,24,39,0.45); backdrop-filter: blur(6px); }
    /* subtle scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-thumb { background: rgba(100,100,100,0.2); border-radius: 9999px; }
    .fade-in { animation: fadeIn .32s ease both; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(6px);} to {opacity:1; transform:none;} }
  </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

  <div class="max-w-7xl mx-auto px-4 py-6">
    <!-- NAVBAR -->
    <header class="fixed inset-x-0 top-4 z-50">
      <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 p-3 rounded-2xl glass drop-shadow-md dark:glass-dark">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-lg font-bold">SQ</div>
          <div class="hidden sm:block">
            <div class="font-semibold">Smart QR Bistro</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Contactless — Fast — Secure</div>
          </div>
        </div>

        <nav class="hidden md:flex items-center gap-6 text-sm">
          <a href="#home" class="hover:text-brand-500">Home</a>
          <a href="#menu" class="hover:text-brand-500">Menu</a>
          <a href="#features" class="hover:text-brand-500">Features</a>
          <a href="#scan" class="hover:text-brand-500">Scan QR</a>
        </nav>

        <div class="flex items-center gap-3">
          <!-- Theme toggle -->
          <button id="themeToggle" aria-label="Toggle theme" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <svg id="lightIcon" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v2M12 19v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 7a5 5 0 100 10 5 5 0 000-10z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <svg id="darkIcon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <!-- Cart preview -->
          <button id="cartBtnTop" class="relative p-2 rounded-lg bg-brand-600 text-white hover:brightness-105 shadow-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 3h2l1.6 9.59A2 2 0 0 0 8.55 15H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span id="cartCountTop" class="absolute -top-2 -right-2 bg-accent text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">0</span>
          </button>
        </div>
      </div>
    </header>

    <!-- HERO -->
    <section id="home" class="mt-28">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="space-y-6">
          <h1 class="text-4xl md:text-5xl font-bold leading-tight">Order faster — eat happier. <span class="text-accent">Smart QR</span></h1>
          <p class="text-gray-600 dark:text-gray-300 max-w-xl">Scan the table QR, browse the menu, customise your order and pay — all from your phone. Designed for speed and safety with a beautiful minimal UI.</p>

          <div class="flex items-center gap-3">
            <a href="#menu" class="inline-flex items-center gap-2 bg-brand-600 text-white px-5 py-3 rounded-lg shadow hover:shadow-lg transition">Explore Menu</a>
            <a href="#scan" class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-gray-200 dark:border-gray-700">How it works</a>
          </div>

          <div class="flex gap-4 mt-4">
            <div class="text-sm">
              <div class="font-semibold">Fast</div>
              <div class="text-gray-500">Order in seconds</div>
            </div>
            <div class="text-sm">
              <div class="font-semibold">Contactless</div>
              <div class="text-gray-500">Safe dining</div>
            </div>
            <div class="text-sm">
              <div class="font-semibold">Secure</div>
              <div class="text-gray-500">Payments & receipts</div>
            </div>
          </div>
        </div>

        <div class="relative">
          <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=900&q=80" alt="Hero food" class="rounded-2xl shadow-xl w-full h-80 object-cover" />

          <!-- small floating card -->
          <div class="absolute -bottom-6 left-6 bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-lg w-64 glass-dark">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg overflow-hidden">
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=200&q=60" alt="dish" class="w-full h-full object-cover" />
              </div>
              <div>
                <div class="font-semibold text-sm">Chef's Special</div>
                <div class="text-xs text-gray-400">Truffle Pasta • ₹449</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- MENU + QR SCAN -->
    <section id="menu" class="mt-20">
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- LEFT: Filters + QR -->
        <aside class="space-y-6">
          <div class="p-4 rounded-2xl glass shadow-sm">
            <h3 class="font-semibold mb-2">Your Table</h3>
            <div class="text-sm text-gray-500">Table: <span id="tableNo">A-12</span> • Party: <span id="partySize">2</span></div>
            <div class="mt-3">
              <label class="text-xs text-gray-400">Special notes</label>
              <textarea id="notes" class="mt-2 w-full rounded-lg border border-gray-200 dark:border-gray-700 p-2 text-sm" placeholder="Allergies or requests..."></textarea>
            </div>
            <button id="startOrder" class="mt-4 w-full py-2 rounded-lg bg-accent text-white font-medium">Start Ordering</button>
          </div>

          <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 shadow-sm">
            <h4 class="font-semibold mb-3">Scan QR (Preview)</h4>
            <div class="flex items-center gap-4">
              <div class="bg-white p-3 rounded-lg shadow-md">
                <!-- inline SVG QR so it always loads -->
                <svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                  <rect width="120" height="120" fill="#fff" />
                  <rect x="6" y="6" width="30" height="30" fill="#111" />
                  <rect x="84" y="6" width="30" height="30" fill="#111" />
                  <rect x="6" y="84" width="30" height="30" fill="#111" />
                  <rect x="48" y="48" width="6" height="6" fill="#111" />
                  <rect x="60" y="48" width="6" height="6" fill="#111" />
                  <rect x="48" y="60" width="6" height="6" fill="#111" />
                </svg>
              </div>
              <div class="text-sm text-gray-500">Scan to open menu on your phone — or use this preview to generate real QR codes for each table in backend.</div>
            </div>
          </div>

          <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 shadow-sm">
            <h4 class="font-semibold mb-3">Categories</h4>
            <div id="categoryList" class="flex flex-wrap gap-2"></div>
          </div>
        </aside>

        <!-- RIGHT: Menu grid and features -->
        <div class="lg:col-span-2">
          <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <input id="search" type="search" placeholder="Search dishes, categories..." class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 w-full md:w-96" />
            </div>
            <div class="text-sm text-gray-500">Tap a card to add • Swipe on mobile for quick actions</div>
          </div>

          <div id="menuGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>

          <!-- Features -->
          <div id="features" class="mt-10 grid md:grid-cols-3 gap-6">
            <div class="p-4 rounded-lg bg-white dark:bg-gray-800 shadow-sm fade-in">
              <h5 class="font-semibold">Fast Ordering</h5>
              <p class="text-sm text-gray-500">Place orders directly from your phone — no waiting for a server.</p>
            </div>
            <div class="p-4 rounded-lg bg-white dark:bg-gray-800 shadow-sm fade-in">
              <h5 class="font-semibold">Contactless</h5>
              <p class="text-sm text-gray-500">Reduce touchpoints and keep your guests safe.</p>
            </div>
            <div class="p-4 rounded-lg bg-white dark:bg-gray-800 shadow-sm fade-in">
              <h5 class="font-semibold">Easy Payments</h5>
              <p class="text-sm text-gray-500">Integrate payment methods and split bills easily.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CART MODAL (floating) -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-end sm:items-center justify-center z-50">
      <div class="w-full sm:max-w-2xl bg-white dark:bg-gray-800 rounded-t-2xl sm:rounded-2xl p-4 sm:p-6 shadow-xl">
        <div class="flex items-start justify-between">
          <h3 class="text-lg font-semibold">Your Order</h3>
          <button id="closeCart" class="text-gray-400 hover:text-gray-600">Close</button>
        </div>

        <div id="cartItems" class="mt-4 divide-y divide-gray-100 dark:divide-gray-700 max-h-64 overflow-auto"></div>

        <div class="mt-4 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Sub total</div>
            <div id="subTotal" class="font-semibold text-lg">₹0</div>
          </div>
          <div class="flex items-center gap-3">
            <button id="clearCart" class="px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700 text-sm">Clear</button>
            <button id="checkout" class="px-4 py-2 rounded-md bg-accent text-white font-medium">Checkout</button>
          </div>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <footer class="mt-16 py-8 text-center text-sm text-gray-500">
      <div>Made with ❤️ — Smart QR Bistro • © <span id="year"></span></div>
      <div class="mt-2">Follow us: <a class="underline" href="#">Instagram</a> • <a class="underline" href="#">Twitter</a></div>
    </footer>
  </div>

  <!-- SCRIPT: UI Logic, theme, menu -->
  <script>
    // Theme handling (remember preference)
    const themeKey = 'smartqr_theme';
    const root = document.documentElement;
    const darkIcon = document.getElementById('darkIcon');
    const lightIcon = document.getElementById('lightIcon');

    function applyTheme(theme){
      if(theme === 'dark') { root.classList.add('dark'); darkIcon.classList.add('hidden'); lightIcon.classList.remove('hidden'); }
      else { root.classList.remove('dark'); darkIcon.classList.remove('hidden'); lightIcon.classList.add('hidden'); }
      localStorage.setItem(themeKey, theme);
    }

    // initialize theme from localStorage or system
    (function(){
      const saved = localStorage.getItem(themeKey);
      if(saved) applyTheme(saved);
      else {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark ? 'dark' : 'light');
      }
    })();

    document.getElementById('themeToggle').addEventListener('click', () => {
      const isDark = document.documentElement.classList.contains('dark');
      applyTheme(isDark ? 'light' : 'dark');
    });

    // sample menu data (images from Unsplash reliable endpoints)
    const menuData = [
      { id:1, name:'Margherita Pizza', cat:'Pizza', price:299, desc:'Classic cheese & tomato', img:'https://images.unsplash.com/photo-1548365328-9a0a6b8c6a4f?auto=format&fit=crop&w=800&q=80' },
      { id:2, name:'Pepperoni Feast', cat:'Pizza', price:399, desc:'Loaded with pepperoni slices', img:'https://images.unsplash.com/photo-1606755962775-5f7b3ce2be2a?auto=format&fit=crop&w=800&q=80' },
      { id:3, name:'Truffle Pasta', cat:'Pasta', price:449, desc:'Creamy truffle sauce', img:'https://images.unsplash.com/photo-1604908177522-0f9752d6c0b1?auto=format&fit=crop&w=800&q=80' },
      { id:4, name:'Caesar Salad', cat:'Salad', price:199, desc:'Crispy greens & parmesan', img:'https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?auto=format&fit=crop&w=800&q=80' },
      { id:5, name:'Masala Dosa', cat:'South Indian', price:119, desc:'Crispy dosa with potato masala', img:'https://images.unsplash.com/photo-1604908177522-0f9752d6c0b1?auto=format&fit=crop&w=800&q=80' },
      { id:6, name:'Butter Chicken', cat:'Main Course', price:349, desc:'Rich tomato & butter gravy', img:'https://images.unsplash.com/photo-1604908177522-0f9752d6c0b1?auto=format&fit=crop&w=800&q=80' }
    ];

    // State
    let cart = {};

    // Elements
    const menuGrid = document.getElementById('menuGrid');
    const categoryList = document.getElementById('categoryList');
    const searchInput = document.getElementById('search');
    const cartCountTop = document.getElementById('cartCountTop');
    const cartModal = document.getElementById('cartModal');
    const cartItemsEl = document.getElementById('cartItems');
    const subTotalEl = document.getElementById('subTotal');

    // Render categories
    const categories = [...new Set(menuData.map(m => m.cat))];
    function renderCategories(){
      categoryList.innerHTML = '<button data-cat="all" class="px-3 py-1 rounded-full border">All</button>' + categories.map(c => ` <button data-cat="${c}" class="px-3 py-1 rounded-full border">${c}</button>` ).join('');
      categoryList.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => { filterAndRender(); categoryList.querySelectorAll('button').forEach(b => b.classList.remove('bg-brand-50')); btn.classList.add('bg-brand-50'); });
      });
    }

    function formatRupee(x){ return '₹' + x.toFixed(0); }

    function renderMenu(items){
      menuGrid.innerHTML = '';
      items.forEach(item => {
        const card = document.createElement('article');
        card.className = 'bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow hover:shadow-lg transition-transform hover:-translate-y-1 cursor-pointer';
        card.innerHTML = `
          <img src="${item.img}" alt="${item.name}" class="w-full h-40 object-cover" />
          <div class="p-4">
            <div class="flex items-start justify-between">
              <div>
                <h4 class="font-semibold">${item.name}</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">${item.desc}</p>
              </div>
              <div class="text-right">
                <div class="font-semibold">${formatRupee(item.price)}</div>
                <button data-id="${item.id}" class="mt-2 px-3 py-1 text-xs rounded-md bg-brand-50 text-brand-700 border border-brand-100">Add</button>
              </div>
            </div>
          </div>
        `;
        // add handlers
        card.querySelector('button').addEventListener('click', (e) => { e.stopPropagation(); addToCart(item.id); pulseCart(); });
        card.addEventListener('click', () => { addToCart(item.id); pulseCart(); });
        menuGrid.appendChild(card);
      });
    }

    function addToCart(id){
      const item = menuData.find(m => m.id === id);
      if(!item) return;
      if(!cart[id]) cart[id] = {...item, qty:0};
      cart[id].qty += 1;
      updateCartUI();
    }

    function changeQty(id, delta){
      if(!cart[id]) return;
      cart[id].qty += delta;
      if(cart[id].qty <= 0) delete cart[id];
      updateCartUI();
    }

    function updateCartUI(){
      const total = Object.values(cart).reduce((s,i)=>s+i.qty,0);
      const subtotal = Object.values(cart).reduce((s,i)=>s+(i.qty*i.price),0);
      cartCountTop.textContent = total;
      document.getElementById('cartCountTop').textContent = total;
      document.getElementById('cartCountTop').dataset.count = total;
      subTotalEl.textContent = formatRupee(subtotal);

      cartItemsEl.innerHTML = '';
      if(total === 0){
        cartItemsEl.innerHTML = '<div class="py-6 text-center text-sm text-gray-500">Your cart is empty. Tap items to add.</div>';
      } else {
        Object.values(cart).forEach(i => {
          const row = document.createElement('div');
          row.className = 'py-3 flex items-center justify-between gap-3';
          row.innerHTML = `
            <div>
              <div class="font-medium">${i.name}</div>
              <div class="text-xs text-gray-500">${formatRupee(i.price)} x ${i.qty}</div>
            </div>
            <div class="flex items-center gap-2">
              <button data-id="${i.id}" class="px-2 py-1 rounded-md border text-sm">-</button>
              <div class="text-sm w-6 text-center">${i.qty}</div>
              <button data-id="${i.id}" class="px-2 py-1 rounded-md border text-sm">+</button>
            </div>
          `;
          const btns = row.querySelectorAll('button');
          btns[0].addEventListener('click', () => { changeQty(i.id, -1); });
          btns[1].addEventListener('click', () => { changeQty(i.id, +1); });
          cartItemsEl.appendChild(row);
        });
      }
    }

    function pulseCart(){
      const el = document.getElementById('cartBtnTop');
      el.animate([{ transform: 'translateY(0)' }, { transform: 'translateY(-6px)' }, { transform: 'translateY(0)' }], { duration: 260, easing: 'ease-out' });
    }

    // modal controls
    document.getElementById('cartBtnTop').addEventListener('click', () => { openCart(); });
    document.getElementById('closeCart').addEventListener('click', () => { closeCart(); });
    document.getElementById('clearCart').addEventListener('click', () => { cart = {}; updateCartUI(); });
    document.getElementById('checkout').addEventListener('click', () => { alert('Checkout — integrate payment here. Order:\n' + JSON.stringify(cart)); });

    function openCart(){ cartModal.classList.remove('hidden'); cartModal.classList.add('flex'); updateCartUI(); }
    function closeCart(){ cartModal.classList.add('hidden'); cartModal.classList.remove('flex'); }

    // search & filter
    searchInput.addEventListener('input', filterAndRender);
    function filterAndRender(){
      const q = searchInput.value.trim().toLowerCase();
      const activeCatBtn = categoryList.querySelector('button.bg-brand-50');
      const cat = activeCatBtn ? activeCatBtn.dataset.cat : 'all';
      let items = menuData.filter(m => (cat === 'all' || m.cat === cat) && (m.name.toLowerCase().includes(q) || m.desc.toLowerCase().includes(q) || m.cat.toLowerCase().includes(q)));
      renderMenu(items);
    }

    // init
    renderCategories(); renderMenu(menuData); updateCartUI();

    // prefill table from URL (for QR integration demo)
    (function prefillFromURL(){ const params = new URLSearchParams(location.search); const t = params.get('table'); const p = params.get('party'); if(t) document.getElementById('tableNo').textContent = t; if(p) document.getElementById('partySize').textContent = p; })();

    // footer year
    document.getElementById('year').textContent = new Date().getFullYear();

    // accessibility: close cart with escape
    document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeCart(); });
  </script>
</body>
</html>
