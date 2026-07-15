@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<h3 class="mb-3">Transaksi Baru</h3>

<form action="{{ route('kasir.transactions.store') }}" method="POST" id="form-transaction">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">Pilih Meja</label>
                    <select name="table_id" class="form-select" required>
                        <option value="">-- Pilih Meja --</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->table_number }} ({{ $table->capacity }} orang)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <label class="form-label">Daftar Menu</label>
                    <div class="row g-2" style="max-height: 500px; overflow-y: auto;">
                        @foreach($menus as $menu)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $menu->name }}</strong><br>
                                        <small class="text-muted">{{ $menu->category->name }} - Rp {{ number_format($menu->price, 0, ',', '.') }}</small><br>
                                        <small class="text-muted">Stok: {{ $menu->stock }}</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary btn-add-item"
                                        data-id="{{ $menu->id }}"
                                        data-name="{{ $menu->name }}"
                                        data-price="{{ $menu->price }}"
                                        data-stock="{{ $menu->stock }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Keranjang</h5>
                    <div id="cart-items">
                        <p class="text-muted" id="cart-empty">Belum ada item.</p>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label class="form-label">Diskon (Rp)</label>
                        <input type="number" name="discount" id="discount" value="0" min="0" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Pajak / PPN (%)</label>
                        <input type="number" name="tax_percentage" id="tax_percentage" value="0" min="0" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Pajak</span>
                        <span id="tax-display">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Grand Total</span>
                        <span id="grand-total">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3" id="btn-submit" disabled>
                        Proses Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let cart = [];

function formatRupiah(number) {
    return 'Rp ' + Math.round(number).toLocaleString('id-ID');
}

function renderCart() {
    const container = document.getElementById('cart-items');
    const emptyText = document.getElementById('cart-empty');

    if (cart.length === 0) {
        container.innerHTML = '';
        container.appendChild(emptyText);
        document.getElementById('btn-submit').disabled = true;
    } else {
        container.innerHTML = '';
        document.getElementById('btn-submit').disabled = false;

        cart.forEach((item, index) => {
            const row = document.createElement('div');
            row.className = 'd-flex justify-content-between align-items-center mb-2';
            row.innerHTML = `
                <div>
                    <small>${item.name}</small><br>
                    <small class="text-muted">${formatRupiah(item.price)} x ${item.qty}</small>
                    <input type="hidden" name="items[${index}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-decrease" data-index="${index}">-</button>
                    <span>${item.qty}</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-increase" data-index="${index}">+</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove" data-index="${index}"><i class="bi bi-x"></i></button>
                </div>
            `;
            container.appendChild(row);
        });
    }

    calculateTotal();
}

function calculateTotal() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const taxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
    const tax = subtotal * (taxPercentage / 100);
    const grandTotal = subtotal - discount + tax;

    document.getElementById('subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('tax-display').textContent = formatRupiah(tax);
    document.getElementById('grand-total').textContent = formatRupiah(grandTotal < 0 ? 0 : grandTotal);
}

document.querySelectorAll('.btn-add-item').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        const stock = parseInt(this.dataset.stock);

        const existing = cart.find(item => item.id === id);

        if (existing) {
            if (existing.qty < stock) {
                existing.qty++;
            } else {
                Swal.fire('Stok tidak cukup', `Stok ${name} tersisa ${stock}`, 'warning');
            }
        } else {
            if (stock > 0) {
                cart.push({ id, name, price, qty: 1, stock });
            } else {
                Swal.fire('Stok habis', `${name} sedang tidak tersedia`, 'warning');
            }
        }

        renderCart();
    });
});

document.getElementById('cart-items').addEventListener('click', function(e) {
    const index = e.target.closest('button')?.dataset.index;
    if (index === undefined) return;

    if (e.target.closest('.btn-increase')) {
        if (cart[index].qty < cart[index].stock) {
            cart[index].qty++;
        } else {
            Swal.fire('Stok tidak cukup', `Stok tersisa ${cart[index].stock}`, 'warning');
        }
    } else if (e.target.closest('.btn-decrease')) {
        cart[index].qty--;
        if (cart[index].qty <= 0) cart.splice(index, 1);
    } else if (e.target.closest('.btn-remove')) {
        cart.splice(index, 1);
    }

    renderCart();
});

document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax_percentage').addEventListener('input', calculateTotal);

document.getElementById('form-transaction').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        Swal.fire('Keranjang kosong', 'Tambahkan minimal 1 menu.', 'warning');
    }
});
</script>
@endpush