<?php

use Illuminate\Support\Facades\Route;

// Storefront
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\SchoolController;
use App\Http\Controllers\Storefront\BundleController as StoreBundleController;
use App\Http\Controllers\Storefront\ProductController as StoreProductController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\OrderTrackController;
use App\Http\Controllers\ContactController;
// Auth
use App\Http\Controllers\Auth\OtpAuthController;

// Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SchoolController as AdminSchoolController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\BundleController as AdminBundleController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AttributeController;

/* ------------------------------ Storefront ------------------------------ */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/bundles', [StoreBundleController::class, 'index'])->name('bundles.index');
Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::get('/school/{school}', [SchoolController::class, 'show'])->name('schools.show');


Route::get('/testing', function () {
    return view('user.categories.categories');
});

Route::get('/testing2', function () {
    return view('user.categories.categories_testing');
});


// SEO bundle route: /school/{school}/{class}/bundle
Route::get('/school/{school}/{classSlug}/bundle', [StoreBundleController::class, 'show'])->name('bundle.show');

Route::get('/products', [StoreProductController::class, 'index'])->name('products.index');
Route::get('/category/{slug}', [StoreProductController::class, 'category'])->name('category.show');
Route::get('/product/{product}', [StoreProductController::class, 'show'])->name('product.show');
Route::get('/get-classes/{school}', [StoreProductController::class, 'getClasses'])->name('get.Classes');
// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/product/{product}', [CartController::class, 'addProduct'])->name('cart.addProduct');
Route::post('/cart/bundle/{bundle}', [CartController::class, 'addBundle'])->name('cart.addBundle');
Route::delete('/cart/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout (guest checkout always available)
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
Route::post('/checkout/{order}', [CheckoutController::class, 'statusUpdate'])->name('checkout.update');
Route::get('/checkout/{orderNumber}/bank', [CheckoutController::class, 'bank'])->name('checkout.bank');
Route::post('/checkout/{orderNumber}/proof', [CheckoutController::class, 'uploadProof'])->name('checkout.proof');
Route::get('/checkout/{order}/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Order tracking
Route::get('/track/{orderNumber}', [OrderTrackController::class, 'show'])->name('order.track');

/* -------------------------------- Auth ---------------------------------- */
// Route::get('/login', [OtpAuthController::class, 'showLogin'])->name('login');
// Route::post('/login/send-otp', [OtpAuthController::class, 'sendOtp'])->name('login.sendOtp');
// Route::post('/login/verify-otp', [OtpAuthController::class, 'verifyOtp'])->name('login.verifyOtp');
Route::post('/logout', [OtpAuthController::class, 'logout'])->name('logout');



Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');



/* -------------------------------- Admin --------------------------------- */
Route::prefix('admin')->name('admin.')
    ->middleware(['auth', 'role:admin,super_admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Module 1: Product CRUD
        Route::get('products/bulk', [AdminProductController::class, 'bulkUploadShow'])->name('products.bulk.show');
        Route::post('products/bulk', [AdminProductController::class, 'bulkUploadPost'])->name('products.bulk.post');
        Route::post('products/bulk/import', [AdminProductController::class, 'bulkUploadImport'])->name('products.bulk.import');
        Route::get('products/bulk/template', [AdminProductController::class, 'bulkUploadTemplate'])->name('products.bulk.template');
        Route::resource('products', AdminProductController::class)->except('show');

        // Module 2: Categories
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');

        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Module 3: Schools
        Route::get('schools', [AdminSchoolController::class, 'index'])->name('schools.index');
        Route::post('schools', [AdminSchoolController::class, 'store'])->name('schools.store');
        Route::get('schools/{school}/edit', [AdminSchoolController::class, 'edit'])->name('schools.edit');
        Route::put('schools/{school}', [AdminSchoolController::class, 'update'])->name('schools.update');
        Route::delete('schools/{school}', [AdminSchoolController::class, 'destroy'])->name('schools.destroy');

        // Module 4: Classes
        Route::get('classes', [ClassController::class, 'index'])->name('classes.index');
        Route::post('classes', [ClassController::class, 'store'])->name('classes.store');
        Route::get('classes/{class}/edit', [ClassController::class, 'edit'])->name('classes.edit');
        Route::put('classes/{class}/update', [ClassController::class, 'update'])->name('classes.update');

        Route::delete('classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');

        // Module 5: Bundles
        Route::get('bundles', [AdminBundleController::class, 'index'])->name('bundles.index');
        Route::get('bundles/create', [AdminBundleController::class, 'create'])->name('bundles.create');
        Route::post('bundles', [AdminBundleController::class, 'store'])->name('bundles.store');
        Route::get('bundles/{bundle}/edit', [AdminBundleController::class, 'edit'])->name('bundles.edit');
        Route::put('bundles/{bundle}/update', [AdminBundleController::class, 'update'])->name('bundles.update');
        Route::delete('bundles/{bundle}', [AdminBundleController::class, 'destroy'])->name('bundles.destroy');

        // Module 6: Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

        // Module 7: Payment verification
        Route::get('payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::get('payments/{proof}', [PaymentVerificationController::class, 'show'])->name('payments.show');
        Route::post('payments/{proof}/approve', [PaymentVerificationController::class, 'approve'])->name('payments.approve');
        Route::post('payments/{proof}/reject', [PaymentVerificationController::class, 'reject'])->name('payments.reject');

        // Module 8: Customers
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('customers/{customer}/toggle-block', [CustomerController::class, 'toggleBlock'])->name('customers.toggleBlock');

        // Module 9: Inventory
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::put('inventory/{product}', [InventoryController::class, 'updateStock'])->name('inventory.update');

        // Modules 10 & 11 + Settings — Super Admin ONLY
        Route::middleware('role:super_admin')->group(function () {
            Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');
            Route::get('finance/export', [FinanceController::class, 'export'])->name('finance.export');

            Route::get('admins', [AdminUserController::class, 'index'])->name('admins.index');
            Route::post('admins', [AdminUserController::class, 'store'])->name('admins.store');
            Route::put('admins/{admin}/role', [AdminUserController::class, 'updateRole'])->name('admins.updateRole');
            Route::post('admins/{admin}/revoke', [AdminUserController::class, 'revoke'])->name('admins.revoke');

            Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');


            Route::get('/contacts', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contacts.index');
            // Route::resource('banners', BannerController::class);
    
            Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
            Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
            Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
            Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
            Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
            Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

            // attributes routes
    
            Route::resource('attributes', AttributeController::class);

            Route::get('/attribute/value/create/{attribute}', [AttributeController::class, 'attributeValue'])->name('attributes.value.create');
            Route::post('/attribute/value/{attribute}', [AttributeController::class, 'attributeValueStore'])->name('attributes.value.store');


            Route::delete('/attribute/value/{value}', [AttributeController::class, 'attributeValueDestroy'])->name('attributes.value.destroy');

            Route::get('/attribute/{attribute}/value/{value}/edit', [AttributeController::class, 'attributeValueEdit'])->name('attributes.value.edit');
            Route::put('/attribute/value/{value}/update', [AttributeController::class, 'attributeValueUpdate'])->name('attributes.value.update');


            //attribute selection for product
    
            Route::get('/products/{product}/attribute', [AttributeController::class, 'attributeSelection'])->name('products.attribute.select');
            Route::post('/products/{product}/attribute', [AttributeController::class, 'ProductAttributeStore'])->name('products.attributes.store');
            // attribute value slection
            Route::get('/products/{product}/attribute/value', [AttributeController::class, 'attributeValueSelection'])->name('products.attributes.value.select');
            Route::post('/products/{product}/variant/store', [AttributeController::class, 'ProductVariantStore'])->name('product.variants.store');
        });
    });

// Admin login uses a password (separate from customer OTP login)
require __DIR__ . '/admin-auth.php';
