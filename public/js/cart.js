const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

document.addEventListener('DOMContentLoaded', loadCart);


const $cartDrawer = $('#cartDrawer');
const $overlay = $('#cartOverlay');


function open_cart() {
    $overlay.removeClass('hidden');
    $cartDrawer.removeClass('translate-x-full');
    $('html').addClass('overflow-hidden');
}


// Open Cart side bar
$(document).on('click', '.cart', function (e) {
    e.preventDefault();
    open_cart();
    loadCart();
});

// Close Cart
function closeCart() {
    $cartDrawer.addClass('translate-x-full');
    $('html').removeClass('overflow-hidden');

    setTimeout(function () {
        $overlay.addClass('hidden');
    }, 300);
}

// Close button
$(document).on('click', '#closeCart', function () {
    closeCart();
});

// Click outside
$(document).on('click', '#cartOverlay', function () {
    closeCart();
});



// to manage the cart addition
$(document).on('submit', '.cart-form', function (e) {
    e.preventDefault();

    let form = $(this);
    let button = form.find('button');
    let originalHtml = button.html();

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),

        beforeSend: function () {
            button.html(`
        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"></circle>
        </svg>
    `);
            button.prop('disabled', true);
        },

        success: function (response) {
            open_cart();
            loadCart();

            button.html(`
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="inline-block w-4 h-4 mr-1"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
                Added to Cart
            `);

            console.log(response.message);
        },

        error: function (xhr) {
            console.log(xhr.responseText);
        },

        complete: function () {
            // button.html(originalHtml);
            button.prop('disabled', false);
        }
    });
});




async function loadCart() {
    let res = await fetch('/cart/json');
    let data = await res.json();

    console.log(data)

    let html = '';

    data.items.forEach(item => {

        let savePercent = '';
        if (item.price && item.discount_price && item.discount_price < item.price) {
            let percent = Math.round(((item.price - item.discount_price) / item.price) * 100);
            savePercent = `
    <div class="text-[10px] text-green-600">
        Save ${percent}%
    </div>
    `;
        }

        html += `
    <div class="flex gap-2 mb-4">

        <div class="relative shrink-0">
            <button onclick="removeItem('${item.key}')"
                class="absolute -left-1 -top-1 w-3.5 h-3.5 rounded-full border bg-white text-[10px] text-gray-500 flex items-center justify-center">
                ×
            </button>

           <img src="${storageUrl}/${item.image}"
     class="w-[50px] h-[50px] border rounded object-cover">
        </div>

        <div class="flex-1">

            <div class="flex justify-between">
                <h3 class="text-[13px] font-semibold text-gray-800 leading-4">
                    ${item.name}
                </h3>

                <div class="text-right">
                    <span class="text-[10px] text-red-400 line-through mr-2">
                        Rs ${item.price}
                    </span>
                    <span class="text-[13px] font-semibold">
                        Rs ${item.discount_price ?? item.price}
                    </span>
                </div>
            </div>

            <div class="flex items-top justify-between mt-1">

                <div class="inline-flex h-6 overflow-hidden rounded border border-gray-300">

                    <button onclick="updateQty('${item.key}', 'decrease')"
                        class="flex h-6 w-6 items-center justify-center text-sm text-gray-600 hover:bg-gray-100">
                        −
                    </button>

                    <span class="flex h-6 w-6 items-center justify-center border-x text-xs">
                        ${item.quantity}
                    </span>

                    <button onclick="updateQty('${item.key}', 'increase')"
                        class="flex h-6 w-6 items-center justify-center text-sm text-gray-600 hover:bg-gray-100">
                        +
                    </button>

                </div>

                ${savePercent}

            </div>
        </div>
    </div>
    `;
    });

    console.log(data.total_count);

    document.getElementById('cart_total').innerHTML = data.total

    if (data.total_count != undefined) {
        document.getElementById('cart_count').innerHTML = data.total_count ?? 0;
    }
    else {
        document.getElementById('cart_count').innerHTML = 0;
    }

    document.getElementById('cart-container').innerHTML = html;
}



async function updateQty(key, action) {
    await fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            key,
            action
        })
    });

    loadCart(); // refresh UI
}



async function removeItem(key) {
    await fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ key })
    });

    loadCart();
}