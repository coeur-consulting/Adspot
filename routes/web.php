<?php

use App\Models\Blog;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LinkedSocialAccountController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if(App::environment('production')){
    URL::forceScheme('https');
}

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),


    ]);
});



Route::get('/auth/login/{provider}', [LinkedSocialAccountController::class, 'handleRedirect']);
Route::get('/auth/{provider}/callback', [LinkedSocialAccountController::class, 'handleCallback']);

Route::get('/product/{id}', function ($id) {
    return Inertia::render('Product', [
        'product' => Product::where('id', $id)->with('user', 'category')->first()
    ]);
});
Route::get('/marketplace', function () {
    return Inertia::render('MarketPlace', [
        'categories' => Category::get(['id','name']),
        'subcategories' => Subcategory::get(['id', 'name','category_id']),

    ]);
});

//News route
Route::get('/news', function () {
    return Inertia::render('Blogs', []);
});
Route::get('/get/news', function () {
    return Blog::where('status', 1)->latest()->paginate(24);
});
Route::post('/add/news', [BlogController::class, 'store']);
Route::put('/update/news/{blog}', [BlogController::class, 'update']);
Route::delete('/delete/news/{blog}', [BlogController::class, 'destroy']);

Route::get('/news/{id}', function ($id) {
    return Inertia::render('Blog', [
        'content'=> Blog::find($id),
        'others' => Blog::inRandomeOrder()->where('id','!=',$id)->get()->take(10)
    ]);
});


Route::get('/about', function () {
    return Inertia::render('About', []);
});

Route::get('/contact', function () {
    return Inertia::render('Contact', []);
});
Route::post('/send/contact', [ContactController::class,'sendcontact']);


Route::get('/transaction', function () {
    return Inertia::render('Transaction', []);
});
Route::get('verify-transaction/{txn_id}', [OrderController::class, 'verify']);

Route::post('orders', [OrderController::class, 'store']);


Route::group(['middleware' => 'auth'], function () {
    Route::get('/redirectAuthenticatedUser', [RedirectAuthenticatedUserController::class, 'home']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'getnotifications']);
    Route::get('/notifications/unread', [NotificationController::class, 'unreadnotifications']);
    Route::get('/mark/notifications', [NotificationController::class, 'markreadnotifications']);
    Route::get('/notifications/{id}/mark', [NotificationController::class, 'marksinglenotification']);
    Route::delete('notifications/delete', [NotificationController::class, 'destroy']);
    Route::get('/admin/notifications',function(){
        return Inertia::render('Admin/Notifications', [
            'notifications' => auth()->user()->notifications
        ]);
    });


    Route::get('/my/notifications', function () {
        return Inertia::render('Notifications', [
            'notifications' => auth()->user()->notifications
        ]);
    });



    //Auth admin routes
    Route::group(['middleware' => 'checkrole:admin'], function () {
        Route::get('/admin-dashboard', function () {
            return Inertia::render('AdminDashboard');
        })->name('AdminDashboard');

        Route::resource('admin-categories', CategoryController::class, [
            'names' => [
                'index' => 'categories.index',
                'store' => 'categories.store',
                'destroy' => 'categories.destroy',
                'update' => 'categories.update',

            ]
        ]);

        Route::resource('products', ProductController::class, [
            'names' => [
                'index' => 'products.index',
                'store' => 'products.store',
                'destroy' => 'products.destroy',
                'update' => 'products.update',

            ]
        ]);

        Route::resource('blogs', BlogController::class, [
            'names' => [
                'index' => 'blogs.index',
                'store' => 'blogs.store',
                'destroy' => 'blogs.destroy',
                'update' => 'blogs.update',

            ]
        ]);
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard', [

                'total_products' => auth()->user()->products()->count(),
            ]);
        })->name('dashboard');


        Route::get('view/orders', function () {
            return Inertia::render('Admin/Orders', []);
        })->name('orders');
        Route::get('/get-orders', [OrderController::class, 'allorders']);

        //Offers start

        Route::get('offers/{id}', function ($id) {
            return Inertia::render('Admin/Offers', [
                'product' => Product::find($id)->load('offers')
            ]);
        })->name('offers');
        Route::post('/handle/offers', [OfferController::class,'handleoffers']);

        Route::get('/reports', function () {
            return Inertia::render('Admin/Reports');
        })->name('reports');
    });

    //Auth User routes

    Route::group(['middleware' => 'checkrole:user'], function () {

        Route::resource('orders', OrderController::class);
        Route::get('/checkout', function () {
            return Inertia::render('Checkout', []);
        });

    });
    Route::get('/cart', function () {
        return Inertia::render('Cart', []);
    });
    Route::get('/getcart', function () {
        $cart =  auth()->user()->cart;
        return  response([
            'cart' => $cart,
            'count' => $cart->count()
        ]);
    });
    Route::get('/getfullcart', function () {
       return auth()->user()->cart->load('product','offer');

    });


    Route::post('/addtocart', [CartController::class, 'addtocart']);
    Route::delete('/remove/cart/{cart}', [CartController::class, 'removecart']);
    Route::get('/clear/cart', [CartController::class, 'destroy']);
});


Route::post('/findspace', [UtilityController::class, 'findspace']);
Route::get('/categories', [UtilityController::class, 'getcategories']);
Route::get('/subcategories', [UtilityController::class, 'getsubcategories']);
Route::get('/get-products', [ProductController::class, 'allproducts']);
Route::post('/search-inventory', [ProductController::class, 'searchinventory']);
Route::get('/featured-products', [ProductController::class, 'featuredproducts']);
Route::get('/get-users', [RegisteredUserController::class, 'getusers']);
Route::get('/get-admins', [RegisteredUserController::class, 'getvendors']);
Route::get('/searchproducts', [ProductController::class, 'searchproducts']);

Route::get('/searchorders', [OrderController::class, 'searchorders']);




require __DIR__ . '/auth.php';
