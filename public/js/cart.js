const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

document.addEventListener("DOMContentLoaded", loadCart);

let loader = ` <div class="spinner">
           <div class="spinner1"></div>
            </div>`;

const $cartDrawer = $("#cartDrawer");
const $overlay = $("#cartOverlay");

function open_cart() {
    $overlay.removeClass("hidden");
    $cartDrawer.removeClass("translate-x-full");
    $("html").addClass("overflow-hidden");
}

// Open Cart side bar
$(document).on("click", ".cart", function (e) {
    e.preventDefault();
    loadCart();
    open_cart();
});

// Close Cart
function closeCart() {
    $cartDrawer.addClass("translate-x-full");
    $("html").removeClass("overflow-hidden");

    setTimeout(function () {
        $overlay.addClass("hidden");
    }, 300);
}

// Close button
$(document).on("click", "#closeCart", function () {
    closeCart();
});

// Click outside
$(document).on("click", "#cartOverlay", function () {
    closeCart();
});

// to manage the cart addition
$(document).on("submit", ".cart-form", function (e) {
    e.preventDefault();

    let form = $(this);
    let button = form.find("button");

    // Prevent duplicate requests
    if (button.prop("disabled")) {
        return;
    }

    let originalHtml = button.data("original-html");

    // Store the original HTML only once
    if (!originalHtml) {
        originalHtml = button.html();
        button.data("original-html", originalHtml);
    }

    $.ajax({
        url: form.attr("action"),
        type: "POST",
        data: form.serialize(),
        beforeSend: function () {
            button.prop("disabled", true);

            button.html(`
                <span class="inline-flex items-center gap-2">
                    <span>${originalHtml}</span>
                    ${loader}
                </span>
            `);
        },

        success: async function (response) {
            await loadCart();
            open_cart();

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

            // Restore the original button after 2 seconds
            // setTimeout(() => {
            //     button.html(originalHtml);
            // }, 2000);
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            button.html(originalHtml);
        },

        complete: function () {
            button.prop("disabled", false);
        },
    });
});

// async function loadCart() {
//     let res = await fetch('/cart/json');
//     let data = await res.json();

//     console.log(data)

//     let html = '';

//     if (data.items.length === 0) {
//         html = `
//         <div class="flex flex-col items-center justify-center h-full py-20 text-center">
//             <i class="fa-solid fa-cart-shopping text-5xl text-gray-400 mb-4"></i>

//             <h3 class="text-xl font-medium text-gray-800">
//                 Your Cart is Empty
//             </h3>

//             <p class="text-gray-500 mt-2 font-normal">
//                 Fill your cart with amazing items
//             </p>

//             <a href="/"
//                 class="mt-6 inline-flex items-center rounded-lg bg-[#163A6B] hover:bg-[#102F59] px-4 py-2 text-white font-medium  transition">
//                 Shop Now
//             </a>
//         </div>
//     `;
//     } else {
//         data.items.forEach(item => {

//             let savePercent = '';
//             if (item.price && item.discount_price && item.discount_price < item.price) {
//                 let percent = Math.round(((item.price - item.discount_price) / item.price) * 100);
//                 savePercent = `
//                 <div class="text-[10px] text-green-600">
//                     Save ${percent}%
//                 </div>
//             `;
//             }

//             html += `
//         <div class="flex gap-2 mb-4 cart-item-container">

//             <div class="relative shrink-0 cart-loader">
//                 <button onclick="removeItem('${item.key}',this)"
//                     class="absolute -left-1 -top-1 w-3.5 h-3.5 rounded-full border bg-white text-[10px] text-gray-500 flex items-center justify-center">
//                     ×
//                 </button>

//                 <img src="${item.image}"
//                     class="w-[50px] h-[50px] border rounded object-cover">
//             </div>

//             <div class="flex-1">

//                 <div class="flex justify-between">
//                     <h3 class="text-[13px] font-semibold text-gray-800 leading-4">
//                         ${item.name}
//                     </h3>

//                     <div class="text-right">
//                         <span class="text-[10px] text-red-400 line-through mr-2">
//                             Rs ${item.price}
//                         </span>
//                         <span class="text-[13px] font-semibold">
//                             Rs ${item.discount_price ?? item.price}
//                         </span>
//                     </div>
//                 </div>

//                 <div class="flex items-top justify-between mt-1">

//                     <div class="inline-flex h-6 overflow-hidden rounded border border-gray-300">
//                         <button onclick="updateQty('${item.key}', 'decrease',this)"
//                             class="flex h-6 w-6 items-center justify-center text-sm text-gray-600 hover:bg-gray-100">
//                             −
//                         </button>

//                         <span class="flex h-6 w-6 items-center justify-center border-x text-xs">
//                             ${item.quantity}
//                         </span>

//                         <button onclick="updateQty('${item.key}', 'increase',this)"
//                             class="flex h-6 w-6 items-center justify-center text-sm text-gray-600 hover:bg-gray-100">
//                             +
//                         </button>
//                     </div>

//                     ${savePercent}

