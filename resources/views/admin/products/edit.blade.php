@extends('layouts.admin')

@section('content')
<style>
    .img-preview-box {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background: #f8fafc;
        flex-shrink: 0;
    }
    .img-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .img-preview-remove {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(220, 38, 38, 0.9);
        color: white;
        border: none;
        border-radius: 999px;
        width: 22px;
        height: 22px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .category-checkboxes {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        max-height: 200px;
        overflow-y: auto;
        background: white;
    }
    .category-checkboxes label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 400;
        cursor: pointer;
    }
</style>

<div class="header-actions">
    <h2>แก้ไขสินค้า: {{ $product->sku }}</h2>
    <a href="{{ route('admin.products.index') }}" class="btn" style="background:var(--border-color); text-decoration:none;">กลับ</a>
</div>

@php
    $variantRows = old('variants', $product->variants->map(fn ($variant) => [
        'id' => $variant->id,
        'name' => $variant->name,
        'description' => $variant->description,
        'retail_price' => $variant->retail_price,
        'wholesale_price' => $variant->wholesale_price,
        'stock' => $variant->stock,
        'image_url' => $variant->image ? asset('storage/' . $variant->image) : null,
    ])->toArray());

    if (empty($variantRows)) {
        $variantRows = [['name' => '', 'description' => '', 'retail_price' => '', 'wholesale_price' => '', 'stock' => '']];
    }
    
    $selectedCategoryIds = old('category_ids', $product->categories->pluck('id')->toArray());
@endphp

<div class="card" style="max-width: 980px;">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">SKU รหัสสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ชื่อสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:10px; font-weight:500;">หมวดหมู่ (เลือกได้มากกว่า 1) <span style="color:red;">*</span></label>
                <div class="category-checkboxes">
                    @foreach($categories as $cat)
                        <label>
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCategoryIds) ? 'checked' : '' }}>
                            {{ $cat->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:10px; font-weight:500;">รูปภาพสินค้า (อัปโหลดเพิ่มได้)</label>
                <input type="file" id="imagesInput" name="images[]" multiple accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                
                <div id="imagePreviewContainer" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px;">
                    <!-- Existing Images -->
                    @if(is_array($product->images))
                        @foreach($product->images as $index => $img)
                            <div class="img-preview-box" id="existing_img_{{ $index }}">
                                <img src="{{ asset('storage/' . $img) }}" alt="img">
                                <button type="button" class="img-preview-remove" onclick="removeExistingImage('{{ $img }}', 'existing_img_{{ $index }}')">✕</button>
                                <input type="hidden" name="kept_images[]" value="{{ $img }}">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาปลีกหลัก <span style="color:red;">*</span></label>
                <input type="number" name="retail_price" value="{{ old('retail_price', $product->retail_price) }}" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาส่งหลัก <span style="color:red;">*</span></label>
                <input type="number" name="wholesale_price" value="{{ old('wholesale_price', $product->wholesale_price) }}" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">จำนวนขั้นต่ำราคาส่งหลัก <span style="color:red;">*</span></label>
                <input type="number" name="wholesale_min_qty" value="{{ old('wholesale_min_qty', $product->wholesale_min_qty) }}" min="1" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                <small style="color:var(--text-muted);">ซื้อตั้งแต่กี่ชิ้นถึงได้ราคาส่ง</small>
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">สต็อกสินค้าหลัก</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                <small style="color:var(--text-muted);">กรณีที่สินค้าไม่มีแยกสูตรย่อย</small>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:10px; font-weight:500;">รายละเอียดสินค้า</label>
                <textarea name="description" rows="4" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">{{ old('description', $product->description) }}</textarea>
            </div>
            <div style="grid-column: 1 / -1;">
                <label style="display:flex; align-items:center; gap:10px; font-weight:500;">
                    <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                    แสดงในหมวดสินค้าใหม่
                </label>
            </div>
        </div>

        <div style="border-top:1px solid var(--border-color); padding-top:24px; margin-top:12px;">
            <div class="header-actions" style="margin-bottom:16px;">
                <div>
                    <h3 style="margin:0;">สูตรสินค้าย่อย</h3>
                    <p style="margin:6px 0 0; color:var(--text-muted);">เลือกรูปและราคาแยกตามสูตรได้</p>
                </div>
                <button type="button" id="addVariantButton" class="btn btn-primary">+ เพิ่มสูตร</button>
            </div>

            <div id="variantList" style="display:grid; gap:16px;">
                @foreach($variantRows as $index => $variant)
                    <div class="variant-card" data-variant-card style="border:1px solid var(--border-color); border-radius:16px; padding:18px; background:#fafbff;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <strong>สูตรที่ <span data-variant-number>{{ $index + 1 }}</span></strong>
                            <button type="button" class="btn" data-remove-variant style="background:#fee2e2; color:#dc2626;">ลบสูตรนี้</button>
                        </div>
                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant['id'] ?? '' }}" data-field="id">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div style="grid-column: 1 / -1;">
                                <label style="display:block; margin-bottom:8px;">ชื่อสินค้าย่อย / ชื่อสูตร</label>
                                <input type="text" name="variants[{{ $index }}][name]" value="{{ $variant['name'] ?? '' }}" data-field="name" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <label style="display:block; margin-bottom:8px;">รายละเอียดสูตร (ถ้ามี)</label>
                                <textarea name="variants[{{ $index }}][description]" data-field="description" rows="2" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">{{ $variant['description'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">ราคาปลีกสูตร</label>
                                <input type="number" step="0.01" name="variants[{{ $index }}][retail_price]" value="{{ $variant['retail_price'] ?? '' }}" data-field="retail_price" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">ราคาส่งสูตร</label>
                                <input type="number" step="0.01" name="variants[{{ $index }}][wholesale_price]" value="{{ $variant['wholesale_price'] ?? '' }}" data-field="wholesale_price" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">สต็อก</label>
                                <input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant['stock'] ?? '' }}" data-field="stock" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">รูปสูตร</label>
                                @if(!empty($variant['image_url']))
                                    <div style="margin-bottom:8px;"><img src="{{ $variant['image_url'] }}" alt="img" style="max-width:100px; border-radius:8px;"></div>
                                @endif
                                <input type="file" name="variants[{{ $index }}][image]" data-field="image" accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1.1rem; margin-top:24px;">บันทึกการแก้ไข</button>
    </form>
