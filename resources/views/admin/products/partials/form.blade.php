@php
    $product = $product ?? null;
    $selectedCategoryIds = $selectedCategoryIds ?? [];
    $variantRows = $variantRows ?? [];
    $existingProductImages = old('kept_images', $product?->galleryImages() ?? []);
@endphp

<style>
    .img-preview-box {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 10px;
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
    <h2>{{ $pageTitle }}</h2>
    <a href="{{ $backRoute }}" class="btn" style="background:var(--border-color); text-decoration:none;">กลับ</a>
</div>

<div class="card" style="max-width: 980px;">
    <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($formMethod !== 'POST')
            @method($formMethod)
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">SKU รหัสสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="sku" value="{{ old('sku', $product?->sku) }}" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ชื่อสินค้า <span style="color:red;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product?->name) }}" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
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
                <div id="imagePreviewContainer" style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;">
                    @foreach($existingProductImages as $index => $img)
                        <div class="img-preview-box" data-existing-preview>
                            <img src="{{ route('media.show', ['path' => $img]) }}" alt="img">
                            <button type="button" class="img-preview-remove" data-remove-existing>✕</button>
                            <input type="hidden" name="kept_images[]" value="{{ $img }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคาปลีกหลัก <span style="color:red;">*</span></label>
                <input type="number" name="retail_price" value="{{ old('retail_price', $product?->retail_price) }}" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">ราคารวมราคาส่งหลัก <span style="color:red;">*</span></label>
                <input type="number" name="wholesale_price" value="{{ old('wholesale_price', $product?->wholesale_price) }}" step="0.01" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                <small style="color:var(--text-muted);">เช่น 10 ชิ้น ราคา 4500</small>
            </div>

            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">จำนวนขั้นต่ำราคาส่งหลัก <span style="color:red;">*</span></label>
                <input type="number" name="wholesale_min_qty" value="{{ old('wholesale_min_qty', $product?->wholesale_min_qty ?? 10) }}" min="1" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                <small style="color:var(--text-muted);">ซื้อขั้นต่ำกี่ชิ้นจึงได้ราคารวมราคาส่งนี้</small>
            </div>
            <div>
                <label style="display:block; margin-bottom:10px; font-weight:500;">สต็อกสินค้าหลัก</label>
                <input type="number" name="stock" value="{{ old('stock', $product?->stock ?? 0) }}" min="0" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                <small style="color:var(--text-muted);">กรณีที่สินค้าไม่มีแยกสูตรย่อย</small>
            </div>

            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:10px; font-weight:500;">รายละเอียดสินค้า</label>
                <textarea name="description" rows="4" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">{{ old('description', $product?->description) }}</textarea>
            </div>
            <div style="grid-column: 1 / -1;">
                <label style="display:flex; align-items:center; gap:10px; font-weight:500;">
                    <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product?->is_new_arrival) ? 'checked' : '' }}>
                    แสดงในหมวดสินค้าใหม่
                </label>
            </div>
        </div>

        <div style="border-top:1px solid var(--border-color); padding-top:24px; margin-top:12px;">
            <div class="header-actions" style="margin-bottom:16px;">
                <div>
                    <h3 style="margin:0;">สูตรสินค้าย่อย</h3>
                    <p style="margin:6px 0 0; color:var(--text-muted);">แต่ละสูตรกำหนดราคาปลีก, ราคาส่งแบบยกชุด, จำนวนขั้นต่ำ และอัปโหลดหลายรูปได้</p>
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
                        <input type="hidden" data-field="id" value="{{ $variant['id'] ?? '' }}">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div style="grid-column: 1 / -1;">
                                <label style="display:block; margin-bottom:8px;">ชื่อสินค้าย่อย / ชื่อสูตร</label>
                                <input type="text" data-field="name" value="{{ $variant['name'] ?? '' }}" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <label style="display:block; margin-bottom:8px;">รายละเอียดสูตร (ถ้ามี)</label>
                                <textarea data-field="description" rows="2" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">{{ $variant['description'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">ราคาปลีกสูตร</label>
                                <input type="number" step="0.01" data-field="retail_price" value="{{ $variant['retail_price'] ?? '' }}" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">ราคารวมราคาส่งสูตร</label>
                                <input type="number" step="0.01" data-field="wholesale_price" value="{{ $variant['wholesale_price'] ?? '' }}" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">จำนวนขั้นต่ำราคาส่งสูตร</label>
                                <input type="number" min="1" data-field="wholesale_min_qty" value="{{ $variant['wholesale_min_qty'] ?? old('wholesale_min_qty', $product?->wholesale_min_qty ?? 10) }}" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div>
                                <label style="display:block; margin-bottom:8px;">สต็อกสูตรนี้</label>
                                <input type="number" data-field="stock" value="{{ $variant['stock'] ?? '' }}" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <label style="display:block; margin-bottom:8px;">รูปสูตร (หลายรูปได้)</label>
                                <input type="file" data-field="images" data-array="true" data-variant-images-input multiple accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                                <div data-variant-preview-container style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;">
                                    @foreach(($variant['images'] ?? []) as $image)
                                        <div class="img-preview-box" data-existing-preview>
                                            <img src="{{ route('media.show', ['path' => $image]) }}" alt="img">
                                            <button type="button" class="img-preview-remove" data-remove-existing>✕</button>
                                            <input type="hidden" data-field="kept_images" data-array="true" value="{{ $image }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1.1rem; margin-top:24px;">{{ $submitLabel }}</button>
    </form>
</div>

