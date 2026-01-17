// Cart System - Pearlbeads.co
class ShoppingCart {
    constructor() {
        this.items = this.getCartFromStorage();
        this.init();
    }

    init() {
        this.updateCartUI();
        this.setupEventListeners();
    }

    getCartFromStorage() {
        const cart = localStorage.getItem('pearlbeads_cart');
        return cart ? JSON.parse(cart) : [];
    }

    saveCartToStorage() {
        localStorage.setItem('pearlbeads_cart', JSON.stringify(this.items));
    }

    addItem(product) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }

        this.saveCartToStorage();
        this.updateCartUI();
        this.showNotification('Product added to cart!');
    }

    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveCartToStorage();
        this.updateCartUI();
    }

    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity = parseInt(quantity);
            if (item.quantity <= 0) {
                this.removeItem(productId);
            } else {
                this.saveCartToStorage();
                this.updateCartUI();
            }
        }
    }

    clearCart() {
        this.items = [];
        this.saveCartToStorage();
        this.updateCartUI();
    }

    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getItemCount() {
        return this.items.reduce((count, item) => count + item.quantity, 0);
    }

    updateCartUI() {
        // Update cart badge
        const cartBadge = document.getElementById('cartBadge');
        const itemCount = this.getItemCount();
        
        if (cartBadge) {
            cartBadge.textContent = itemCount;
            cartBadge.style.display = itemCount > 0 ? 'flex' : 'none';
        }

        // Update cart sidebar
        this.renderCartItems();
        this.updateCartTotal();
    }

    renderCartItems() {
        const cartItemsContainer = document.getElementById('cartItems');
        
        if (!cartItemsContainer) return;

        if (this.items.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <p class="text-gray-500">Your cart is empty</p>
                </div>
            `;
            return;
        }

        cartItemsContainer.innerHTML = this.items.map(item => `
            <div class="flex items-center space-x-4 bg-white p-4 rounded-lg shadow-sm mb-3">
                <img src="/images/products/${item.image}" 
                     alt="${item.name}" 
                     class="w-16 h-16 object-cover rounded"
                     onerror="this.src='https://via.placeholder.com/100'">
                
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800 text-sm">${item.name}</h4>
                    <p class="text-purple-600 font-bold text-sm">Rp ${this.formatPrice(item.price)}</p>
                    
                    <div class="flex items-center space-x-2 mt-2">
                        <button onclick="cart.updateQuantity(${item.id}, ${item.quantity - 1})" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-6 h-6 rounded flex items-center justify-center">
                            <span class="text-lg">−</span>
                        </button>
                        <input type="number" 
                               value="${item.quantity}" 
                               min="1"
                               onchange="cart.updateQuantity(${item.id}, this.value)"
                               class="w-12 text-center border border-gray-300 rounded">
                        <button onclick="cart.updateQuantity(${item.id}, ${item.quantity + 1})" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-6 h-6 rounded flex items-center justify-center">
                            <span class="text-lg">+</span>
                        </button>
                    </div>
                </div>
                
                <button onclick="cart.removeItem(${item.id})" 
                        class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        `).join('');
    }

    updateCartTotal() {
        const totalElement = document.getElementById('cartTotal');
        if (totalElement) {
            totalElement.textContent = this.formatPrice(this.getTotal());
        }
    }

    formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
    }

    // MODIFIKASI: Membuka Modal, bukan langsung ke WA
    sendToWhatsApp() {
        // Cek login (jika fitur ini ada)
        if (window.AUTH && !window.AUTH.loggedIn) {
            this.showLoginModal();
            return;
        }

        if (this.items.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Tampilkan modal input nama & jadwal yang ada di layout
        const modal = document.getElementById('orderModal');
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.error("Modal 'orderModal' tidak ditemukan di layout!");
        }
    }

    // FUNGSI FINAL: Mengirim ke WhatsApp setelah input modal valid
    confirmAndSendWA() {
        const nameInput = document.getElementById('customerName');
        const timeInput = document.getElementById('pickupTime');

        if (!nameInput.value || !timeInput.value) {
            alert('Mohon isi Nama dan Jadwal Pengambilan terlebih dahulu!');
            return;
        }

        const phone = '6283836295352';
        let message = `*🛍️ ORDER DARI PEARLBEADS.CO*\n\n`;
        message += `👤 *Nama:* ${nameInput.value}\n`;
        message += `⏰ *Jadwal Ambil:* ${new Date(timeInput.value).toLocaleString('id-ID')}\n`;
        message += `━━━━━━━━━━━━━━━━━━\n\n`;
        message += `*Detail Pesanan:*\n`;

        this.items.forEach((item, index) => {
            message += `${index + 1}. *${item.name}*\n`;
            message += `   Harga: Rp ${this.formatPrice(item.price)}\n`;
            message += `   Jumlah: ${item.quantity}\n`;
            message += `   Subtotal: Rp ${this.formatPrice(item.price * item.quantity)}\n\n`;
        });

        message += '━━━━━━━━━━━━━━━━━━\n';
        message += `*TOTAL: Rp ${this.formatPrice(this.getTotal())}*\n\n`;
        message += '_Mohon konfirmasi pesanan ini. Terima kasih!_ 🙏';

        window.open(
            `https://wa.me/${phone}?text=${encodeURIComponent(message)}`,
            '_blank'
        );

        // Reset & Tutup
        document.getElementById('orderModal').classList.add('hidden');
        nameInput.value = '';
        timeInput.value = '';
        this.clearCart();
    }

    showLoginModal() {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-[110] flex items-center justify-center';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4">
                <div class="text-center">
                    <div class="mb-6">
                        <svg class="w-20 h-20 mx-auto text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Login Required</h3>
                    <p class="text-gray-600 mb-6">You need to login first to complete your order</p>
                    <div class="flex space-x-3">
                        <button onclick="this.closest('.fixed').remove()" 
                                class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button onclick="window.location.href='/login'" 
                                class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            Login Now
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    toggleCartSidebar() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        
        if (sidebar && overlay) {
            const isOpen = sidebar.classList.contains('translate-x-0');
            
            if (isOpen) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            }
        }
    }

    setupEventListeners() {
        const overlay = document.getElementById('cartOverlay');
        if (overlay) {
            overlay.addEventListener('click', () => this.toggleCartSidebar());
        }
    }

    showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down';
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
}

// Inisialisasi
if (!window.location.pathname.startsWith('/admin')) {
    window.cart = new ShoppingCart();
}

// Global functions agar bisa dipanggil dari HTML onclick
function sendToWhatsApp() {
    window.cart.sendToWhatsApp();
}

function confirmAndSendWA() {
    window.cart.confirmAndSendWA();
}

function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    if (modal) modal.classList.add('hidden');
}