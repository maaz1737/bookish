@extends('admin.layout')

@section('title', 'Attribute Values')

@section('content')

    <div class="container py-4">

        <div class="mb-3">
            <h4 class="fw-bold">Arrange Attributes & Select Values</h4>
            <small class="text-muted">Product: {{ $product->name }}</small>
        </div>

        <form method="POST" action="{{ route("admin.product.variants.store", $product->slug) }}">
            @csrf

            <!-- DRAGGABLE LIST -->
            <div id="attributeList">

                @foreach($product->attributes as $attribute)
                    <div class="attribute-row" data-id="{{ $attribute->id }}">

                        <!-- Drag Handle -->
                        <div class="drag-handle">☰</div>

                        <!-- Attribute Name -->
                        <div class="attr-title">
                            {{ $attribute->name }}
                        </div>

                        <!-- VALUES -->
                        <div class="attr-values">

                            @foreach($attribute->values as $value)
                                <label class="value-item">

                                    <input type="checkbox" name="attribute_values[{{ $attribute->id }}][]" value="{{ $value->id }}">

                                    <span class="value-box">
                                        {{ $value->value }}
                                    </span>

                                </label>
                            @endforeach

                        </div>

                    </div>
                @endforeach

            </div>

            <input type="hidden" name="attribute_order" id="attribute_order">

            <div class="text-end mt-4">
                <button class="btn btn-primary px-4">
                    Save
                </button>
            </div>

        </form>
    </div>

    <!-- STYLE -->
    <style>
        /* ROW */
        .attribute-row {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fff;
        }

        /* DRAG HANDLE */
        .drag-handle {
            cursor: grab;
            font-size: 20px;
            color: #888;
            padding: 0 8px;
        }

        /* ATTRIBUTE TITLE */
        .attr-title {
            min-width: 140px;
            font-weight: 600;
        }

        /* VALUES WRAP */
        .attr-values {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        /* VALUE ITEM */
        .value-item {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .value-item input {
            margin-right: 6px;
        }

        /* BOX STYLE */
        .value-box {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 13px;
            background: #f8f9fa;
            transition: 0.2s;
        }

        /* CHECKED STYLE */
        .value-item input:checked+.value-box {
            background: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }
    </style>

    <!-- SORTABLE SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const list = document.getElementById('attributeList');

            new Sortable(list, {
                animation: 150,
                handle: '.drag-handle',
                draggable: '.attribute-row',
                onEnd: function () {

                    let order = [];

                    document.querySelectorAll('.attribute-row').forEach(function (row) {
                        order.push(row.dataset.id);
                    });

                    document.getElementById('attribute_order').value = order.join(',');
                }
            });

        });
    </script>

@endsection