</div>

<template id="variantTemplate">
    <div class="variant-card" data-variant-card style="border:1px solid var(--border-color); border-radius:16px; padding:18px; background:#fafbff;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <strong>สูตรที่ <span data-variant-number></span></strong>
            <button type="button" class="btn" data-remove-variant style="background:#fee2e2; color:#dc2626;">ลบสูตรนี้</button>
        </div>
        <input type="hidden" data-field="id">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:8px;">ชื่อสินค้าย่อย / ชื่อสูตร</label>
                <input type="text" data-field="name" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:8px;">รายละเอียดสูตร (ถ้ามี)</label>
                <textarea data-field="description" rows="2" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;"></textarea>
            </div>
            <div>
                <label style="display:block; margin-bottom:8px;">ราคาปลีกสูตร</label>
                <input type="number" step="0.01" data-field="retail_price" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:8px;">ราคาส่งสูตร</label>
                <input type="number" step="0.01" data-field="wholesale_price" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:8px;">สต็อก</label>
                <input type="number" data-field="stock" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:8px;">รูปสูตร</label>
                <input type="file" data-field="image" accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
    // ----------------------------------------
    // Multiple Images Preview Logic (Edit)
    // ----------------------------------------
    const imagesInput = document.getElementById('imagesInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    
    window.removeExistingImage = function(path, domId) {
        document.getElementById(domId).remove();
    };

    let dataTransfer = new DataTransfer();

    imagesInput.addEventListener('change', function(e) {
        Array.from(this.files).forEach(file => {
            dataTransfer.items.add(file);
        });
        updateInputAndPreview();
    });

    function updateInputAndPreview() {
        imagesInput.files = dataTransfer.files;
        
        // Remove only the newly added preview boxes, keep existing_img
        document.querySelectorAll('.img-preview-box.is-new').forEach(el => el.remove());
        
        Array.from(imagesInput.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.createElement('div');
                box.className = 'img-preview-box is-new';
                box.innerHTML = `
                    <img src="${e.target.result}" alt="preview">
                    <button type="button" class="img-preview-remove" onclick="removeNewImage(${index})">✕</button>
                `;
                previewContainer.appendChild(box);
            }
            reader.readAsDataURL(file);
        });
    }

    window.removeNewImage = function(indexToRemove) {
        const newDataTransfer = new DataTransfer();
        Array.from(imagesInput.files).forEach((file, index) => {
            if (index !== indexToRemove) {
                newDataTransfer.items.add(file);
            }
        });
        dataTransfer = newDataTransfer;
        updateInputAndPreview();
    };

    // ----------------------------------------
    // Variant Logic
    // ----------------------------------------
    const variantList = document.getElementById('variantList');
    const variantTemplate = document.getElementById('variantTemplate');
    const addVariantButton = document.getElementById('addVariantButton');

    function renumberVariantCards() {
        const cards = variantList.querySelectorAll('[data-variant-card]');

        cards.forEach((card, index) => {
            card.querySelector('[data-variant-number]').textContent = index + 1;

            card.querySelectorAll('[name], [data-field]').forEach((field) => {
                const fieldName = field.dataset.field || field.name.match(/\]\[(.+)\]$/)?.[1];
                if (!fieldName) return;
                field.name = `variants[${index}][${fieldName}]`;
            });
        });
    }

    addVariantButton?.addEventListener('click', () => {
        const fragment = variantTemplate.content.cloneNode(true);
        variantList.appendChild(fragment);
        renumberVariantCards();
    });

    variantList?.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-variant]');
        if (!removeButton) return;

        const cards = variantList.querySelectorAll('[data-variant-card]');
        if (cards.length === 1) {
            cards[0].querySelectorAll('input, textarea').forEach((input) => {
                if (input.type === 'hidden') {
                    input.value = '';
                    return;
                }
                input.value = '';
            });
            return;
        }

        removeButton.closest('[data-variant-card]')?.remove();
        renumberVariantCards();
    });

    renumberVariantCards();
</script>
@endsection