<template id="variantTemplate">
    <div class="variant-card" data-variant-card style="border:1px solid var(--border-color); border-radius:16px; padding:18px; background:#fafbff;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <strong>สูตรที่ <span data-variant-number></span></strong>
            <button type="button" class="btn" data-remove-variant style="background:#fee2e2; color:#dc2626;">ลบสูตรนี้</button>
        </div>
        <input type="hidden" data-field="id" value="">
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
                <label style="display:block; margin-bottom:8px;">ราคารวมราคาส่งสูตร</label>
                <input type="number" step="0.01" data-field="wholesale_price" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:8px;">จำนวนขั้นต่ำราคาส่งสูตร</label>
                <input type="number" min="1" data-field="wholesale_min_qty" value="{{ old('wholesale_min_qty', $product?->wholesale_min_qty ?? 10) }}" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:8px;">สต็อกสูตรนี้</label>
                <input type="number" data-field="stock" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
            <div style="grid-column: 1 / -1;">
                <label style="display:block; margin-bottom:8px;">รูปสูตร (หลายรูปได้)</label>
                <input type="file" data-field="images" data-array="true" data-variant-images-input multiple accept="image/*" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                <div data-variant-preview-container style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;"></div>
            </div>
        </div>
    </div>
</template>

<script>
    const imagesInput = document.getElementById('imagesInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    let productFiles = new DataTransfer();

    function buildPreviewBox(src, isNew = false) {
        const box = document.createElement('div');
        box.className = 'img-preview-box';
        if (isNew) {
            box.dataset.newPreview = 'true';
        } else {
            box.dataset.existingPreview = 'true';
        }
        box.innerHTML = `<img src="${src}" alt="preview"><button type="button" class="img-preview-remove">${String.fromCharCode(10005)}</button>`;
        return box;
    }

    function refreshProductPreview() {
        if (!imagesInput) return;

        imagesInput.files = productFiles.files;
        previewContainer.querySelectorAll('[data-new-preview]').forEach((node) => node.remove());

        Array.from(productFiles.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (event) => {
                const box = buildPreviewBox(event.target.result, true);
                box.querySelector('.img-preview-remove').addEventListener('click', () => {
                    const nextFiles = new DataTransfer();
                    Array.from(productFiles.files).forEach((item, fileIndex) => {
                        if (fileIndex !== index) {
                            nextFiles.items.add(item);
                        }
                    });
                    productFiles = nextFiles;
                    refreshProductPreview();
                });
                previewContainer.appendChild(box);
            };
            reader.readAsDataURL(file);
        });
    }

    imagesInput?.addEventListener('change', function () {
        Array.from(this.files).forEach((file) => productFiles.items.add(file));
        refreshProductPreview();
    });

    previewContainer?.addEventListener('click', (event) => {
        if (event.target.matches('[data-remove-existing]')) {
            event.target.closest('[data-existing-preview]')?.remove();
        }
    });

    const variantList = document.getElementById('variantList');
    const variantTemplate = document.getElementById('variantTemplate');
    const addVariantButton = document.getElementById('addVariantButton');

    function nameFieldForIndex(field, index) {
        const baseName = field.dataset.field || field.name?.match(/\]\[(.+?)\](\[\])?$/)?.[1];
        if (!baseName) return;
        const suffix = field.dataset.array === 'true' ? '[]' : '';
        field.name = `variants[${index}][${baseName}]${suffix}`;
    }

    function setupVariantCard(card) {
        if (!card || card.dataset.previewReady === 'true') return;
        card.dataset.previewReady = 'true';
        card._variantFiles = new DataTransfer();

        const input = card.querySelector('[data-variant-images-input]');
        const container = card.querySelector('[data-variant-preview-container]');

        const refreshVariantPreview = () => {
            if (!input || !container) return;
            input.files = card._variantFiles.files;
            container.querySelectorAll('[data-new-preview]').forEach((node) => node.remove());

            Array.from(card._variantFiles.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const box = buildPreviewBox(event.target.result, true);
                    box.querySelector('.img-preview-remove').addEventListener('click', () => {
                        const nextFiles = new DataTransfer();
                        Array.from(card._variantFiles.files).forEach((item, fileIndex) => {
                            if (fileIndex !== index) {
                                nextFiles.items.add(item);
                            }
                        });
                        card._variantFiles = nextFiles;
                        refreshVariantPreview();
                    });
                    container.appendChild(box);
                };
                reader.readAsDataURL(file);
            });
        };

        input?.addEventListener('change', function () {
            Array.from(this.files).forEach((file) => card._variantFiles.items.add(file));
            refreshVariantPreview();
        });

        container?.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-existing]')) {
                event.target.closest('[data-existing-preview]')?.remove();
            }
        });
    }

    function renumberVariantCards() {
        const cards = variantList.querySelectorAll('[data-variant-card]');

        cards.forEach((card, index) => {
            card.querySelector('[data-variant-number]').textContent = index + 1;
            card.querySelectorAll('[data-field], [name]').forEach((field) => nameFieldForIndex(field, index));
            setupVariantCard(card);
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
            const card = cards[0];
            card.querySelectorAll('input, textarea').forEach((field) => {
                if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = false;
                } else if (field.type === 'file') {
                    field.value = '';
                } else {
                    field.value = '';
                }
            });
            card.querySelectorAll('[data-existing-preview], [data-new-preview]').forEach((node) => node.remove());
            card._variantFiles = new DataTransfer();
            renumberVariantCards();
            return;
        }

        removeButton.closest('[data-variant-card]')?.remove();
        renumberVariantCards();
    });

    renumberVariantCards();
</script>
