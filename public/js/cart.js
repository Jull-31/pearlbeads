class ShoppingCart {
    constructor() {
        console.log('🛒 ShoppingCart initializing...');
        this.items = JSON.parse(localStorage.getItem('pearlbeads_cart')) || [];
        this.init();
    }

    init() {
        console.log('📦 Current items:', this.items);
        this.updateUI();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Pastikan event listener terpasang setelah DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            const checkoutBtn = document.querySelector('button[onclick*="openOrderModal"]');
            if (checkoutBtn) {
                console.log('✅ Checkout button found');
                // Tambah event listener langsung (backup dari onclick)
                checkoutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🔘 Checkout button clicked!');
                    this.openOrderModal();
                });
            } else {
                console.warn('⚠️ Checkout button not found');
            }
        });
    }

    save() {
        localStorage.setItem('pearlbeads_cart', JSON.stringify(this.items));
        console.log('💾 Cart saved:', this.items);
        this.updateUI();
    }

    // --- LOGIKA BARANG ---
    addItem(product) {
        console.log('➕ Adding item:', product);
        const existing = this.items.find(item => item.id === product.id);
        if (existing) {
            existing.quantity += 1;
        } else {
            this.items.push({ ...product, quantity: 1 });
        }
        this.save();
        this.toggleCartSidebar(true);
    }

    removeItem(id) {
        console.log('🗑️ Removing item:', id);
        this.items = this.items.filter(item => item.id !== id);
        this.save();
    }

    updateQuantity(id, qty) {
        console.log('🔢 Update quantity:', id, qty);
        const item = this.items.find(item => item.id === id);
        if (item) {
            item.quantity = parseInt(qty);
            if (item.quantity <= 0) {
                this.removeItem(id);
            } else {
                this.save();
            }
        }
    }

    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    // --- LOGIKA TAMPILAN (UI) ---
    updateUI() {
        console.log('🎨 Updating UI...');
        
        // 1. Badge Angka (FIX: Pastikan badge muncul)
        const badge = document.getElementById('cartBadge');
        const count = this.items.reduce((acc, item) => acc + item.quantity, 0);
        if (badge) {
            badge.innerText = count;
            badge.style.transform = count > 0 ? 'scale(1)' : 'scale(0)';
            badge.style.display = count > 0 ? 'flex' : 'none';
            console.log('🔴 Badge updated:', count);
        }

        // 2. Total Harga (FIX: Format yang benar tanpa duplikasi)
        const totalEl = document.getElementById('cartTotal');
        if (totalEl) {
            const formatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(this.getTotal());
            totalEl.innerText = formatted;
            console.log('💰 Total updated:', formatted);
        }

        // 3. List Barang
        const container = document.getElementById('cartItems');
        if (!container) {
            console.warn('⚠️ Cart container not found');
            return;
        }

        if (this.items.length === 0) {
            container.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    <p class="text-4xl mb-2">🛒</p>
                    <p class="font-bold">Keranjang kosong</p>
                    <p class="text-sm">Yuk belanja dulu! 😊</p>
                </div>`;
        } else {
            container.innerHTML = this.items.map(item => `
                <div class="flex gap-3 bg-white p-3 rounded-xl shadow-sm border border-gray-100 mb-3 relative hover:shadow-md transition">
                    <img src="/images/products/${item.image}" 
                         class="w-16 h-16 object-cover rounded-lg bg-gray-100" 
                         onerror="this.src='https://via.placeholder.com/100?text=No+Image'"
                         alt="${item.name}">
                    <div class="flex-1">
                        <h4 class="font-bold text-sm text-gray-800 line-clamp-1">${item.name}</h4>
                        <p class="text-purple-600 font-bold text-xs">
                            ${new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(item.price)}
                        </p>
                        <div class="flex items-center gap-2 mt-2">
                            <button onclick="cart.updateQuantity(${item.id}, ${item.quantity - 1})" 
                                    class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded text-sm font-bold transition">-</button>
                            <span class="text-sm font-bold w-8 text-center">${item.quantity}</span>
                            <button onclick="cart.updateQuantity(${item.id}, ${item.quantity + 1})" 
                                    class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded text-sm font-bold transition">+</button>
                        </div>
                    </div>
                    <button onclick="cart.removeItem(${item.id})" 
                            class="absolute top-3 right-3 text-red-400 hover:text-red-600 text-lg transition">
                        🗑️
                    </button>
                </div>
            `).join('');
        }
    }

    // --- FITUR SIDEBAR & MODAL ---
    toggleCartSidebar(forceOpen = false) {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        
        if (!sidebar || !overlay) {
            console.error('❌ Sidebar or overlay not found');
            return;
        }

        const isOpen = !sidebar.classList.contains('translate-x-full');
        
        if (forceOpen || !isOpen) {
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            console.log('📂 Cart opened');
        } else {
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
            console.log('📁 Cart closed');
        }
    }

    openOrderModal() {
        console.log('🚀 Opening order modal...');
        console.log('📦 Items in cart:', this.items.length);
        
        if (this.items.length === 0) {
            alert('Keranjang masih kosong! 🛒');
            return;
        }

        // ==========================================
        // CEK LOGIN (SATPAM) - INI YANG DITAMBAHKAN
        // ==========================================
        if (typeof window.isLoggedIn !== 'undefined' && !window.isLoggedIn) {
            if(confirm('Ups! Kamu harus Login dulu untuk Checkout.\n\nMau login sekarang?')) {
                window.location.href = '/login';
            }
            return; // Stop, jangan lanjut buka modal
        }

        const modal = document.getElementById('orderModal');
        if (!modal) {
            console.error('❌ Modal element not found!');
            alert('Error: Modal tidak ditemukan!');
            return;
        }

        // Force display
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        modal.style.opacity = '1';
        console.log('✅ Modal opened successfully');
        
        // Set default pickup time (besok jam 10 pagi)
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow.setHours(10, 0, 0, 0);
        const pickupInput = document.getElementById('pickupTime');
        if (pickupInput) {
            pickupInput.value = tomorrow.toISOString().slice(0, 16);
        }
    }

    closeOrderModal() {
        console.log('❌ Closing order modal...');
        const modal = document.getElementById('orderModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
            console.log('✅ Modal closed');
        }
    }

    // --- CHECKOUT KE WA ---
    async confirmAndSendWA() {
        console.log('📤 Sending to WhatsApp...');
        
        const name = document.getElementById('customerName').value.trim();
        const time = document.getElementById('pickupTime').value;

        if (!name || !time) {
            alert('Mohon isi Nama & Jadwal Pengambilan! ⚠️');
            return;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            if (!csrfToken) {
                console.error('❌ CSRF token not found');
                throw new Error('CSRF token tidak ditemukan');
            }

            console.log('📡 Sending checkout request...');
            
            const response = await fetch('/checkout', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    pickup_time: time,
                    total: this.getTotal(),
                    items: this.items
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('✅ Server response:', result);

            if (result.status === 'success') {
                const phone = '6285328171427';
                let message = `*🛍️ ORDER BARU #${result.order_id}*\n\n`;
                message += `👤 Nama: ${name}\n`;
                message += `📅 Pickup: ${new Date(time).toLocaleString('id-ID', {
                    dateStyle: 'full',
                    timeStyle: 'short'
                })}\n`;
                message += `━━━━━━━━━━━━━━━━\n`;
                
                this.items.forEach((item, index) => {
                    message += `${index + 1}. ${item.name} (${item.quantity}x) - Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}\n`;
                });
                
                message += `━━━━━━━━━━━━━━━━\n`;
                message += `*TOTAL: Rp ${new Intl.NumberFormat('id-ID').format(this.getTotal())}*\n\n`;
                message += `Terima kasih sudah berbelanja di Pearlbeads! 💜`;

                const waUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                console.log('📱 Opening WhatsApp...');
                window.open(waUrl, '_blank');
                
                // Reset & reload
                setTimeout(() => {
                    this.items = [];
                    this.save();
                    this.closeOrderModal();
                    window.location.reload();
                }, 500);
                
            } else {
                throw new Error(result.message || 'Checkout gagal');
            }
        } catch (error) {
            console.error('❌ Checkout error:', error);
            alert('Gagal melakukan checkout: ' + error.message);
        }
    }
}

// INISIALISASI GLOBAL
console.log('🚀 Loading ShoppingCart...');

function initCart() {
    if (typeof window.cart === 'undefined') {
        window.cart = new ShoppingCart();
        console.log('✅ Cart initialized successfully');
    }
}

// Multiple initialization points untuk memastikan cart selalu ter-load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCart);
} else {
    initCart();
}

// Backup initialization
window.addEventListener('load', () => {
    if (typeof window.cart === 'undefined') {
        console.warn('⚠️ Cart not initialized, retrying...');
        initCart();
    }
});