//                 </div>
//             </div>
//         </div>
//         `;
//         });
//     }
//     document.getElementById('cart_total').innerHTML = data.total
//     document.getElementById('cart_count').innerHTML = data.total_count ?? 0;
//     document.getElementById('review_cart').innerHTML = data.total_count ?? 0;
//     document.getElementById('cart-container').innerHTML = html;
// }

async function loadCart() {
    let res = await fetch("/cart/json");
    let data = await res.json();

    console.log(data);

    let html = "";

    if (data.items.length === 0) {
        html = `
        <div class="flex flex-col items-center justify-center h-full py-20 text-center">
            <i class="fa-solid fa-cart-shopping text-5xl text-gray-400 mb-4"></i>

            <h3 class="text-xl font-medium text-gray-800">
                Your Cart is Empty
            </h3>

            <p class="text-gray-500 mt-2 font-normal">
                Fill your cart with amazing items
            </p>

            <a href="/"
                class="mt-6 inline-flex items-center rounded-lg bg-[#163A6B] hover:bg-[#102F59] px-4 py-2 text-white font-medium transition">
                Shop Now
            </a>
        </div>
    `;
    } else {
        data.items.forEach((item) => {
            let savePercent = "";
            if (
                item.price &&
                item.discount_price &&
                item.discount_price < item.price
            ) {
                let percent = Math.round(
                    ((item.price - item.discount_price) / item.price) * 100,
                );
                savePercent = `
                <div class="text-[11px] text-emerald-600 font-medium mt-0.5">
                    Save ${percent}%
                </div>
            `;
            }

            html += `
            <div class="cart-item-container flex items-start gap-4 mb-4 p-4 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                
                <div class="relative shrink-0 cart-loader">
                    <img src="${item.image}"
                        class="w-20 h-20 rounded-xl border border-[#E6ECF5] bg-white p-1 shadow-sm object-cover transition-all duration-300 hover:shadow-md">
                </div>

                <div class="flex-1 flex flex-col justify-between min-h-[80px]">
                    <div>
                        <h3 class="text-[14px] font-semibold text-gray-800 leading-tight line-clamp-2">
                            ${item.name}
                        </h3>
                    </div>
                    
                    <div class="flex items-center mt-2">
                        <div class="inline-flex h-8 overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                            <button
                                onclick="updateQty('${item.key}', 'decrease', this)"
                                class="flex h-8 w-8 items-center justify-center text-sm text-gray-600 hover:bg-gray-150 transition-colors">
                                −
                            </button>
                            <span class="flex h-8 w-8 items-center justify-center border-x border-gray-200 bg-white text-sm font-medium text-gray-800">
                                ${item.quantity}
                            </span>
                            <button
                                onclick="updateQty('${item.key}', 'increase', this)"
                                class="flex h-8 w-8 items-center justify-center text-sm text-gray-600 hover:bg-gray-150 transition-colors">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <div class="shrink-0 flex flex-col items-end justify-between min-h-[64px] text-right">
                    <div>
                        <span class="text-[14px] font-bold text-[#163A6B] block leading-none">
                            Rs ${item.discount_price ?? item.price}
                        </span>
                        <span class="text-[11px] text-gray-400 line-through block mt-1 leading-none">
                            Rs ${item.price}
                        </span>
                        ${savePercent}
                    </div>

                    <button
                        onclick="removeItem('${item.key}', this)"
                        class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-red-500 hover:text-red-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-3.5 h-3.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 7H5M10 11V17M14 11V17M6 7L7 19C7.1 20.1 7.9 21 9 21H15C16.1 21 16.9 20.1 17 19L18 7M9 7V5C9 4.4 9.4 4 10 4H14C14.6 4 15 4.4 15 5V7"/>
                        </svg>
                        Remove
                    </button>
                </div>

            </div>
            `;
        });
    }
    document.getElementById("cart_total").innerHTML = data.total;
    document.getElementById("cart_count").innerHTML = data.total_count ?? 0;
    document.getElementById("review_cart").innerHTML = data.total_count ?? 0;
    document.getElementById("cart-container").innerHTML = html;
}

async function updateQty(key, action, ele) {
    let image = $(ele).closest(".cart-item-container").find(".cart-loader");
    let originalHtml = image.html();
    image.html(`<span class="relative">
        ${originalHtml}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        ${loader}
    </div>
</span>
        `);

    await fetch("/cart/update", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
        },
        body: JSON.stringify({
            key,
            action,
        }),
    });

    loadCart(); // refresh UI
}

async function removeItem(key, ele) {
    // before send message
    let image = $(ele).closest(".cart-loader");
    let originalHtml = image.html();
    image.html(`<span class="relative">
        ${originalHtml}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        ${loader}
    </div>
</span>
        `);

    try {
        const response = await fetch("/cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify({ key }),
        });

        if (!response.ok) {
            throw new Error("Failed to remove item");
        }

        // Reload cart
        await loadCart();

        // Success message
    } catch (error) {
        showToast("Something went wrong.", "error");
        console.error(error);
    }
}
