<!DOCTYPE html><html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Katalog Produk - Inventory System">
    <title>Katalog Produk | Inventory System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── Reset & Base ──────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary:   #0f1117;
            --bg-card:      #1a1d27;
            --bg-card-hover:#222633;
            --border:       rgba(255,255,255,.06);
            --text-primary: #e8eaed;
            --text-secondary:#9aa0ab;
            --accent:       #6c5ce7;
            --accent-light: #a29bfe;
            --success:      #00cec9;
            --warning:      #fdcb6e;
            --danger:       #ff7675;
            --radius:       14px;
            --shadow:       0 4px 24px rgba(0,0,0,.35);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ── Header / Navbar ───────────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 2.5rem;
            background: rgba(15,17,23,.75);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }
        .navbar-brand {
            display: flex; align-items: center; gap: .65rem;
            font-weight: 700; font-size: 1.2rem; color: var(--text-primary);
            text-decoration: none;
        }
        .navbar-brand .logo-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            border-radius: 8px;
            display: grid; place-items: center;
            font-size: .9rem;
        }
        .navbar-stats {
            display: flex; gap: 1.5rem; font-size: .85rem; color: var(--text-secondary);
        }
        .navbar-stats span strong {
            color: var(--text-primary);
        }

        /* ── Hero / Page Title ─────────────────────────────── */
        .hero {
            padding: 3rem 2.5rem 2rem;
            background: linear-gradient(180deg, rgba(108,92,231,.08) 0%, transparent 100%);
        }
        .hero h1 {
            font-size: 2rem; font-weight: 700;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p {
            margin-top: .35rem; color: var(--text-secondary); font-size: .95rem;
        }

        /* ── Search & Filter Bar ───────────────────────────── */
        .toolbar {
            display: flex; flex-wrap: wrap; gap: 1rem;
            padding: 0 2.5rem 2rem;
        }
        .search-box {
            flex: 1 1 280px;
            display: flex; align-items: center; gap: .5rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: .6rem 1rem;
            transition: border-color .2s;
        }
        .search-box:focus-within { border-color: var(--accent); }
        .search-box svg { flex-shrink: 0; color: var(--text-secondary); }
        .search-box input {
            flex: 1; border: none; outline: none;
            background: transparent; color: var(--text-primary);
            font-family: inherit; font-size: .9rem;
        }
        .search-box input::placeholder { color: var(--text-secondary); }

        .filter-btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .6rem 1.1rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--text-secondary);
            font-family: inherit; font-size: .85rem; cursor: pointer;
            transition: all .2s;
        }
        .filter-btn:hover, .filter-btn.active {
            border-color: var(--accent); color: var(--accent-light);
        }

        /* ── Product Grid ──────────────────────────────────── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            padding: 0 2.5rem 3rem;
        }

        .product-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: transform .25s, box-shadow .25s, border-color .25s;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: rgba(108,92,231,.3);
        }

        .card-header {
            padding: 1.25rem 1.25rem .75rem;
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .card-sku {
            font-size: .7rem; text-transform: uppercase; letter-spacing: .08em;
            color: var(--accent-light); font-weight: 600;
        }
        .card-status {
            font-size: .7rem; font-weight: 600;
            padding: .2rem .55rem; border-radius: 6px;
        }
        .card-status.active   { background: rgba(0,206,201,.12); color: var(--success); }
        .card-status.inactive { background: rgba(255,118,117,.12); color: var(--danger); }

        .card-body { padding: 0 1.25rem 1rem; }
        .card-body h3 {
            font-size: 1.05rem; font-weight: 600; margin-bottom: .35rem;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .card-category {
            display: inline-block;
            font-size: .75rem; color: var(--text-secondary);
            background: rgba(255,255,255,.04);
            padding: .15rem .55rem; border-radius: 6px;
            margin-bottom: .75rem;
        }

        .card-footer {
            display: flex; justify-content: space-between; align-items: center;
            padding: .85rem 1.25rem;
            border-top: 1px solid var(--border);
        }
        .card-price {
            font-size: 1.15rem; font-weight: 700;
            background: linear-gradient(135deg, var(--accent-light), var(--success));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .card-stock {
            font-size: .8rem; color: var(--text-secondary);
        }
        .card-stock strong { color: var(--text-primary); }

        /* ── Style button ───────────────────────────────────── */
        .delete-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            padding: 0;
            background-color: #fee2e2; /* Merah sangat muda */
            color: #ef4444; /* Merah standar */
            border: 1px solid #fecaca;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .delete-btn:hover {
            background-color: #ef4444;
            color: white;
            border-color: #dc2626;
            transform: scale(1.1);
        }

        .delete-btn svg {
            display: block;
        }

        /* ── Style button edit ───────────────────────────────────── */
        .edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background-color: #e0f2fe; /* Biru muda */
            color: #0284c7; /* Biru standar */
            border: 1px solid #bae6fd;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 4px;
        }
        .edit-btn:hover {
            background-color: #0284c7;
            color: white;
        }

        /* ── Empty State ───────────────────────────────────── */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center; padding: 4rem 1rem;
            color: var(--text-secondary);
        }
        .empty-state svg { margin-bottom: 1rem; opacity: .4; }
        .empty-state h3 { color: var(--text-primary); margin-bottom: .4rem; }

        /* ── Responsive ────────────────────────────────────── */
        @media (max-width: 640px) {
            .navbar, .hero, .toolbar, .product-grid { padding-left: 1rem; padding-right: 1rem; }
            .hero h1 { font-size: 1.5rem; }
            .product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ── Navbar ─────────────────────────────────────── -->
    <nav class="navbar" id="navbar">
        <a href="/katalog" class="navbar-brand">
            <span class="logo-icon">📦</span>
            Inventory System
        </a>
        <div class="navbar-stats">
            <span>Total Produk: <strong id="totalCount">{{ count($products) }}</strong></span>
        </div>
    </nav>

    <!-- ── Hero ───────────────────────────────────────── -->
    <section class="hero">
        <h1>Katalog Produk</h1>
        <p>Kelola dan pantau seluruh produk inventaris Anda.</p>
    </section>

    <!-- ── Toolbar ────────────────────────────────────── -->
    <div class="toolbar" id="toolbar">
        <button class="filter-btn active" onclick="fetchByCategory('all', this)">Semua Produk</button>
        
        @foreach($categories as $cat)
            <button class="filter-btn" onclick="fetchByCategory('{{ $cat }}', this)">{{ $cat }}</button>
        @endforeach

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari produk...">
        </div>
    </div>

    <!-- ── Product Grid ───────────────────────────────── -->
    <section class="product-grid" id="productGrid">

        @forelse ($products as $product)
        <div class="product-card">
            <div class="card-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="card-sku">{{ $product->sku }}</span>
                    <button 
                        class="edit-btn" 
                        title="Edit Produk"
                        data-product='@json($product)'
                        onclick="handleEdit(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </button>
                    
                    <button 
                        class="delete-btn" 
                        title="Hapus Produk"
                        data-id="{{ $product->id }}"
                        onclick="handleDelete(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>
                </div>
                <span class="card-status {{ strtolower($product->status) === 'active' ? 'active' : 'inactive' }}">
                    {{ ucfirst($product->status) }}
                </span>
            </div>
            <div class="card-body">
                <h3>{{ $product->name }}</h3>
                <span class="card-category">{{ $product->category }}</span>
            </div>
            <div class="card-footer">
                <span class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="card-stock">Stok: <strong>{{ $product->stock }}</strong></span>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            <h3>Belum Ada Produk</h3>
            <p>Produk yang ditambahkan akan muncul di sini.</p>
        </div>
        @endforelse

    </section>

    <section class="toolbar" style="flex-direction: column; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
        <h2 style="font-size: 1.2rem; color: var(--text-dark);">➕ Tambah Produk Baru</h2>
        <form id="formProduk" style="display: flex; gap: 10px; width: 100%; flex-wrap: wrap;">
            <div class="search-box" style="flex: 1; min-width: 200px;">
                <input type="text" id="newName" placeholder="Nama Produk" required>
            </div>
            <div class="search-box" style="width: 150px;">
                <input type="text" id="newSku" placeholder="SKU" required>
            </div>
            <div class="search-box" style="width: 150px;">
                <input type="text" id="newCategory" placeholder="Kategori (Contoh: Clothing)" required>
            </div>
            <div class="search-box" style="width: 120px;">
                <input type="number" id="newPrice" placeholder="Harga" required>
            </div>
            <div class="search-box" style="width: 100px;">
                <input type="number" id="newStock" placeholder="Stok">
            </div>
            <button type="submit" class="filter-btn active" style="background: var(--primary-color); border: none;">
                Simpan
            </button>
        </form>
        <div id="statusPesan"></div>
    </section>

    <script>
        // ── Search & Filter ─────────────────────────────
        const searchInput = document.getElementById('searchInput');
        const cards       = document.querySelectorAll('.product-card');
        const filterBtns  = document.querySelectorAll('.filter-btn');
        let activeFilter  = 'all';

        function applyFilters() {
            const query = searchInput.value.toLowerCase().trim();
            let visible = 0;

            cards.forEach(card => {
                const name   = card.dataset.name;
                const sku    = card.dataset.sku;
                const status = card.dataset.status;

                const matchSearch = !query || name.includes(query) || sku.includes(query);
                const matchFilter = activeFilter === 'all' || status === activeFilter;

                const show = matchSearch && matchFilter;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            document.getElementById('totalCount').textContent = visible;
        }

        searchInput.addEventListener('input', applyFilters);

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeFilter = btn.dataset.filter;
                applyFilters();
            });
        });

        // ── Logic Tambah Produk ke API ──────────────────
        const formProduk = document.getElementById('formProduk');
        const statusPesan = document.getElementById('statusPesan');

        formProduk.addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                name: document.getElementById('newName').value,
                sku: document.getElementById('newSku').value,
                category: document.getElementById('newCategory').value,
                price: document.getElementById('newPrice').value,
                stock: document.getElementById('newStock').value
            };

            fetch('/api/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    statusPesan.innerHTML = `<small style="color:green">✅ ${result.message}</small>`;
                    // Refresh otomatis untuk melihat produk baru di grid
                    setTimeout(() => location.reload(), 1000);
                } else {
                    // Jika SKU duplikat atau validasi gagal
                    const errorMsg = result.errors ? Object.values(result.errors).flat().join(', ') : result.message;
                    statusPesan.innerHTML = `<small style="color:red">❌ ${errorMsg}</small>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusPesan.innerHTML = `<small style="color:red">❌ Terjadi kesalahan koneksi.</small>`;
            });
        });

        function fetchByCategory(kategori, element) {
            // 1. Ubah tampilan tombol aktif
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');

            // 2. Panggil API GET dengan parameter REQUIRED (?category=...)
            fetch(`/api/products?category=${kategori}`)
                .then(response => response.json())
                .then(result => {
                    const grid = document.getElementById('productGrid');
                    grid.innerHTML = ''; 

                    result.data.forEach(product => {
                        // Ubah objek menjadi string JSON yang aman untuk atribut HTML
                        const productString = JSON.stringify(product).replace(/'/g, "&apos;");

                        const card = `
                            <div class="product-card">
                                <div class="card-header">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="card-sku">${product.sku}</span>
                                        
                                        <button class="edit-btn" data-product='${productString}' onclick="handleEdit(this)">
                                            <svg>...</svg>
                                        </button>
                                        
                                        <button class="delete-btn" data-id="${product.id}" onclick="handleDelete(this)">
                                            <svg>...</svg>
                                        </button>
                                    </div>
                                    <span class="card-status ${product.status.toLowerCase()}">${product.status}</span>
                                </div>
                                ...
                            </div>
                        `;
                        grid.innerHTML += card;
                    });

                    // Update total count
                    document.getElementById('totalCount').textContent = result.data.length;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function deleteProduct(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                fetch(`/api/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Penting untuk keamanan Laravel
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert(result.message);
                        location.reload(); // Refresh untuk melihat perubahan
                    } else {
                        alert('Gagal menghapus: ' + result.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function editProduct(product) {
            // Isi form dengan data yang mau diedit
            document.getElementById('newName').value = product.name;
            document.getElementById('newSku').value = product.sku;
            document.getElementById('newSku').disabled = true; // SKU biasanya tidak boleh diedit
            document.getElementById('newCategory').value = product.category;
            document.getElementById('newPrice').value = product.price;
            document.getElementById('newStock').value = product.stock;

            // Ubah tombol simpan menjadi tombol Update
            const submitBtn = document.querySelector('#formProduk button');
            submitBtn.textContent = 'Update Data';
            submitBtn.onclick = function(e) {
                e.preventDefault();
                updateProduct(product.id);
            };
        }

        function updateProduct(id) {
            const data = {
                name: document.getElementById('newName').value,
                category: document.getElementById('newCategory').value,
                price: document.getElementById('newPrice').value,
                stock: document.getElementById('newStock').value
            };

            fetch(`/api/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('Berhasil diupdate!');
                    location.reload();
                }
            });
        }

        function openEditModal(product) {
            // 1. Isi input modal dengan data produk yang diklik
            document.getElementById('editId').value = product.id;
            document.getElementById('editName').value = product.name;
            document.getElementById('editCategory').value = product.category;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editStock').value = product.stock;

            // 2. Tampilkan Modal
            document.getElementById('modalEdit').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        // Event listener untuk tombol "Simpan" di dalam Modal
        document.getElementById('formUpdateProduk').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            
            const data = {
                name: document.getElementById('editName').value,
                category: document.getElementById('editCategory').value,
                price: document.getElementById('editPrice').value,
                stock: document.getElementById('editStock').value
            };

            fetch(`/api/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('Data berhasil diperbarui!');
                    location.reload();
                }
            });
        });

        function handleEdit(element) {
            // Mengambil data dari atribut data-product yang sudah diconvert jadi objek
            const product = JSON.parse(element.getAttribute('data-product'));
            openEditModal(product);
        }
        function handleDelete(element) {
            const id = element.getAttribute('data-id');
            deleteProduct(id);
        }
    </script>
    
</body>
</html>